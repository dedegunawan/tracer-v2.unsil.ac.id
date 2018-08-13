<?php
trait LoginTrait {
	//var $loginUrl = base_url('/login');
	//var $dashboardUrl = base_url('/dashboard');
	function isLogin() {
		return @$_SESSION['user']['userObject']['id'];
	}
	function trackUrl() {
		return true;
	}
	function needLogin() {
        //var_dump($this->isLogin(), __LINE__, __FILE__);

        $last_url = uri_string();
		if ($this->trackUrl()) {
			$_SESSION['last_url'] = base_url($last_url);
		}

		if(!$this->isLogin()) {
			@$_SESSION['message']['error'][] = 'Belum Login, atau session expired. Anda Harus Login Kembali';
			redirect($this->loginUrl());
		}
		/*
		else {
			redirect($this->dashboardUrl());
		}
		*/
	}
	function flashUserData() {
		$user_id = $this->isLogin();
		if ($user_id) {
			$userObject = User::find($user_id);
			$_SESSION['user']['userObject'] = $userObject;
			$_SESSION['user']['ProfileNum'] = $userObject->count();
			$_SESSION['user']['Profile'] = $userObject->profileParse();
		}
	}
	function doLogin() {
        return $this->_doProsesLogin();

        //tidak akan dieksekusi

	}
    function _doProsesLogin() {
        $username = $this->input->post('username');
		$password = $this->input->post('password');
		//$hashPassword = password_hash($password, PASSWORD_DEFAULT);

		$userObject = User::where('username', $username)->first();
		if(
			$userObject
			&&
			$userObject instanceof User
		) {
			$hashedPassword = password_verify($password, $userObject->password);
			if($hashedPassword) {
				@$_SESSION['user']['userObject'] = $userObject;
				@$_SESSION['user']['id'] = $userObject->id;
				redirect(
					(@$_SESSION['last_url'])
					? @$_SESSION['last_url']
					: $this->dashboardUrl()
				);
			}
			else {
				@$_SESSION['message']['error'][] = 'Password Failed';
			}
			//var_dump(password_hash('dedegunawan', PASSWORD_DEFAULT));
		}
		else {
			@$_SESSION['message']['error'][] = 'Username Failed';
		}
		redirect($this->loginUrl());
    }
	function doLogout() {
		unset($_SESSION['user']);
		@$_SESSION['message']['success'][] = 'Anda telah berhasil Logout dari sistem';
		redirect($this->loginUrl());

	}
	function loginUrl() {
		return base_url('/login');
	}
	function logoutUrl() {
		return base_url('/login/logout');
	}
	function dashboardUrl() {
		return base_url('/dashboard');
	}
	function logout() {
		$this->doLogout();
	}
	function detectPostLogin() {
		if(isset($_POST['username']) && trim(@$_POST['username']) == '') {
			@$_SESSION['message']['error'][] = 'Username Harus Diisi';
		}
		if(isset($_POST['password']) && trim(@$_POST['password']) == '') {
			@$_SESSION['message']['error'][] = 'Password Harus Diisi';
		}
		return (
			trim(@$_POST['username'])
			&& trim(@$_POST['password'])
		);
	}
	function redirectOnLoginToDashboardPage() {
		if($this->isLogin()) {
			redirect($this->dashboardUrl());
		}
	}

}
