<?php

namespace Drupal\googlelogin\Controller;

/**
 * @file
 * Contains \Drupal\googlogin\Controller\GoogleLoginCallback.
 */

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Drupal\googlelogin\GoogleLoginAuthentication;

/**
 * Returns responses for callback method.
 */
class GoogleLoginCallbackController extends ControllerBase {

  /**
   * GetGoogleCode Get the Code and create an user and/or enable a session.
   */
  public function getGoogleCode() {

    $code = \Drupal::request()->query->get('code');

    $this->google_client = \Drupal::service('google_client');
    $this->config_factory = \Drupal::service('config.factory');

    $authentication = new GoogleLoginAuthentication($this->google_client, $this->config_factory);
    $google_account = $authentication->getUserData($code);
    if (isset($google_account['error'])) {
      \Drupal::logger('googlelogin')->error($this->t("Something was wrong trying to login with Google."));

      $this->redirect('user');
    }

    $drupal_user = user_load_by_mail($google_account['email']);
    if (!$drupal_user || $drupal_user === FALSE) {
      $drupal_user = $this->googleloginCreateUser($google_account);
    }

    \Drupal::moduleHandler()->invoke('user', user_login_finalize($drupal_user));
    $this->redirect('user');
  }

  /**
   * Create drupal account with google account data.
   *
   * @param array $account
   *         Google account data.
   *
   * @return object
   *         Drupal user.
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
    $new_user->save();
    return $new_user;
  }

}
