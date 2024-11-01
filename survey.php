<?php
/*
Plugin Name: Survey
Plugin URI: http://seosthemes.com/survey/
Description: Simple WordPress Survey Plugin. Survey is easy to use, Include Shortcode in your page.
Version: 1.1
Contributors: seosbg
Author: seosbg
Author URI: http://seosthemes.com/
Text Domain: survey
*/

// ************** Include **************

include_once(plugin_dir_path(__FILE__) . 'inc/shortcode.php');
	
// ************* User Section **************

add_action('admin_menu', 'survey_menu');

function survey_menu() {
	add_menu_page('Survey', 'Survey', 'administrator', 'survey-settings', 'survey_plugin_settings_page', plugins_url( 'images/icon.png' , __FILE__  ));
}

add_action( 'admin_init', 'survey_plugin_settings' );

function survey_plugin_settings() {
	register_setting( 'survey-settings-group', 'questions_number' );
	register_setting( 'survey-settings-group', 'seos_send' );
	register_setting( 'survey-settings-group', 'seos_send_button' );
	register_setting( 'survey-settings-group', 'seos_not_send' );
	register_setting( 'survey-settings-group', 'seos_admin_email' );
	register_setting( 'survey-settings-group', 'seos_form_title' );
	register_setting( 'survey-settings-group', 'seos_spam' );
	
	$q = get_option('questions_number');
	for($new=1; $new<=get_option('count_rad'.$q); $new++) {
		register_setting( 'survey-settings-group', 'seos_form_radio'.$q );	
		register_setting( 'survey-settings-group', 'seos_form_radio_text'.$q.$new);	
	}
	
	
	for($go=1; $go<=get_option('questions_number'); $go++) {	
		register_setting( 'survey-settings-group', 'question'.$go );	


		register_setting( 'survey-settings-group', 'count_rad'.$go );
		$count_rad = get_option('count_rad'.$go);
		for($rad_num=1; $rad_num<=$count_rad; $rad_num++) {
			register_setting( 'survey-settings-group', 'seos_form_radio_text'.$go.$rad_num);
		}	
	}		
	
}


/*********************** Admin Scripts and Styles **************************/

function survey_admin_scripts() {
	wp_enqueue_style( 'survey-admin-css', plugin_dir_url(__FILE__) . '/css/admin.css' );
}
 
add_action( 'admin_enqueue_scripts', 'survey_admin_scripts' );


/*********************** Scripts and Styles **************************/

function survey_styles() {
	wp_enqueue_style( 'survey-styles-css', plugin_dir_url(__FILE__) . '/css/survey-style.css' );
}
 
add_action( 'wp_enqueue_scripts', 'survey_styles' );	

function survey_plugin_settings_page() {
?>

<div class="survey">

    <div class="survey-seos">
		<div>
			<a target="_blank" href="https://seosthemes.com/survey">
				<div class="btn s-red">
					 <?php _e('Survey ', 'survey'); echo ' <img class="ss-logo" src="' . plugins_url( 'images/logo.png' , __FILE__ ) . '" alt="logo" />';  _e(' Plugin', 'survey'); ?>
				</div>
			</a>
		</div>
	</div>	
			
	<h1><?php _e('Survey', 'survey'); ?></h1>
	
    <a href="http://seosthemes.com/survey/"><button type="button" class="button button-primary"><?php _e('How to use - Survey', 'survey'); ?></button></a>
   
	<?php include_once(plugin_dir_path(__FILE__) . 'inc/form.php'); ?>
	
</div>
<?php }

	function survey_language_load() {
		load_plugin_textdomain('survey_language_load', FALSE, basename(dirname(__FILE__)) . '/languages');
	}
	add_action('init', 'survey_language_load');
	