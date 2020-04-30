<?php

/**
 * This class defines all code necessary generate the custom post types and taxonomies
 *
 * @link       apfm
 * @since      1.0.0
 * @package    Apfm_Lighthouse_Cpt
 * @subpackage Apfm_Lighthouse_Cpt/includes
 * @author     A Place for Mom, Inc.
 */
class Apfm_Lighthouse_Cpt_Data
{

	public function __construct()
	{
		// add data version option
		if (!get_option('apfm_custom_data_version')) {
			add_option('apfm_custom_data_version', 0);
		}
	}

	/**
	 * Create Custom Taxonomys
	 */
	public function apfm_custom_taxonomies()
	{
		/**
		 * Taxonomy: Feature Types.
		 */
		$labels = [
			"name" => __("Feature Types", "apfm-lighthouse-cpt"),
			"singular_name" => __("Feature Type", "apfm-lighthouse-cpt"),
		];

		$args = [
			"label" => __("Feature Types", "apfm-lighthouse-cpt"),
			"labels" => $labels,
			"public" => true,
			"publicly_queryable" => true,
			"hierarchical" => true,
			"show_ui" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"query_var" => true,
			"rewrite" => ['slug' => 'feature_type', 'with_front' => true,],
			"show_admin_column" => false,
			"show_in_rest" => true,
			"rest_base" => "feature_type",
			"rest_controller_class" => "WP_REST_Terms_Controller",
			"show_in_quick_edit" => false,
			"show_in_graphql" => true,
			"graphql_single_name" => "feature_type",
			"graphql_plural_name" => "feature_types",
		];
		register_taxonomy("feature_type", ["apfm_features"], $args);
	}

	/**
	 * Register Custom Content Type
	 */
	public function apfm_custom_post_types()
	{
		/**
		 * Post Type: Views.
		 */

		$labels = [
			"name" => __("Views", "apfm-lighthouse-cpt"),
			"singular_name" => __("View", "apfm-lighthouse-cpt"),
		];

		$args = [
			"label" => __("Views", "apfm-lighthouse-cpt"),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => ["slug" => "apfm_views", "with_front" => true],
			"query_var" => true,
			"menu_icon" => "dashicons-admin-page",
			"supports" => ["title", "revisions"],
			"show_in_graphql" => true,
			"graphql_single_name" => "view",
			"graphql_plural_name" => "views",
		];

		register_post_type("apfm_views", $args);

		/**
		 * Post Type: Articles.
		 */

		$labels = [
			"name" => __("Articles", "apfm-lighthouse-cpt"),
			"singular_name" => __("Article", "apfm-lighthouse-cpt"),
		];

		$args = [
			"label" => __("Articles", "apfm-lighthouse-cpt"),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => true,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => ["slug" => "apfm_article", "with_front" => true],
			"query_var" => true,
			"menu_icon" => "dashicons-format-aside",
			"taxonomies" => ["category", "post_tag"],
			"show_in_graphql" => true,
			"graphql_single_name" => "article",
			"graphql_plural_name" => "articles",
			"supports" => ["title", "editor", "thumbnail", "excerpt", "revisions"],
		];

		register_post_type("apfm_article", $args);

		/**
		 * Post Type: Features.
		 */

		$labels = [
			"name" => __("Features", "apfm-lighthouse-cpt"),
			"singular_name" => __("Feature", "apfm-lighthouse-cpt"),
		];

		$args = [
			"label" => __("Features", "apfm-lighthouse-cpt"),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => ["slug" => "apfm_features", "with_front" => true],
			"query_var" => true,
			"menu_icon" => "dashicons-align-left",
			"supports" => ["title", "revisions"],
			"taxonomies" => ["feature_type"],
			"show_in_graphql" => true,
			"graphql_single_name" => "feature",
			"graphql_plural_name" => "features",
		];

		register_post_type("apfm_features", $args);

		/**
		 * Post Type: Collections.
		 */

		$labels = [
			"name" => __("Collections", "apfm-lighthouse-cpt"),
			"singular_name" => __("Collection", "apfm-lighthouse-cpt"),
		];

		$args = [
			"label" => __("Collections", "apfm-lighthouse-cpt"),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => ["slug" => "apfm_collections", "with_front" => true],
			"query_var" => true,
			"menu_icon" => "dashicons-screenoptions",
			"supports" => ["title", "revisions"],
			"show_in_graphql" => true,
			"graphql_single_name" => "collection",
			"graphql_plural_name" => "collections",
		];

		register_post_type("apfm_collections", $args);

		/**
		 * Post Type: Lead Forms.
		 */

		$labels = [
			"name" => __("Lead Forms", "apfm-lighthouse-cpt"),
			"singular_name" => __("Lead Form", "apfm-lighthouse-cpt"),
		];

		$args = [
			"label" => __("Lead Forms", "apfm-lighthouse-cpt"),
			"labels" => $labels,
			"description" => "",
			"public" => true,
			"publicly_queryable" => true,
			"show_ui" => true,
			"show_in_rest" => true,
			"rest_base" => "",
			"rest_controller_class" => "WP_REST_Posts_Controller",
			"has_archive" => false,
			"show_in_menu" => true,
			"show_in_nav_menus" => true,
			"delete_with_user" => false,
			"exclude_from_search" => false,
			"capability_type" => "post",
			"map_meta_cap" => true,
			"hierarchical" => false,
			"rewrite" => ["slug" => "lead_form", "with_front" => true],
			"query_var" => true,
			"menu_icon" => "dashicons-feedback",
			"supports" => ["title", "custom-fields", "revisions"],
			"show_in_graphql" => true,
			"graphql_single_name" => "lead_form",
			"graphql_plural_name" => "lead_forms",
		];

		register_post_type("lead_form", $args);
	}

