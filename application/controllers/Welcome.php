<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH."/libraries/TraitTemplate.php";

class Welcome extends CI_Controller {
	use TraitTemplate;
	function __construct() {
		parent::__construct();
		$this->load->database();
		$this->load->model('DataAlumniTemp');
		$this->load->model('JawabanAlumniTemp');
		$this->load->model('DataPenggunaTemp');
		$this->load->model('JawabanPenggunaTemp');
		$this->load->model('Prodi');
		$this->load->model('Jenjang');
		$this->load->model('Pekerjaan');
		$this->load->model('ButirPertanyaan', 'bp');
		$this->load->library('session');
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
		$roleAccess = @$_SESSION['roleAccess'];
		$sebagai = @$_SESSION['sebagai'];
		$pertanyaan = @$_SESSION['pertanyaan'];

		//session_destroy();
		//var_dump($sebagai, $roleAccess);


		switch (true) {
			case !$roleAccess:
				$this->showFormRoleAccess();
				break;
			default:
				$this->showFormPertanyaan($sebagai);
				break;
		}
	}
	function showFormPertanyaan($sebagai) {
		//pertanyaan nomor berapa ?
		//0 berarti data awal,
		$pertanyaan = (@$_SESSION['pertanyaan']) ? @$_SESSION['pertanyaan'] : '0';
		$pertanyaan += 1;
		//var_dump($sebagai);

		switch (true) {
			case $pertanyaan == 1:
				call_user_func_array(array($this, 'dataDiri'.ucwords($sebagai)), array());
				break;
			default:
				call_user_func_array(array($this, 'pertanyaan'.ucwords($sebagai)), array($pertanyaan));
				echo $this->template->render('templatePertanyaan');
				break;
		}

		//echo $this->template->render('content/masteranak/index');
	}


