<?php
/**
 * @package Gather Community
 * 
 */

namespace Includes\Pages;

use \Includes\Api\SettingsApi;
use \Includes\Base\BaseController;
use Includes\Api\Callbacks\AdminCallbacks;

class Admin extends BaseController
{
    public $settings;
    public $pages;
    public $subpages;
    public $callbacks;

    public function register() {
        $this->settings = new SettingsApi();
        $this->callbacks = new AdminCallbacks();
        $this->setPages();
        $this->setSubPages();
        $this->setSettings();
        $this->settings->addPages( $this->pages )->register();
    }

    public function setPages()
    {
        $this->settings = new SettingsApi();
        $this->pages = [
            [
                'page_title'    => 'Gather Community',
                'menu_title'    => 'Gather Community',
                'capability'    => 'manage_options',
                'menu_slug'     => 'gather_community',
                'callback'      => [$this->callbacks, 'dashboardPage'],
                'icon_url'      => $this->gather_plugin_url . 'assets/images/gather-icon.png',
                'position'      => 110
            ]
        ];
    }

    public function setSubPages()
    {
        $this->subpages  = [
            [
                'parent_slug'   => $this->pages[0]['menu_slug'],
                'page_title'    => 'Pages Setup',
                'menu_title'    => 'Pages Setup',
                'capability'    => $this->pages[0]['capability'],
                'menu_slug'     => 'gather_community_page_setup',
                'callback'      => [$this->callbacks, 'settingsPage'],
            ]
        ];
    }

    public function setSettings()
    {
        $args = [
            [
                'option_group'  => 'gather_options_group',
                'option_name'   => 'gc_classified_categories_form_id',
                'callback'      => [$this->callbacks, 'gatherOptionsGroup']
            ],
            [
                'option_group'  => 'gather_options_group',
                'option_name'   => 'gc_announcement_notification_id',
                'callback'      => [$this->callbacks, 'gatherOptionsGroup']
            ],
            [
                'option_group'  => 'gather_options_group',
                'option_name'   => 'gc_active_announcement_id',
                'callback'      => [$this->callbacks, 'gatherOptionsGroup']
            ],
            [
                'option_group'  => 'gather_options_group',
                'option_name'   => 'gc_announcement_approve_id',
                'callback'      => [$this->callbacks, 'gatherOptionsGroup']
            ],
            [
                'option_group'  => 'gather_options_group',
                'option_name'   => 'gc_official_announcement_field_id',
                'callback'      => [$this->callbacks, 'gatherOptionsGroup']
            ],
            [
                'option_group'  => 'gather_options_group',
                'option_name'   => 'gc_active_polls_view_id',
                'callback'      => [$this->callbacks, 'gatherOptionsGroup']
            ]
        ];

        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = [
            [
                'id'        => 'gather_admin_index',
                'title'     => 'Settings',
                'callback'  => [$this->callbacks, 'gatherAdminSection'],
                'page'      => 'gather_community'
            ]
        ];

        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = [
            [
                'id'        => 'text_example',
                'title'     => 'Text Example',
                'callback'  => [$this->callbacks, 'gatherTextExample'],
                'page'      => 'gather_community',
                'section'   => 'gather_admin_index',
                'args'      => [
                    'label_for'     => 'text_example',
                    'class'         => 'form-label'
                ]
            ]
        ];

        $this->settings->setFields($args);
    }

}