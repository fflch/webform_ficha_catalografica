<?php 

namespace Drupal\webform_ficha_catalografica\Utils;

use Drupal\webform\Entity\WebformSubmission;
use Drupal\webform\WebformSubmissionInterface;

use Cezpdf;

class Ficha {
	public static function fields(WebformSubmissionInterface $webform_submission){

	  $data = $webform_submission->getData();//dados da submissão
	  $webform = $webform_submission->getWebform();//configs do webform
	  
	  # Vamos verificar se esse formulário tem campo do tipo ficha catalográfica
	  # se tiver mais que um, consideramos somente o último ...
	  $ficha_field = FALSE;
	  $elements = $webform->getElementsDecoded();
	  foreach ($elements as $element) {
		if($element['#type'] == 'ficha_catalografica'){
			$ficha_field = $element;
		}
	  }
	  # TODO: O que faremos senão tiver nenhum campo do tipo ficha?
	  
	  return [
		'pessoa_nome' => $data[$ficha_field["#pessoa_nome"]],
		'pessoa_ultimonome' => $data[$ficha_field["#pessoa_ultimonome"]],
		'orientador_nome' => $data[$ficha_field["#orientador_nome"]],
		'orientador_ultimonome' => $data[$ficha_field["#orientador_ultimonome"]],
		'sou_orientadora' => $data[$ficha_field["#sou_orientadora"]],
		'coorientador_nome' => $data[$ficha_field["#coorientador_nome"]],
		'coorientador_ultimonome' => $data[$ficha_field["#coorientador_ultimonome"]],
		'sou_coorientadora' => $data[$ficha_field["#sou_coorientadora"]],
		'tipo_trabalho' => $data[$ficha_field["#tipo_trabalho"]],
		'departamento' => $data[$ficha_field["#departamento"]],
		'area_concentracao' => $data[$ficha_field["#area_concentracao"]],
		'ano' => $data[$ficha_field["#ano"]],
		'no_paginas' => $data[$ficha_field["#no_paginas"]],
		'titulo_trabalho' => $data[$ficha_field["#titulo_trabalho"]],
		'cod_cutter' => $data[$ficha_field["#cod_cutter"]],
		'assunto1' => $data[$ficha_field["#assunto1"]],
		'assunto2' => $data[$ficha_field["#assunto2"]],
		'assunto3' => $data[$ficha_field["#assunto3"]],
		'assunto4' => $data[$ficha_field["#assunto4"]],
		'assunto5' => $data[$ficha_field["#assunto5"]],
		'cabecalho' => $ficha_field["#cabecalho"],
		'unidade' => $ficha_field["#unidade"],
		'cidade' => $ficha_field["#cidade"],
		'descricao_ficha' => $ficha_field["#descricao_ficha"],
	  ];
	}

	public static function pdf($webform_submission) {
		$fields = self::fields($webform_submission);
		
		$orientadora = $fields['sou_orientadora'] ? 'a' : ''; //se for do gênero feminino
		$coorientadora = $fields['sou_coorientadora'] ? 'a' : ''; //se for do gênero feminino
		
		$codigo1 = substr($fields['pessoa_ultimonome'],0,1);
		// separa o título por espaços em branco e verifica a primeira palavra
		// se a primeira palavra for uma stopword, o $codigo2 será a primeira letra da segunda palavra do título
		
		$vetitulo = explode (" ",$fields['titulo_trabalho']);
		
		$stopwords = array ("o", "a", "os", "as", "um", "uns", "uma", "umas", "de", "do", "da", "dos", "das", "no", "na", "nos", "nas", "ao", "aos", "à", "às", "pelo", "pela", "pelos", "pelas", "duma", "dumas", "dum", "duns", "num", "numa", "nuns", "numas", "com", "por", "em");
	
		if (in_array (strtolower($vetitulo[0]), $stopwords))
			$codigo2 = strtolower(substr($vetitulo[1],0,1));
		else
			$codigo2 = strtolower(substr($vetitulo[0],0,1));
	
		// monta o Código Cutter
		$codigo = $codigo1.$fields['cod_cutter'].$codigo2;

		$aux_orientador = "; orientador$orientadora ".$fields['orientador_nome']." ".$fields['orientador_ultimonome'];
		$orientador_texto = isset($fields['orientador_nome']) && strlen($fields['orientador_nome']) > 0 && isset($fields['orientador_ultimonome']) && strlen($fields['orientador_ultimonome']) > 0  ? $aux_orientador : "";
		
		$aux_coorientador = "; coorientador$coorientadora ".$fields['coorientador_nome']." ".$fields['coorientador_ultimonome'];
		$coorientador_texto = isset($fields['coorientador_nome']) && strlen($fields['coorientador_nome']) > 0 && isset($fields['coorientador_ultimonome']) && strlen($fields['coorientador_ultimonome']) > 0  ? $aux_coorientador : "";


		// monta informações da ficha catalográfica
		$texto = $fields['pessoa_ultimonome'].", ".$fields['pessoa_nome']."\n   ".$fields['titulo_trabalho']." / ".	$fields['pessoa_nome']." ".$fields['pessoa_ultimonome']. $orientador_texto . $coorientador_texto . " - ".$fields['cidade'].", ".$fields['ano'].".\n   ".$fields['no_paginas']." f.\n\n\n   ".$fields['tipo_trabalho']; 
		
		$departamento_texto = isset($fields['departamento']) && strlen($fields['departamento']) > 0 ? " ".$fields['departamento'].". " : " ";  
		$area_texto = isset($fields['area_concentracao']) && strlen($fields['area_concentracao']) > 0 ? "Área de concentração: ".$fields['area_concentracao'].". " : " ";  
		$texto .= "- ".str_replace('\n', PHP_EOL,$fields['unidade']).".".$departamento_texto.	$area_texto."\n\n\n   1. ".$fields['assunto1'].". ";
	
		if (!empty ($fields['assunto2'])) 
			$texto .= "2. ".$fields['assunto2'].". "; 
	
		if (!empty ($fields['assunto3'])) 
			$texto .= "3. ".$fields['assunto3'].". "; 
	
		if (!empty ($fields['assunto4'])) 
			$texto .= "4. ".$fields['assunto4'].". "; 
	
		if (!empty ($fields['assunto5'])) 
			$texto .= "5. ".$fields['assunto5'].". ";
		
		if (isset($fields['orientador_nome']) && strlen($fields['orientador_nome']) > 0 && isset($fields['orientador_ultimonome']) && strlen($fields['orientador_ultimonome']) > 0)
			$texto .= "I. ".$fields['orientador_ultimonome'].", ".$fields['orientador_nome'].", orient. II. Título.";
	
	
	$ficha = array (array('cod' => "\n".$codigo, 'ficha' => $texto));
	
	// Gera a ficha em pdf
	$pdf = new Cezpdf('a4','portrait','color',[255,255,255]);

	$pdf->selectFont('Times-Roman');
	
	$pdf->ezText (str_replace('\n', PHP_EOL, $fields['cabecalho']) . "\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", 10, array('justification' => 'center'));
	
	$pdf->rectangle(116,90,350,210);
	
	$pdf->ezText (str_replace('\n', PHP_EOL,$fields['descricao_ficha']) . "\n\n", 10, array('justification' => 'center'));
	
	$pdf->selectFont('Courier');
	
	$pdf->ezTable ($ficha,'','', array ('fontSize' => 9,'showHeadings'=>0, 'showLines'=>0, 'width'=>345, 'cols' =>array('cod'=>array('width'=>45))));

	$pdf->ezStream();   
	
	}
}




 

