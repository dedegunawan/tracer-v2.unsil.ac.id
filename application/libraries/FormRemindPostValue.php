<?php 
class FormRemindPostValue {
	static function detectPost() {
		//var_dump($_POST);
		if(isset($_POST)) {
			foreach($_POST as $key => $value) {
				$_SESSION['FormRemindPostValueObject'][$key] = $value;
			}
		}
	}
	static function forget() {
		unset($_SESSION['FormRemindPostValueObject']);
		
	}
	static function __callStatic($name, $arguments) {
		if(
			@$_SESSION['FormRemindPostValueObject'] && 
			array_key_exists($name, @$_SESSION['FormRemindPostValueObject']) 
		) {
			$result = $_SESSION['FormRemindPostValueObject'][$name];
			unset($_SESSION['FormRemindPostValueObject'][$name]);
			return $result;
		}
		else {
			return '';
		}
	}
	
}