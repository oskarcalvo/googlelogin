<?php

/**
 * @file GoogleLoginCallback.php
 * Contains \Drupal\googlogin\Controller\GoogleLoginCallback
 */

namespace Drupal\googlelogin\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\googlelogin\GoogleLoginAuthentication;

/**
 * Returns responses for callback method.
 */

class GoogleLoginCallbackController extends ControllerBase {


  /**
   * getGoogleCode Get the Code from googel and create an user or enable a session for a user.
   *
   * @param  string $code Token give back by Google
   * @return If the resonse it's ok The user is created or the user session created, if it goes wrong go back to the uesr/login form
   */
  public function getGoogleCode() {

    $code = \Drupal::request()->query->get('code');

    $this->google_client = \Drupal::service('google_client');
    $this->config_factory = \Drupal::service('config.factory');

    $authentication = new GoogleLoginAuthentication($this->google_client, $this->config_factory);
    $google_account = $authentication->getUserData($code);

    $drupal_user = user_load_by_mail ($google_account['email']);

    // si no existe guardamos el usuario.
    if (!$drupal_user || $drupal_user === FALSE){

      $drupal_user = $this->googleloginCreateUser($google_account);

    }

    \Drupal::moduleHandler()->invoke('user', user_login_finalize($drupal_user));
    $this->redirect('user');

  }


  /**
   * Create drupal account with google account data
   * @param  array  $account Google account data
   * @return object $user Drupal user.
   */
  private function googleloginCreateUser(array $account) {

    $new_user = \Drupal\user\Entity\User::create();
    $new_user->setPassword(user_password(25));
    $new_user->setEmail($account['email']);
    $new_user->setUsername($account['name']);
    $new_user->set('init', 'email');
    $new_user->enforceIsNew();
    $new_user->set('langcode', $account['locale']);
    $new_user->set('preferred_langcode', $account['locale']);
    $new_user->set('preferred_admin_langcode', $account['locale']);
    $new_user->activate();
    $created_user = $new_user->save();

    return $new_user;
  }

}
