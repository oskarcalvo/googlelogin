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

    $values = $authentication->getUserData($code);



    $markup = '<pre>' .$values .'</pre>';
     return array(
    '#markup' => $markup,
  );

  }







}
