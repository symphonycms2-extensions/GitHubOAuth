<?php

    if(!defined('__IN_SYMPHONY__')) die('<h2>Error</h2><p>You cannot directly access this file</p>');

	require_once(TOOLKIT . '/class.event.php');
	
	Class eventgithub_authenticate extends Event{

		public function __construct(&$parent, $env = null) {
			parent::__construct($parent, $env);
		}
		
		public static function about(){
			return array(
				'name' => __('GitHub Authentication'),
				'author' => array(
					'name' => 'Remie Bolte',
					'website' => 'http://www.symphony-dev.net',
					'email' => 'r.bolte@gmail.com'
				),
				'version' => '0.1.0',
				'release-date' => '2011-09-28',
				'trigger-condition' => ''
			);
		}

		public function load(){
			return $this->__trigger();
		}

		public static function documentation(){
			return new XMLElement('p', 'This is an event that redirects users to the GitHub login page for authentication.');
		}

		protected function __trigger(){
			$clientId = Symphony::Configuration()->get('client_id', 'githuboauth');
			$scope = Symphony::Configuration()->get('scope', 'githuboauth');
			$redirectUrl = Symphony::Configuration()->get('auth_redirect', 'githuboauth');
			
			header('Location: https://github.com/login/oauth/authorize?client_id=' . $clientId . '&redirect_uri=' . $redirectUrl . '&scope=' . $scope);
			exit;
		}
	}
