<?php
/**
 * WordPress AJAX Process Execution.
 *
 * @package WordPress
 * @subpackage Administration
 */

/**
 * Executing AJAX process.
 *
 * @since unknown
 */
  
define('DOING_AJAX', true);
define('WP_ADMIN', true);

require_once('../../../wp-load.php');

if( ! isset($_POST['action']))
	die('-1');

require_once('../../../wp-admin/includes/admin.php');
@header('Content-Type: text/html; charset=' . get_option('blog_charset'));
send_nosniff_header();

do_action('admin_init');

if ( ! is_user_logged_in() ) {
	$result['STATUS'] = 'error';
	$result['ERROR_MESSAGE'] = 'not_logged';
	echo json_encode($result);
	die();
}
else{
	switch ( $action = $_POST['action'] ) {
		case'change_language':
			update_option('bga_language',$_POST['bga_language']);
			$result['STATUS'] = 'ok';
			echo json_encode($result);
			die();
		break;
		case'save_bga_print_settings':
			$values_s = $_POST['values'];
			$temp = explode('&',$values_s);
			foreach($temp as $v){
				$t = explode('=',$v);
				$values[$t[0]] = $t[1];	
			}
			$save = json_encode($values);
			update_option('bga_print_settings',$save);
			$result['STATUS'] = 'error';
			if($save==get_option(bga_print_settings))
				$result['STATUS'] = 'ok';
			echo json_encode($result);
			die();
		break;
		case'save_bga_ads_general_settings':
			$bga_ads_id = $_POST['bga_ads_id'];
			$bga_ads_chanel = $_POST['bga_ads_chanel'];
			
			update_option('bga_ads_id', $bga_ads_id);
			update_option('bga_ads_chanel', $bga_ads_chanel);
			
			$result['STATUS'] = 'ok';
			echo json_encode($result);
			die();
		break;
	}
}
?>
