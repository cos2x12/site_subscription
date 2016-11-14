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
   * То что ниже - это аннотация. Аннотации пишутся в комментариях и в них
   * объявляются различные данные. В данном случае указано, что документацию
   * к данному методу надо взять из комментария к самому классу.
   *
   * А в самом методе мы возвращаем название нашей формы в виде строки.
   * Эта строка используется для альтера формы (об этом ниже в тексте).
   *
   * {@inheritdoc}.
   */
  public function getFormId() {
    return 'subscription_form';
  }

  /**
   * Создание нашей формы.
   *
   * {@inheritdoc}.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Объявляем телефон.
    $form['email'] = array(
      '#type' => 'email',
      '#title' => $this->t('Enter your E-mail'),
      '#description' => $this->t('A valid e-mail address.'),
      '#attributes' => array('placeholder' => $this->t('user@mydomain.com'), 'class' => ['form-control']),
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
    return \Drupal::service('email.validator')->isValid($email);
  }

  /**
   * Отправка формы.
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
  $email = $form_state->getValue('email');

      if($email != mail){
  $uuid = \Drupal::service('uuid');
  db_insert('site_subscription')
  ->fields(array(
    'uuid' => $uuid->generate(),
    'uid' => 0,
//    'mail' => $form_state->getValue('mail'),
    'mail' => serialize(array('email' => $form_state->getValue('email')) ),
//    'status' => 0,
    'created' => REQUEST_TIME,
//    'updated' => REQUEST_TIME,
  ))
  ->execute();
  drupal_set_message($this->t('Your e-mail has been sent'));
  }else{
  drupal_set_message($this->t('Your e-mail has been sent to'));
  }
 }
}

//    drupal_set_message($this->t('Thank you @email.', array(
//      '@email' => $form_state->getValue('email'),
//    )))