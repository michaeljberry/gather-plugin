<?php
/**
 * @package Gather Community
 * 
 */

namespace Includes\Api;

class FormidableFilter
{
    public $announcementsNotifications;
    public $activeAnnouncements;
    public $classifiedsCategoriesFormId;
    public $announcementApprovedId;
    public $officialAnouncementFieldId;
    public $activePollsViewId;
    public $businessCategoryViewId;
    public $activePollField;

    function __construct()
    {
        $this->announcementsNotifications = esc_attr( get_option( 'gc_announcement_notification_id' ) );
        $this->activeAnnouncements = esc_attr( get_option( 'gc_active_announcement_id' ) );
        $this->classifiedsCategoriesFormId = esc_attr( get_option( 'gc_classified_categories_form_id' ) );
        $this->announcementApprovedId = esc_attr( get_option( 'gc_announcement_approve_id' ) );
        $this->officialAnouncementFieldId = esc_attr( get_option( 'gc_official_announcement_field_id' ) );
        $this->activePollsViewId = esc_attr( get_option( 'gc_active_polls_view_id' ) );
        $this->businessCategoryViewId = esc_attr( get_option( 'gc_business_category_view_id' ) );
        $this->activePollField = esc_attr( get_option( 'gc_active_poll_field_id' ) );
    }

    public function register()
    {
        if ( !has_filter( 'wp_nav_menu', 'do_shortcode' ) ) {
            add_filter( 'wp_nav_menu', 'shortcode_unautop' );
            add_filter( 'wp_nav_menu', 'do_shortcode', 11 );
        }

        add_filter( 'frm_global_login_msg', [$this, 'ff_change_global_login_message'] );
        add_filter( 'wp_nav_menu_items', [$this, 'add_extra_item_to_nav_menu'], 10, 2 );
        add_filter( 'wp_get_nav_menu_items', [$this, 'add_classifieds_sub_menu_items'], 10, 3 );
        add_filter( 'frm_get_default_value', [$this, 'auto_select_approved_for_municipal_users'], 10, 2 );
        add_filter( 'frm_display_inner_content_before_add_wrapper', [$this, 'active_polls_view'], 10, 3 );
        add_filter( 'frm_validate_entry', [$this, 'validate_my_form'], 20, 2 );
        add_filter( 'frm_no_entries_message', [$this, 'remove_no_entries_message'], 10, 2);
        add_filter( 'frm_no_entries_message', [$this, 'remove_no_entries_message_div'], 10, 2);
        add_filter( 'wp_get_page', [$this, 'hide_menu'], 10, 3);
        add_filter( 'frm_setup_new_fields_vars', [$this, 'add_custom_autocomplete_options'], 20, 2);
        add_filter( 'frm_setup_edit_fields_vars', [$this, 'add_custom_autocomplete_options'], 20, 2);
    }

    function ff_change_global_login_message( $message ) {
        if ( function_exists( 'load_formidable_forms' ) ) {
    
            $frm_settings = \FrmAppHelper::get_settings();
            $frm_login_msg = $frm_settings->login_msg;
            
            /*
             * In Formidable Forms -> General Settings -> Message Defaults -> Login Message
             * use the following:
             * Please  *register/sign in* to access this form.
            */
            if ( substr_count( $frm_login_msg, '*' ) == 2 ) { // because the login message has 2 '*', we know we should be editing the message
                $frm_login_msg_array = explode( "*", $frm_login_msg );
                
                $current_url = home_url( add_query_arg( [], $GLOBALS['wp']->request ) ); // get_permalink() doesn't include query vars
                
                $frm_login_msg = $frm_login_msg_array[0] . "";
                $frm_login_msg .= '<a class="login-link" href="#user_login_modal" alt="' . esc_attr__( 'Login', 'Wordpress' ) . '">&nbsp;';
                $frm_login_msg .= $frm_login_msg_array[1];
                $frm_login_msg .= '</a>';
                $frm_login_msg .= $frm_login_msg_array[2];
            }

            return $frm_login_msg;
        }

        return '';
    }

    function add_extra_item_to_nav_menu($items, $args) {
        $notificationBell = do_shortcode( "[display-frm-data id=$this->activeAnnouncements wpautop=0]" );
        if (!empty($notificationBell)){
            $items .= '<li class="gather">';
            $items .= $notificationBell;
            $items .= '</li>';
        } else {
            $items .= '<li class="gather">';
            $items .= do_shortcode( "[display-frm-data id=$this->announcementsNotifications wpautop=0]" );
            $items .= '</li>';
        }
        return $items;
    }

    function remove_no_entries_message_div( $message, $args ) {
        $user = wp_get_current_user();
        if ( $args['display']->ID == $this->activeAnnouncements ) {
            $message = "";
        }

        if ($args['display']->ID == $this->announcementsNotifications && !isset($user->id)) {
            $message = "";
        }

        return $message;
    }

