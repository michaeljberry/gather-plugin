<?php
/**
 * @package Gather Community
 * 
 */

namespace Includes\Base;

class GatherDeactivate
{
    public static function deactivate() {
        flush_rewrite_rules();
    }
}