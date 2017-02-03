<?php

/**
 * @file
 * Contains \Drupal\site_subscription\Form\SubscriptionSettingsForm
 */

namespace Drupal\site_subscription\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Subscription settings form.
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
        return [
            'site_subscription.settings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        // Загружаем конфигурацию.
        $config = $this->config('site_subscription.settings');
        
        // Объявляет поле количество писем для обработки за один запуск crone.
        $form['number'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Enter the number of letters for delivery'),
            '#description' => $this->t('It is not recommended to put a number greater than 50.'),            
            '#default_value' => $config->get('number'),
        );

        return parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function validateForm(array &$form, FormStateInterface $form_state) {}

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {        
        // Записывает значения в конфигурацию.
        $this->config('site_subscription.settings')
            ->set('number', $form_state->getValues['number'])
            ->save();
    }
}