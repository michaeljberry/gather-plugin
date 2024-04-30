<?php
/**
 * @package Gather Community
 * 
 */

namespace Includes\Base;

use Includes\Api\GatherCommunity;

class GatherActivate
{
    public static function activate() {
        GatherCommunity::auto_populate_data();
        flush_rewrite_rules();
    }
}