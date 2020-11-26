<?php 

namespace Drupal\webform_ficha_catalografica\Utils;

use Drupal\webform\Entity\WebformSubmission;
use Drupal\webform\WebformSubmissionInterface;

use Cezpdf;

class Ficha {
	public static function fields(WebformSubmissionInterface $webform_submission){

	  $data = $webform_submission->getData();
	  $webform = $webform_submission->getWebform();
	  
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
	  
	  #dump($data);
	  #dump($element);
  
	  return [
		'pessoa_nome' => $data[$element["#pessoa_nome"]],
		'pessoa_ultimonome' => $data[$element["#pessoa_ultimonome"]],
		# Completar...
	  ];
	}

	public static function pdf($webform_submission) {
		$fields = self::fields($webform_submission);

		$pdf = new Cezpdf('a4','portrait','color',[0.8,0.8,0.8]);
		// Set pdf Bleedbox
		$pdf->ezSetMargins(20,20,20,20);
		// Use one of the pdf core fonts
		$mainFont = 'Times-Roman';
		// Select the font
		$pdf->selectFont($mainFont);
		// Define the font size
		$size=12;
		// Modified to use the local file if it can
		$pdf->openHere('Fit');
		
		// Output some colored text by using text directives and justify it to the right of the document
		$content = "Esse é o nome {$fields['pessoa_nome']} e esse adivinha? {$fields['pessoa_ultimonome']} ";
		$pdf->ezText($content, $size, ['justification'=>'right']);
		
		// Output the pdf as stream, but uncompress
		return $pdf->ezStream(['compress'=>0]);
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




 

