<?php

namespace Drupal\webform_ficha_catalografica\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\webform\Entity\WebformSubmission;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class BoletoController.
 */
class FichaController extends ControllerBase {

  public function pdf($webform_submission_id) {
    $webform_submission = WebformSubmission::load($webform_submission_id);

    $msg = '';

    if($webform_submission) {

      /* Verificamos se há boleto gerado para esse webform_submission */
      $data = $webform_submission->getData();
      if(isset($data['boleto_status'])){
    
        /*
        $response = new Response();
        $response->headers->set('Content-Type', 'application/pdf');
        $response->setContent(base64_decode($obter['value']));
        return $response;
        */

      }
    }
    else {
        $msg = "Não existe submissão com id {$webform_submission_id}";
    }

    return [
      '#type' => 'markup',
      '#markup' => $this->t("Não foi possível gerar a ficha: {$msg}"),
    ];
  }

}