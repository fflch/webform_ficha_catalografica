<?php

namespace Drupal\webform_ficha_catalografica\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\webform\Entity\WebformSubmission;
use Symfony\Component\HttpFoundation\Response;
use Drupal\webform_ficha_catalografica\Utils\Ficha;

/**
 * Class BoletoController.
 */
class FichaController extends ControllerBase {

  public function pdf($webform_submission_id) {
    $webform_submission = WebformSubmission::load($webform_submission_id);
    if($webform_submission) {
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->setContent(base64_decode(Ficha::pdf($webform_submission)));
        return $response;
    }

    return [
      '#type' => 'markup',
      '#markup' => $this->t("Não foi possível gerar a ficha"),
    ];
  }

}