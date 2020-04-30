<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @link       apfm
 * @package    Apfm_Lighthouse_Cpt
 * @subpackage Apfm_Lighthouse_Cpt/admin
 * @author     A Place for Mom, Inc.
 */
class Apfm_Lighthouse_Cpt_Admin {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $lighthouse_cpt    The ID of this plugin.
     */
    private $lighthouse_cpt;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * The view of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      Apfm_Lighthouse_Cpt_View    $version    Apfm_Lighthouse_Cpt_View instance created to render all views.
     */
    private $view; // Our view manager

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $lighthouse_cpt       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $lighthouse_cpt, $version, $view ) {

        $this->lighthouse_cpt = $lighthouse_cpt;
        $this->version = $version;
        $this->view = $view;

    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        wp_enqueue_style( $this->lighthouse_cpt, plugin_dir_url( __FILE__ ) . 'css/apfm-lighthouse-cpt-admin.min.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        wp_enqueue_script( $this->lighthouse_cpt, plugin_dir_url( __FILE__ ) . 'js/apfm-lighthouse-cpt-admin.min.js', array( 'jquery' ), $this->version, false );

	}
	
	public function acf_custom_json_save_point( $path ) {
		$blogname = get_option('blogname');

		// update path
		$path = plugin_dir_path( dirname( __FILE__ ) ).'json-data/';
		
		// add blog name to path so it works in multisite too
		$path .= $blogname.'/';

		// add final folder
		$path .= 'acf-json/';
		
		// return
		return $path;
	}

	function acf_custom_json_load_point( $paths ) {
		$blogname = get_option('blogname');

		// remove original path (optional)
		unset($paths[0]);

		// update path
		$path = plugin_dir_path( dirname( __FILE__ ) ).'json-data/';
		
		// add blog name to path so it works in multisite too
		$path .= $blogname.'/';

		// add final folder
		$path .= 'acf-json/';
		
		// append path
		$paths[] = $path;
		
		// return
		return $paths;
		
	}

	public function acf_location_rules_types( $choices ) {
		
		$choices['Post']['slug'] = 'Post Slug';

		return $choices;
		
	}

	public function acf_location_rule_values_slug( $choices ) {
		// get post types
		$post_types = acf_get_post_types(array(
			'show_ui'	=> 1,
			'exclude'	=> array('page', 'attachment')
		));
		
		
		// get posts grouped by post type
		$groups = acf_get_grouped_posts(array(
			'post_type' => $post_types
		));
		
		if( !empty($groups) ) {
	
			foreach( array_keys($groups) as $group_title ) {
				
				// vars
				$posts = acf_extract_var( $groups, $group_title );
				$pairs = array();

				// override post data
				foreach( $posts as $post_id => $post ) {
					// print_r($post);
					// update
					$pairs[ $post->post_name ] = acf_get_post_title( $posts[ $post_id ] );
				};
				
				// append to $choices
				$choices[ $group_title ] = $pairs;
			}
			
		}
		// print_r($choices);
		// return
		return $choices;
	}

	public function acf_location_rule_match_slug( $match, $rule, $options, $field_group )
	{
		// error_log("matching slug");
		// error_log("match");
		// error_log(var_export($match,1));
		// error_log("rule");
		// error_log(var_export($rule,1));
		// error_log("options");
		// error_log(var_export($options,1));
		// error_log("fieldgroup");
		// error_log(var_export($field_group,1));

		if(isset($options['post_id']) && $options['post_id']) {
			// get slug
			$post = get_post($options['post_id']); 
			$slug = $post->post_name;

			if($rule['operator'] == "==")
			{
				$match = ( $rule['value'] == $slug );
			}
			elseif($rule['operator'] == "!=")
			{
				$match = ( $rule['value'] != $slug );
			}
		}

		return $match;
	}

    /**
     * Function to register the admin settings in the database to control API Sync cron frequency
     *
     * @since    1.0.0
     */
    public function apfm_lighthouse_cpt_register_settings() {
        // $env = strtolower( getenv("WORDPRESS_ENV", true ) ) | "dev";

        // // SITE INFO
        // add_option( 'apfm_lighthouse_cptsite_type', 'apfm-site' );
        // add_option( 'apfm_lighthouse_cptgmaps_api_key', '');
        // add_option( 'apfm_lighthouse_cpttcpa_text', 'By clicking {submit-button-text}, you agree to our <a href="https://www.aplaceformom.com/terms-of-use" target="_blank">Terms of Use</a> and our <a href="https://www.aplaceformom.com/privacy" target="_blank">Privacy Policy</a>. You also consent that we, or our partner providers, may reach out to you using a system that can auto-dial; however, you do not need to consent to this to use our service.');
        
        // // WS3 INFO
        // add_option( 'apfm_lighthouse_cpt_subsource_id', 0 );
        
        // // SETTINGS REGISTER
        // // SITE
        // register_setting( 'apfm-lighthouse-cpt-group', 'apfm_lighthouse_cptsite_type' );
        // register_setting( 'apfm-lighthouse-cpt-group', 'apfm_lighthouse_cptgmaps_api_key' );
        // register_setting( 'apfm-lighthouse-cpt-group', 'apfm_lighthouse_cpttcpa_text' );
        // // WS3
        // register_setting( 'apfm-lighthouse-cpt-group', 'apfm_lighthouse_cptsubsource_id' );
    }

    /**
     * Function to create the admin settings form to control API Sync cron frequency
     *
     * @since    1.0.0
     */
    public function apfm_lighthouse_cpt_settings_page() {
        // add_options_page(
		// 	'APFM Lighthouse CPT Settings',
		// 	'APFM Lighthouse CPT Settings',
		// 	'manage_options',
		// 	'apfm-lighthouse-cpt-settings',
		// 	array($this,'render_apfm_lighthouse_cptoptions_page')
        // );
    }

    public function apfm_lighthouse_cpt_site_type( $classes )
    {
        // $type = get_option('apfm_lighthouse_cptsite_type')?get_option('apfm_lighthouse_cptsite_type'):'apfm-site';
        // $classes[] = '" data-pa-sitetype="'.$type;

        // return $classes;
    }

    public function render_apfm_lighthouse_cpt_options_page() {

        // // prepare variables
        // $vars = [];
        // // render view
        // $view_file = 'views/apfm-lighthouse-cpt-settings-view.php';


        // // render view
        // $output = '';
        // $view_path = apply_filters('apfm_view_path', plugin_dir_path( __FILE__ ) . $view_file);
        // $this->view->set_view_file( $view_path );
        // $this->view->set_vars( $vars );
        // $output = $this->view->get_render();

        // echo $output;
    }

	public function remove_wp_menus() {
		// global $menu;
		// error_log(print_r($menu, true));
		global $submenu;
		// error_log(print_r($submenu, true));
		
		remove_menu_page( 'index.php' );                  //Dashboard
		remove_menu_page( 'jetpack' );                    //Jetpack* 
		remove_menu_page( 'edit.php' );                   //Posts
		// remove_menu_page( 'upload.php' );                 //Media
		remove_menu_page( 'edit.php?post_type=page' );    //Pages
		remove_menu_page( 'edit-comments.php' );          //Comments
		
		// remove_menu_page( 'themes.php' );                 //Appearance
		remove_submenu_page( 'themes.php', 'themes.php' );
		remove_submenu_page( 'themes.php', 'widgets.php' );

		// remove_submenu_page for customize.php dynamic url
		if ( isset( $submenu[ 'themes.php' ] ) ) {
			foreach ( $submenu[ 'themes.php' ] as $index => $menu_item ) {
				if ( strpos($menu_item[2], 'customize.php') !== false ) {
					unset( $submenu[ 'themes.php' ][ $index ] );
				}
			}
		}

		// remove_menu_page( 'plugins.php' );                //Plugins
		// remove_menu_page( 'users.php' );                  //Users
		// remove_menu_page( 'tools.php' );                  //Tools
		// remove_menu_page( 'options-general.php' );        //Settings
	}

	public function add_noindex_head() {
		echo "<meta name='robots' content='noindex,nofollow' />\n";
	}
}
