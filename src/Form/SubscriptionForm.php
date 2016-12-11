<?php
/**
* @file
* Contains \Drupal\site_subscription\Form\SubscriptionForm.
*/

namespace Drupal\site_subscription\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* Subscription form.
*/
class SubscriptionForm extends FormBase {
    /**
    * {@inheritdoc}.
    */
    public function getFormId() {
        return 'site_subscription_form';
    }
    
    /**
    * {@inheritdoc}.
    */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $account = \Drupal::currentUser();

        // Объявляем e-mail.
        $form['mail'] = array(
        '#type' => 'email',
        '#title' => $this->t('Enter your E-mail'),
        '#description' => $this->t('A valid e-mail address.'),
        '#attributes' => array('placeholder' => $this->t('user@mydomain.com'), 'class' => ['form-control']),
        '#access' => $account->id() ? FALSE : TRUE,
        );        

        // Добавляем нашу кнопку для отправки.
        $form['actions']['#type'] = 'actions';
        $form['actions']['submit'] = array(
        '#type' => 'submit',
        '#value' => $this->t('Subscribe'),
        '#button_type' => 'primary',
        );
        
        return $form;
    }
    
    /**
    * {@inheritdoc}
    */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        return \Drupal::service('email.validator')->isValid($form_state->getValue('mail'));
    }
    
    /**
    * {@inheritdoc}
    */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $account = \Drupal::currentUser();
        $connection = \Drupal::database();

        $result = $connection->select('site_subscription', 'n')
        ->fields('n', array('mail'))
        ->condition('n.mail', $form_state->getValue('mail'));
        $mail = $result->execute()->fetchField();
        // Execute the statement

        $result1 = $connection->select('site_subscription', 'n')
        ->fields('n', array('uid'))
        ->condition('n.uid', $account->id());
        $uid = $result1->execute()->fetchField();

        if ($mail == $form_state->getValue('mail') && $account->id() == $uid) {
            drupal_set_message($this->t('You are subscribed'));
        }
        elseif ($account->id()) {
            $connection->insert('site_subscription')
            ->fields([
                'uid' => $account->id(),
                'type' => 'all',
                'type_id' => '0',
                'mail' => $account->getEmail(),
                'created' => REQUEST_TIME,
            ])
            ->execute();
        }
        else {
            $connection->insert('site_subscription')
            ->fields([
                'uid' => 0,
                'type' => 'all',
                'type_id' => '0',
                'mail' => $form_state->getValue('mail'),
                'created' => REQUEST_TIME,
            ])
            ->execute();
        }        
    }
}