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

    //$token = $this->client->fetchAccessTokenWithAuthCode($code);
    //$response = $this->client->verifyIdToken($token['id_token']);
    //return $response;
    //
    //
    $values = Array
      (
          'iss' => 'https://accounts.google.com',
          'iat' => 1478181680,
          'exp' => 1478185280,
          'at_hash' => 'tONXvyXBghr3y-VvwwonEA',
          'aud' => '639246462648-hqg9c69pmo06p7ttbqcdjfhmn0fhu304.apps.googleusercontent.com',
          'sub' => 114427219992087777550,
          'email_verified' => 1,
          'azp' => '639246462648-hqg9c69pmo06p7ttbqcdjfhmn0fhu304.apps.googleusercontent.com',
          'email' =>    substr(sha1(rand()), 0, 15).'@gmail.com',
          'name' => substr(sha1(rand()), 0, 15),
          'picture' => 'https://lh6.googleusercontent.com/-CZs4psw6wO8/AAAAAAAAAAI/AAAAAAAAAAA/7pdgdUWznro/s96-c/photo.jpg',
          'given_name' => 'oskar',
          'family_name' => 'calvo',
          'locale' => 'es'
      );

    return $values;
  }




}
