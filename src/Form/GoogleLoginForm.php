<?php

/**
 * @file
 * Contains Drupal\googlelogin\Form\GoogleLoginFormForm
 */

namespace Drupal\googlelogin\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

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
    $config = $this->config('googlelogin.settings');

    $form['googlelogin_id'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Google customer id'),
      '#default_value' => $config->get('googlelogin.id'),
    );
    $form['googlelogin_secret'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Google customer secret'),
      '#default_value' => $config->get('googlelogin.secret'),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('googlelogin.settings')
      ->set('googlelogin.id', $form_state->getValue('googlelogin_id'))
      ->set('googlelogin.secret', $form_state->getValue('googlelogin_secret'))
      ->save();

    parent::submitForm($form, $form_state);
  }
}
?>