	// change the field location rule for post based in post slug
	public function apfm_fix_json_post_ids($json_dirs)
	{
		if ($this->filesystem_init()) {
			global $wp_filesystem;

			foreach ($json_dirs as $key => $json_dir) {
				// get all files in folder
				$file_paths = list_files($json_dir, 1, array('index.php'));

				foreach ($file_paths as $key => $file_path) {
					// echo "Fixing json post ids in $file_path... ";

					// get data file
					$json_data = $wp_filesystem->get_contents($file_path);

					$field_group = json_decode($json_data, true);

					// get field location rules
					$locations = $field_group['location'];
					$post_slugs = array();
					$post_ids = array();
					$post_rule_keys = array();
					$post_type = '';

					// error_log(var_export($locations, 1));
					if($locations) {
						foreach ($locations as $key => $location) {
							foreach ($location as $key2 => $rule) {
								// get post type
								if ($rule['param'] == 'post_type') {
									$post_type = $rule['value'];
								} elseif ($rule['param'] == 'slug') {
									$post_slugs[] = $rule['value'];
								} elseif ($rule['param'] == 'post') {
									$post_ids[] = $rule['value'];
									$post_rule_keys[] = array($key, $key2);
								}
							}
						}
					}

					// check if this field group has rules for specific post and slug
					if(count($post_slugs)) {
						if (count($post_slugs) == count($post_rule_keys)) {

							foreach ($post_slugs as $key => $slug) {
								// check if it exists and get id
								$post_id = $this->get_post_id_by_slug($slug);

								$id = false;
								if (!is_null($post_id)) {
									$id = $post_id;
								}

								// only act if post exists
								if ($id) {
									// if post id is equal in this database no action is needed
									if ($id != $post_ids[$key]) {
										// error_log('post id '.$id.' different '.$post_ids[$key].' for slug '.$slug.' will update');

										// update field group post rule value
										$path = $post_rule_keys[$key];
										$field_group['location'][$path[0]][$path[1]]['value'] = $id;

										// update last modified time
										$field_group['modified'] = time();
									}
								} else {
									error_log('Cannot tie field group "' . $field_group['title'] . '" to post ' . $post_ids[$key] . ' because slug ' . $slug . ' of type ' . $post_type . ' does not exist in this site.');
								}
							}
						} else {
							error_log('Amount of slugs and post ids rules dont match for "' . $field_group['title'] . '.');
						}
					}

					// convert to json format
					$updated_json_data = json_encode($field_group, JSON_PRETTY_PRINT);

					// write contents to file again
					if($updated_json_data != "null" && !is_null($updated_json_data)) {
						if (!$wp_filesystem->put_contents($file_path, $updated_json_data, FS_CHMOD_FILE)) {
							error_log('Error writing file '.$file_path.'.');
						}
					} else {
						error_log("reading file:");
						error_log(var_export($file_path,1));

						error_log("intial json data:");
						error_log(var_export($json_data,1));

						error_log("encoding field:");
						error_log(var_export($field_group,1));

						error_log("json encoded:");
						error_log(var_export($updated_json_data,1));
					}

					// echo "Done.\n";
				}
			}
		}
	}

