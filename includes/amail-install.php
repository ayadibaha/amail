<?php
function setup_db(){
	global $wpdb;
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	if ($wpdb->get_var('SHOW TABLES LIKE wp_amail_list') != 'wp_amail_list') {
		$sql = "CREATE TABLE wp_amail_list(
			id int(10) AUTO_INCREMENT,
			name varchar(50),
			email varchar(50),
			status varchar(10),
			verified varchar(20),
			url varchar(200),
			date_add datetime DEFAULT '0000/00/00 00:00:00',
			address varchar(200),
			PRIMARY KEY(id));";
	    dbDelta($sql);
	}
	if ($wpdb->get_var('SHOW TABLES LIKE wp_amail_msg') != 'wp_amail_msg') {
		$sql = "CREATE TABLE IF NOT EXISTS wp_amail_msg(
			id int(2),
			msg varchar(65500),
			PRIMARY KEY(id));";
		dbDelta($sql);
	}
}
function install_libraries(){
	wp_enqueue_style( 'bootstrap', plugins_url('aMail/includes/css/bootstrap.min.css', _FILE_) );
	wp_enqueue_style( 'bootstrap-theme', plugins_url('aMail/includes/css/bootstrap-theme.min.css', _FILE_) );
	wp_enqueue_style( 'style', plugins_url('aMail/includes/css/style.css', _FILE_) );
	wp_enqueue_script( 'jquery-js', plugins_url('aMail/includes/js/jquery.js', _FILE_) );
	wp_enqueue_script( 'bootstrap-js', plugins_url('aMail/includes/js/bootstrap.min.js', _FILE_) );
	wp_enqueue_script( 'dataTables-js', plugins_url('aMail/includes/js/dataTables.bootstrap.min.js', _FILE_) );
	wp_enqueue_script( 'script', plugins_url('aMail/includes/js/script.js', _FILE_) );
}
?>