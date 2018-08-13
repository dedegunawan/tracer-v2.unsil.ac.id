<?php
trait BootApp {
	function boot() {
		$this->load->library('session');
		$this->loadProfileUser();
	}


	function loadProfileUser() {
		if(
			$_SESSION['user']['userObject']
			&&
			(
			!isset($_SESSION['user']['Profile'])
			||
			!isset($_SESSION['user']['ProfileNum'])
			||
			$_SESSION['user']['ProfileNum'] != $_SESSION['user']['userObject']->profile->count()
			)
		) {
			$_SESSION['user']['ProfileNum'] = $_SESSION['user']['userObject']->profile->count();
			$_SESSION['user']['Profile'] = $_SESSION['user']['userObject']->profileParse();

		}
	}
}