	/**
	 * Function that will automatically remove ACF field groups when JSON file is deleted
	 */
	public function apfm_acf_auto_suppr($json_dirs)
	{

		$groups = acf_get_field_groups();
		if (empty($groups)) {
			return;
		}
		// sync groups that have been deleted
		if (!is_array($json_dirs) || !$json_dirs) {
			throw new \Exception('JSON dirs missing');
		}
		$delete = array();
		foreach ($groups as $group) {
			$found = false;

			foreach ($json_dirs as $json_dir) {
				$json_file = rtrim($json_dir, '/') . '/' . $group['key'] . '.json';

				if (is_file($json_file)) {
					$found = true;

					break;
				}
			}

			if (!$found) {
				$delete[] = $group['key'];
			}
		}
		if (!empty($delete)) {
			foreach ($delete as $group_key) {
				acf_delete_field_group($group_key);
			}
		}
	}

	/**
	 * Function that will automatically update ACF field groups via JSON file update.
	 */
	public function apfm_acf_auto_synch($json_dirs)
	{

		$groups = acf_get_field_groups();
		if (empty($groups)) {
			return;
		}

		// find JSON field groups which have not yet been imported
		$sync 	= array();
		foreach ($groups as $group) {
			$local 		= acf_maybe_get($group, 'local', false);
			$modified 	= acf_maybe_get($group, 'modified', 0);
			$private 	= acf_maybe_get($group, 'private', false);

			// ignore DB / PHP / private field groups
			if ($local !== 'json' || $private) {
				// do nothing
			} elseif (!$group['ID']) {
				$sync[$group['key']] = $group;
			} elseif ($modified && $modified > get_post_modified_time('U', true, $group['ID'], true)) {
				$sync[$group['key']]  = $group;
			}
		}

		if (empty($sync)) {
			return;
		}
		foreach ($sync as $key => $group) { //foreach ($keys as $key) {
			// append fields
			if (acf_have_local_fields($key)) {
				$group['fields'] = acf_get_fields($key);
			}

			// import
			$field_group = acf_import_field_group($group);
		}
	}

	/**
	 * run the auto synch
	 */
	public function apfm_fields_autosync_and_fix_ids()
	{
		$json_dirs = acf_get_setting('load_json');
		$this->apfm_acf_auto_suppr($json_dirs);
		$this->apfm_fix_json_post_ids($json_dirs);
		$this->apfm_acf_auto_synch($json_dirs);
	}

	public function get_post_id_by_slug($slug)
	{
		global $wpdb;
		$post_id = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE post_name = %s AND post_status = 'publish' LIMIT 1", $slug));

		return $post_id;
	}

