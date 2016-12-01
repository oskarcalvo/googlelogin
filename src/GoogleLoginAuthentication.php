<?php

namespace Drupal\googlelogin;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Url;

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
   * Constructs a new GoogleLoginAuthentication object.
   *
   * @param Google_Client $google_client
   *        class to connect with Google Login API.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(\Google_Client $google_client, ConfigFactoryInterface $config_factory) {

    $this->google_client = $google_client;
    $this->configFactory = $config_factory->get('googlelogin.settings');

    try {

      if ($this->google_client && is_object($this->google_client)) {

        $this->google_client->setClientId($this->configFactory->get('googlelogin_id'));
        $this->google_client->setClientSecret($this->configFactory->get('googlelogin_secret'));
        // Temporal url until I create de internal url.
        $url = Url::fromRoute('googlelogin.callback')->setAbsolute()->toString();
        $this->google_client->setRedirectUri($url);
        $this->google_client->setScopes('profile');
      }
    }
    catch (Exception $e) {
      \Drupal::logger('googlelogin')->error($e->getMessage());
    }

  }

  /**
   * Function that returns the string url to accesss google login.
   *
   * @return string
   *         A string that is a url.
   */
  public function getAuthenticationtUrl() {
    return $this->google_client->createAuthUrl();
  }

  /**
   * Get Access Token with Auth Code and user data value.
   *
   * @param string $code
   *         string give back from Google Client API.
   *
   * @return array
   *         Array with Google account or with Google error.
   */
  public function getUserData($code) {

    $token = $this->client->fetchAccessTokenWithAuthCode($code);
    $response = $this->client->verifyIdToken($token['id_token']);
    return $response;
  }

}
