<?php

/**
 * @file
 * Contains \Drupal\site_subscription\Form\SubscriptionSettingsForm
 */

namespace Drupal\site_subscription\Form;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\site_subscription\Controller\SubscriptionDatabaseController;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Subscription type class form.
 */
class SubscriptionSettingsForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'site_subscription_settings_form';
    }
    
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    // Возвращает названия конфиг файла.
    // Значения будут храниться в файле:
    // subscription.settings
    return [
      'site_subscription.settings',
    ];
  }    
    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
    // Загружаем наши конфиги.
        $config = $this->config('site_subscription.settings');
    // Добавляем поле для возможности задать телефон по умолчанию.
    // Далее мы будем использовать это значение в предыдущей форме.
        // Объявляем e-mail.
        $form['default_number'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('Enter the number of letters for delivery'),
        '#description' => $this->t('It is not recommended to put a number greater than 50.'),
        '#attributes' => array('class' => ['form-control']),
        '#default_value' => $config->get('number'),
        );
        
        // Добавляем нашу кнопку для отправки.
        // $form['actions']['#type'] = 'actions';
        // $form['actions']['submit'] = array(
        // '#type' => 'submit',
        // '#value' => $this->t('Save'),
        // '#button_type' => 'primary',
        // );
      // Субмит наследуем от ConfigFormBase
      return parent::buildForm($form, $form_state);
    }

    /**
    * {@inheritdoc}
    */
    public function validateForm(array &$form, FormStateInterface $form_state) {

    }  

    /**
    * {@inheritdoc}
    */
    public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    // Записываем значения в наш конфиг файл и сохраняем.
    $this->config('site_subscription.settings')
      ->set('number', $values['default_number'])
      ->save();      
    }
}