    function add_classifieds_sub_menu_items($items, $menu, $args) {
        // don't add child categories in administration of menus
        if (is_admin()) {
            return $items;
        }
        
        foreach ($items as $index => $i) {
    
            if ("Classifieds" !== $i->title) {
                continue;
            }
            
            $classifiedMenuId = $i->ID;
            $entries = \FrmEntry::getAll(array('it.form_id' => $this->classifiedsCategoriesFormId), ' ORDER BY it.name ASC', '');
            
            // add classifieds categories
    
            foreach ($entries as $index => $entry) {
                $e = new \stdClass();
                $category = $entry->name;
    
                $e->title = $category;
                $e->url = "/classifieds?category=$category";
                $e->menu_order = 500 * ($index + 1);
                $e->post_type = "nav_menu_item";
                $e->post_status = "published";
                $e->post_parent = 0;
                $e->menu_item_parent = $i->ID;
                $e->type = "custom";
                $e->object = "custom";
                $e->description = "";
                $e->object_id = $entry->ID;
                $e->db_id = $entry->ID;
                $e->ID = $entry->ID;
                $e->classes = array();
    
                $items[] = $e;
            }
        }

        return $items;
    }

    function auto_select_approved_for_municipal_users($new_value, $field){
        if ( $field->id == $this->announcementApprovedId || $field->id == $this->officialAnouncementFieldId ) {
            $user = wp_get_current_user();
            if (in_array('municipality', $user->roles) || in_array('administrator', $user->roles)){
                if ($field->id == $this->announcementApprovedId) {
                    return "Yes";
                }
            }
        }
        return $new_value;
    }

    function active_polls_view( $inner_content, $view, $args ) {
        if ($view->ID == $this->activePollsViewId) {
            $forms = explode(", ", $inner_content);
            $content = "";

            foreach($forms as $formId) {
                global $wpdb;
                $formTitle = $wpdb->get_col($wpdb->prepare("SELECT name FROM " . $wpdb->prefix . "frm_forms WHERE id = %d", $formId));
                $formTitle = str_ireplace("Poll -", "", $formTitle[0]);
                $pollTitle = "<h4>$formTitle</h4>";
                
                $form = do_shortcode('[formidable id=' . $formId . ' minimize=1]');
                $user = wp_get_current_user();
                $resultsHtml = "";
                if (stripos($form, 'voted') !== false) {
                    $formStats = [];
                    $formStats["total"] = 0;
                    $formEntries = \FrmEntryMeta::getAll("form_id=". $formId);
                    foreach ($formEntries as $entry) {
                        if (!empty($entry->fi_options)) {
                            $fieldId = $entry->field_id;
                            $field = \FrmField::getOne( $fieldId );
                            $fieldOptions = [];
                            foreach ($field->options as $option) {
                                $fieldOptions[] = $option['label'];
                                if (!array_key_exists($option['label'], $formStats)) {
                                    $formStats[$option['label']] = 0;
                                }
                            }
                            $formStats[$entry->meta_value]++;
                            $formStats["total"]++;
                        }
                    }
                    $total = $formStats['total'];
                    unset($formStats['total']);
                    arsort($formStats);
                    $resultsHtml .= "<p>&nbsp;</p><p><strong>Poll Results:</strong></p>";
                    foreach ($formStats as $key => $stat) {
                        $resultsHtml .= "$key: " . round((($stat / $total) * 100), 0) . "%<br>";
                    }
                    $resultsHtml .= "";
                }
    
                $content .= '<li><figure><section>';
                $content .= $pollTitle;
                $content .= $form;
                $content .= $resultsHtml;
                $content .= '</section></figure></li>';
            }
            $inner_content = $content;
        }

        return $inner_content;
    }

    function validate_my_form( $errors, $values ) {
        $pollForms = GatherCommunity::get_poll_forms();
        if ( in_array((int) $values['form_id'], $pollForms) ) {
            GatherCommunity::change_already_submitted_message();
        }
        
        return $errors;
    }

    function remove_no_entries_message( $message, $args ) {
        if ( $args['display']->ID == $this->businessCategoryViewId ) {
            $message = '';
            $message .= '<main class="business-listings">';
                $message .= '<section class="cards">';
                    $message .= '<ul>';
                        $message .= '<li>';
                            $message .= '<figure>';
                                $message .= '<div class="logo-placeholder">';
                                    $message .= '<div style="font-size: 24px; font-weight: 600;">AnyWhere USA<br>FREE BUSINESS DIRECTORY</div>';
                                $message .= '</div>';
                                $message .= '<figcaption class="caption-content"><h3>Your business could go here</h3><div><a href="#">Learn More</a></div></figcaption>';
                            $message .= '</figure>';
                        $message .= '</li>';
                    $message .= '</ul>';
                $message .= '</section>';
            $message .= '</main>';
        }
        return $message;
    }

    function hide_menu($items, $menu, $args) {
        // don't add child categories in administration of menus
        if (is_admin()) {
            return $items;
        }
    }

    function add_custom_autocomplete_options($values, $field) {
        $activePollField = $this->activePollField;
        if ($field->id == $activePollField) {
            global $wpdb;
    
            $forms = $wpdb->get_results($wpdb->prepare("SELECT id, name FROM " . $wpdb->prefix . "frm_forms"));
            
            foreach ($forms as $form) {
                if (stripos($form->name, "poll -") !== false) {
                    $values['options'][$form->id] = $form->name;
                }
            }
            $values['use_key'] = true;
        }
        
        return $values;
    }

}