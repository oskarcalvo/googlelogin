<?php

namespace Drupal\googlelogin;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Class to wrapp google client class.
 */
class GoogleLoginAuthentication {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a new GoogleLoginAuthentication object
   *
   * @param Google_Client $Google_Client  class to connect with Google Login API.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(\Google_Client $Google_Client, ConfigFactoryInterface $config_factory){

    $this->google_client = $Google_Client;
    $this->configFactory = $config_factory->get('googlelogin.settings');

    try{

      if($this->google_client && is_object($this->google_client) ) {

        $this->google_client->setClientId($this->configFactory->get('googlelogin_id'))  ;
        $this->google_client->setClientSecret ($this->configFactory->get('googlelogin_secret')) ;
        // Temporal url until I create de internal url.
        $url = Url::fromRoute('googlelogin.callback')->setAbsolute()->toString();
        $this->google_client->setRedirectUri ($url) ;
        $this->google_client->setScopes ('profile') ;
      }

    } catch(Exception $e) {

      \Drupal::logger('googlelogin')->error($e->getMessage());
    }
  }

  public function getAuthenticationtUrl(){

    return $this->google_client->createAuthUrl();

  }

  /**
   * Get Access Token with Auth Code and user data value.
   * @param  string $code string give back from Google Client API
   * @return [type]       [description]
   */
  public function getUserData($code){

    $token = $this->client->fetchAccessTokenWithAuthCode($code);
    $response = $this->client->verifyIdToken($token['id_token']);
    return $response;
  }




}