	function showFormRoleAccess() {
		//detect get start pertanyaan
		if (@$_GET['start']) {
			$_SESSION['roleAccess'] = true;
			if ($_GET['start'] == 2) {
				$_SESSION['sebagai'] = 'pengguna';
			}
			else {
				$_SESSION['sebagai'] = 'alumni';
			}
			redirect(base_url($this->urlController()->index));
		}
		$this->template->addData([
			'ci' => get_instance(),
			'page_title' => 'Tracer Alumni Unsil',
		]);

		echo $this->template->render('test');
	}
	function pertanyaanAlumni($pertanyaan) {
		$realPertanyaan = ($pertanyaan-1);
		$pertanyaanNow = @$this->bp->alumni()[$realPertanyaan];
		//var_dump();
		switch (true) {
			case $pertanyaanNow == NULL :
				//echo "Pertanyaan Habis Mas Bro.";
				$this->template->addData([
					'pertanyaanView' => $this->textHabisAlumni(),
					'thanks_text' => $this->thanksTextAlumni(),
					'habis' => true,
				]);
				break;
			case $pertanyaanNow['pilihan'] == 'textarea':
				$jawaban = $this->input->post('jawaban');
				//var_dump($jawaban);

				if ($jawaban && $realPertanyaan == $this->input->post('pertanyaan_number')) {
					$jawaban_temp = JawabanAlumniTemp::firstOrCreate(['alumni_temp_id' => $_SESSION['alumni_temp'], 'pertanyaan_id' => $realPertanyaan]);
					$jawaban_temp->jawaban = $jawaban;
					$jawaban_temp->save();
					$_SESSION['pertanyaan'] = $pertanyaan;
					unset($_POST);
					$_POST = array();
					header("Refresh:0");

				}
				$this->template->addData($pertanyaanNow);
				$this->template->addData([
					'pertanyaanView' => $this->template->render('content/pertanyaanTextarea'),
					'count' => count($this->bp->alumni()),
					'now' =>$realPertanyaan,
				]);

				break;
			case is_array($pertanyaanNow['pilihan']):
				$jawaban = $this->input->post('jawaban');
				//var_dump($jawaban);

				if ($jawaban && $realPertanyaan == $this->input->post('pertanyaan_number')) {
					$jawaban_temp = JawabanAlumniTemp::firstOrCreate(['alumni_temp_id' => $_SESSION['alumni_temp'], 'pertanyaan_id' => $realPertanyaan]);
					$jawaban_temp->jawaban = $jawaban;
					$jawaban_temp->save();
					$_SESSION['pertanyaan'] = $pertanyaan;
					unset($_POST);
					$_POST = array();
					header("Refresh:0");

				}
				$this->template->addData($pertanyaanNow);
				$this->template->addData([
					'pertanyaanView' => $this->template->render('content/pertanyaanPilihan'),
					'count' => count($this->bp->alumni()),
					'now' =>$realPertanyaan,
				]);

				break;

			default:
				# code...
				break;
		}

	}
	function dataDiriAlumni() {
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

		if ($this->form_validation->run() == FALSE)
        {
			//var_dump(Prodi::all());
                echo $this->template->render('data_diri_alumni', ['listProdi' => Prodi::orderBy('ProdiID')->get(), 'listPekerjaan' => Pekerjaan::orderBy('nama_pekerjaan')->get()]);
        }
        else
        {
			$data_diri = new DataAlumniTemp;
			$data_diri->nama_depan = $this->input->post('nama_depan', TRUE);
			$data_diri->nama_belakang = $this->input->post('nama_belakang', TRUE);
			$data_diri->tahun_lulus = $this->input->post('tahun_lulus', TRUE);
			$data_diri->tahun_angkatan = $this->input->post('tahun_angkatan', TRUE);
			$data_diri->prodi = $this->input->post('prodi', TRUE);
			$data_diri->pekerjaan = $this->input->post('pekerjaan', TRUE);
			$data_diri->tempat_bekerja = $this->input->post('tempat_bekerja', TRUE);
			$data_diri->jenis_kelamin = $this->input->post('jenis_kelamin', TRUE);
			$data_diri->alamat = $this->input->post('alamat', TRUE);
			$data_diri->telp_hp = $this->input->post('telp_hp', TRUE);
			$data_diri->email = $this->input->post('email', TRUE);
			$data_diri->kontak_lainnya = $this->input->post('kontak_lainnya', TRUE);
			if (@$_SESSION['operator']) {
				$data_diri->pengisi = $_SESSION['operator'];
			}
			$data_diri->save();
			$_SESSION['alumni_temp'] = $data_diri->id;
			$_SESSION['pertanyaan'] = 1;
			header("Refresh:0");
        }

		//echo "Data Diri Alumni";
	}


