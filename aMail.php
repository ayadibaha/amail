<?php
/*
Plugin Name: aMail (Automated Emails)
Author: Ayadi Baha Eddine
Author URI: https://github.com/ayadibaha
Version: 1.0
*/
class aMail{
	function __construct(){
		require( ABSPATH . 'wp-content/plugins/aMail/includes/amail-install.php' );
		setup_db();
		install_libraries();
		add_action( 'admin_menu', array($this,'install_menus') );
	}
	function install_menus(){
    	add_menu_page('aMail', 'aMail', 'manage_options', 'amail-menu', array($this,'menu_page') );
    	add_submenu_page('amail-menu', 'Dashboard', 'Dashboard', 'manage_options', 'amail-menu' );
    	add_submenu_page('amail-menu', 'Lead list', 'Lead list', 'manage_options', 'amail-list',array($this,'submenu_page') );
	}
	function menu_page(){
		include(ABSPATH . 'wp-content/plugins/aMail/includes/amail-dashboard.php');
	}
	function submenu_page(){
		include(ABSPATH . 'wp-content/plugins/aMail/includes/amail-lead.php');
	}
}
new aMail();
?>