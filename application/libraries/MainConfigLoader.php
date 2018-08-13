<?php
class MainConfigLoader {

	function __get($attr) {
		$attributes = $this->attributes();
		if(array_key_exists($attr, $attributes)) {
			return $attributes[$attr];

		}
		else {
			return NULL;
		}
	}
	function attributes() {
		return array(
			'title' => 'KosanKu',
			'title_html' => '<b>KK</b>',
			'title_html_mini' => '<b>KK</b>',
			'versi' => 0.1,
			'frontend' => '/',
			'copyright' => array(
				'nama' => '',
				'site' => ''
			),
			'menu_frontend' => array(
				'home' => array(
					'value' => 'Home',
					'attr' => array('url' => '/', 'icon' => 'fa fa-home'),
					'child' => array(),
				),
				'cari_anak' => array(
					'value' => 'Cari Anak',
					'attr' => array('url' => '/carianak', 'icon' => 'fa fa-search'),
					'child' => array(),
				),
			),
		);
	}
	function image_anak_dir($url = '') {
		return '/assets/img-anak/'.$url;
	}
	function sliderHome() {
		return array(
			array(
				'image' => base_url('/assets/frontend/images/slider/01.jpg'),
				'title' => 'Title 001',
				'title2' => 'Title 0023',
				'deskripsi' => 'Deskripsi Deskripsi Deskripsi Deskripsi ',
			),
			array(
				'image' => base_url('/assets/frontend/images/slider/02.jpg'),
				'title' => 'Title 001',
				'title2' => 'Title 0023 cdef',
				'deskripsi' => 'Deskripsi Deskripsi Deskripsi Deskripsi ',
			),
			array(
				'image' => base_url('/assets/frontend/images/slider/03.jpg'),
				'title' => 'Title 001',
				'title2' => 'Title 0023 hgt',
				'deskripsi' => 'Deskripsi Deskripsi Deskripsi Deskripsi ',
			),
			array(
				'image' => base_url('/assets/frontend/images/slider/04.jpg'),
				'title' => 'Title 001',
				'title2' => 'Title 0023 hgt',
				'deskripsi' => 'Deskripsi Deskripsi Deskripsi Deskripsi ',
			),
		);
	}

}
