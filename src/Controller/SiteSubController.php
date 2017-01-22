<?php

namespace Drupal\site_subscription\Controller;

use Drupal\Core\Controller\ControllerBase;

class SiteSubController extends ControllerBase {

    /**
     * Страница отображения зарегистрированных слайдов.
     */
    public function getSubscriptions() {
        return array(
            '#theme' => 'site_subscription',
        );
    }

}