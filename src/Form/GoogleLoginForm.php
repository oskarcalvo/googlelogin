<?php

namespace Drupal\googlelogin\Form;

/**
 * @file
 * Contains Drupal\googlelogin\Form\GoogleLoginFormForm.
 */

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;

/**
 * Configure hello settings for this site.
 */
class GoogleLoginForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'googlelogin_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'googlelogin.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);
    $config = $this->config('googlelogin.settings');

    $url = Url::fromUri('https://console.developers.google.com');
    $text = $this->t('Google project');
    $link = Link::fromTextAndUrl($text, $url);
    $new_link = ($link->toRenderable());
    $new_link['#attributes'] = ['target' => ['blank']];
    $html_link = render($link);

    $form['googlelogin_text'] = array(
      '#type' => 'item',
      '#markup' => '<h4 class="label">' . $this->t("If you don't have a Google project to add the Customer Id and Customer secret, you need to create a new project in google following this link:  @link", ['@link' => $html_link]) . '</h4>',
    );
    $form['googlelogin_id'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Google customer id"),
      '#default_value' => $config->get('googlelogin_id'),
      '#required' => TRUE,
    );
    $form['googlelogin_secret'] = array(
      '#type' => 'textfield',
      '#title' => $this->t("Google customer secret"),
      '#default_value' => $config->get('googlelogin_secret'),
      '#required' => TRUE,
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('googlelogin.settings')
      ->set('googlelogin_id', $form_state->getValue('googlelogin_id'))
      ->set('googlelogin_secret', $form_state->getValue('googlelogin_secret'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
