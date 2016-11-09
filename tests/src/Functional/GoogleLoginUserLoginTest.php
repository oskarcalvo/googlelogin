<?php

namespace Drupal\Tests\googlelogin\Functional;

/**
 * @file( (GoogleLoginUserLoginTest))
 * Contains \Drupal\googlelogin\Test\GoogleLoginUserLoginTest
 */

use Drupal\Tests\BrowserTestBase;
use Drupal\user\Entity\User;
use Drupal\Core\Url;

/**
 * Provide some basic test for the new link created in Drupal login form
 *
 * @group Googlelogin
 */
class GoogleLoginUserLoginTest extends BrowserTestBase {

  /**
   * @var \Drupal\user\Entity\User.
   */
  protected $user;

  /**
   * Enabled modules
   */
  public static $modules = ['googlelogin', 'user'];

  /**
   * Use the Standard profile to test help implementations of many core modules.
   */
  protected $profile = 'standard';

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
  }

  /**
   * Check that the anonymous user can see the form
   */
  public function testGoogleLoginCheckAccessUserLoginForm () {
    $this->anonymousUser = $this->drupalCreateUser([]);
    // log as anonymous, is the only user that can access to this form.
    $this->drupalLogin($this->anonymousUser);
    $this->druaplGet(Url::fromRemote('user.login'));
    //Check that the anonymous user can access to login form.
    $this->assertSession()->statusCodeEquals(200);
  }

  /**
   * Check there is a link in the login form
   */
  public function testGoogleLoginCheckLinkIsAvailable () {
    $this->anonymousUser = $this->drupalCreateUser([]);
    // log as anonymous, is the only user that can access to this form.
    $this->drupalLogin($this->anonymousUser);
    $this->druaplGet(Url::fromRemote('user.login'));
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->pageTextContains('Login with your Google account');
  }

}
