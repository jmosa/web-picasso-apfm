<?php

/**
* Plugin Name: APFM Lighthouse CPT
* Plugin URI: https://www.aplaceformom.com/
* Description: Lighthouse CPT creates and mantains the data structures (Custom post types and custom fields) used for the new APFM.com site sections.
* Version: 1.5.7
* Author: A Place for Mom, Inc.
* Author URI: https://www.aplaceformom.com/
* Copyright (c) 2018 A Place For Mom. All rights reserved.
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
    die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'APFM_LIGHTHOUSE_CPT_VERSION', '1.5.7' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-apfm-lighthouse-cpt-activator.php
 */
function activate_apfm_lighthouse_cpt() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-apfm-lighthouse-cpt-activator.php';
    Apfm_Lighthouse_Cpt_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-apfm-lighthouse-cpt-deactivator.php
 */
function deactivate_apfm_lighthouse_cpt() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-apfm-lighthouse-cpt-deactivator.php';
    Apfm_Lighthouse_Cpt_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_apfm_lighthouse_cpt' );
register_deactivation_hook( __FILE__, 'deactivate_apfm_lighthouse_cpt' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-apfm-lighthouse-cpt.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_apfm_lighthouse_cpt() {

    $plugin = new Apfm_Lighthouse_Cpt();
    $plugin->run();

}
run_apfm_lighthouse_cpt();


