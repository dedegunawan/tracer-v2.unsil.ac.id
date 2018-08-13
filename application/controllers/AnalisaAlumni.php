<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."/libraries/TraitTemplate.php";
require_once APPPATH."/libraries/DummyConfiguration.php";
require_once APPPATH."/libraries/LoginTrait.php";
require_once APPPATH."/libraries/FormRemindPostValue.php";
require_once APPPATH."/libraries/MessageParser.php";
require_once APPPATH."/libraries/ClassLoader.php";

class AnalisaAlumni extends CI_Controller {
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
        $pertanyaans = $bt->optionAnalisaAlumni();
        $this->template->addData([
			'pertanyaans' => $pertanyaans,
		]);

        echo $this->template->render('content/analisaalumni/formView');
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
        echo $this->template->render('content/analisaalumni/kesesuainKeilmuan');
    }
    function mengatasiKesulitanPekerjaan() {
        $bt = new ButirPertanyaan;
        $pilihanNya = @$bt->alumni()[4];
        $allPilihan = JawabanAlumniTemp::where('pertanyaan_id', 4)->get();
        $this->template->addData([
			'pertanyaan' => $pilihanNya,
            'allPilihan' => $allPilihan,

		]);
        echo $this->template->render('content/analisaalumni/kesesuainKeilmuan');
    }
    function showPilihanPertanyaan($all_pertanyaan) {
        $this->template->addData([
			'pertanyaanA' => $all_pertanyaan,

		]);
        echo $this->template->render('content/analisaalumni/showPilihanPertanyaan');
    }
    function kesesuainKeilmuan() {
        $bt = new ButirPertanyaan;
        $pilihanNya = @$bt->alumni()[1];
        $allPilihan = JawabanAlumniTemp::where('pertanyaan_id', 1)->get();
        $this->template->addData([
			'pertanyaan' => $pilihanNya,
            'allPilihan' => $allPilihan,

		]);
        echo $this->template->render('content/analisaalumni/kesesuainKeilmuan');
    }
    function showGeneralResultAlumni($pertanyaan_id) {
        $bt = new ButirPertanyaan;
        $pilihanNya = @$bt->alumni()[$pertanyaan_id];
        $allPilihan = JawabanAlumniTemp::where('pertanyaan_id', $pertanyaan_id)->get();
        $this->template->addData([
			'nomor' => $pertanyaan_id,
			'pertanyaan' => $pilihanNya,
            'allPilihan' => $allPilihan,
		]);
        echo $this->template->render('content/analisaalumni/kesesuainKeilmuan');
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
        echo $this->template->render('content/analisaalumni/kesesuaianKurikulum');
    }
    function distribusiFrekuensiKurikulum($soalNumber) {
        $bt = new ButirPertanyaan;
        $pilihans = array(
			@$bt->alumni()[$soalNumber],
		);
		$alumnis = DataAlumniTemp::all();
        $allPilihan = JawabanAlumniTemp::whereIn('pertanyaan_id', array($soalNumber))->get();
        $this->template->addData([
			'pertanyaan' => @$bt->alumni()[$soalNumber],
            'allPilihan' => $allPilihan,
			'alumnis' => $alumnis,
			'soalNumber' => $soalNumber,

		]);
        echo $this->template->render('content/analisaalumni/distribusiFrekuensiKurikulum');
    }
    function bergantiPekerjaanLebih() {
        $bt = new ButirPertanyaan;
        $pilihanNya = @$bt->alumni()[2];
        $allPilihan = JawabanAlumniTemp::where('pertanyaan_id', 2)->get();
        $this->template->addData([
			'pertanyaan' => $pilihanNya,
            'allPilihan' => $allPilihan,

		]);
        echo $this->template->render('content/analisaalumni/kesesuainKeilmuan');
    }
    function lamanyaMencariPekerjaan() {
        $bt = new ButirPertanyaan;
        $pilihanNya = @$bt->alumni()[7];
        $allPilihan = JawabanAlumniTemp::where('pertanyaan_id', 7)->get();
        $this->template->addData([
			'pertanyaan' => $pilihanNya,
            'allPilihan' => $allPilihan,

		]);
        echo $this->template->render('content/analisaalumni/kesesuainKeilmuan');
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
	public function tingkatSerapanAlumni()
	{
		$this->load->model('Wisudawan');
		$abc = new Wisudawan;
		$all_lulusan = $abc->getLulusan()->sortBy('Angkatan');
		$all_angkatan = $all_lulusan->pluck('Angkatan')->unique();
		$valid_prodi = Prodi::where('NA', 'N')->select('ProdiID')->get()->pluck('ProdiID')->all();
		$valid_prodi = array_map(function($a) {
			return (string) $a;
		}, $valid_prodi);
		$jumlahPengisi = DataAlumniTemp::selectRaw('tahun_angkatan, count(id) as jumlah')->groupBy('tahun_angkatan')->get();

		$this->template->addData([
			'all_lulusan' => $all_lulusan,
            'all_angkatan' => $all_angkatan,
            'prodis' => $valid_prodi,
			'jumlahPengisi' => $jumlahPengisi,

		]);
        echo $this->template->render('content/analisaalumni/tingkatSerapanAlumni');
		/*
		$this->load->model('Wisudawan');
		$abc = new Wisudawan;
		$abc->getLulusan()->sortBy('Angkatan');
        echo $this->template->render('content/analisaalumni/tingkatSerapanAlumni');
		*/
	}

}
