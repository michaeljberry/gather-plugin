<?php
/**
 * @package Gather Community
 * 
 */
namespace Includes\Base;

class BaseController
{
    public $gather_plugin_path;
    public $gather_plugin_url;
    public $gather_plugin_base;

    public function __construct()
    {
        $this->gather_plugin_path  = plugin_dir_path( dirname( __FILE__, 2 ) );
        $this->gather_plugin_url   = plugin_dir_url( dirname( __FILE__, 2 ) );
        $this->gather_plugin_base  = plugin_basename( dirname( __FILE__, 3 ) ) . '/gather.php';
    }
}