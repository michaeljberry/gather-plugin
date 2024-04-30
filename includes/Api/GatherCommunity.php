<?php
/**
 * @package Gather Community
 * 
 */

namespace Includes\Api;

class GatherCommunity
{
    public static function change_already_submitted_message() {
        $settings                    = \FrmProAppHelper::get_settings();
        $settings->already_submitted = 'You have already voted in this poll.';
    }
    
    public static function get_poll_forms() {
        global $wpdb;
    
        $forms = $wpdb->get_results($wpdb->prepare("SELECT id, name FROM " . $wpdb->prefix . "frm_forms"));
        $pollForms = [];
        foreach ($forms as $form) {
            if (stripos($form->name, "poll -") !== false) {
                $pollForms[] = (int)$form->id;
            }
        }
        return $pollForms;
    }

    public static function auto_populate_data()
    {
        global $wpdb;
        $wpdb->query("insert into ".$wpdb->prefix."options (option_name, option_value, autoload) values ('gc_announcement_notification_id', 2176, 'yes')");
        $wpdb->query("insert into ".$wpdb->prefix."options (option_name, option_value, autoload) values ('gc_active_announcement_id', 1872, 'yes')");
        $wpdb->query("insert into ".$wpdb->prefix."options (option_name, option_value, autoload) values ('gc_classified_categories_form_id', 10, 'yes')");
        $wpdb->query("insert into ".$wpdb->prefix."options (option_name, option_value, autoload) values ('gc_announcement_approve_id', 27, 'yes')");
        $wpdb->query("insert into ".$wpdb->prefix."options (option_name, option_value, autoload) values ('gc_official_announcement_field_id', 35, 'yes')");
        $wpdb->query("insert into ".$wpdb->prefix."options (option_name, option_value, autoload) values ('gc_active_polls_view_id', 2067, 'yes')");
        $wpdb->query("insert into ".$wpdb->prefix."options (option_name, option_value, autoload) values ('gc_business_category_view_id', 1043, 'yes')");
        $wpdb->query("insert into ".$wpdb->prefix."options (option_name, option_value, autoload) values ('gc_active_poll_field_id', 92, 'yes')");
    }
}