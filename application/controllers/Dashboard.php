<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/libraries/TraitTemplate.php";
require_once APPPATH."/libraries/DummyConfiguration.php";
require_once APPPATH."/libraries/LoginTrait.php";
use GuzzleHttp\Client;

class Dashboard extends CI_Controller {
	use TraitTemplate;
	use LoginTrait;
	var $module;
	function __construct() {
		parent::__construct();
		$this->load->database();
		/*
		$this->load->model('DataAlumniTemp');
		$this->load->model('JawabanAlumniTemp');
		$this->load->model('DataPenggunaTemp');
		$this->load->model('JawabanPenggunaTemp');
		$this->load->model('Prodi');
		$this->load->model('Jenjang');
		$this->load->model('Pekerjaan');
		$this->load->model('ButirPertanyaan', 'bp');
		*/
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->helper('url');

		//session_destroy();
		//init template engine Directory
		$this->init(APPPATH."/views/backend/");
		//access template engine : $this->template

		//store ci object to template engine
        //var_dump();
		$this->template->addData([
			'ci' => get_instance(),
            'conf' => new DummyConfiguration($this->config->item('conf_dummy_configuration_property')),
		]);
        $this->needLogin();

		$this->load->library('role');
		$this->role->hasAccessWithRedirect(get_class($this));


	}

	public function index()
	{
		//just show admin menu, with selamat datang & isi survey
        //echo "Tampilkan Data";
		$this->registerX();
        echo $this->template->render('content/dashboard');
        //var_dump(__LINE__, __FILE__);
        //  die();

	}

	function urlController() {
		$className = strtolower(get_class($this));
		return (object) array(
			'index' => $className."/index",
			'before' => $className."/before",
			'destroy' => $className."/destroy",
		);
	}
	function registerX() {

		$this->_registerModule('berdasarkanProdi', array(
			'menu' => '',
			'file' => 'content/dashboard/module/berdasarkanProdi',
		));

		$this->_registerModule('berdasarkanProdiPengguna', array(
			'menu' => '',
			'file' => 'content/dashboard/module/berdasarkanProdiPengguna',
		));
		$this->_registerModule('kosong', array(
			'menu' => 'kosongNow',
			'file' => 'content/dashboard/module/kosong',
		));

		$this->_registerModule('berdasarkanKelamin', array(
			'menu' => '',
			'file' => 'content/dashboard/module/berdasarkanKelamin',
		));
		$this->_registerModule('berdasarkanKelaminPengguna', array(
			'menu' => '',
			'file' => 'content/dashboard/module/berdasarkanKelaminPengguna',
		));

	}
	function _registerModule($moduleName, $moduleConfig = array()) {
		$template = array(
			'file' => '',
			'menu' => '',
		);
		$mdl = array_merge($template, $moduleConfig);
		$this->module[$moduleName] = $mdl;
	}
	function _getModule($moduleName = '') {
		if (trim($moduleName) && array_key_exists($moduleName, $this->module)) {
			return $this->module[$moduleName];
		} else {
			return $this->module;
		}

	}
	function _getMenu() {
		$keys = $this->module;
		array_walk($keys, function(&$item, $key) {
			$item = $item['menu'];
		});
		return $keys;

	}



}
