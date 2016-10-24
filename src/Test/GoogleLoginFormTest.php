<?php

/**
 * @file(GoogleLoginTest.php)
 * Contains \Drupal\googlelogin\Test\GoogleLoginFormTest
 */

namespace Drupal\googlelogin\Test;

use Drupal\simpletest\WebTestBase;
use Drupal\user\Entity\User;

/**
 * Provide somo basic test for googlelogin config form.
 * @group testmodule
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
  public static $modules = ['googlelogin', 'testmodule'];


  protected function setUp(){
    parent::setUp();
    $this->anonymousUser = $this->drupalCreateUser(['view content']);
    $this->adminUser = $this->drupalCreateUser(['administer site configuration']);
  }

  /**
   * Test the URL
   */
  public function GoogleLoginFormTestRouterURLIsAccessible() {
          
    $this->drupalLogin($this->anonymousUser);
    $this->drupalGet('/admin/config/system/googleloginform');
    $this->assertResponse(403,'Url is not accesible for anonymousUser');

    $this->drupalLogin($this->adminuser);
    $this->drupalGet('/admin/config/system/googleloginform');
    $this->assertResponse(200, 'Url is accesible for adminUser');

  }
}

