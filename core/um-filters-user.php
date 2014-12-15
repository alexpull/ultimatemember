<?php

	/***
	***	@Get all bulk actions
	***/
	add_filter('um_admin_bulk_user_actions_hook', 'um_admin_bulk_user_actions_hook', 1);
	function um_admin_bulk_user_actions_hook( $actions ){

		$actions = null;

		$actions['um_approve_membership'] = array( 'label' => __('Approve Membership') );
		$actions['um_reject_membership'] = array( 'label' => __('Reject Membership') );
		$actions['um_put_as_pending'] = array( 'label' => __('Put as Pending Review') );
		$actions['um_resend_activation'] = array( 'label' => __('Resend Activation E-mail') );
		$actions['um_deactivate'] = array( 'label' => __('Deactivate') );
		$actions['um_reenable'] = array( 'label' => __('Reactivate') );
		$actions['um_delete'] = array( 'label' => __('Delete') );
		
		return $actions;
	}
	
	/***
	***	@Main admin user actions
	***/
	add_filter('um_admin_user_actions_hook', 'um_admin_user_actions_hook', 1);
	function um_admin_user_actions_hook( $actions ){

		$actions = null;
		
		if ( !um_user('super_admin') ) {
		
			if ( um_user('account_status') == 'awaiting_admin_review' ){
				$actions['um_approve_membership'] = array( 'label' => __('Approve Membership') );
				$actions['um_reject_membership'] = array( 'label' => __('Reject Membership') );
			} else {
				$actions['um_approve_membership'] = array( 'label' => __('Approve Membership'), 'disabled' => 'disabled' );
				$actions['um_reject_membership'] = array( 'label' => __('Reject Membership'), 'disabled' => 'disabled'  );
			}
			
			if ( um_user('account_status') == 'rejected' ) {
				$actions['um_approve_membership'] = array( 'label' => __('Approve Membership') );
				$actions['um_reject_membership'] = array( 'label' => __('Reject Membership'), 'disabled' => 'disabled'  );
			}
			
			if ( um_user('account_status') == 'approved' ) {
				$actions['um_put_as_pending'] = array( 'label' => __('Put as Pending Review') );
			} else {
				$actions['um_put_as_pending'] = array( 'label' => __('Put as Pending Review'), 'disabled' => 'disabled'  );
			}
			
			if ( um_user('account_status') == 'awaiting_email_confirmation' ) {
				$actions['um_resend_activation'] = array( 'label' => __('Resend Activation E-mail') );
			} else {
				$actions['um_resend_activation'] = array( 'label' => __('Resend Activation E-mail'), 'disabled' => 'disabled'  );
			}
			
			if (  um_user('account_status') != 'inactive' ) {
				$actions['um_deactivate'] = array( 'label' => __('Deactivate this account') );
			} else {
				$actions['um_deactivate'] = array( 'label' => __('Deactivate this account'), 'disabled' => 'disabled'  );
			}
			
			if (  um_user('account_status') == 'inactive' ) {
				$actions['um_reenable'] = array( 'label' => __('Reactivate this account') );
			} else {
				$actions['um_reenable'] = array( 'label' => __('Reactivate this account'), 'disabled' => 'disabled'  );
			}
			
			$actions['um_delete'] = array( 'label' => __('Delete this user') );
			
		}
		
		return $actions;
	}