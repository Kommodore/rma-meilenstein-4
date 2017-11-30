<?php
	include( 'fpdf181/fpdf.php' );
	include('CSVHandler.php');

	$csv = new CSVHandler('input.csv');

	$row     = 0;
	$content = array();
	$thead   = array();
	if(($handle = fopen( "input.csv", "r" ) ) !== false) {
		$pdf = new FPDF();
		$pdf->SetFont('Arial','',14);
		$pdf->AddPage();

		foreach($csv->getColumns() as $column){
			$pdf->Cell( 65, 7, $column, 1 );
		}
		$pdf->Ln();
		foreach($csv->getContent() as $content){
			foreach($content as $entry){
				$pdf->Cell( 65, 7, $entry, 1 );
			}
			$pdf->Ln();
		}

		fclose( $handle );
		$pdf->Output();
	}
