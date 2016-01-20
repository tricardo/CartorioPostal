<?php

require("../includes/fpdf/fpdf.php");
require_once ('PDF.php');
require_once ('NotificacaoScania.php');

class PDFFactory {
	
	/**
	 * 
	 * @param PDF $pdf
	 */
	public static function retornaPDF($pedido,$pdf){
		switch($pdf){
			case 'scania':
				return new NotificacaoScania($pedido);
		}
	}
}


?>