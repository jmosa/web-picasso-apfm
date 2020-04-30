<?php
require_once('core/wp-load.php');
require_once('core/wp-admin/includes/file.php');

// if multisite do sync in every site, if not just for main site
if(is_multisite()) {
	// get all blogs
	$sites = get_sites();

	// iterate over sites to get blog id and execute sync
    foreach ( $sites as $key => $site ) {
		switch_to_blog( $site->blog_id );
		
		// execute apfm-lighthouse-cpt plugin sync action
		do_action( 'apfm_sync' );

		restore_current_blog();
	}
} else {
	// execute apfm-lighthouse-cpt plugin sync action
	do_action( 'apfm_sync' );
}
