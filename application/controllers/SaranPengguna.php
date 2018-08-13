<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."/libraries/TraitTemplate.php";
require_once APPPATH."/libraries/DummyConfiguration.php";
require_once APPPATH."/libraries/LoginTrait.php";
require_once APPPATH."/libraries/FormRemindPostValue.php";
require_once APPPATH."/libraries/MessageParser.php";
require_once APPPATH."/libraries/ClassLoader.php";


class SaranPengguna extends CI_Controller {
	use TraitTemplate;
	use LoginTrait;
	function __construct() {
		parent::__construct();
		$this->load->database();
		/*
		$this->load->model('DataAlumniTemp');
		$this->load->model('JawabanAlumniTemp');
		$this->load->model('DataAlumniTemp');
		$this->load->model('JawabanAlumniTemp');
		$this->load->model('Prodi');
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
		$this->load->model('Pekerjaan');
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
		$this->template->addData([
			'alumnis' => $out->get(),
			'listAngkatan' => $listAngkatan,
			'message' => MessageParser::parse_flash(),

		]);

		echo $this->template->render('content/saranpengguna/index');
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
		$alumni = DataAlumniTemp::find($id);
		$jawaban = JawabanAlumniTemp::where('alumni_temp_id', $id)->delete();
		$alumni->delete();
		$_SESSION['message']['success'][] = "Hapus Data Berhasil";
		redirect(base_url($this->urlController()->index));
	}
	function lihat($id) {
		$bt = new ButirPertanyaan;
		$alumni = DataAlumniTemp::find($id);
		$this->template->addData([
			'alumni' => $alumni,
			'message' => MessageParser::parse_flash(),
			'pertanyaans' => $bt->alumni(),

		]);
		echo $this->template->render('content/saranpengguna/lihat');
	}


	function do_xls_download() {
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
		$this->template->addData([
			'alumnis' => $out->get(),
			'listAngkatan' => $listAngkatan,

		]);
		echo $this->template->render('content/saranpengguna/xlsDownload');
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
		$this->template->addData([
			'alumnis' => $out->get(),
			'listAngkatan' => $listAngkatan,

		]);
		echo $this->template->render('content/saranpengguna/pdfDownload');
	}
	public function tambah()
	{
		$bt = new ButirPertanyaan;
		FormRemindPostValue::detectPost();
		//var_dump($_POST);
		$this->form_validation->set_message('required', 'Kolom {field} Harus Diisi.');
		$this->form_validation->set_rules('nama_depan', 'Nama Depan', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('nama_belakang', 'Nama Belakang', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('tahun_lulus', 'Tahun Lulus', 'required|callback_is_angka|callback_valid_year', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('tahun_angkatan', 'Tahun Angkatan', 'required|callback_is_angka|callback_valid_year', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('prodi', 'Program Studi', 'required|callback_is_valid_prodi', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('tempat_bekerja', 'Tempat Bekerja', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('alamat', 'Alamat', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('telp_hp', 'Telp / HP', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('email', 'Email', 'required', array('required' => '%s harus diisi'));

		$pertanyaans = $bt->alumni();
		foreach ($pertanyaans as $key => $pertanyaan) {
			if ($pertanyaan['required']) {
				$this->form_validation->set_rules('pertanyaan'.$key, 'Pertanyaan No '.$key, 'required', array('required' => '%s harus diisi'));
			}
		}
		if($this->form_validation->run() == false) {
			MessageParser::get_error_form_validation();
			$this->template->addData([
				'pertanyaans' => $pertanyaans,
				'message' => MessageParser::parse_flash(),
				'prodis' => Prodi::orderBy('ProdiID')->get(),
				'pekerjaans' => Pekerjaan::orderBy('nama_pekerjaan')->get(),
				'page_title' => 'Tambah Data',

			]);
			echo $this->template->render('content/saranpengguna/tambah');
		} else {
			$alumni = new DataAlumniTemp;
			$alumni->nama_depan = $this->input->post('nama_depan');
			$alumni->nama_belakang = $this->input->post('nama_belakang');
			$alumni->tahun_lulus = $this->input->post('tahun_lulus');
			$alumni->tahun_angkatan = $this->input->post('tahun_angkatan');
			$pk = $this->input->post('pekerjaan');
			$pkr = Pekerjaan::find($pk);
			$alumni->pekerjaan = @$pkr->nama_pekerjaan;
			$alumni->alamat = $this->input->post('alamat');
			$alumni->telp_hp = $this->input->post('telp_hp');
			$alumni->email = $this->input->post('email');
			$alumni->kontak_lainnya = $this->input->post('kontak_lainnya');
			$alumni->tempat_bekerja = $this->input->post('tempat_bekerja');
			$alumni->prodi = $this->input->post('prodi');
			$alumni->jenis_kelamin = $this->input->post('jenis_kelamin');
			$alumni->operator = $this->isLogin();
			$alumni->save();
			foreach ($pertanyaans as $key => $pertanyaan) {
				$jawaban = new JawabanAlumniTemp;
				$jawaban->alumni_temp_id = $alumni->id;
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
