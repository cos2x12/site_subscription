<?php
/**
 * @file
 * Contains \Drupal\site_subscription\Controller\SiteSubscriptionController.
 */

namespace Drupal\site_subscription\Controller;

use Drupal\Core\Controller\ControllerBase;

class SiteSubscriptionController extends ControllerBase {

  /**
   * Главная страница списка организаций.
   */
  public function content() {
//    $site_subscription_content = array(
//      '#theme' => 'site_subscription_content',
//    );

    return array(
      '#type' => 'container',
      '#markup' => $this->t('Hello, World!'),
     // $site_subscription_content,
    );
  }
}
