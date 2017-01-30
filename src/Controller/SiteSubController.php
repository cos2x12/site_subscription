<?php

namespace Drupal\site_subscription\Controller;

use Drupal\Core\Controller\ControllerBase;

class SiteSubController extends ControllerBase {

    /**
     * Страница отображения зарегистрированных слайдов.
     */
    public function getSubscription() {
        return array(
            '#theme' => 'site_subscription_admin_page',            
            '#attached' => array(
                'library' => array(
                    'site_subscription/subscription',
                ),
            ),
            '#cache' => [
                'keys' => ['subscription', 'full'],
                'tags' => ['subscription'],
                'contexts' => ['languages', 'timezone'],
                'max-age' => Cache::PERMANENT,
            ],            
        );
    }

}
