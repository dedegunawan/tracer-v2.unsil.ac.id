<?php

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
	function setWidthOfTable($widthOfTable) {
			$this->widthOfTable = $widthOfTable;
	}
	public function Header() {
		// Logo
		$image_file = FCPATH.'logo.png';
		// Image example with resizing
		$this->Image($image_file, 50, 10, 20);
		$this->SetFont('times', 'B', 11, '', true);
		$SetX = PDF_MARGIN_LEFT+35;
		$widthData = 297-2*(PDF_MARGIN_LEFT+35);
		$this->SetX($SetX);
		$this->Cell($widthData, 7, 'KEMENTERIAN RISET, TEKNOLOGI DAN PENDIDIKAN TINGGI', 0, 0, 'C');
		$this->Ln(6);
		$this->SetX($SetX);
		$this->SetFont('times', 'B', 15, '', true);
		$this->Cell($widthData, 7, 'UNIVERSITAS SILIWANGI', 0, 0, 'C');
		$this->Ln(6);
		$this->SetFont('times', '', 10, '', true);
		$this->SetX($SetX);
		$this->Cell($widthData, 7, 'Kampus : Jalan Siliwangi No. 24 | PO. BOX 164 | Tasikmalaya 46115', 0, 0, 'C');
		$this->Ln(4);
		$this->SetX($SetX);
		$this->Cell($widthData, 7, 'Telepon : +62 265 330634 - 333092 | Fax : +62 265 325812', 0, 0, 'C');
		$this->Ln(4);
		$this->SetX($SetX);
		$this->Cell($widthData, 7, 'Website : http://unsil.ac.id/ | email : info@unsil.ac.id', 0, 0, 'C');
		$this->Ln(4);
		$style = array('width' => 0.8, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
		$this->Line(15, 35, 277, 35, $style);
		$style = array('width' => 0.3, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 0, 0));
		$this->Line(15, 36.5, 277, 36.5, $style);

		/*
        $this->SetFont('times', 'B', 12, '', true);
		// Set font
		$this->Cell(0, 0, 'TRACER STUDY UNIVERSITAS SILIWANGI', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->SetFont('times', '', 12, '', true);
		$this->Cell(0, 0, 'nanti', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		*/
	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
		$this->SetY(-15);
		// Set font
		$this->SetFont('times', 'I', 8);
		// Page number
		$this->Cell(0, 10, 'Sistem Tracer Study UNSIL. Halaman '.$this->getAliasNumPage().' dari '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}

    // Load table data from file
    public function LoadData($file) {
        // Read file lines
        $lines = file($file);
        $data = array();
        foreach($lines as $line) {
            $data[] = explode(';', chop($line));
        }
        return $data;
    }

    // Colored table
    public function ColoredTable($header,$data) {
        // Colors, line width and bold font
        $this->SetFillColor(23,155,23);
        $this->SetTextColor(255);
        $this->SetDrawColor(0,0,0);
        $this->SetLineWidth(0.1);
        $this->SetFont('', 'B');
        // Header
        $w = $this->widthOfTable;
        $num_headers = count($header);
        for($i = 0; $i < $num_headers; ++$i) {
            $this->Cell($w[$i%$num_headers], 7, $header[$i], 1, 0, 'C', 1);
        }
        $this->Ln();
        // Color and font restoration
        $this->SetFillColor(224, 235, 255);

        $this->SetTextColor(0);
        $this->SetFont('');
        // Data
        $fill = 0;
        foreach($data as $row) {
			if ($fill) {
				$this->SetFillColor(224, 235, 255);
				$this->SetFillColor(255, 255, 255);
			}
			else {
				$this->SetFillColor(255, 255, 255);
			}
			$max_height = 0;
			for($i = 0; $i < $num_headers; ++$i) {
				$this->Cell($w[$i%$num_headers], 6, $row[$i], '1', 0, 'L', 1);
	        }

            $this->Ln();
            $fill=!$fill;
        }
        $this->Cell(array_sum($w), 0, '', 'T');
    }
}

$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Dede Gunawan');
$pdf->SetTitle('Data Alumni');
$pdf->SetSubject('Export Data Alumni, PDF');
$pdf->SetKeywords('Data Alumni, Tracer Study, unsil');
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);
// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('times', '', 9, '', true);
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP+15, -1);
$pdf->AddPage();
// Set some content to print
$pdf->setWidthOfTable(array(
	'8', '40', '20', '23', '30', '25', '45', '30', '35', '10'
));
$header = array(
	'No.',
	'Nama ',
	'Lulus (th)',
	'Angkatan (th)',
	'Tempat Bekerja',
	'Pekerjaan',
	'Alamat',
	'Telp/HP',
	'Email',
	'Kel'
);


$listProdi = $alumnis->pluck('prodi')->unique()->all();

$pdf->SetFont('times', 'B', 11, '', true);
$pdf->Cell('265', 6, 'REKAP DATA ALUMNI', 0, 1, 'C', 0);
$pdf->Cell('265', 6, 'TRACER STUDY UNIVERSITAS SILIWANGI', 0, 0, 'C', 0);
$pdf->Ln();
foreach ($listProdi as $ProdiID) {
	$start = 0;

	$datas = $alumnis->where('prodi', (string) $ProdiID);
	$lP = Prodi::where('ProdiID', (string) $ProdiID)->first();
	$pdf->SetFont('times', 'B', 10, '', true);
	$pdf->Cell('120', 6, 'Program Studi : '.$lP->Nama, 0, 0, 'L', 0);
	$pdf->SetFont('times', '', 9, '', true);
	$pdf->Ln();
	$data = array();
	foreach ($datas as $d) {
		$start++;
		$data[] = array($start, ucwords(strtolower($d->nama_depan." ".$d->nama_belakang)), $d->tahun_lulus, $d->tahun_angkatan, ucwords(strtolower($d->tempat_bekerja)), ucwords($d->pekerjaan), ucwords(strtolower($d->alamat)), $d->telp_hp, strtolower($d->email), strtoupper($d->jenis_kelamin));
	}
	$pdf->ColoredTable($header, $data);
	$pdf->Ln();
}
// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');
