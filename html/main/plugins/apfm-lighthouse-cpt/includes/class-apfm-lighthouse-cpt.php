<?php

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @link       apfm
 * @since      1.0.0
 * @package    Apfm_Lighthouse_Cpt
 * @subpackage Apfm_Lighthouse_Cpt/includes
 * @author     A Place for Mom, Inc.
 */
class Apfm_Lighthouse_Cpt {

    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Apfm_Lighthouse_Cpt_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The view that's responsible for rendering the html views of the plugin
     *
     * @since    1.0.0
     * @access   protected
     * @var      Apfm_Lighthouse_Cpt_View    $loader    Renders view templates.
     */
    protected $view;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $lighthouse_cpt    The string used to uniquely identify this plugin.
     */
    protected $lighthouse_cpt;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
	protected $version;
	
    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if ( defined( 'APFM_LIGHTHOUSE_CPT_VERSION' ) ) {
            $this->version = APFM_LIGHTHOUSE_CPT_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->lighthouse_cpt = 'apfm-lighthouse-cpt';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();

    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Apfm_Lighthouse_Cpt_Loader. Orchestrates the hooks of the plugin.
     * - Apfm_Lighthouse_Cpt_i18n. Defines internationalization functionality.
     * - Apfm_Lighthouse_Cpt_Admin. Defines all hooks for the admin area.
     * - Apfm_Lighthouse_Cpt_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {

        /**
         * The class responsible for orchestrating the actions and filters of the core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-apfm-lighthouse-cpt-loader.php';

        /**
         * The class responsible for rendering the views of the plugin.
         */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-apfm-lighthouse-cpt-view.php';
		
        /**
         * The class responsible for defining internationalization functionality of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-apfm-lighthouse-cpt-i18n.php';

        /**
         * The class responsible for defining all custom post types and taxonomies.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-apfm-lighthouse-cpt-data.php';

        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-apfm-lighthouse-cpt-admin.php';

        /**
         * The class responsible for defining all actions that occur in the public-facing side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-apfm-lighthouse-cpt-public.php';

        $this->loader = new Apfm_Lighthouse_Cpt_Loader();
        $this->view = new Apfm_Lighthouse_Cpt_View();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Apfm_Lighthouse_Cpt_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {

        $plugin_i18n = new Apfm_Lighthouse_Cpt_i18n();

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
        // add data related actions
        $plugin_data = new Apfm_Lighthouse_Cpt_Data();
        
        $this->loader->add_action( 'init', $plugin_data, 'apfm_custom_taxonomies' );
        // $this->loader->add_action( 'init', $plugin_data, 'apfm_default_terms' );
        $this->loader->add_action( 'init', $plugin_data, 'apfm_custom_post_types' );
        $this->loader->add_filter( 'manage_apfm_features_posts_columns', $plugin_data, 'lighthouse_cpt_columns_head' );
		$this->loader->add_action( 'manage_apfm_features_posts_custom_column', $plugin_data, 'lighthouse_cpt_columns_content', 10, 2 );
		$this->loader->add_action( 'restrict_manage_posts', $plugin_data, 'lighthouse_cpt_filter_by_feature_type' , 10, 2);
		$this->loader->add_action( 'manage_edit-apfm_features_sortable_columns', $plugin_data, 'lighthouse_cpt_columns_sortable' );
		$this->loader->add_filter( 'posts_clauses', $plugin_data, 'lighthouse_cpt_sort_by_feature_type', 10, 2 );

		$this->loader->add_action( 'save_post', $plugin_data, 'apfm_post_data_save', 10, 3 );
		$this->loader->add_action( 'post_updated', $plugin_data, 'apfm_slug_change_checker', 10, 3 );
		$this->loader->add_action( 'admin_init', $plugin_data, 'apfm_custom_data_load', 15 );
		$this->loader->add_action( 'admin_init', $plugin_data, 'apfm_fields_autosync_and_fix_ids', 20 );
		$this->loader->add_action( 'apfm_sync', $plugin_data, 'apfm_custom_data_load', 15 );
		$this->loader->add_action( 'apfm_sync', $plugin_data, 'apfm_fields_autosync_and_fix_ids', 20 );

        // add admin related actions
        $plugin_admin = new Apfm_Lighthouse_Cpt_Admin( $this->get_lighthouse_cpt(), $this->get_version(), $this->get_view() );

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_filter( 'acf/settings/save_json', $plugin_admin, 'acf_custom_json_save_point' );
		$this->loader->add_filter( 'acf/settings/load_json', $plugin_admin, 'acf_custom_json_load_point' );
		$this->loader->add_filter( 'acf/location/rule_types', $plugin_admin, 'acf_location_rules_types' );
		$this->loader->add_filter( 'acf/location/rule_values/slug', $plugin_admin, 'acf_location_rule_values_slug' );
		$this->loader->add_filter( 'acf/location/rule_match/slug', $plugin_admin, 'acf_location_rule_match_slug', 10, 4 );
        // $this->loader->add_action( 'admin_init', $plugin_admin, 'apfm_lighthouse_cpt_register_settings' );
		// $this->loader->add_action( 'admin_menu', $plugin_admin, 'apfm_lighthouse_cpt_settings_page' );
		
		// Hide unused WP default post types from CMS dashboard (IN-90)
		// Comment the following line to see Pages, Posts, Comments in wp-admin menu
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'remove_wp_menus' );

		// IN-846: Add noindex,nofollow meta tag to head in admin pages
		$this->loader->add_action( 'admin_head', $plugin_admin, 'add_noindex_head', 10, 1 );
		$this->loader->add_action( 'login_head', $plugin_admin, 'add_noindex_head', 10, 1 );
		// IN-846: Add noindex,nofollow to front-end. This is redundant if "Discourage Search
		// Engines" is selected in Options, or if X-Robots-Tag header is sent. This redundancy
		// is intentional. The most restrictive directive given should be the one respected by
		// crawlers. See: https://developers.google.com/search/reference/robots_meta_tag#precedence
		$this->loader->add_action( 'wp_head', $plugin_admin, 'add_noindex_head', 10, 1 );

    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {

        $plugin_public = new Apfm_Lighthouse_Cpt_Public( $this->get_lighthouse_cpt(), $this->get_version(), $this->get_view() );

        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles', 15 );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts', 15 );
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_lighthouse_cpt() {
        return $this->lighthouse_cpt;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Apfm_Lighthouse_Cpt_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

    /**
     * Retrieve the view renderer of the plugin.
     *
     * @since     1.0.0
     * @return    string    The view of the plugin.
     */
    public function get_view() {
        return $this->view;
    }
}
