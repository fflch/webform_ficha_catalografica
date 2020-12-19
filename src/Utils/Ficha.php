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
	  ];
	}

	public static function pdf($webform_submission) {
		$fields = self::fields($webform_submission);
		
		$orientadora = $fields['sou_orientadora'] ? 'a' : '';//se for do gênero feminino
		
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
		// monta informações da ficha catalográfica
		$texto = $fields['pessoa_ultimonome'].", ".$fields['pessoa_nome']."\n   ".$fields['titulo_trabalho']." / ".	$fields['pessoa_nome']." ".$fields['pessoa_ultimonome']." ; orientador$orientadora ".$fields['orientador_nome']." ".$fields['orientador_ultimonome'].". - São Paulo, ".$fields['ano'].".\n   ".$fields['no_paginas']." f.\n\n\n   ".$fields['tipo_trabalho']; 
		
		
		$texto .= "- Faculdade de Filosofia, Letras e Ciências Humanas da Universidade de São Paulo. ".$fields['departamento'].	". Área de concentração: ".$fields['area_concentracao'].". \n\n\n   1. ".$fields['assunto1'].". ";
	
		if (!empty ($fields['assunto2'])) 
			$texto .= "2. ".$fields['assunto2'].". "; 
	
		if (!empty ($fields['assunto3'])) 
			$texto .= "3. ".$fields['assunto3'].". "; 
	
		if (!empty ($fields['assunto4'])) 
			$texto .= "4. ".$fields['assunto4'].". "; 
	
		if (!empty ($fields['assunto5'])) 
			$texto .= "5. ".$fields['assunto5'].". ";
			
		$texto .= "I. ".$fields['orientador_ultimonome'].", ".$fields['orientador_nome'].", orient. II. Título.";
	
	
	$ficha = array (array('cod' => "\n".$codigo, 'ficha' => $texto));
	
	// Gera a ficha em pdf
	$pdf = new Cezpdf('a4','portrait','color',[255,255,255]);

	$pdf -> selectFont("../pdf-php/fonts/Times-Roman.afm");
	
	$pdf -> ezText ("Autorizo a reprodução e divulgação total ou parcial deste trabalho, por qualquer meio\nconvencional ou eletrônico, para fins de estudo e pesquisa, desde que citada a fonte.\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", 10, array('justification' => 'center'));
	
	$pdf -> rectangle(116,90,350,210);
	
	$pdf -> ezText ("Catalogação na Publicação\nServiço de Biblioteca e Documentação\nFaculdade de Filosofia, Letras e Ciências Humanas da Universidade de São Paulo\n\n", 10, array('justification' => 'center'));
	
	$pdf->selectFont("../pdf-php/fonts/Courier.afm");
	
	$pdf -> ezTable ($ficha,'','', array ('fontSize' => 9,'showHeadings'=>0, 'showLines'=>0, 'width'=>345, 'cols' =>array('cod'=>array('width'=>45))));
	
	
	$pdf->ezStream();   
	
	}


/*
	$codigo1 = substr($sobrenome,0,1);
	// separa o t�tulo por espa�os em branco e verifica a primeira palavra
	// se a primeira palavra for uma stopword, o $codigo2 ser� a primeira letra da segunda palavra do t�tulo
	
	$vetitulo = explode (" ",$titulo);
	
	$stopwords = array ("o", "a", "os", "as", "um", "uns", "uma", "umas", "de", "do", "da", "dos", "das", "no", "na", "nos", "nas", "ao", "aos", "�", "�s", "pelo", "pela", "pelos", "pelas", "duma", "dumas", "dum", "duns", "num", "numa", "nuns", "numas", "com", "por", "em");

	if (in_array (strtolower($vetitulo[0]), $stopwords))
		$codigo2 = strtolower(substr($vetitulo[1],0,1));
	else
		$codigo2 = strtolower(substr($vetitulo[0],0,1));

// monta o C�digo Cutter
	$codigo = $codigo1.$cutter.$codigo2;
// monta informa��es da ficha catalogr�fica
	$texto = $sobrenome.", ".$nome."\n   ".$titulo." / ".$nome." ".$sobrenome." ; orientador$orientadora ".$nome_ori." ".$sobrenome_ori.". - S�o Paulo, ".$ano.".\n   $pags f.\n\n\n   ".$trabalho; 

	$texto .= "- Faculdade de Filosofia, Letras e Ci�ncias Humanas da Universidade de S�o Paulo. $departamento. �rea de concentra��o: $area. \n\n\n   1. ".$assunto1.". ";

	if (!empty ($assunto2)) 

		$texto .= "2. $assunto2. "; 

	if (!empty ($assunto3)) 

		$texto .= "3. $assunto3. "; 

	if (!empty ($assunto4)) 

		$texto .= "4. $assunto4. "; 

	if (!empty ($assunto5)) 

		$texto .= "5. $assunto5. ";

	$texto .= "I. $sobrenome_ori, $nome_ori, orient. II. T�tulo.";


$ficha = array (array('cod' => "\n".$codigo, 'ficha' => $texto));

// Gera a ficha em pdf

$pdf -> selectFont("../pdf-php/fonts/Times-Roman.afm");

$pdf -> ezText ("Autorizo a reprodu��o e divulga��o total ou parcial deste trabalho, por qualquer meio\nconvencional ou eletr�nico, para fins de estudo e pesquisa, desde que citada a fonte.\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n", 10, array('justification' => 'center'));

$pdf -> rectangle(116,90,350,210);

$pdf -> ezText ("Cataloga��o na Publica��o\nServi�o de Biblioteca e Documenta��o\nFaculdade de Filosofia, Letras e Ci�ncias Humanas da Universidade de S�o Paulo\n\n", 10, array('justification' => 'center'));

$pdf->selectFont("../pdf-php/fonts/Courier.afm");

$pdf -> ezTable ($ficha,'','', array ('fontSize' => 9,'showHeadings'=>0, 'showLines'=>0, 'width'=>345, 'cols' =>array('cod'=>array('width'=>45))));


$pdf->ezStream();   
*/

}




 

