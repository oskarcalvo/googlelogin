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

    $request = \Drupal::request();
    $code = $request->query->get('code');


    $authentication = new GoogleLoginAuthentication();


    $markup = '<h3>' .$code .'</h3>';
     return array(
    '#markup' => $markup,
  );

  }
}
