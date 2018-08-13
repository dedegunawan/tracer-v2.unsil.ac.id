<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."/libraries/TraitTemplate.php";
require_once APPPATH."/libraries/DummyConfiguration.php";
require_once APPPATH."/libraries/LoginTrait.php";
require_once APPPATH."/libraries/FormRemindPostValue.php";
require_once APPPATH."/libraries/MessageParser.php";
require_once APPPATH."/libraries/ClassLoader.php";

class AnalisaPengguna extends CI_Controller {
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
		$this->load->model('DataPenggunaTemp');
		$this->load->model('JawabanPenggunaTemp');
		$this->load->model('Prodi');
		$this->load->library('role');
		$this->role->hasAccessWithRedirect(get_class($this));


	}
	public function index()
	{
        /*
			Pilih Form dulu,
            kalau
		*/
        $bt = new ButirPertanyaan;
        $pertanyaans = $bt->optionAnalisaPengguna();
        $this->template->addData([
			'pertanyaans' => $pertanyaans,
		]);

        echo $this->template->render('content/analisapengguna/formView');
	}
    //start for Option
    function databaseAlumni() {
        $bt = new ButirPertanyaan;
        $pilihanNya = @$bt->alumni()[1];
        $allPilihan = JawabanAlumniTemp::where('pertanyaan_id', 1)->get();
        $this->template->addData([
			'pertanyaan' => $pilihanNya,
            'allPilihan' => $allPilihan,

		]);
        echo $this->template->render('content/analisapengguna/kesesuainKeilmuan');
    }
    function mengatasiKesulitanPekerjaan() {
        $bt = new ButirPertanyaan;
        $pilihanNya = @$bt->alumni()[4];
        $allPilihan = JawabanAlumniTemp::where('pertanyaan_id', 4)->get();
        $this->template->addData([
			'pertanyaan' => $pilihanNya,
            'allPilihan' => $allPilihan,

		]);
        echo $this->template->render('content/analisapengguna/kesesuainKeilmuan');
    }
    function showPilihanPertanyaan($all_pertanyaan) {
        $this->template->addData([
			'pertanyaanA' => $all_pertanyaan,

		]);
        echo $this->template->render('content/analisapengguna/showPilihanPertanyaan');
    }
    function kesesuainKeilmuan() {
        $bt = new ButirPertanyaan;
        $pilihanNya = @$bt->alumni()[1];
        $allPilihan = JawabanAlumniTemp::where('pertanyaan_id', 1)->get();
        $this->template->addData([
			'pertanyaan' => $pilihanNya,
            'allPilihan' => $allPilihan,

		]);
        echo $this->template->render('content/analisapengguna/kesesuainKeilmuan');
    }
    function showTanggapanPengguna() {
        $bt = new ButirPertanyaan;
        $pilihan = @$bt->pengguna();
		array_pop($pilihan);
		//$abc = array_keys($pilihan);
        $penggunas = DataPenggunaTemp::all();
        $this->template->addData([
			'pertanyaan' => $pilihan,
            'penggunas' => $penggunas,

		]);
        echo $this->template->render('content/analisapengguna/showTanggapanPengguna');
    }
    function kesesuaianKurikulum() {
        $bt = new ButirPertanyaan;
        $pilihans = array(
			@$bt->alumni()[8],
			@$bt->alumni()[9],
			@$bt->alumni()[10],
		);
		$alumnis = DataAlumniTemp::all();
        $allPilihan = JawabanAlumniTemp::whereIn('pertanyaan_id', array(8,9,10))->get();
        $this->template->addData([
			'pertanyaan' => $pilihans,
            'allPilihan' => $allPilihan,
			'alumnis' => $alumnis,

		]);
        echo $this->template->render('content/analisapengguna/kesesuaianKurikulum');
    }
    function distribusiFrekuensiKurikulum($soalNumber) {
        $bt = new ButirPertanyaan;
        $pilihans = array(
			@$bt->pengguna()[$soalNumber],
		);
		$alumnis = DataPenggunaTemp::all();
        $allPilihan = JawabanPenggunaTemp::whereIn('pertanyaan_id', array($soalNumber))->get();
        $this->template->addData([
			'pertanyaan' => @$bt->pengguna()[$soalNumber],
            'allPilihan' => $allPilihan,
			'alumnis' => $alumnis,
			'soalNumber' => $soalNumber,

		]);
        echo $this->template->render('content/analisapengguna/distribusiFrekuensiKurikulum');
    }
    function bergantiPekerjaanLebih() {
        $bt = new ButirPertanyaan;
        $pilihanNya = @$bt->alumni()[2];
        $allPilihan = JawabanAlumniTemp::where('pertanyaan_id', 2)->get();
        $this->template->addData([
			'pertanyaan' => $pilihanNya,
            'allPilihan' => $allPilihan,

		]);
        echo $this->template->render('content/analisapengguna/kesesuainKeilmuan');
    }
    function lamanyaMencariPekerjaan() {
        $bt = new ButirPertanyaan;
        $pilihanNya = @$bt->alumni()[7];
        $allPilihan = JawabanAlumniTemp::where('pertanyaan_id', 7)->get();
        $this->template->addData([
			'pertanyaan' => $pilihanNya,
            'allPilihan' => $allPilihan,

		]);
        echo $this->template->render('content/analisapengguna/kesesuainKeilmuan');
    }

    //end for Option
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
		$pengguna = DataPenggunaTemp::find($id);
		$jawaban = JawabanPenggunaTemp::where('alumni_pengguna_id', $id)->delete();
		$pengguna->delete();
		$_SESSION['message']['success'][] = "Hapus Data Berhasil";
		redirect(base_url($this->urlController()->index));
	}
	public function tes()
	{
	}
	public function tingkatSerapanPengguna()
	{
		$this->load->model('Wisudawan');
		$abc = new Wisudawan;
		$all_lulusan = $abc->getLulusan()->sortBy('Angkatan');
		$all_angkatan = $all_lulusan->pluck('Angkatan')->unique();
		$valid_prodi = Prodi::where('NA', 'N')->select('ProdiID')->get()->pluck('ProdiID')->all();
		$valid_prodi = array_map(function($a) {
			return (string) $a;
		}, $valid_prodi);
		$jumlahPengisi = DataPenggunaTemp::selectRaw('tahun_angkatan, count(id) as jumlah')->groupBy('tahun_angkatan')->get();

		$this->template->addData([
			'all_lulusan' => $all_lulusan,
            'all_angkatan' => $all_angkatan,
            'prodis' => $valid_prodi,
			'jumlahPengisi' => $jumlahPengisi,

		]);
        echo $this->template->render('content/analisapengguna/tingkatSerapanPengguna');
	}

}
