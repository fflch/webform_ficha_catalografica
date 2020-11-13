<?php 

namespace Drupal\webform_ficha_catalografica\Plugin\WebformElement;

use Drupal\webform\Plugin\WebformElementBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\webform\WebformSubmissionInterface;

/**
 * Provides a 'FichaCatalografica' element.
 *
 * @WebformElement(
 *   id = "ficha_catalografica",
 *   default_key = "ficha_catalografica",
 *   label = @Translation("Ficha Catalográfica"),
 *   description = @Translation("Provides a form element that manage ficha catalográfica"),
 *   category = @Translation("Advanced elements"),
 *   states_wrapper = TRUE,
 * )
 */
class WebformElementFichaCatalografica extends WebformElementBase {

    public function getDefaultProperties() {
        return [
            'flex' => 1,
            'nome' => '',
            'ultimonome' => '',
        ];
    }

    public function form(array $form, FormStateInterface $form_state) {
        $form = parent::form($form, $form_state);

        $form['ficha_catalografica'] = [
            '#type' => 'fieldset',
            '#title' => $this->t('Configurações de uma ficha catalográfica'),
        ];

        $form['ficha_catalografica']['container'] = [
            '#type' => 'container',
        ];

        $form['ficha_catalografica']['container']['nome'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('chave para Nome'),
            '#required' => TRUE,
        ];

        $form['ficha_catalografica']['container']['ultimonome'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('chave para último'),
            '#required' => TRUE,
        ];

        return $form;
    }

    public function preSave(array &$element, WebformSubmissionInterface $webform_submission) {
        # gerar o pdf da ficha catalográfica
        var_dump("parar"); die();
    }
}