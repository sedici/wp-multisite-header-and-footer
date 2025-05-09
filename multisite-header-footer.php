<?php
/**
 * Plugin Name: Multisite Header and Footer
 * Plugin URI: http://sedici.unlp.edu.ar/
 * Description: This plugin allows to create and display a footer or header on all sites of your multisite. 
 * Version: 1.0 (Beta)
 * Author: SEDICI
 * Author URI: http://sedici.unlp.edu.ar/   
 * Copyright (c) 2015 SEDICI UNLP, http://sedici.unlp.edu.ar
 * Domain Path: /languages
 * Distributed under the GNU GPL v3. For full terms see the file docs/COPYING.
 * Network: true
 */

 namespace Wp_multisite_manager;
 define( __NAMESPACE__ . '\MM', __NAMESPACE__ . '\\' );
 define( MM . 'PLUGIN_NAME', 'wp-multisite-header-and-footer');
 define( MM . 'PLUGIN_VERSION', '1.0.0' );
 define( MM . 'PLUGIN_NAME_DIR', plugin_dir_path( __FILE__ ) );
 define( MM . 'PLUGIN_NAME_URL', plugin_dir_url( __FILE__ ) );
 define( MM . 'PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
 define( MM . 'PLUGIN_TEXT_DOMAIN', 'wp-multisite-header-and-footer' );

 require_once 'Inc/activator.php';
 require_once 'Inc/deactivator.php';


 require_once 'core/class-init.php';


/**
 * Register Activation and Deactivation Hooks
 */ 


register_activation_hook( __FILE__, array( MM . 'Inc\Activator', 'activate' ) );

register_deactivation_hook( __FILE__, array( MM . 'Inc\Deactivator', 'deactivate' ) );



class WP_multisite_manager {
    
    static $curr_dir; 

	static $init;




	/**
	 * Loads the plugin
	 * @access    public
	 */
	public static function init() {

       // Load the header on the DB
      //  $wpdb->insert('bannerCustom', 
     // $banner);
     
		if ( null == self::$init ) {
            self::$init = new Core\Init();
			self::$init->run();
		}

		return self::$init;
	}



    public static function curr_dir() {
        return plugins_url( '.', __FILE__ );
    }
}
/*
 * Comienza la ejecución del plugin
 */


 
function wp_multisite_manager_init(){
	return wp_multisite_manager::init();
}




/**
 * Si se accede desde afuera de wordpress aborta la ejecución.
 */
if ((! defined( 'WPINC' ) ) or (! is_multisite())) die;
wp_multisite_manager_init();

?>
