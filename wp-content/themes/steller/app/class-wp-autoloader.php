<?php

namespace Theme\Steller;

/**
 * Class WP_Autoloader
 *
 * @package Theme\Steller
 *
 * The class that includes all the required components to work with the theme.
 */

class WP_Autoloader {


    static protected $autoload_dirs = [];

    /**
     * Inits auto load.
     */
    static public function init() {
        self::define_autoload_dirs();
        self::load();
    }

    static protected function define_autoload_dirs() {
        $theme_server_path = get_stylesheet_directory();

        self::$autoload_dirs = [
            "{$theme_server_path}/app/*.php",

        ];
    }

    /**
     * Loads all files from directories specified in the variable
     * $autoload_dirs.
     */
    static protected function load() {
        foreach ( self::$autoload_dirs as $directory ) {
            foreach ( glob( $directory ) as $module ) {

                if ( ! $modulepath = $module ) {
                    trigger_error( sprintf( __( 'Error locating %s for inclusion', 'steller' ), $module ), E_USER_ERROR );
                }

                require_once( $modulepath );
            }
        }

        unset( $module, $filepath );
    }

}