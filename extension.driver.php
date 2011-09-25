<?php

    class Extension_GitHubOAuth extends Extension {
	/*-------------------------------------------------------------------------
		Definition:
	-------------------------------------------------------------------------*/

		public function about() {
			return array(
				'name'			=> 'GitHub OAuth',
				'version'		=> '0.1.0',
				'release-date'	=> '2011-09-25',
				'author'		=> array(
					'name'			=> 'Remie Bolte',
					'website'		=> 'http://www.symphony-dev.net',
					'email'			=> 'r.bolte@gmail.com'
				)
			);
		}

    }

?>