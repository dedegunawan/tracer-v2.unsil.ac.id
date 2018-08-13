<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."/libraries/TraitTemplate.php";
require_once APPPATH."/libraries/DummyConfiguration.php";
require_once APPPATH."/libraries/LoginTrait.php";
require_once APPPATH."/libraries/FormRemindPostValue.php";
require_once APPPATH."/libraries/MessageParser.php";
require_once APPPATH."/libraries/ClassLoader.php";

function checker_year($tahun_angkatan, $tahun_lulus) {
	$sisa = $tahun_lulus - $tahun_angkatan;
	if (
		$sisa >= 4
		&&
		$tahun_angkatan >= 1978
		&&
		$tahun_lulus <= date('Y')
	) {
		return true;
	}
	if ($sisa < 4) {
		return "Kuliah dibawah 4 tahun, {$tahun_angkatan} - {$tahun_lulus}";
	}
	if ($tahun_angkatan < 1978) {
		return "Tahun Angkatan tidak ada, {$tahun_angkatan}";
	}
	if ($tahun_lulus > date('Y') ) {
		return "Tahun Angkatan tidak ada, {$tahun_lulus}";
	}
	return false;
}
function checker_jawaban($arrayOfPertanyaan, $collectionJawaban) {
	if (count($arrayOfPertanyaan) == $collectionJawaban->count()) {
		return true;
	}
	else {
		return "jumlah jawaban tidak sama dengan jumlah pertanyaan";
	}
	return false;
}
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL)
        && preg_match('/@.+\./', $email);
}
function isValidNoHp($no_hp) {
    $no_hp_t = trim($no_hp, "+");
    $no_hp_t = trim($no_hp_t);
	return is_numeric($no_hp);

}
function check_kontak($email, $no_hp) {
	$emailV = isValidEmail($email);
	$no_hpV = isValidNoHp($no_hp);
	if ($emailV && $no_hp) {
		return true;
	}
	if (!$emailV) {
		return "Email tidak valid";
	}
	if (!$no_hpV) {
		return "No HP tidak valid";
	}
	return false;
}

class CleaningAlumni extends CI_Controller {
	use TraitTemplate;
	use LoginTrait;
	function __construct() {
		parent::__construct();
		$this->load->database();

		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');

		$this->init(APPPATH."/views/backend/");
		//access template engine : $this->template

		//store ci object to template engine
        //var_dump();
		$this->template->addData([
			'ci' => get_instance(),
            'conf' => new DummyConfiguration($this->config->item('conf_dummy_configuration_property')),


		]);
        $this->needLogin();

		$this->load->model('ButirPertanyaan');
		$this->load->model('DataAlumniTemp');
		$this->load->model('JawabanAlumniTemp');
		$this->load->model('Prodi');
		$this->load->model('ValidAlumni');
		$this->load->library('role');
		$this->role->hasAccessWithRedirect(get_class($this));


	}
	public function index()
	{
		/*
			algoritma :
				persiapan :
					-> data pertanyaan,
					-> data alumni,
					-> jawaban dari seluruh alumni
				baca list seluruh alumni,
					-> by looping
					-> ketika looping,
						hitung jumlah pertanyaan === jumlah jawaban alumni,
						data alumni : nama_depan, nama_belakang, pekerjaan, alamat, kontak lainnya, tempat_bekerja,
						email valid
						tahun lulus, tahun angkatan,
						telp_hp

		*/
		$bt = new ButirPertanyaan;
		$pertanyaans = $bt->alumni();
		$alumnis = DataAlumniTemp::all();
		$this->template->addData([
			'pertanyaans' => $pertanyaans,
            'alumnis' => $alumnis,

		]);
		echo $this->template->render('content/cleaningalumni/index');
	}

	function urlController() {
		$className = strtolower(get_class($this));
		return (object) array(
			'index' => $className."/index",
			'edit' => $className."/edit",
			'hapus' => $className."/hapus",
			'tambah' => $className."/tambah",
			'lihat' => "masteralumni/lihat",
		);
	}

	function hapus($id) {
		$pengguna = DataAlumniTemp::find($id);
		$jawaban = JawabanAlumniTemp::where('alumni_temp_id', $id)->delete();
		$pengguna->delete();
		$_SESSION['message']['success'][] = "Hapus Data Berhasil";
		redirect(base_url($this->urlController()->index));
	}
	//validation
	function is_angka($str) {
		if (is_numeric($str)) {
			return true;
		}
		else {
			$this->form_validation->set_message('is_angka', 'Kolom {field} harus berupa angka');
            return FALSE;
		}
	}
	//validation
	function valid_year($str) {
		if ($str >= 1978 && $str <= date('Y')) {
			return true;
		}
		else {
			$this->form_validation->set_message('valid_year', 'Kolom {field} harus berupa tahun angkatan anda.');
            return FALSE;
		}
	}
	function is_valid_prodi($str) {
		$listProdi=Prodi::all()->pluck('ProdiID');
		if ($listProdi->search($str) !== FALSE) {
			return true;
		}
		else {
			$this->form_validation->set_message('is_valid_prodi', 'Prodi Tidak Valid');
            return FALSE;
		}
	}
}
