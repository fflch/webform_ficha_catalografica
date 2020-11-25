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
            'pessoa_nome' => '',
            'pessoa_ultimonome' => '',
            'orientador_nome' => '',
            'orientador_ultimonome' => '',
            'sou_orientador' => '',
            'tipo_trabalho' => '',
            'departamento' => '',
            'area_concentracao' => '',
            'ano' => '',
            'no_paginas' => '',
            'titulo_trabalho' => '',
            'cod_cutter' => '',
            'assunto1' => '',
            'assunto2' => '',
            'assunto3' => '',
            'assunto4' => '',
            'assunto5' => '',
        ];
    }

    public function form(array $form, FormStateInterface $form_state) {
        $form = parent::form($form, $form_state);

        $form['ficha_catalografica'] = [
            '#type' => 'fieldset',
            '#title' => $this->t('Mapeamento de campos'),
            '#description' => $this->t("Mapeamento dos campos para gerar a ficha catalográfica"),
        ];

        $form['ficha_catalografica']['container'] = [
        '#type' => 'container',
        ];

        $form['ficha_catalografica']['container']['informacoes_pessoais'] = [
        '#type' => 'fieldset',
        '#description' => $this->t(""),
        '#title' => $this->t('Informações Pessoais'),
        ];

        $form['ficha_catalografica']['container']['informacoes_pessoais']['pessoa_nome'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para nome'),
            '#required' => FALSE,
        ];

        $form['ficha_catalografica']['container']['informacoes_pessoais']['pessoa_ultimonome'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para último sobrenome'),
            '#required' => FALSE,
        ];

        $form['ficha_catalografica']['container']['informacoes_orientador'] = [
        '#type' => 'fieldset',
        '#description' => $this->t(""),
        '#title' => $this->t('Informações do(a) Orientador(a)'),

        ];
        $form['ficha_catalografica']['container']['informacoes_orientador']['orientador_nome'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para nome do(a) orientador(a)'),
            '#required' => FALSE,
        ]; 

        $form['ficha_catalografica']['container']['informacoes_orientador']['orientador_ultimonome'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('chave para último sobrenome do(a) orientador(a)'),
            '#required' => FALSE,
        ];

        $form['ficha_catalografica']['container']['informacoes_orientador']['sou_orientador'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para sou orientador(a)'),
            '#description' => $this->t("O campo 'sou orientador(a)' é geralmente um checkbox que indica se o inscrito é ou não orientador. Caso afirmativo, seu nome e sobrenome serão pegos da área 'Informações Pessoais', não precisando preencher as 'Informações do(a) orientador(a)'."),
            '#required' => FALSE,
        ];

        $form['ficha_catalografica']['container']['informacoes_obra'] = [
        '#type' => 'fieldset',
        '#description' => $this->t(""),
        '#title' => $this->t('Informações da Obra'),
        ];

        $form['ficha_catalografica']['container']['informacoes_obra']['tipo_trabalho'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para tipo de trabalho'),
            '#description' => $this->t("Campo que indica o tipo de trabalho, como Tese, Dissertação, TGI"),
            '#required' => FALSE,
        ];

        $form['ficha_catalografica']['container']['informacoes_obra']['departamento'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para departamento'),
            '#required' => FALSE,
        ];

        $form['ficha_catalografica']['container']['informacoes_obra']['area_concentracao'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para área de concentração'),
            '#required' => FALSE,
        ];

        $form['ficha_catalografica']['container']['informacoes_obra']['ano'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para ano'),
            '#required' => FALSE,
        ]; 

        $form['ficha_catalografica']['container']['informacoes_obra']['no_paginas'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para número de páginas'),
            '#required' => FALSE,
        ];

        $form['ficha_catalografica']['container']['informacoes_obra']['titulo_trabalho'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para título do trabalho'),
            '#required' => FALSE,
        ];

        $form['ficha_catalografica']['container']['informacoes_obra']['cod_cutter'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para código cutter'),
            '#required' => FALSE,
        ];

        $form['ficha_catalografica']['container']['assuntos'] = [
        '#type' => 'fieldset',
        '#description' => $this->t(""),
        '#title' => $this->t('Assuntos (mín. 1, máx. 5)'),
        ];

        $form['ficha_catalografica']['container']['assuntos']['assunto1'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para primeiro assunto'),
            '#required' => FALSE,
        ];

        $form['ficha_catalografica']['container']['assuntos']['assunto2'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para segundo assunto'),
            '#required' => FALSE,
        ];

        $form['ficha_catalografica']['container']['assuntos']['assunto3'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para terceiro assunto'),
            '#required' => FALSE,
        ];

        $form['ficha_catalografica']['container']['assuntos']['assunto4'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para quarto assunto'),
            '#required' => FALSE,
        ];
        
        $form['ficha_catalografica']['container']['assuntos']['assunto5'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para quinto assunto'),
            '#required' => FALSE,
        ];

        return $form;
    }

    public function preSave(array &$element, WebformSubmissionInterface $webform_submission) {
        # gerar o pdf da ficha catalográfica
        var_dump("parar"); die();
    }
}