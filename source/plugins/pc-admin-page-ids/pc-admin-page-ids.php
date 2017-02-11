<?php
/*
Plugin Name: PC Admin Page IDs
Plugin URI: http://petercoughlin.com/wp-plugins/
Description: Adds a page and post ID column in WordPress admin...
Author: Peter Coughlin
Version: 2.0
Author URI: http://petercoughlin.com/
*/

function pc_admin_page_ids_init() {

	add_filter('manage_posts_columns', 'pc_admin_page_ids_filter');
	add_filter('manage_pages_columns', 'pc_admin_page_ids_filter');
	add_action('manage_posts_custom_column', 'pc_admin_page_ids_action', 10, 2);
	add_action('manage_pages_custom_column', 'pc_admin_page_ids_action', 10, 2);

}# end function pc_admin_page_ids_init() {


function pc_admin_page_ids_filter( $defaults ) {

    return pc_array_insert($defaults, 1, 'ids', 'ID');

}# end function pc_admin_page_ids( $content ) {


function pc_admin_page_ids_action( $column_name, $id ) {

	if ( $column_name == 'ids' )
		echo $id;

}# end function pc_admin_page_ids_action() {


function pc_array_insert( $array, $pos, $key, $val ) {

    $arraytmp = array_splice($array, $pos);
    $array[$key] = $val;
    $array = array_merge ($array, $arraytmp);

    return $array;

}# end function pc_array_insert( $array, $pos, $key, $val ) {

add_action('init', 'pc_admin_page_ids_init');
?>
