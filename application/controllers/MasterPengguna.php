<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."/libraries/TraitTemplate.php";
require_once APPPATH."/libraries/DummyConfiguration.php";
require_once APPPATH."/libraries/LoginTrait.php";
require_once APPPATH."/libraries/FormRemindPostValue.php";
require_once APPPATH."/libraries/MessageParser.php";
require_once APPPATH."/libraries/ClassLoader.php";


class MasterPengguna extends CI_Controller {
	use TraitTemplate;
	use LoginTrait;
	function __construct() {
		parent::__construct();
		$this->load->database();
		/*
		$this->load->model('DataAlumniTemp');
		$this->load->model('JawabanAlumniTemp');
		$this->load->model('DataPenggunaTemp');
		$this->load->model('JawabanPenggunaTemp');
		$this->load->model('Jenjang');
		$this->load->model('Pekerjaan');
		$this->load->model('ButirPertanyaan', 'bp');
		*/
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
		$this->load->model('DataPenggunaTemp');
		$this->load->model('JawabanPenggunaTemp');
		$this->load->model('Prodi');
		$this->load->model('Jenjang');
		$this->load->library('role');
		$this->role->hasAccessWithRedirect(get_class($this));

	}
	public function index()
	{
		$out = new DataPenggunaTemp;
		$ox = $this->uri->segment(3);
		if ($ox) {
			$out = $out->where('prodi', (string) $ox);
			$listAngkatan = $out->get()->pluck('tahun_angkatan')->unique()->all();
		}
		else {
			$listAngkatan = array();
		}

		$oz = $this->uri->segment(4);
		if ($oz) {
			$out = $out->where('tahun_angkatan', (string) $oz);
		}

		$out = $out->get();

		$this->template->addData([
			'penggunas' => $out,
			'listAngkatan' => $listAngkatan,
			'message' => MessageParser::parse_flash(),

		]);

		echo $this->template->render('content/masterpengguna/index');
	}
	public function do_xls_download()
	{
		$out = new DataPenggunaTemp;
		$ox = $this->uri->segment(3);
		if ($ox) {
			$out = $out->where('prodi', (string) $ox);
			$listAngkatan = $out->get()->pluck('tahun_angkatan')->unique()->all();
		}
		else {
			$listAngkatan = array();
		}

		$oz = $this->uri->segment(4);
		if ($oz) {
			$out = $out->where('tahun_angkatan', (string) $oz);
		}

		$out = $out->get();

		$this->template->addData([
			'penggunas' => $out,
			'listAngkatan' => $listAngkatan,

		]);

		echo $this->template->render('content/masterpengguna/xlsDownload');
	}


	function do_pdf_cetak() {
		$out = new DataPenggunaTemp;
		$ox = $this->uri->segment(3);
		if ($ox) {
			$out = $out->where('prodi', (string) $ox);
			$listAngkatan = $out->get()->pluck('tahun_angkatan')->unique()->all();
		}
		else {
			$listAngkatan = array();
		}

		$oz = $this->uri->segment(4);
		if ($oz) {
			$out = $out->where('tahun_angkatan', (string) $oz);
		}

		$out = $out->orderBy('prodi', 'asc');
		$out = $out->orderBy('tahun_angkatan', 'asc');
		$out = $out->orderBy('nama_alumni', 'asc');
		//$out = $out->get();

		$this->template->addData([
			'penggunas' => $out->get(),
			'listAngkatan' => $listAngkatan,

		]);
		echo $this->template->render('content/masterpengguna/pdfDownload');
	}

	function urlController() {
		$className = strtolower(get_class($this));
		return (object) array(
			'index' => $className."/index",
			'edit' => $className."/edit",
			'hapus' => $className."/hapus",
			'tambah' => $className."/tambah",
			'lihat' => $className."/lihat",

			'pdf' => $className."/do_pdf_cetak",
			'xls' => $className."/do_xls_download",
		);
	}

	function hapus($id) {
		$pengguna = DataPenggunaTemp::find($id);
		$jawaban = JawabanPenggunaTemp::where('pengguna_temp_id', $id)->delete();
		$pengguna->delete();
		$_SESSION['message']['success'][] = "Hapus Data Berhasil";
		redirect(base_url($this->urlController()->index));
	}

	function lihat($id) {
		$bt = new ButirPertanyaan;
		$pengguna = DataPenggunaTemp::find($id);
		$this->template->addData([
			'pengguna' => $pengguna,
			'message' => MessageParser::parse_flash(),
			'pertanyaans' => $bt->pengguna(),
			'page_title' => 'Detail Data',

		]);
		echo $this->template->render('content/masterpengguna/lihat');
	}

	public function tambah()
	{
		$bt = new ButirPertanyaan;
		FormRemindPostValue::detectPost();
		$this->form_validation->set_message('required', 'Kolom {field} Harus Diisi.');
		$this->form_validation->set_rules('nama_lembaga', 'Nama Lembaga', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('nama_alumni', 'Nama Alumni', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('tahun_angkatan', 'Tahun Angkatan', 'required|callback_is_angka|callback_valid_year', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('tahun_lulus', 'Tahun Lulus', 'required|callback_is_angka|callback_valid_year', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('email_lembaga', 'Email Lembaga', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('prodi', 'Program Studi', 'required|callback_is_valid_prodi', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required', array('required' => '%s harus diisi'));
		$pertanyaans = $bt->pengguna();
		foreach ($pertanyaans as $key => $pertanyaan) {
			if ($pertanyaan['required']) {
				$this->form_validation->set_rules('pertanyaan'.$key, 'Pertanyaan No '.$key, 'required', array('required' => '%s harus diisi'));
			}
		}
		if($this->form_validation->run() == false) {
			MessageParser::get_error_form_validation();
			$this->template->addData([
				'pertanyaans' => $pertanyaans,
				'prodis' => Prodi::where('NA', 'N')->orderBy('JenjangID')->orderBy('Nama')->get(),
				'message' => MessageParser::parse_flash(),
				'page_title' => 'Tambah Data',

			]);
			echo $this->template->render('content/masterpengguna/tambah');
		} else {
			$pengguna = new DataPenggunaTemp;
			$pengguna->nama_lembaga = $this->input->post('nama_lembaga');
			$pengguna->jabatan = $this->input->post('jabatan');
			$pengguna->email_lembaga = $this->input->post('email_lembaga');
			$pengguna->nama_alumni = $this->input->post('nama_alumni');
			$pengguna->tahun_angkatan = $this->input->post('tahun_angkatan');
			$pengguna->tahun_lulus = $this->input->post('tahun_lulus');
			$pengguna->prodi = $this->input->post('prodi');
			$pengguna->jenis_kelamin = $this->input->post('jenis_kelamin');
			$pengguna->operator = $this->isLogin();
			$pengguna->save();

			foreach ($pertanyaans as $key => $pertanyaan) {
				$jawaban = new JawabanPenggunaTemp;
				$jawaban->pengguna_temp_id = $pengguna->id;
				$jawaban->pertanyaan_id = $key;
				$jawaban->jawaban = $this->input->post('pertanyaan'.$key);
				$jawaban->save();
			}
			$_SESSION['message']['success'][] = "Input Data Berhasil";
			redirect(base_url($this->urlController()->index));
		}
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
