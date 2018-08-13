<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH."/libraries/TraitTemplate.php";
require_once APPPATH."/libraries/DummyConfiguration.php";
require_once APPPATH."/libraries/LoginTrait.php";
require_once APPPATH."/libraries/FormRemindPostValue.php";
require_once APPPATH."/libraries/MessageParser.php";
require_once APPPATH."/libraries/ClassLoader.php";


class Errors extends CI_Controller {
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
		$this->load->library('role');

	}
	public function index()
	{
        $this->output->set_status_header('404');
		echo $this->template->render('errors/404');
	}
	public function e403()
	{
        $this->output->set_status_header('403');
		echo $this->template->render('errors/403');
	}

	function urlController() {
		$className = strtolower(get_class($this));
		return (object) array(
			'index' => $className."/index",
		);
	}

}
