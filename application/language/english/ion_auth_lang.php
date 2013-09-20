<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* Name:  Ion Auth Lang - English
*
* Author: Ben Edmunds
* 		  ben.edmunds@gmail.com
*         @benedmunds
*
* Location: http://github.com/benedmunds/ion_auth/
*
* Created:  03.14.2010
*
* Description:  English language file for Ion Auth messages and errors
*
*/

// Account Creation
$lang['account_creation_successful'] 	  	 = 'Account successfully created.';
$lang['account_creation_unsuccessful'] 	 	 = 'Unable to create account. Please try again.';
$lang['account_creation_duplicate_email'] 	 = 'This email already exists.';
$lang['account_creation_duplicate_username'] = 'Username already used.';

// Password
$lang['password_change_successful'] 	 	 = 'You&#39;ve successfully reset your password.';
$lang['password_change_unsuccessful'] 	  	 = 'Unable to change password. Please try again.';
$lang['forgot_password_successful'] 	 	 = 'We&#39;ve sent you an email that will allow you to reset your password.';
$lang['forgot_password_unsuccessful'] 	 	 = 'Unable to reset password.';

// Activation
$lang['activate_successful'] 		  	     = 'Account successfully activated.';
$lang['activate_unsuccessful'] 		 	     = 'Unable to activate account. Please try again.';
$lang['deactivate_successful'] 		  	     = 'Account has been de-activated.';
$lang['deactivate_unsuccessful'] 	  	     = 'Unable to de-activate account. Please try again.';
$lang['activation_email_successful'] 	  	 = 'Activation email sent.';
$lang['activation_email_unsuccessful']   	 = 'Unable to send activation email. Please try again.';

// Login / Logout
$lang['login_successful'] 		  	         = 'Logged in successfully.';
$lang['login_unsuccessful'] 		  	     = 'The email address or password you provided does not match our records.';
$lang['login_unsuccessful_not_active'] 		 = 'Account is inactive.';
$lang['login_timeout']                       = 'Temporarily locked out. Please try again later.';
$lang['logout_successful'] 		 	         = 'Logged out successfully.';

// Account Changes
$lang['update_successful'] 		 	         = 'Account information successfully updated.';
$lang['update_unsuccessful'] 		 	     = 'Unable to update account information. Please try again.';
$lang['delete_successful']               = 'User deleted.';
$lang['delete_unsuccessful']           = 'Unable to delete user. Please try again.';

// Groups
$lang['group_creation_successful']  = 'Group created successfully.';
$lang['group_already_exists']       = 'Group name already taken.';
$lang['group_update_successful']    = 'Group details updated.';
$lang['group_delete_successful']    = 'Group deleted.';
$lang['group_delete_unsuccessful'] 	= 'Unable to delete group. Please try again.';
$lang['group_name_required'] 		= 'Group name is a required field.';

// Email Subjects
$lang['email_forgotten_password_subject']    = 'Reset your Emplayo password.';
$lang['email_new_password_subject']          = 'Your Emplayo password has been changed.';
$lang['email_activation_subject']            = 'Please confirm your email address.';