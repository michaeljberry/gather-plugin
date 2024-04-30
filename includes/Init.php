<?php
/**
 * @package Gather Community
 * 
 */

 namespace Includes;

 final class Init
 {
    /**
     * Store all the classes inside an array
     */
    public static function get_services() {
        return [
            Pages\Admin::class,
            Base\Enqueue::class,
            Base\GatherSettingsLinks::class,
            Api\FormidableFilter::class,
            // Api\FormidableAction::class
        ];
    }

    public static function register_services() {
        foreach ( self::get_services() as $class) {
            $service = self::instantiate($class);
            if(method_exists($service, 'register')) {
                $service->register();
            }
        }
    }

    /**
     * Initialize all the class
     */
    private static function instantiate($class) {
        return new $class;
    }
 }