<?php
/**
 * @package Gather Community
 * 
 */

namespace Includes\Base;

class GatherSettingsLinks extends BaseController
{
    public function register() {
        add_filter( 'plugin_action_links_' . $this->gather_plugin_base, [$this, 'gather_settings_link']);
    }

    public function gather_settings_link($links) {
        $gather_settings_link = '<a href="admin.php?page=gather_community">Settings</a>';
        array_push($links, $gather_settings_link);
        return $links;
    }

}