<?php

/**
 * @file
 * Contains \Drupal\site_subscription\Form\SubscriptionNumberItemsForm
 */

namespace Drupal\site_subscription\Form;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\site_subscription\Controller\SubscriptionDatabaseController;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Subscription type class form.
 */
class SubscriptionNumberItemsForm extends FormBase {

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'site_subscription_number_items_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {

        // Объявляем e-mail.
        $form['number'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('Enter the number of letters for delivery'),
        '#description' => $this->t('It is not recommended to put a number greater than 50.'),
        '#attributes' => array('class' => ['form-control']),
        '#default_value' => 5,
        );
        
        // Добавляем нашу кнопку для отправки.
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
        '#type' => 'submit',
        '#value' => $this->t('Save'),
        '#button_type' => 'primary',
        );
        return $form;
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
      
    }
}