	function dataDiriPengguna() {
		$this->form_validation->set_rules('nama_lembaga', 'Nama Lembaga', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('jabatan', 'Jabatan', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('nama_alumni', 'Nama Alumni', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('tahun_angkatan', 'Tahun Angkatan', 'required|callback_is_angka|callback_valid_year', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('tahun_lulus', 'Tahun Lulus', 'required|callback_is_angka|callback_valid_year', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('email_lembaga', 'Email Lembaga', 'required', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('prodi', 'Program Studi', 'required|callback_is_valid_prodi', array('required' => '%s harus diisi'));
		$this->form_validation->set_rules('jenis_kelamin', 'Jenis Kelamin', 'required', array('required' => '%s harus diisi'));

		if ($this->form_validation->run() == FALSE)
        {
                echo $this->template->render('data_diri_pengguna', ['listProdi' => Prodi::orderBy('ProdiID')->get()]);
        }
        else
        {
			$data_diri = new DataPenggunaTemp;
			$data_diri->nama_lembaga = $this->input->post('nama_lembaga', TRUE);
			$data_diri->jabatan = $this->input->post('jabatan', TRUE);
			$data_diri->nama_alumni = $this->input->post('nama_alumni', TRUE);
			$data_diri->tahun_angkatan = $this->input->post('tahun_angkatan', TRUE);
			$data_diri->tahun_lulus = $this->input->post('tahun_lulus', TRUE);
			$data_diri->email_lembaga = $this->input->post('email_lembaga', TRUE);
			$data_diri->prodi = $this->input->post('prodi', TRUE);
			$data_diri->jenis_kelamin = $this->input->post('jenis_kelamin', TRUE);
			$data_diri->save();
			$_SESSION['pengguna_temp'] = $data_diri->id;
			$_SESSION['pertanyaan'] = 1;
			header("Refresh:0");
        }

		//echo "Data Diri Alumni";
	}

	function pertanyaanPengguna($pertanyaan) {
		$realPertanyaan = ($pertanyaan-1);
		$pertanyaanNow = @$this->bp->pengguna()[$realPertanyaan];
		//var_dump();
		switch (true) {
			case $pertanyaanNow == NULL :
				//echo "Pertanyaan Habis Mas Bro.";
				$this->template->addData([
					'pertanyaanView' => $this->textHabisPengguna(),
					'thanks_text' => $this->thanksTextPengguna(),
					'habis' => true,
				]);
				break;
			case $pertanyaanNow['pilihan'] == 'textarea':
				$jawaban = $this->input->post('jawaban');
				//var_dump($jawaban);

				if ($jawaban && $realPertanyaan == $this->input->post('pertanyaan_number')) {
					$jawaban_temp = JawabanPenggunaTemp::firstOrCreate(['pengguna_temp_id' => $_SESSION['pengguna_temp'], 'pertanyaan_id' => $realPertanyaan]);
					$jawaban_temp->jawaban = $jawaban;
					$jawaban_temp->save();
					$_SESSION['pertanyaan'] = $pertanyaan;
					unset($_POST);
					$_POST = array();
					header("Refresh:0");

				}
				$this->template->addData($pertanyaanNow);
				$this->template->addData([
					'pertanyaanView' => $this->template->render('content/pertanyaanTextarea'),
					'count' => count($this->bp->pengguna()),
					'now' =>$realPertanyaan,
				]);

				break;
			case is_array($pertanyaanNow['pilihan']):
				$jawaban = $this->input->post('jawaban');
				//var_dump($jawaban);

				if ($jawaban && $realPertanyaan == $this->input->post('pertanyaan_number')) {
					$jawaban_temp = JawabanPenggunaTemp::firstOrCreate(['pengguna_temp_id' => $_SESSION['pengguna_temp'], 'pertanyaan_id' => $realPertanyaan]);
					$jawaban_temp->jawaban = $jawaban;
					$jawaban_temp->save();
					$_SESSION['pertanyaan'] = $pertanyaan;
					unset($_POST);
					$_POST = array();
					header("Refresh:0");

				}
				$this->template->addData($pertanyaanNow);
				$this->template->addData([
					'pertanyaanView' => $this->template->render('content/pertanyaanPilihan'),
					'count' => count($this->bp->pengguna()),
					'now' =>$realPertanyaan,
				]);

				break;

			default:
				# code...
				break;
		}

	}


	function destroy() {
		session_destroy();
		header("Location:".base_url(@$this->urlController()->index));
	}
	function before() {
		//var_dump($_SESSION);
		$_SESSION['pertanyaan'] = (@$_SESSION['pertanyaan'] ? $_SESSION['pertanyaan']-1 : 0);
		header("Location:".base_url(@$this->urlController()->index));
 	}
	function urlController() {
		$className = strtolower(get_class($this));
		return (object) array(
			'index' => $className."/index",
			'before' => $className."/before",
			'destroy' => $className."/destroy",
		);
	}
	function textHabisPengguna() {
		return "Terima Kasih Text kepada Pengguna";
	}
	function textHabisAlumni() {
		return "Terima Kasih Text kepada Pengguna";
	}
	function thanksTextPengguna() {
		return "Terima Kasih!";
	}
	function thanksTextAlumni() {
		return "Terima Kasih!";
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
