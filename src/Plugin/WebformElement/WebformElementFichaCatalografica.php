<?php 

namespace Drupal\webform_ficha_catalografica\Plugin\WebformElement;

use Drupal\webform\Plugin\WebformElementBase;
use Drupal\Core\Form\FormStateInterface;

use Symfony\Component\HttpFoundation\Response;
use Drupal\webform_ficha_catalografica\Utils\Ficha;

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
            'sou_orientadora' => '',
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
            'cabecalho' => '',
            'unidade' => '',
            'descricao_ficha' => '',
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
            '#required' => TRUE,
        ];

        $form['ficha_catalografica']['container']['informacoes_pessoais']['pessoa_ultimonome'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para último sobrenome'),
            '#required' => TRUE,
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
            '#required' => TRUE,
        ]; 

        $form['ficha_catalografica']['container']['informacoes_orientador']['orientador_ultimonome'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('chave para último sobrenome do(a) orientador(a)'),
            '#required' => TRUE,
        ];

        $form['ficha_catalografica']['container']['informacoes_orientador']['sou_orientadora'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para sou orientadora'),
            '#description' => $this->t("Marcar para orientadoras (gênero feminino)"),
            '#required' => TRUE,
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
            '#required' => TRUE,
        ];

        $form['ficha_catalografica']['container']['informacoes_obra']['departamento'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para departamento'),
            '#required' => TRUE,
        ];

        $form['ficha_catalografica']['container']['informacoes_obra']['area_concentracao'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para área de concentração'),
            '#required' => TRUE,
        ];

        $form['ficha_catalografica']['container']['informacoes_obra']['ano'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para ano'),
            '#required' => TRUE,
        ]; 

        $form['ficha_catalografica']['container']['informacoes_obra']['no_paginas'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para número de páginas'),
            '#required' => TRUE,
        ];

        $form['ficha_catalografica']['container']['informacoes_obra']['titulo_trabalho'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para título do trabalho'),
            '#required' => TRUE,
        ];

        $form['ficha_catalografica']['container']['informacoes_obra']['cod_cutter'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para código cutter'),
            '#required' => TRUE,
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
            '#required' => TRUE,
        ];

        $form['ficha_catalografica']['container']['assuntos']['assunto2'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para segundo assunto'),
            '#required' => TRUE,
        ];

        $form['ficha_catalografica']['container']['assuntos']['assunto3'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para terceiro assunto'),
            '#required' => TRUE,
        ];

        $form['ficha_catalografica']['container']['assuntos']['assunto4'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para quarto assunto'),
            '#required' => TRUE,
        ];
        
        $form['ficha_catalografica']['container']['assuntos']['assunto5'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 125],
            '#title' => $this->t('Chave para quinto assunto'),
            '#required' => TRUE,
        ];
        $form['ficha_catalografica']['container']['info_ficha'] = [
            '#type' => 'fieldset',
            '#description' => $this->t('Utilize \n nos campos a seguir para pular linha.'),
            '#title' => $this->t('Informações da Ficha'),
        ];
        $form['ficha_catalografica']['container']['info_ficha']['cabecalho'] = [
            '#type' => 'textarea',
            '#attributes' => ['size' => 1500],
            '#description' => $this->t('Ex: Autorizo a reprodução e divulgação total ou parcial deste trabalho, por qualquer meio\nconvencional ou eletrônico, para fins de estudo e pesquisa, desde que citada a fonte.'),
            '#title' => $this->t('Cabeçalho'),
            '#required' => TRUE,
        ];
        $form['ficha_catalografica']['container']['info_ficha']['unidade'] = [
            '#type' => 'textfield',
            '#attributes' => ['size' => 1500],
            '#description' => $this->t('Ex: Nome da Faculdade - Nome da universidade (Faculdade de Filosofia, Letras e Ciências Humanas da Universidade de São Paulo)'),
            '#title' => $this->t('Unidade'),
            '#required' => TRUE,
        ];
        $form['ficha_catalografica']['container']['info_ficha']['descricao_ficha'] = [
            '#type' => 'textarea',
            '#attributes' => ['size' => 1500],
            '#description' => $this->t('Ex: Catalogação na Publicação\nServiço de Biblioteca e Documentação\nFaculdade de Filosofia, Letras e Ciências Humanas da Universidade de São Paulo'),
            '#title' => $this->t('Descrição da Ficha'),
            '#required' => TRUE,
        ];
        return $form;
    }

}