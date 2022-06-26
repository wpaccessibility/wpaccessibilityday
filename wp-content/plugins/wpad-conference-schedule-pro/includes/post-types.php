<?php

function wpcsp_register_post_types() {

	// Speaker post type labels.
	$speakerlabels = array(
		'name'               => __( 'Speakers',                   'wpcsp' ),
		'singular_name'      => __( 'Speaker',                    'wpcsp' ),
		'add_new'            => __( 'Add New',                    'wpcsp' ),
		'add_new_item'       => __( 'Create New Speaker',         'wpcsp' ),
		'edit'               => __( 'Edit',                       'wpcsp' ),
		'edit_item'          => __( 'Edit Speaker',               'wpcsp' ),
		'new_item'           => __( 'New Speaker',                'wpcsp' ),
		'view'               => __( 'View Speaker',               'wpcsp' ),
		'view_item'          => __( 'View Speaker',               'wpcsp' ),
		'search_items'       => __( 'Search Speakers',            'wpcsp' ),
		'not_found'          => __( 'No speakers found',          'wpcsp' ),
		'not_found_in_trash' => __( 'No speakers found in Trash', 'wpcsp' ),
		'parent_item_colon'  => __( 'Parent Speaker:',            'wpcsp' ),
	);

	// Register speaker post type.
	register_post_type(
		'wpcsp_speaker',
		array(
			'labels'          => $speakerlabels,
			'rewrite'         => array( 'slug' => 'speakers' ),
			'supports'        => array( 'title', 'editor', 'revisions', 'thumbnail', 'page-attributes', 'excerpt' ),
			'menu_position'   => 20,
			'public'          => true,
			'publicly_queryable' => true,
			'show_ui'         => true,
			'can_export'      => true,
			'capability_type' => 'post',
			'hierarchical'    => false,
			'query_var'       => true,
			'menu_icon'       => 'dashicons-groups',
			'show_in_rest'    => true,
			'rest_base'       => 'speakers',
			'has_archive' 	  => false,
		)
	);

	// Sponsor post type labels.
	$spnsorlabels = array(
		'name'               => __( 'Sponsors',                   'wpcsp' ),
		'singular_name'      => __( 'Sponsor',                    'wpcsp' ),
		'add_new'            => __( 'Add New',                    'wpcsp' ),
		'add_new_item'       => __( 'Create New Sponsor',         'wpcsp' ),
		'edit'               => __( 'Edit',                       'wpcsp' ),
		'edit_item'          => __( 'Edit Sponsor',               'wpcsp' ),
		'new_item'           => __( 'New Sponsor',                'wpcsp' ),
		'view'               => __( 'View Sponsor',               'wpcsp' ),
		'view_item'          => __( 'View Sponsor',               'wpcsp' ),
		'search_items'       => __( 'Search Sponsors',            'wpcsp' ),
		'not_found'          => __( 'No sponsors found',          'wpcsp' ),
		'not_found_in_trash' => __( 'No sponsors found in Trash', 'wpcsp' ),
		'parent_item_colon'  => __( 'Parent Sponsor:',            'wpcsp' ),
	);

	// Register sponsor post type.
	register_post_type(
		'wpcsp_sponsor',
		array(
			'labels'          => $spnsorlabels,
			'rewrite'         => array( 'slug' => 'sponsors', 'with_front' => false, ),
			'supports'        => array( 'title', 'editor', 'revisions', 'thumbnail'),
			'menu_position'   => 21,
			'public'          => true,
			'show_ui'         => true,
			'can_export'      => true,
			'capability_type' => 'post',
			'hierarchical'    => false,
			'query_var'       => true,
			'menu_icon'       => 'dashicons-heart',
			'show_in_rest'    => true,
			'rest_base'       => 'sponsors',
		)
	);

}

add_action( 'init', 'wpcsp_register_post_types' );

//* Change CPT title text
add_action( 'gettext', 'wpcsp_change_title_text' );
function wpcsp_change_title_text( $translation ) {
	global $post;
	if( isset( $post ) ) {
		switch( $post->post_type ){
			case 'wpcsp_speaker' :
				if( $translation == 'Add title' ) return 'Enter Speaker Full Name Here';
			break;
            case 'wpcsp_sponsor' :
                if( $translation == 'Add title' ) return 'Enter Sponsoring Company Name Here';
            break;
		}
	}
	return $translation;
}

// Add page templates
add_filter( 'single_template', 'wpcsp_set_single_template' );
function wpcsp_set_single_template($single_template) {
	global $post;

	if ($post->post_type == 'wpcsp_speaker' ) {
		$single_template = WPCSP_DIR . '/templates/speaker-template.php';
	}
	if ($post->post_type == 'wpcsp_sponsor' ) {
		$single_template = WPCSP_DIR . '/templates/sponsor-template.php';
	}
	return $single_template;
}