	// create or update json file on post save from the type list
	public function apfm_post_data_save($post_id, $post, $update)
	{
		$blogname = get_option('blogname');

		// allowed post types to sync
		$allowed_post_types = array('apfm_features', 'apfm_views', 'lead_form');

		// get path elements
		$post_type = $post->post_type;
		$post_slug = $post->post_name;

		// only save to file for allowd types
		if (in_array($post_type, $allowed_post_types) && $post_slug) {
			if ($this->filesystem_init()) {
				global $wp_filesystem;

				// path for final destination dir
				$dir_save_path = plugin_dir_path( dirname( __FILE__ ) ).'json-data/';

				// add blog name to path so it works in multisite too
				$dir_save_path .= $blogname.'/';
				
				// add post type subfolder
				$dir_save_path .= $post_type.'/';
				
				// path for final destination file
				$file_save_path = $dir_save_path.$post_slug.'.json';

				// if post is trashed then remove the json file
				if ($post->post_status == 'trash') {
					// get correct file name to delete
					$file_save_path = str_replace('__trashed', '', $file_save_path);
					$wp_filesystem->delete($file_save_path);
				} else {
					// get post data
					$post_data = array(
						"post_type" => $post->post_type,
						"title" => $post->post_title,
						"slug" => $post->post_name,
						"last_modified" => $post->post_modified,
						"status" => $post->post_status,
						"taxonomies" => array()
					);

					// get taxonomies
					$taxonomies = get_taxonomies('', 'names');
					$terms = wp_get_post_terms($post->ID, $taxonomies);

					// group terms by tax
					$tax_array = array();
					foreach ($terms as $key => $term) {
						$tax_array[$term->taxonomy][] = array(
							'name' => $term->name,
							'slug' => $term->slug,
							'parent' => $term->parent
						);
					}

					// format for json
					foreach ($tax_array as $tax => $terms) {
						$post_data['taxonomies'][] = array('slug' => $tax, 'terms' => $terms);
					}

					// convert to json format
					$json_data = json_encode($post_data, JSON_PRETTY_PRINT);

					// if directory didn't exist, let's create it
					if(!$wp_filesystem->is_dir($dir_save_path)) {
						// use php mkdir to recursively create folders
						if (!mkdir($dir_save_path, 0775, true)) {
							error_log('Failed to create folder '.$dir_save_path);
						}
						// $wp_filesystem->mkdir($dir_save_path);
					}

					// write contents to file
					if (!$wp_filesystem->put_contents($file_save_path, $json_data, FS_CHMOD_FILE)) {
						error_log('Error writing file.');
					}
				}
			}
		}
	}

	// check if post update changes slug and deletes old json file
	public function apfm_slug_change_checker($post_ID, $post_after, $post_before)
	{
		$blogname = get_option('blogname');
		try {
			if ($post_after->post_name != $post_before->post_name) {
				// error_log('slug changed from: '.$post_before->post_name.' to '.$post_after->post_name);
				if ($this->filesystem_init()) {
					global $wp_filesystem;

					// get path elements for old json file
					$post_type = $post_before->post_type;
					$post_slug = $post_before->post_name;
		
					// path for final destination dir
					$dir_save_path = plugin_dir_path( dirname( __FILE__ ) ).'json-data/';

					// add blog name to path so it works in multisite too
					$dir_save_path .= $blogname.'/';
					
					// add post type subfolder
					$dir_save_path .= $post_type.'/';
					
					// path for final destination file
					$file_save_path = $dir_save_path.$post_slug.'.json';

					// error_log('deleting file: '.$file_save_path);
					$wp_filesystem->delete($file_save_path);
				}
			} else {
				// error_log('slug not changed: '.$post_after->post_name.' = '.$post_before->post_name);
			}
		} catch (\Throwable $th) {
			error_log(print_r($th, 1));
		}
	}

