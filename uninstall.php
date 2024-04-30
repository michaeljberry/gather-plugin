<?php
/**
 * Trigger this file when plugin uninstall
 * @package Gather Community
 */

if(!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}

// clear database stored data upon uninstalling plugin
// $books = get_posts(['post_type' => 'book', 'numberposts' => -1]);
// foreach ($books as $book) {
//     wp_delete_post($book->ID, true);
// }

global $wpdb;
$wpdb->query("delete from wp_posts where post_type = 'book'");
$wpdb->query("delete from wp_postmeta where post_id not in (select id from wp_posts)");
$wpdb->query("delete from wp_term_relationships where object_id not in (select id from wp_posts)");

// Formidable IDs
$wpdb->query("delete from wp_options where option_name = 'gc_announcement_notification_id')");
$wpdb->query("delete from wp_options where option_name = 'gc_active_announcement_id')");
$wpdb->query("delete from wp_options where option_name = 'gc_classified_categories_form_id')");
$wpdb->query("delete from wp_options where option_name = 'gc_announcement_approve_id')");
$wpdb->query("delete from wp_options where option_name = 'gc_official_announcement_field_id')");
$wpdb->query("delete from wp_options where option_name = 'gc_active_polls_view_id')");
$wpdb->query("delete from wp_options where option_name = 'gc_business_category_view_id')");
$wpdb->query("delete from wp_options where option_name = 'gc_active_poll_field_id')");