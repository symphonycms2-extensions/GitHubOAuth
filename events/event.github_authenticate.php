<?php

    if(!defined('__IN_SYMPHONY__')) die('<h2>Error</h2><p>You cannot directly access this file</p>');

	require_once(TOOLKIT . '/class.event.php');
	
	Class eventgithub_authenticate extends Event{
		
		public static function about(){
			return array(
						'name' => __('GitHub Authentication'),
						'author' => array(
										array(	'name' => 'Remie Bolte',
												'website' => 'http://www.symphony-dev.net',
										   		'email' => 'r.bolte@gmail.com'
										),
						),
						'version' => '0.1',
						'release-date' => '2011-09-25',
						'trigger-condition' => '');
		}

		public function load(){
			return $this->__trigger();
		}

		public static function documentation(){
			return __('This event redirects users to the GitHub login page');
		}

		protected function __trigger(){

		}

	}