	public function apfm_custom_data_load()
	{
		$blogname = get_option('blogname');
		// echo "Custom data load running in $blogname... ";

		if ($this->filesystem_init()) {
			global $wp_filesystem;

			$dir_save_path = plugin_dir_path( dirname( __FILE__ ) ).'json-data/';
			
			// add blog name to path so it works in multisite too
			$dir_save_path .= $blogname.'/';
			
			// path for final destination of files
			$folder_paths = list_files( $dir_save_path, 1, array('acf-json'));
			// error_log(print_r($folder_paths,1));
			
			foreach ($folder_paths as $key => $folder_path) {
				// get all files in folder
				$file_paths = list_files($folder_path, 1);

				foreach ($file_paths as $key => $file_path) {
					// get data file
					$json_data = $wp_filesystem->get_contents($file_path);
					$post_data = json_decode($json_data, true);

					// get post if exists
					$post = get_page_by_path($post_data['slug'], 'OBJECT', $post_data['post_type']);
					$current_version = 0;

					$post_data_attrs = array();
					if (!is_null($post)) {
						// get post id
						$post_data_attrs['ID'] = $post->ID;

						// get database version
						$current_version = strtotime($post->post_modified);
					} // else {
					// 	error_log('No post found for slug: '.$post_data['slug'].' with post type '.$post_data['post_type'].'will create new post.');
					// }

					// get file version and compare it with database latest version
					$file_version = strtotime($post_data['last_modified']);

					// error_log("post modified:".$current_version);
					// error_log("file modified:".$file_version);exit();

					// if version is behind begin update
					if ($file_version > $current_version) {
						// load taxonomy terms
						$post_taxonomies = $post_data['taxonomies'];

						foreach ($post_taxonomies as $key => $taxonomy) {
							foreach ($taxonomy['terms'] as $key => $term) {
								if (!term_exists($term['name'], $taxonomy['slug'], $term['parent'])) {
									$term_id = wp_insert_term($term['name'], $taxonomy['slug'], array('parent' => $term['parent'], 'slug' => $term['slug']));
								}
							}
						}

						// complete attributes to save
						$post_data_attrs['post_title'] = $post_data['title'];
						$post_data_attrs['post_type'] = $post_data['post_type'];
						$post_data_attrs['post_status'] = $post_data['status'];
						
						// add post terms
						$post_data_attrs['tax_input'] = array();

						foreach ($post_taxonomies as $key => $tax) {
							$term_ids = array();

							foreach ($tax['terms'] as $key => $term) {
								$term_ids[] = get_term_by('name', $term['name'], $tax['slug'])->term_id;
							}
							$post_data_attrs['tax_input'][$tax['slug']] = $term_ids;
						}

						// insert or update post only if fields modified or whole new post
						$should_update = true;
						if(isset($post_data_attrs['ID'])) {
							if(!$this->found_new_data($post_data_attrs, $post)) {
								$should_update = false;
							}
						}

						// upsert post
						if($should_update) {
							$post_id = wp_insert_post($post_data_attrs);
						}
					}
				}
			}
		}
		// echo "Done.\n";
	}

	// check if updating file has actually new fields
	private function found_new_data($post_file, $post_db) {
		$should_update = false;

		// check regular fields
		if($post_file['post_title'] !== $post_db->post_title) {
			$should_update = true;
		}
		if($post_file['post_type'] !== $post_db->post_type) {
			$should_update = true;
		}
		if($post_file['post_status'] !== $post_db->post_status) {
			$should_update = true;
		}

		// check taxonomies
		$db_term_ids = array();
		$taxonomies = get_taxonomies('', 'names');
		if ( $terms = wp_get_post_terms($post_db->ID, $taxonomies) ) {
			$db_term_ids = wp_list_pluck( $terms, 'term_id' );
		}

		$file_term_ids = array();
		foreach ($post_file['tax_input'] as $tax => $terms) {
			$file_term_ids = array_merge($file_term_ids, $terms);
		}
		
		// only if it has taxonomies in any end, db or file
		if(count($db_term_ids) && count($db_term_ids)) {
			// remove duplicates
			$db_term_ids = array_unique($db_term_ids);
			$file_term_ids = array_unique($file_term_ids);

			// if count of taxonomies is different then update
			if(count($db_term_ids) != count($db_term_ids)) {
				$should_update = true;
			} else {
				// sort
				sort($db_term_ids);
				sort($file_term_ids);

				// error_log('term ids arrays');
				// error_log(print_r($db_term_ids,1));
				// error_log(print_r($file_term_ids,1));

				// convert to string
				$db_term_ids_s = implode(',', $db_term_ids);
				$file_term_ids_s = implode(',', $file_term_ids);

				// error_log('term ids strings');
				// error_log(print_r($db_term_ids_s,1));
				// error_log(print_r($file_term_ids_s,1));

				// if changed ids then update
				if($db_term_ids_s != $file_term_ids_s) {
					$should_update = true;
				}
			}
		}

		return $should_update;
	}

