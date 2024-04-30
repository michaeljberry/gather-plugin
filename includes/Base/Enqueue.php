<?php
/**
 * @package Gather Community
 * 
 */

 namespace Includes\Base;

 use \Includes\Base\BaseController;

 class Enqueue extends BaseController
 {
    public function register() {
        add_action( 'admin_enqueue_scripts', [$this, 'enqueue'] ); // change the admin to wp to make the css affects the front end
        add_action( 'wp_enqueue_scripts', [$this, 'enqueue_front'] );
    }

    function enqueue() {
        wp_enqueue_style('bootstrap', $this->gather_plugin_url . 'assets/css/bootstrap.min.css', __FILE__ );
        wp_enqueue_style('pluginstyle', $this->gather_plugin_url . 'assets/css/style.css', __FILE__ );

        wp_enqueue_script('bootstrapjs', $this->gather_plugin_url . 'assets/js/bootstrap.min.js', __FILE__ );
        wp_enqueue_script('pluginscript', $this->gather_plugin_url . 'assets/js/main.js', __FILE__ );
    }

    function enqueue_front() {
        wp_enqueue_style('frontnedcss', $this->gather_plugin_url . 'assets/css/front.css', __FILE__ );

        wp_enqueue_script('jqueryscript', $this->gather_plugin_url . 'assets/js/jquery.min.js', __FILE__ );
        wp_enqueue_script('frontendjs', $this->gather_plugin_url . 'assets/js/front.js', __FILE__ );
    }
 }