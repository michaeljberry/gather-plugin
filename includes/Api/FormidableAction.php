<?php
/**
 * @package Gather Community
 * 
 */

namespace Includes\Api;

class FormidableAction
{
    public function register()
    {
        add_action( 'frm_display_form_action', [$this, 'check_entry_count'], 8, 3 );
        remove_action( 'pre_get_posts', [$this, 'FrmProFileField::filter_media_library'], 99 );
    }

    function check_entry_count( $params, $fields, $form ) {
        $pollForms = GatherCommunity::get_poll_forms();
        if ( in_array((int) $form->id, $pollForms) ) {
            GatherCommunity::change_already_submitted_message();
        }
    }
}