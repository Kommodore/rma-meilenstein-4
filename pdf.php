<?php
	include( 'fpdf181/fpdf.php' );

	$row     = 0;
	$content = array();
	$thead   = array();
	if(($handle = fopen( "input.csv", "r" ) ) !== false) {
		$pdf = new FPDF();
		$pdf->SetFont('Arial','',14);
		$pdf->AddPage();

		while(($data = fgetcsv( $handle, 1000, "," ) ) !== false ){
			if( $row ++ == 0 ){
				$num = count($data);
				for ( $col = 0; $col < $num; $col ++ ) {
					$pdf->Cell( 65, 7, $data[$col], 1 );
				}
				$pdf->Ln();
			} else {
				$num = count( $data );
				for ( $col = 0; $col < $num; $col ++ ) {
					$pdf->Cell( 65, 6, $data[$col], 1 );
				}
				$pdf->Ln();
			}
		}
		fclose( $handle );
		$pdf->Output();
	}
