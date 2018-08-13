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
	 ->setTitle("Export Data Alumni")
	 ->setSubject("Export Data Alumni")
	 ->setDescription("Export Data Alumni, XLS, XLSX")
	 ->setKeywords("Export Data Alumni with PHP")
	 ->setCategory("Export Data Alumni");


// Add some data
$baris = 3;

$column = array(
    'No.',
    'Nama ',
    'Kritik &amp; Saran',
);
$ab = $objPHPExcel->setActiveSheetIndex(0);
$startInit = 2;
$baris = 3;
foreach ($column as $key => $value) {
    $ab->setCellValue(num2alpha($startInit+$key).$baris, $value);
}


$start=0;

foreach($alumnis as $alumni) {
    $start++;
    $column = array(
        $start,
        $alumni->nama_alumni,
        @$alumni->jawaban_alumni_temp()->where('pertanyaan_id', 8)->first()->jawaban,
    );
    $ab = $objPHPExcel->setActiveSheetIndex(0);
    $startInit = 2;
    $baris = 3+$start;
    foreach ($column as $key => $value) {
        $ab->setCellValue(num2alpha($startInit+$key).$baris, $value);
    }

}


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Kritik & Saran');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="data-alumni-'.$ci->uri->segment(3).'-'.$ci->uri->segment(4).'.xls"');
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
