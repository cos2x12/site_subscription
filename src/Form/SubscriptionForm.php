<?php
/**
* @file
* Contains \Drupal\site_subscription\Form\SubscriptionForm.
*
* В комментарии выше указываем, что содержится в данном файле.
*/

// Объявляем пространство имён формы. Drupal\site_subscription\Form
namespace Drupal\site_subscription\Form;

// Указываем что нам потребуется FormBase, от которого мы будем наследоваться
// а также FormStateInterface который позволит работать с данными.
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
* Объявляем нашу форму, наследуясь от FormBase.
* Название класса строго должно соответствовать названию файла.
*/
class SubscriptionForm extends FormBase {
    /**
    * {@inheritdoc}.
    */
    public function getFormId() {
        return 'site_subscription_form';
    }
    
    /**
    * Создание нашей формы.
    *
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

        // Предоставляет обёртку для одного или более Action элементов.
        $form['actions']['#type'] = 'actions';

        // Добавляем нашу кнопку для отправки.
        $form['actions']['submit'] = array(
        '#type' => 'submit',
        '#value' => $this->t('Subscribe'),
        '#button_type' => 'primary',
        );
        
        return $form;
    }
    
    /**
    * Валидация отправленых данных в форме.
    *
    * {@inheritdoc}
    */
    public function validateForm(array &$form, FormStateInterface $form_state) {
        return \Drupal::service('email.validator')->isValid($form_state->getValue('mail'));
    }
    
    /**
    * Отправка формы.
    *
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