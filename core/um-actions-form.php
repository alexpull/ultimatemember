<?php

	/***
	***	@checks if user is blacklisted
	***/
	add_action('um_submit_form_errors_hook__blacklist', 'um_submit_form_errors_hook__blacklist', 10);
	function um_submit_form_errors_hook__blacklist($args){
		global $ultimatemember;
		
		$form_id = $args['form_id'];
		$mode = $args['mode'];
		$fields = unserialize( $args['custom_fields'] );
		
		$words = um_get_option('blocked_words');
		if ( $words != '' ) {
		
			$words = array_map("rtrim", explode("\n", $words));
			foreach( $fields as $key => $array ) {
			
				if ( isset($array['validate']) && in_array( $array['validate'], array('unique_username','unique_email','unique_username_or_email') ) ) {
					
					if (  in_array( $args[$key], $words ) ) {
						
						$ultimatemember->form->add_error( $key,  __('You are not allowed to use this word as your username.') );
					
					}
					
				}
				
			}

		}
		
	}
	
	/***
	***	@the main error handler for form submitting
	***/
	add_action('um_submit_form_errors_hook', 'um_submit_form_errors_hook', 10);
	function um_submit_form_errors_hook($args){
		global $ultimatemember;
		
		$form_id = $args['form_id'];
		$mode = $args['mode'];
		$fields = unserialize( $args['custom_fields'] );
		
		foreach( $fields as $key => $array ) {
		
			if ( isset( $array['required'] ) && $array['required'] == 1 ) {
				if ( !isset($args[$key]) || $args[$key] == '' ) {
				$ultimatemember->form->add_error($key, sprintf(__('%s is required'), $array['label']) );
				}
			}
			
			if ( isset( $array['max_words'] ) && $array['max_words'] > 0 ) {
				if ( str_word_count( $args[$key] ) > $array['max_words'] ) {
				$ultimatemember->form->add_error($key, sprintf(__('You are only allowed to enter a maximum of %s words'), $array['max_words']) );
				}
			}
			
			if ( isset( $array['min_chars'] ) && $array['min_chars'] > 0 ) {
				if ( strlen( utf8_decode( $args[$key] ) ) < $array['min_chars'] ) {
				$ultimatemember->form->add_error($key, sprintf(__('Your %s must contain at least %s characters'), $array['label'], $array['min_chars']) );
				}	
			}
			
			if ( isset( $array['max_chars'] ) && $array['max_chars'] > 0 ) {
				if ( strlen( utf8_decode( $args[$key] ) ) > $array['max_chars'] ) {
				$ultimatemember->form->add_error($key, sprintf(__('Your %s must contain less than %s characters'), $array['label'], $array['max_chars']) );
				}
			}
			
			if ( isset( $array['html'] ) && $array['html'] == 0 ) {
				if ( $args[$key] != htmlspecialchars($args[$key]) ) {
				$ultimatemember->form->add_error($key, __('You can not use HTML tags here') );
				}
			}
			
			if ( isset( $array['force_good_pass'] ) && $array['force_good_pass'] == 1 ) {
				if ( !$ultimatemember->validation->strong_pass( $args[$key] ) ) {
				$ultimatemember->form->add_error($key, __('Your password must contain at least one capital letter and one number') );
				}
			}
			
			if ( isset( $array['force_confirm_pass'] ) && $array['force_confirm_pass'] == 1 ) {
				if ( $args[ 'confirm_' . $key] == '' && !$ultimatemember->form->has_error($key) ) {
				$ultimatemember->form->add_error( 'confirm_' . $key , __('Please confirm your password') );
				}
				if ( $args[ 'confirm_' . $key] != $args[$key] && !$ultimatemember->form->has_error($key) ) {
				$ultimatemember->form->add_error( 'confirm_' . $key , __('Your passwords do not match') );
				}
			}
			
			if ( isset( $array['min_selections'] ) && $array['min_selections'] > 0 ) {
				if ( ( !isset($args[$key]) ) || ( isset( $args[$key] ) && is_array($args[$key]) && count( $args[$key] ) < $array['min_selections'] ) ) {
				$ultimatemember->form->add_error($key, sprintf(__('Please select at least %s choices'), $array['min_selections'] ) );
				}
			}
			
			if ( isset( $array['max_selections'] ) && $array['max_selections'] > 0 ) {
				if ( isset( $args[$key] ) && is_array($args[$key]) && count( $args[$key] ) > $array['max_selections'] ) {
				$ultimatemember->form->add_error($key, sprintf(__('You can only select up to %s choices'), $array['max_selections'] ) );
				}
			}
			
			if ( isset( $array['validate'] ) && !empty( $array['validate'] ) ) {
			
				switch( $array['validate'] ) {
				
					case 'phone_number':
						if ( !$ultimatemember->validation->is_phone_number( $args[$key] ) ) {
							$ultimatemember->form->add_error($key, __('Please enter a valid phone number') );
						}
						break;
						
					case 'facebook_url':
						if ( !$ultimatemember->validation->is_url( $args[$key], 'facebook.com' ) ) {
							$ultimatemember->form->add_error($key, sprintf(__('Please enter a valid %s username or profile URL'), $array['label'] ) );
						}
						break;
						
					case 'twitter_url':
						if ( !$ultimatemember->validation->is_url( $args[$key], 'twitter.com' ) ) {
							$ultimatemember->form->add_error($key, sprintf(__('Please enter a valid %s username or profile URL'), $array['label'] ) );
						}
						break;

					case 'instagram_url':
						if ( !$ultimatemember->validation->is_url( $args[$key], 'instagram.com' ) ) {
							$ultimatemember->form->add_error($key, sprintf(__('Please enter a valid %s username or profile URL'), $array['label'] ) );
						}
						break;
						
					case 'google_url':
						if ( !$ultimatemember->validation->is_url( $args[$key], 'plus.google.com' ) ) {
							$ultimatemember->form->add_error($key, sprintf(__('Please enter a valid %s username or profile URL'), $array['label'] ) );
						}
						break;
						
					case 'linkedin_url':
						if ( !$ultimatemember->validation->is_url( $args[$key], 'linkedin.com' ) ) {
							$ultimatemember->form->add_error($key, sprintf(__('Please enter a valid %s username or profile URL'), $array['label'] ) );
						}
						break;
						
					case 'skype':
						if ( !$ultimatemember->validation->is_url( $args[$key], 'skype.com' ) ) {
							$ultimatemember->form->add_error($key, sprintf(__('Please enter a valid %s username or profile URL'), $array['label'] ) );
						}
						break;
						
					case 'unique_username':
						
						if ( $args[$key] == '' ) {
							$ultimatemember->form->add_error($key, __('You must provide a username') );
						} else if ( $mode == 'register' && username_exists( sanitize_user( $args[$key] ) ) ) {
							$ultimatemember->form->add_error($key, __('Your username is already taken') );
						} else if ( is_email( $args[$key] ) ) {
							$ultimatemember->form->add_error($key, __('Username cannot be an email') );
						} else if ( !$ultimatemember->validation->safe_username( $args[$key] ) ) {
							$ultimatemember->form->add_error($key, __('Your username contains invalid characters') );
						}
						
						break;
						
					case 'unique_username_or_email':
						
						if ( $args[$key] == '' ) {
							$ultimatemember->form->add_error($key,  __('You must provide a username') );
						} else if ( $mode == 'register' && username_exists( sanitize_user( $args[$key] ) ) ) {
							$ultimatemember->form->add_error($key, __('Your username is already taken') );
						} else if ( $mode == 'register' && email_exists( $args[$key] ) ) {
							$ultimatemember->form->add_error($key,  __('This email is already linked to an existing account') );
						} else if ( !$ultimatemember->validation->safe_username( $args[$key] ) ) {
							$ultimatemember->form->add_error($key,  __('Your username contains invalid characters') );
						}
						
						break;
						
					case 'unique_email':
						
						if ( $args[$key] == '' ) {
							$ultimatemember->form->add_error($key, __('You must provide your email') );
						} else if ( $mode == 'register' && email_exists( $args[$key] ) ) {
							$ultimatemember->form->add_error($key, __('This email is already linked to an existing account') );
						} else if ( !is_email( $args[$key] ) ) {
							$ultimatemember->form->add_error($key, __('This is not a valid email') );
						} else if ( !$ultimatemember->validation->safe_username( $args[$key] ) ) {
							$ultimatemember->form->add_error($key,  __('Your email contains invalid characters') );
						}
						
						break;
				
				}
				
			}
			
		}
		
	}