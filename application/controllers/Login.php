<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/libraries/TraitTemplate.php";
require_once APPPATH."/libraries/DummyConfiguration.php";
require_once APPPATH."/libraries/LoginTrait.php";
require_once APPPATH."/libraries/FormRemindPostValue.php";
require_once APPPATH."/libraries/MessageParser.php";


class Login extends CI_Controller {
    protected $databaseLogin;
	use TraitTemplate;
	use LoginTrait;
	function __construct() {
		parent::__construct();
		$this->load->library('session');
		$this->load->database();

        $loginDb = @$this->load->database('login_database', TRUE);
        $this->setDatabaseLogin($loginDb);
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
		$this->load->library('form_validation');
		$this->load->helper('url');

		//session_destroy();
		//init template engine Directory
		$this->init(APPPATH."/views/");
		//access template engine : $this->template

		//store ci object to template engine
		$this->template->addData([
			'ci' => get_instance()
		]);


	}
	/**
	 * Logika : Memilih Sebagai apa,
	 * Kemudian dimunculkan pertanyaan x(=1) dari n
	 * loop until n
	 */
	public function index()
	{
		//$userInfo = @$_SESSION['userInfo'];
		//session_destroy();

		switch (true) {
			case $this->isLogin():
				$this->_showDashboard();
				break;
			case $this->detectPostLogin() :
				$this->doLogin();
				break;
			default:
				$this->_showLoginForm();
				break;
		}
	}

	function getFromTable($username, $password, $tableType='karyawan', $throwError=0) {
	    $userObject = $this->getDatabaseLogin()->where('Login', $username)->get($tableType)->row_array();

	    if (!$userObject && $throwError) throw new Exception("User tidak ditemukan");


	    $passwordScheme = @$userObject['PasswordScheme'];
	    if (!$passwordScheme) $passwordScheme = "MD5";
	    if ($passwordScheme == "MD5") {
	        $same = @$userObject['Password'] == md5($password);
        } elseif ($passwordScheme == "BCRYPT") {
	        $same = password_verify($password, @$userObject['Password']);
        } else {
	        $same = false;
        }


        if (!$same && $throwError)  throw new Exception("Password salah");

	    return $same ? $userObject : false;
    }
	function _doProsesLogin() {
		try {
		    $loginDb = $this->getDatabaseLogin();

		    if (!$loginDb) {
		        throw new Exception("Database login failed");
            }

            $username = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = false;
            switch (true) {
                case !$user :
                    $user = $this->getFromTable($username, $password, "karyawan");
                    if ($user) break;
                case !$user :
                    $user = $this->getFromTable($username, $password, "dosen");
                    if ($user) break;
                case !$user :
                    $user = $this->getFromTable($username, $password, "mhsw", 1);
                    if ($user) break;
            }

            if (!$user) throw new Exception("User tidak ditemukan");

            $userInfo = $user;

            $_SESSION['userInfo'] = $userInfo;
            if ($userInfo) {
                $_SESSION['user']['userObject'] = $userInfo;
                $_SESSION['user']['userObject']['id'] = (@$userInfo['Login'] ? $userInfo['Login'] : (@$userInfo['MhswID'] ? $userInfo['MhswID'] : ''));
                $_SESSION['user']['Profile'] = new DummyConfiguration(array('nama_depan' => $userInfo['Nama'], 'image_url' => 'http://simak.unsil.ac.id/us-unsil/'.$userInfo['Foto']));
                $_SESSION['user']['ProfileNum'] = 1;
            }
            redirect(base_url('/Dashboard'));

		} catch (Exception $e) {
			MessageParser::set('error', 'Login Gagal, '.$e->getMessage());
            header("Refresh:0");
		}

	}
	function autologin() {
		redirect($this->config->item('url_api').'autologin');
	}
	function urlController() {
		$className = strtolower(get_class($this));
		return (object) array(
			'index' => $className."/index",
			'before' => $className."/before",
			'destroy' => $className."/destroy",
		);
	}


	function _showLoginForm() {
		$this->template->addData([
			'message' => MessageParser::get(),
		]);
		MessageParser::flash();
		echo $this->template->render('operator/login_form');
	}

	//override trait,
	function doLogout() {
		//hubungi dulu server untuk melakukan forget
		unset($_SESSION['user']);
		@$_SESSION['message']['success'][] = 'Anda telah berhasil Logout dari sistem';
		redirect($this->loginUrl());

	}

	function _showDashboard() {

		redirect($this->dashboardUrl());
	}

    /**
     * @return mixed
     */
    public function getDatabaseLogin()
    {
        return $this->databaseLogin;
    }

    /**
     * @param mixed $databaseLogin
     */
    public function setDatabaseLogin($databaseLogin)
    {
        $this->databaseLogin = $databaseLogin;
    }

}
