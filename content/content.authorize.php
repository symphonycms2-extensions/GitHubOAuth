<?php

	$clientId = Symphony::Configuration()->get('client_id', 'githuboauth');
	$secret = Symphony::Configuration()->get('secret', 'githuboauth');
	$redirectUrl = Symphony::Configuration()->get('token_redirect', 'githuboauth');
		
	if(isset($_REQUEST['code'])) {
		
		$code = $_REQUEST['code'];
		
		$url = 'https://github.com/login/oauth/access_token';
		$post = 'client_id=' . $clientId . '&client_secret=' . $secret . '&code=' . $code;
		
		if(function_exists('http_post_data')) {
			$result = http_post_data($url, $post);
			$result = http_parse_message($result);
			$result = $result->body;
		}
		else if(function_exists('curl_version')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			$result = curl_exec($ch);
			curl_close($ch);
		}
		else {
			echo 'Failed to post HTTP.';
			exit();
		}
		
		$headers = explode('&',trim($result));
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

	} else {
		echo 'Fail.';
	}
	
	exit();
?>
