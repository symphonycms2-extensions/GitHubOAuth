<?php

	$clientId = Symphony::Configuration()->get('client_id', 'githuboauth');
	$secret = Symphony::Configuration()->get('secret', 'githuboauth');
	$redirectUrl = Symphony::Configuration()->get('token_redirect', 'githuboauth');
		
	if(isset($_REQUEST['code'])) {
		if(function_exists('http_post_data')) {
			$code=$_REQUEST['code'];
			$result = http_post_data('https://github.com/login/oauth/access_token', 'client_id=' . $clientId . '&client_secret=' . $secret . '&code=' . $code);
			$result = http_parse_message($result);
			
			$headers = explode('&',trim($result->body));
			foreach($headers as $item) {
				$header = explode('=',$item);
				if($header[0] == 'access_token') {
					$token = $header[1];
					break;
				}
			}

			$cookie = new Cookie('github',TWO_WEEKS, __SYM_COOKIE_PATH__, null, true);
			$cookie->set('token',$token);
			
			header('Location: ' . $redirectUrl);
			exit;
		} else {
			echo 'Failed to post http';
		}
	} else {
		echo 'failure!';
	}
?>
