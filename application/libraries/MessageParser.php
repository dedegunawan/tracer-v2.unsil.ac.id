<?php
class MessageParser {
	public static function parse($message) {
		$out_sementara = array();
		if(is_array($message)) {
			foreach($message as $key => $data) {
				$dx = is_array($data) ? implode('</div><div class="alert alert-'.$key.' alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>', $data) : $data;
				array_push($out_sementara, '<div class="alert alert-'.$key.' alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
					'.$dx.'
				  </div>');
			}

		}
		return implode("", $out_sementara);
	}
	public static function flash() {
		$_SESSION['message'] = array();
	}
	public static function get($what = '') {
		if (trim($what) != '') {
			return @$_SESSION['message'][$what];
		}
		else {
			return @$_SESSION['message'];
		}
	}
	public static function set($what, $message = '') {
		if (!is_array(@$_SESSION['message'][$what])) {
			@$_SESSION['message'][$what] = array();
		}
		@$_SESSION['message'][$what][] = $message;
	}
	public static function parse_flash() {
		$message = @$_SESSION['message'];
		self::flash();
		return self::parse($message);
	}
	public static function get_error_form_validation() {
		$error_message = validation_errors_array();
		if(is_array($error_message)) {
			foreach($error_message as $error) {
				@$_SESSION['message']['danger'][] = $error;
			}
		}
	}


}
