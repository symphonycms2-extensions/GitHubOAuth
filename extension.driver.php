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
    
    	/*-------------------------------------------------------------------------
    		Delegate
    	-------------------------------------------------------------------------*/
    
    	public function getSubscribedDelegates() {
    		return array(
    			array(
    				'page' => '/system/preferences/',
    				'delegate' => 'AddCustomPreferenceFieldsets',
    				'callback' => 'appendPreferences'
    			),
    			array(
    				'page' => '/system/preferences/',
    				'delegate' => 'Save',
    				'callback' => 'savePreferences'
    			),
                array(
                    'page' => '/frontend/',
                    'delegate' => 'FrontendProcessEvents',
                    'callback' => 'appendEventXML'
                ),
    		);
    	}
    
    	/*-------------------------------------------------------------------------
    		Delegated functions
    	-------------------------------------------------------------------------*/	
    
    	public function fetchNavigation() {
    		return array(
    			array('location' => 'System', 'link' => '/authorize/'),
    		);
    	}
    
    	public function appendPreferences($context){
    		$group = new XMLElement('fieldset',null,array('class'=>'settings'));
    		$group->appendChild(new XMLElement('legend', 'GitHub Authentication'));
    
    		// Application Client
    		$group->appendChild(new XMLElement('h3', 'GitHub OAuth Application',array('style'=>'margin-bottom: 5px;')));
    		$group->appendChild(new XMLElement('p','You will need to provide the GitHub OAuth client application credentials. You can retrieve them from <a href="https://github.com/account/applications/new">https://github.com/account/applications/new</a>',array('class'=>'help')));
    		
    		$div = new XMLElement('div',null,array('class'=>'group'));
    		$label = Widget::Label();
                    $input = Widget::Input('settings[githuboauth][client_id]', Symphony::Configuration()->get('client_id', 'githuboauth'), 'text');
                    $label->setValue(__('Client ID') . $input->generate());
                    $div->appendChild($label);
    		
    		$label = Widget::Label();
                    $input = Widget::Input('settings[githuboauth][secret]', Symphony::Configuration()->get('secret', 'githuboauth'), 'password');
                    $label->setValue(__('Client Secret') . $input->generate());
                    $div->appendChild($label);
    		$group->appendChild($div);
    
    		// GitHub Redirection
    		$group->appendChild(new XMLElement('h3', 'GitHub Redirection',array('style'=>'margin-bottom:5px')));
    		$group->appendChild(new XMLElement('p','GitHub authentication consist of two steps: ask GitHub for permission and authenticate user.<br />After each step you will be redirected. The first redirection (after confirmation) is performed by GitHub. After granting permission, GitHub will redirect the user to the specified URL. It will provide a token (code) to the application which can be used to confirm the authentication. The second redirect (after authentication) is used to return to the correct page once the authentication process has completed.',array('class'=>'help')));
    
    		$div = new XMLElement('div',null,array('class'=>'group'));
    		$label = Widget::Label();
                    $input = Widget::Input('settings[githuboauth][auth_redirect]', Symphony::Configuration()->get('auth_redirect', 'githuboauth'), 'text');
                    $label->setValue(__('Redirect URL (after confirmation)') . $input->generate());
                    $div->appendChild($label);
    
                    $label = Widget::Label();
                    $input = Widget::Input('settings[githuboauth][token_redirect]', Symphony::Configuration()->get('token_redirect', 'githuboauth'), 'text');
                    $label->setValue(__('Redirect URL (after authentication)') . $input->generate());
    		$div->appendChild($label);
    		$group->appendChild($div);
    
    		// Application Scope
    		$scope = Symphony::Configuration()->get('scope', 'githuboauth');
    
    		$group->appendChild(new XMLElement('h3', 'Application Scope',array('style'=>'margin-bottom:5px')));
    		$group->appendChild(new XMLElement('p','Allows you to specify which information you want to be able to retrieve from GitHub. The user will be prompted about requested the scope and will have to allow the application to access his account information.',array('class'=>'help')));
    
    		$div = new XMLElement('div',null,array('class'=>'group'));
    		$label = Widget::Label();
                    $input = Widget::Input('settings[githuboauth][scope][]', 'user', 'checkbox');
                    if(strpos($scope,'user') !== FALSE) { $input->setAttribute('checked', 'checked'); }
                    $label->setValue($input->generate() . ' ' . __('User'));
                    $div->appendChild($label);
    
                    $label = Widget::Label();
                    $input = Widget::Input('settings[githuboauth][scope][]', 'public_repo', 'checkbox');
                    if(strpos($scope,'public_repo') !== FALSE) { $input->setAttribute('checked', 'checked'); }
                    $label->setValue($input->generate() . ' ' . __('Public repositories'));
                    $div->appendChild($label);
    		$group->appendChild($div);
    
    		$div = new XMLElement('div',null,array('class'=>'group'));
                    $label = Widget::Label();
                    $input = Widget::Input('settings[githuboauth][scope][]', 'repo', 'checkbox');
                    if(strpos($scope,'repo') !== FALSE) { $input->setAttribute('checked', 'checked'); }
                    $label->setValue($input->generate() . ' ' . __('Repositories'));
                    $div->appendChild($label);
    
                    $label = Widget::Label();
                    $input = Widget::Input('settings[githuboauth][scope][]', 'gist', 'checkbox');
                    if(strpos($scope,'gist') !== FALSE) { $input->setAttribute('checked', 'checked'); }
                    $label->setValue($input->generate() . ' ' . __('Gist'));
                    $div->appendChild($label);
    
    		$group->appendChild($div);
    
    		// Append preferences
    		$context['wrapper']->appendChild($group);
    	}
    
    	public function savePreferences($context){
    		$scope = implode(',', $_REQUEST['settings']['githuboauth']['scope']);
    		$context['settings']['githuboauth']['scope'] = $scope;
    	}
        
        public function appendEventXML(array $context = null) {
            $cookie = new Cookie('github',TWO_WEEKS, __SYM_COOKIE_PATH__, null, true);
            $token = $cookie->get('token');

            $result = new XMLElement('github');
			if($token) {
				$result->setAttributearray(array(
					'logged-in' => 'yes',
					'token' => $token
				));
			}
			else {
				$result->setAttribute('logged-in','no');
			}

			$context['wrapper']->appendChild($result);
        }

    }

?>
