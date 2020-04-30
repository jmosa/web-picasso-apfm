<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       apfm
 * @since      1.0.0
 * @package    Apfm_Lighthouse_Cpt
 * @subpackage Apfm_Lighthouse_Cpt/includes
 * @author     A Place for Mom, Inc.
 */
class Apfm_Lighthouse_Cpt_i18n {


    /**
     * Load the plugin text domain for translation.
     *
     * @since    1.0.0
     */
    public function load_plugin_textdomain() {

        load_plugin_textdomain(
            'apfm-lighthouse-cpt',
            false,
            dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
        );

    }
}
