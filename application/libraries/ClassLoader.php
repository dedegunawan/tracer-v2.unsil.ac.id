<?php
require_once APPPATH."libraries/LoginTrait.php";
require_once APPPATH."libraries/MessageParser.php";
require_once APPPATH."libraries/FormRemindPostValue.php";
require_once APPPATH."libraries/MainConfigLoader.php";
require_once APPPATH."libraries/BootApp.php";
require_once APPPATH."libraries/DataMining.php";

if ( ! function_exists('validation_errors_array'))
{
    function validation_errors_array()
    {
        if (FALSE === ($OBJ =& _get_validation_object()))
        {
            return '';
        }
        // No errrors, validation passes!
        if (count($OBJ->_error_array) === 0)
        {
            return '';
        }
        // Generate the error string
        $array = '';
        foreach ($OBJ->_error_array as $key => $val)
        {
            if ($val != '')
            {
                $array[$key]= $val;
            }
        }
        return $array;
    }
}


if ( ! function_exists('bulan'))
{
    function bulan()
    {
        return array(
			'1' => 'Januari',
			'2' => 'Pebruari',
			'3' => 'Maret',
			'4' => 'April',
			'5' => 'Mei',
			'6' => 'Juni',
			'7' => 'Juli',
			'8' => 'Agustus',
			'9' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember',
		);
    }
}

if ( ! function_exists('bulan_indo'))
{
    function bulan_indo($tgl)
    {
        $bulan = bulan();
		$ab = explode("-", $tgl);
		$ax = array_reverse($ab);
		$ax[1] = @$bulan[(int) @$ax[1]];
		return implode(" ", $ax);
    }
}
