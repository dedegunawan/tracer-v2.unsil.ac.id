<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */


function num2alpha($n) {
    $r = '';
    for ($i = 1; $n >= 0 && $i < 10; $i++) {
        $r = chr(0x41 + ($n % pow(26, $i) / pow(26, $i - 1))) . $r;
        $n -= pow(26, $i);
    }
    return $r;
}
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Jakarta');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');



// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Dede Gunawan")
	 ->setLastModifiedBy("Dede Gunawan")
	 ->setTitle("Template Data Alumni")
	 ->setSubject("Template Data Alumni")
	 ->setDescription("Template Data Alumni, XLS, XLSX")
	 ->setKeywords("Template Data Alumni with PHP")
	 ->setCategory("Template Data Alumni");


// Add some data
$baris = 3;

$column = array(
    'No.',
    'Nama Depan',
    'Nama Belakang',
    'Tahun Lulus',
    'Tahun Angkatan',
    'Pekerjaan',
    'Alamat',
    'Telp/HP',
    'Email',
    'Kontak lain',
    'Kode Prodi',
    'Tempat Bekerja',
    'Jenis Kelamin',
);
foreach ($pertanyaans as $key => $value) {
    $column[] = "Jawaban Soal No. $key";
}
$ab = $objPHPExcel->setActiveSheetIndex(0);
$startInit = 2;
$baris = 3;
foreach ($column as $key => $value) {
    $ab->setCellValue(num2alpha($startInit+$key).$baris, $value);
}


$start=0;

$start++;
$column = array(
    1,
    'Dede',
    'Gunawan',
    '2017',
    '2013',
    'Programmer',
    'Kp. Cioray, Ds. Jatiwaras, Kec. Jatiwaras',
    '082216320714',
    'dede@unsil.ac.id',
    '-',
    '7006',
    'Isi dengan tenpat bekerja',
    'L',
);

foreach ($pertanyaans as $key => $value) {
    $column[] = "-";
}
$ab = $objPHPExcel->setActiveSheetIndex(0);
$startInit = 2;
$baris = 3+$start;
foreach ($column as $key => $value) {
    $ab->setCellValue(num2alpha($startInit+$key).$baris, $value);
}


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Template Data Mahasiswa');

$objWorkSheet = $objPHPExcel->createSheet(1);

$column = array(
    "Soal No.",
    'Pertanyaan',
    'Pilihan Jawaban',
);

$startInit = 0;
$baris = 1;
foreach ($column as $key => $value) {
    $objWorkSheet->setCellValue(num2alpha($startInit+$key).$baris, $value);
}

foreach ($pertanyaans as $key => $pertanyaan) {
    $baris++;

    $objWorkSheet->setCellValue('A'.$baris, $key);
    $objWorkSheet->setCellValue('B'.$baris, $pertanyaan['pertanyaan']);
    if (!is_array($pertanyaan['pilihan']) && $pertanyaan['pilihan'] == 'textarea') {
        $objWorkSheet->setCellValue('C'.$baris, 'Isi dengan kalimat');
    } else {
        $pilihan = $pertanyaan['pilihan'];
        $fx = array();
        foreach ($pilihan as $k => $v) {
            $fx[] = "($k) => $v";
        }
        $objWorkSheet->setCellValue('C'.$baris, implode(",  ", $fx));
    }
}

// Rename sheet
$objWorkSheet->setTitle("Pertanyaan");


$objWorkSheet = $objPHPExcel->createSheet(2);

$column = array(
    "Kode Prodi",
    'Nama Prodi',
    'Fakultas',
    'Jenjang',
);

$startInit = 0;
$baris = 1;
foreach ($column as $key => $value) {
    $objWorkSheet->setCellValue(num2alpha($startInit+$key).$baris, $value);
}

foreach ($prodis as $key => $prodi) {
    $baris++;

    $objWorkSheet->setCellValue('A'.$baris, $prodi->ProdiID);
    $objWorkSheet->setCellValue('B'.$baris, $prodi->Nama);
    $objWorkSheet->setCellValue('C'.$baris, @$prodi->fakultas->Nama);
    $objWorkSheet->setCellValue('D'.$baris, @$prodi->jenjang->Nama);
}

// Rename sheet
$objWorkSheet->setTitle("Prodi");



// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="template-data-alumni.xls"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
