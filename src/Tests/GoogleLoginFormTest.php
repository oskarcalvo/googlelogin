<?php

/**
 * @file(GoogleLoginTest.php)
 * Contains \Drupal\googlelogin\Test\GoogleLoginFormTest
 */

namespace Drupal\googlelogin\Tests;

use Drupal\simpletest\WebTestBase;
use Drupal\user\Entity\User;
use Drupal\Core\Url;

/**
 * Provide somo basic test for googlelogin setting form.
 *
 * @group Googlelogin
 */
class GoogleLoginFormTest extends WebTestBase {


  /**
   * An anonimous user
   * @var \Drupal\user\UserInterface
   */
  protected $anonymousUser;

  /**
   * A user with permissoin to edit the form
   */
  protected $adminUser;

  /**
   * Module to install
   */
  public static $modules = ['googlelogin', 'user'];


  protected function setUp() {
    parent::setUp();

    $this->anonymousUser = $this->drupalCreateUser([]);
    $this->adminUser = $this->drupalCreateUser(['administer site configuration']);
  }

  /**
   * Test the URL
   */
  public function testGoogleLoginFormTestRouterURLIsAccessible() {

    //Try the anonymousUser
    $this->drupalLogin($this->anonymousUser );
    $this->drupalGet(Url::fromRoute('googlelogin.settings_options'));
    $this->assertResponse(403,'Url is not accesible for anonymousUser');

    //Try the adminUser
    $this->drupalLogin($this->adminUser);
    $this->drupalGet(Url::fromRoute('googlelogin.settings_options'));
    $this->assertResponse(200, 'Url is accesible for adminUser');
  }

  /**
   * Test the form has a Customer id field.
   */
  public function testGoogleLoginFormTestCustomerIdFieldExists() {
    $this->drupalLogin($this->adminUser);
    $this->drupalGet(Url::fromRoute('googlelogin.settings_options'));
    $this->assertResponse(200);
    $this->assertFieldById('edit-googlelogin-id', NULL, 'Found Customer Id with the id #edit-googlelogin-id.');
  }

  /**
   * Test the form has a secret field.
   */
  public function testGoogleLoginFormTestSecretFieldExists() {
    $this->drupalLogin($this->adminUser);
    $this->drupalGet(Url::fromRoute('googlelogin.settings_options'));
    $this->assertResponse(200);
    $this->assertFieldById('edit-googlelogin-secret', NULL, 'Found Secret with the id #edit-googlelogin-secret.');
  }

  /**
   * Test to check the value of the form fields.
   */
  public function testGoogleLoginFormTestValidateData() {
    $this->drupalLogin($this->adminUser);
    $this->drupalGet(Url::fromRoute('googlelogin.settings_options'));
    $this->assertResponse(200);
    $config = $this->config('googlelogin.settings');
    $this->assertFieldByName('googlelogin_id', $config->get('googlelogin.id'), 'The field googlelogin id value is correct');
    $this->assertFieldByName('googlelogin_secret', $config->get('googlelogin.secret'), 'The field googlelogin secret value is correct');
  }

}

