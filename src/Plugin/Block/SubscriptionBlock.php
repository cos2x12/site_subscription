<?php

namespace Drupal\site_subscription\Form;
namespace Drupal\site_subscription\Plugin\Block;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Subscription' Block
 *
 * @Block(
 *   id = "subscription_block",
 *   admin_label = @Translation("Subscription block"),
 * )
 */
class SubscriptionBlock extends BlockBase {
  /**
   * {@inheritdoc}
   */
  public function build() {

    return array(
    $form = \Drupal::formBuilder()->getForm('Drupal\site_subscription\Form\SubscriptionForm'),
    );
  }


}