<?php
/**
 * @package Gather Community
 * 
 */

namespace Includes\Api\Callbacks;

use Includes\Base\BaseController;

class AdminCallbacks extends BaseController
{
    public function dashboardPage()
    {
        return require_once ("$this->gather_plugin_path/templates/dashboard.php");
    }

    public function settingsPage()
    {
        return require_once ("$this->gather_plugin_path/templates/settings.php");
    }

    public function gatherOptionsGroup($input)
    {
        return $input;
    }

    public function gatherAdminSection()
    {
        // echo 'Check this section.';
    }

    public function gatherTextExample()
    {
        $value = esc_attr( get_option( 'text_example' ) );
        echo '<input type="text" class="form-control" name="text_example" value="'. $value .'" placeholder="" />';
    }
}