<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fpdf_gen {
		
	public function __construct() {
		
		require_once 'third_party/fpdf/fpdf.php';
		
		$pdf = new FPDF();
		$pdf->AddPage('P', 'Letter');
		
		$CI =& get_instance();
		$CI->fpdf = $pdf;
		
	}
	
}