	private function filesystem_init()
	{
		$access_type = get_filesystem_method();

		if ($access_type == 'direct') {
			/* you can safely run request_filesystem_credentials() without any issues and don't need to worry about passing in a URL */
			$creds = request_filesystem_credentials(site_url() . '/wp-admin/', '', false, false, array());

			/* initialize the API */
			if (!WP_Filesystem($creds)) {
				/* any problems and we exit */
				error_log('File system credentials not working.');
				return false;
			}

			return true;
		} else {
			/* don't have direct write access. Prompt user with our notice */
			// add_action('admin_notices', 'you_admin_notice_function');
			error_log('File system is not accessible directly, cannot create files locally.');
			return false;
		}
	}


	public function lighthouse_cpt_columns_head($columns)
	{
		// take column date to move it to the end
		$d = $columns['date'];
		unset($columns['date']);

		// create new column
		$columns['feature_type'] = __('Feature Type', 'apfm-lighthouse-cpt');

		// re add date column
		$columns['date'] = $d;

		return $columns;
	}

	public function lighthouse_cpt_columns_content($column, $post_id)
	{
		$post = get_post($post_id);

		switch ($column) {
			case 'feature_type':
				$terms = get_the_terms($post_id, 'feature_type');

				if ($terms) {
					foreach ($terms as $feature_type) {
						echo $feature_type->name . "\n";
					}
				}
				break;
		}
	}

	public function lighthouse_cpt_filter_by_feature_type($post_type, $which)
	{
		$taxonomy_slug = 'feature_type';
		$taxonomy_name = 'Feature Type';

		// Apply this only on a specific post type
		if ($taxonomy_slug !== 'feature_type')
			return;

		// Retrieve taxonomy terms
		$terms = get_terms($taxonomy_slug);

		// Display filter HTML
		echo "<select name='{$taxonomy_slug}' id='{$taxonomy_slug}' class='postform'>";
		echo '<option value="">' . sprintf(esc_html__('Show All %s', 'text_domain'), $taxonomy_name) . '</option>';
		foreach ($terms as $term) {
			printf(
				'<option value="%1$s" %2$s>%3$s (%4$s)</option>',
				$term->slug,
				((isset($_GET[$taxonomy_slug]) && ($_GET[$taxonomy_slug] == $term->slug)) ? ' selected="selected"' : ''),
				$term->name,
				$term->count
			);
		}
		echo '</select>';
	}

	public function lighthouse_cpt_columns_sortable($columns)
	{
		$columns['feature_type'] = 'feature_type';

		//To make a column 'un-sortable' remove it from the array
		//unset($columns['date']);

		return $columns;
	}

	public function lighthouse_cpt_sort_by_feature_type($clauses, $wp_query)
	{
		global $wpdb;

		if (isset($wp_query->query['orderby']) && 'feature_type' == $wp_query->query['orderby']) {

			$clauses['join'] .= <<<SQL
			LEFT OUTER JOIN {$wpdb->term_relationships} ON {$wpdb->posts}.ID={$wpdb->term_relationships}.object_id
			LEFT OUTER JOIN {$wpdb->term_taxonomy} USING (term_taxonomy_id)
			LEFT OUTER JOIN {$wpdb->terms} USING (term_id)
SQL;
			$clauses['where'] .= " AND (taxonomy = 'feature_type' OR taxonomy IS NULL)";
			$clauses['groupby'] = "object_id";
			$clauses['orderby']  = "GROUP_CONCAT({$wpdb->terms}.name ORDER BY name ASC) ";
			$clauses['orderby'] .= ('ASC' == strtoupper($wp_query->get('order'))) ? 'ASC' : 'DESC';
		}

		return $clauses;
	}
}
