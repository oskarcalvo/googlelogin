<?php

namespace Drupal\Tests\googlelogin\Unit;

use Drupal\googlelogin\GoogleLoginAuthentication;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Url;
use Drupal\Tests\UnitTestCase;

/**
 * @coversDefaultClass \Drupal\googlelogin\GoogleLoginAuthentication
 * @group Googlelogin
 */
class GoogleLoginAuthenticationTest extends UnitTestCase {

  /**
   * The mocked configuration
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $config;

  /**
   * The mocked Google_Client
   *
   * @var \Google_Cliente
   */
  protected $google_client;

  /**
   * The tested googlelogin
   *
   * @var \Drupal\googlelogin\GoogleLoginAuthentication
   */
  protected $googleLoginAuthentication;

  /**
   * {@inheritodc}
   */
  protected function setUp() {
    parent::setUp();

    $this->google_client = $this->getMock('Google_Client');
    $this->config = $this->getMock('\Drupal\Core\Config\ConfigFactoryInterface');
    $this->$googleLoginAuthentication = new GoogleLoginAuthentication ($this->google_client, $this->config);
  }

  /**
   * Test the method AuthenticationtUrl
   */
  public function testgetAuthenticationtUrl() {
    $url = $this->$googleLoginAuthentication->getAuthenticationtUrl();
    $response = filter_var($url, FILTER_VALIDATE_URL);
    $this->assertEquals(TRUE, $response);
  }

  /**
   * Test the method getUserData
   */
  public function testgetUserData() {

  }
}
