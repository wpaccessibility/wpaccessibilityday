<?php

/**
 *
 * @link              https://wpconferenceschedule.com
 * @since             1.0.0
 * @package           wp_conference_schedule_pro
 *
 * @wordpress-plugin
 * Plugin Name:       WP Conference Schedule Pro
 * Plugin URI:        https://wpconferenceschedule.com
 * Description:       Creates sessions post types for conference websites. Includes shortcode and custom block for fully mobile-responsive conference schedule in table format.
 * Version:           1.0.0
 * Author:            Road Warrior Creative
 * Author URI:        https://roadwarriorcreative.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpcsp
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define('WPCSP_PLUGIN_FILE', __FILE__ );

/**
 * Currently plugin versions.
 */
define( 'WPCSP_VERSION', '1.0.0' );

/**
 * Plugin directory
 */
define( 'WPCSP_DIR' , plugin_dir_path( __FILE__ ) );

/**
 * Plugin Activation & Deactivation
 */
register_activation_hook( __FILE__, 'wpcsp_pro_activation');
register_deactivation_hook( __FILE__, 'wpcsp_pro_deactivation');
register_uninstall_hook( __FILE__, 'wpcsp_pro_uninstall');

/**
 * Define file path and basename
 */
$ac_pro_plugin_directory = __FILE__;
$ac_pro_plugin_basename = plugin_basename( __FILE__ );

/**
 * Import Resources
 */
require_once(WPCSP_DIR . '/includes/activation.php');
require_once(WPCSP_DIR . '/includes/deactivation.php');
require_once(WPCSP_DIR . '/includes/uninstall.php');
require_once(WPCSP_DIR . '/includes/helper-functions.php');
require_once(WPCSP_DIR . '/includes/enqueue-scripts.php');
//require_once(WPCSP_DIR . '/includes/license.php');
require_once(WPCSP_DIR . '/includes/post-types.php');
require_once(WPCSP_DIR . '/includes/taxonomies.php');
require_once(WPCSP_DIR . '/includes/cmb2/init.php');
require_once(WPCSP_DIR . '/includes/cmb-field-select2/cmb-field-select2.php');
require_once(WPCSP_DIR . '/includes/cmb2-conditional-logic/cmb2-conditional-logic.php');
require_once(WPCSP_DIR . '/includes/settings.php' );

//require_once( __DIR__ . '/vendor/autoload.php');
//WP_Dependency_Installer::instance( __DIR__ )->run();

/**
 * Filters and Actions
 */
add_action( 'admin_enqueue_scripts', 'wpcsp_pro_admin_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'wpcsp_pro_admin_enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'wpcsp_pro_enqueue_styles' );
//add_filter( 'pand_theme_loader', '__return_true' );
add_action( 'cmb2_admin_init', 'wpcsp_speaker_metabox' );
add_action( 'cmb2_admin_init', 'wpcsp_sponsor_metabox' );
add_action( 'cmb2_admin_init', 'wpcsp_sponsor_level_metabox' );

function wpcsp_speaker_metabox() {

	$cmb = new_cmb2_box( array(
		'id'            => 'wpcsp_speaker_metabox',
		'title'         => __( 'Speaker Information', 'wpcsp' ),
		'object_types'  => array( 'wpcsp_speaker', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	// first name
	$cmb->add_field( array(
		'name'       => __( 'First Name', 'wpcsp' ),
		//'desc'       => __( 'field description (optional)', 'wpcsp' ),
		'id'         => 'wpcsp_first_name',
		'type'       => 'text',
	) );
	
	// last name
	$cmb->add_field( array(
		'name'       => __( 'Last Name', 'wpcsp' ),
		//'desc'       => __( '', 'wpcsp' ),
		'id'         => 'wpcsp_last_name',
		'type'       => 'text',
	) );

	// title
	$cmb->add_field( array(
		'name'       => __( 'Title', 'wpcsp' ),
		//'desc'       => __( '', 'wpcsp' ),
		'id'         => 'wpcsp_title',
		'type'       => 'text',
	) );

	// organization
	$cmb->add_field( array(
		'name'       => __( 'Organization', 'wpcsp' ),
		//'desc'       => __( '', 'wpcsp' ),
		'id'         => 'wpcsp_organization',
		'type'       => 'text',
	) );

	// Facebook URL
	$cmb->add_field( array(
		'name'       => __( 'Facebook URL', 'wpcsp' ),
		//'desc'       => __( '', 'wpcsp' ),
		'id'         => 'wpcsp_facebook_url',
		'type'       => 'text_url',
		'protocols' => array( 'http', 'https' ), // Array of allowed protocols
	) );

	// Twitter URL
	$cmb->add_field( array(
		'name'       => __( 'Twitter URL', 'wpcsp' ),
		//'desc'       => __( '', 'wpcsp' ),
		'id'         => 'wpcsp_twitter_url',
		'type'       => 'text_url',
		'protocols' => array( 'http', 'https' ), // Array of allowed protocols
	) );

	// Instagram URL
	$cmb->add_field( array(
		'name'       => __( 'Instagram URL', 'wpcsp' ),
		//'desc'       => __( '', 'wpcsp' ),
		'id'         => 'wpcsp_instagram_url',
		'type'       => 'text_url',
		'protocols' => array( 'http', 'https' ), // Array of allowed protocols
	) );

	// Linkedin URL
	$cmb->add_field( array(
		'name'       => __( 'Linkedin URL', 'wpcsp' ),
		//'desc'       => __( '', 'wpcsp' ),
		'id'         => 'wpcsp_linkedin_url',
		'type'       => 'text_url',
		'protocols' => array( 'http', 'https' ), // Array of allowed protocols
	) );

	// YouTube URL
	$cmb->add_field( array(
		'name'       => __( 'YouTube URL', 'wpcsp' ),
		//'desc'       => __( '', 'wpcsp' ),
		'id'         => 'wpcsp_youtube_url',
		'type'       => 'text_url',
		'protocols' => array( 'http', 'https' ), // Array of allowed protocols
	) );

	// Website URL
	$cmb->add_field( array(
		'name'       => __( 'Website URL', 'wpcsp' ),
		//'desc'       => __( '', 'wpcsp' ),
		'id'         => 'wpcsp_website_url',
		'type'       => 'text_url',
		'protocols' => array( 'http', 'https' ), // Array of allowed protocols
	) );
}

function wpcsp_sponsor_metabox() {

	$cmb = new_cmb2_box( array(
		'id'            => 'wpcsp_sponsor_metabox',
		'title'         => __( 'Sponsor Information', 'wpcsp' ),
		'object_types'  => array( 'wpcsp_sponsor', ), // Post type
		'context'       => 'normal',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

	// Website URL
	$cmb->add_field( array(
		'name'       => __( 'Website URL', 'wpcsp' ),
		//'desc'       => __( '', 'wpcsp' ),
		'id'         => 'wpcsp_website_url',
		'type'       => 'text_url',
		'protocols' => array( 'http', 'https' ), // Array of allowed protocols
	) );
}

function wpcsp_sponsor_level_metabox() {

	$cmb = new_cmb2_box( array(
		'id'               => 'wpcsp_sponsor_level_metabox',
		'title'            => esc_html__( 'Category Metabox', 'cmb2' ), // Doesn't output for term boxes
		'object_types'     => array( 'term' ), // Tells CMB2 to use term_meta vs post_meta
		'taxonomies'       => array( 'wpcsp_sponsor_level' ), // Tells CMB2 which taxonomies should have these fields
		// 'new_term_section' => true, // Will display in the "Add New Category" section
	) );

	// Logo Height
	$cmb->add_field( array(
		'name' => __( 'Logo Height', 'wpcsp' ),
		'desc' => __( 'Pixels', 'wpcsp' ),
		'id'   => 'wpcsp_logo_height',
		'type' => 'text_small',
		'attributes' => array(
			'type' => 'number',
			'pattern' => '\d*',
		),
	) );

}
class WP_Conference_Schedule_Pro{

	function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_filter( 'wpcs_filter_session_speaker_meta_field', [$this, 'filter_session_speaker_meta_field'], 11, 1 );
		add_shortcode( 'wpcs_sponsors', array( $this, 'shortcode_sponsors' ) );
		add_shortcode( 'wpcs_speakers', array( $this, 'shortcode_speakers' ) );
		add_filter( 'wpcs_filter_session_speakers', [$this, 'filter_session_speakers'], 11, 2 );
		add_filter( 'wpcs_session_content_header', [$this, 'session_content_header'], 11, 1 );
		add_action( 'wpsc_single_taxonomies', array( $this, 'single_session_tags' ) );
		add_filter( 'wpcs_filter_single_session_speakers', [$this, 'filter_single_session_speakers'], 11, 2 );
		add_filter( 'wpcs_session_content_footer', [$this, 'session_sponsors'], 11, 1);
	}

	/**
	 * Runs during admin_init.
	 */
	function admin_init() {
		register_setting( 'conference_sponsor_options', 'conference_sponsor_level_order', array( $this, 'validate_sponsor_options' ) );
		register_setting( 'speaker_options', 'speaker_level_order', array( $this, 'validate_sponsor_options' ) );
	}

	/**
	 * Runs during admin_menu
	 */
	function admin_menu() {
		$page = add_submenu_page( 'edit.php?post_type=wpcsp_sponsor', __( 'Order Sponsor Levels', 'wpcsp' ), __( 'Order Sponsor Levels', 'wpcsp' ), 'edit_posts', 'sponsor_levels', array( $this, 'render_order_sponsor_levels' ) );

		add_action( "admin_print_scripts-$page", array( $this, 'enqueue_order_sponsor_levels_scripts' ) );

		$page = add_submenu_page( 'edit.php?post_type=wpcsp_speaker', __( 'Order Speaker Groups', 'wpcsp' ), __( 'Order Speaker Groups', 'wpcsp' ), 'edit_posts', 'speaker_levels', array( $this, 'render_order_speaker_levels' ) );

		add_action( "admin_print_scripts-$page", array( $this, 'enqueue_order_sponsor_levels_scripts' ) );
	}

	/**
	 * Enqueues scripts and styles for the render_order_sponsors_level admin page.
	 */
	function enqueue_order_sponsor_levels_scripts() {
		wp_enqueue_script( 'wpcsp-sponsor-order', plugins_url( 'assets/js/order-sponsor-levels.js', __FILE__ ), array( 'jquery-ui-sortable' ), '20110212' );
		wp_enqueue_style( 'wpcsp-sponsor-order', plugins_url( 'assets/css/order-sponsor-levels.css', __FILE__ ), array(), '20110212' );
	}

	/**
	 * Renders the Order Sponsor Levels admin page.
	 */
	function render_order_sponsor_levels() {
		if ( ! isset( $_REQUEST['updated'] ) ) {
			$_REQUEST['updated'] = false;
		}

		$levels = $this->get_sponsor_levels('conference_sponsor_level_order','wpcsp_sponsor_level');
		?>
		<div class="wrap">
			<h1><?php _e( 'Order Sponsor Levels', 'wpcsp' ); ?></h1>

			<?php if ( false !== $_REQUEST['updated'] ) : ?>
				<div class="updated fade"><p><strong><?php _e( 'Options saved', 'wpcsp' ); ?></strong></p></div>
			<?php endif; ?>

			<form method="post" action="options.php">
				<?php settings_fields( 'conference_sponsor_options' ); ?>
				<div class="description sponsor-order-instructions">
					<?php _e( 'Change the order of sponsor levels are displayed in the sponsors page template.', 'wpcsp' ); ?>
				</div>
				<ul class="sponsor-order">
				<?php foreach ( $levels as $term ) : ?>
					<li class="level">
						<input type="hidden" class="level-id" name="conference_sponsor_level_order[]" value="<?php echo esc_attr( $term->term_id ); ?>" />
						<?php echo esc_html( $term->name ); ?>
					</li>
				<?php endforeach; ?>
				</ul>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'wpcsp' ); ?>" />
				</p>
			</form>
		</div>
		<?php
	}

	/**
	 * Renders the Order Speaker Levels admin page.
	 */
	function render_order_speaker_levels() {
		if ( ! isset( $_REQUEST['updated'] ) ) {
			$_REQUEST['updated'] = false;
		}

		$levels = $this->get_sponsor_levels('speaker_level_order','wpcsp_speaker_level');
		?>
		<div class="wrap">
			<h1><?php _e( 'Order Speaker Groups', 'wpcsp' ); ?></h1>

			<?php if ( false !== $_REQUEST['updated'] ) : ?>
				<div class="updated fade"><p><strong><?php _e( 'Options saved', 'wpcsp' ); ?></strong></p></div>
			<?php endif; ?>

			<form method="post" action="options.php">
				<?php settings_fields( 'speaker_options' ); ?>
				<div class="description sponsor-order-instructions">
					<?php _e( 'Change the order of speaker groups are displayed in the speaker page template.', 'wpcsp' ); ?>
				</div>
				<ul class="sponsor-order">
				<?php foreach ( $levels as $term ) : ?>
					<li class="level">
						<input type="hidden" class="level-id" name="speaker_level_order[]" value="<?php echo esc_attr( $term->term_id ); ?>" />
						<?php echo esc_html( $term->name ); ?>
					</li>
				<?php endforeach; ?>
				</ul>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'wpcsp' ); ?>" />
				</p>
			</form>
		</div>
		<?php
	}

	/**
	 * Runs when settings are updated for the sponsor level order page.
	 */
	function validate_sponsor_options( $input ) {
		if ( ! is_array( $input ) ) {
			$input = null;
		} else {
			foreach ( $input as $key => $value ) {
				$input[ $key ] = (int) $input[ $key ];
			}
			$input = array_values( $input );
		}

		return $input;
	}

	/**
	 * Returns the sponsor level terms in set order.
	 */
	function get_sponsor_levels($option, $taxonomy) {
		$option        = get_option( $option );
		$term_objects  = get_terms( $taxonomy, array( 'get' => 'all' ) );
		$terms         = array();
		$ordered_terms = array();

		foreach ( $term_objects as $term ) {
			$terms[ $term->term_id ] = $term;
		}

		if ( empty( $option ) ) {
			$option = array();
		}

		foreach ( $option as $term_id ) {
			if ( isset( $terms[ $term_id ] ) ) {
				$ordered_terms[] = $terms[ $term_id ];
				unset( $terms[ $term_id ] );
			}
		}

		return array_merge( $ordered_terms, array_values( $terms ) );
	}

	/**
	 * The [sponsors] shortcode handler.
	 */
	function shortcode_sponsors( $attr, $content ) {
		global $post;

		$attr = shortcode_atts( array(
			'link'           => 'none',
			'title'          => 'visible',
			'content'        => 'full',
			'excerpt_length' => 55,
			'heading_level'  => 'h2',
		), $attr );
		/*
		title = visible
		link = website, post
		content = full, excerpt
		heading_level = h2
		excerpt_length = 0
		*/

		$attr['link'] = strtolower( $attr['link'] );
		$terms        = $this->get_sponsor_levels('conference_sponsor_level_order','wpcsp_sponsor_level');

		ob_start();
		?>

		<div class="wpcsp-sponsors">
			<?php foreach ( $terms as $term ) :
				$sponsors = new WP_Query( array(
					'post_type'      => 'wpcsp_sponsor',
					'order'          => 'ASC',
					'orderby'		 =>  'title',
					'posts_per_page' => -1,
					'taxonomy'       => $term->taxonomy,
					'term'           => $term->slug,
				) );

				if ( ! $sponsors->have_posts() ) {
					continue;
				}

				// temporarily hide elements
				$attr['title'] = 'hidden';
				$attr['content'] = 'hidden';
				?>	

				<div class="wpcsp-sponsor-level wpcsp-sponsor-level-<?php echo sanitize_html_class( $term->slug ); ?>">
					<?php $heading_level = ($attr['heading_level']) ? $attr['heading_level'] : 'h2'; ?>
					<<?php echo $heading_level; ?> class="wpcsp-sponsor-level-heading"><span><?php echo esc_html( $term->name ); ?></span></<?php echo $heading_level; ?>>

					<ul class="wpcsp-sponsor-list">
						<?php while ( $sponsors->have_posts() ) :
							$sponsors->the_post();
							$website = get_post_meta( get_the_ID(), 'wpcsp_website_url', true );
							$logo_height = (get_term_meta($term->term_id,'wpcsp_logo_height',true)) ? get_term_meta($term->term_id,'wpcsp_logo_height',true).'px' : 'auto';
							$image = (has_post_thumbnail()) ? '<img class="wpcsp-sponsor-image" src="'.get_the_post_thumbnail_url(get_the_ID(),'full').'" alt="'.get_the_title(get_the_ID()).'" style="width: auto; max-height: '.$logo_height.';"  />' : null;
							//
							?>

							<li id="wpcsp-sponsor-<?php the_ID(); ?>" class="wpcsp-sponsor">
								<?php if ( 'visible' === $attr['title'] ) : ?>
									<?php if ( 'website' === $attr['link'] && $website ) : ?>
										<h3>
											<a href="<?php echo esc_attr( esc_url( $website ) ); ?>">
												<?php the_title(); ?>
											</a>
										</h3>
									<?php elseif ( 'post' === $attr['link'] ) : ?>
										<h3>
											<a href="<?php echo esc_attr( esc_url( get_permalink() ) ); ?>">
												<?php the_title(); ?>
											</a>
										</h3>
									<?php else : ?>
										<h3>
											<?php the_title(); ?>
										</h3>
									<?php endif; ?>
								<?php endif; ?>

								<div class="wpcsp-sponsor-description">
									<?php if ( 'website' == $attr['link'] && $website ) : ?>
										<a href="<?php echo esc_attr( esc_url( $website ) ); ?>">
											<?php echo $image; ?>
										</a>
									<?php elseif ( 'post' == $attr['link'] ) : ?>
										<a href="<?php echo esc_attr( esc_url( get_permalink() ) ); ?>">
											<?php echo $image; ?>
										</a>
									<?php else : ?>
										<?php echo $image; ?>
									<?php endif; ?>

									<?php if ( 'full' === $attr['content'] ) : ?>
										<?php the_content(); ?>
									<?php elseif ( 'excerpt' === $attr['content'] ) : ?>
										<?php echo wpautop(
											wp_trim_words(
												get_the_content(),
												absint( $attr['excerpt_length'] ),
												apply_filters( 'excerpt_more', ' ' . '&hellip;' )
											)
										); ?>
									<?php endif; ?>
								</div>
							</li>
						<?php endwhile; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>

		<?php

		wp_reset_postdata();
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}

	/**
	 * The [speakers] shortcode handler.
	 */
	function shortcode_speakers( $attr, $content ) {
		global $post;

		// Prepare the shortcodes arguments
		$attr = shortcode_atts( array(
			'show_image'     => true,
			'image_size'     => 150,
			'show_content'	 => true,
			'posts_per_page' => -1,
			'orderby'        => 'date',
			'order'          => 'desc',
			'speaker_link'   => '',
			'track'          => '',
			'groups'         => '',
			'columns'		 => 1,
			'gap'			 => 30,
			'align'			 => 'left'
		), $attr );

		foreach ( array( 'orderby', 'order', 'speaker_link' ) as $key_for_case_sensitive_value ) {
			$attr[ $key_for_case_sensitive_value ] = strtolower( $attr[ $key_for_case_sensitive_value ] );
		}

		$attr['show_image'] = $this->str_to_bool( $attr['show_image'] );
		$attr['show_content'] = $this->str_to_bool( $attr['show_content'] );
		$attr['orderby']      = in_array( $attr['orderby'],      array( 'date', 'title', 'rand' ) ) ? $attr['orderby']      : 'date';
		$attr['order']        = in_array( $attr['order'],        array( 'asc', 'desc'           ) ) ? $attr['order']        : 'desc';
		$attr['speaker_link'] = in_array( $attr['speaker_link'], array( 'permalink'             ) ) ? $attr['speaker_link'] : '';
		$attr['track']        = array_filter( explode( ',', $attr['track'] ) );
		$attr['groups']       = array_filter( explode( ',', $attr['groups'] ) );

		// Fetch all the relevant sessions
		$session_args = array(
			'post_type'      => 'wpcs_session',
			'posts_per_page' => -1,
		);

		if ( ! empty( $attr['track'] ) ) {
			$session_args['tax_query'] = array(
				array(
					'taxonomy' => 'wpcs_track',
					'field'    => 'slug',
					'terms'    => $attr['track'],
				),
			);
		}

		$sessions = get_posts( $session_args );

		// Parse the sessions
		$speaker_ids = $speakers_tracks = array();
		foreach ( $sessions as $session ) {
			// Get the speaker IDs for all the sessions in the requested tracks
			$session_speaker_ids = get_post_meta( $session->ID, '_rwc_cs_speaker_id' );
			$speaker_ids         = array_merge( $speaker_ids, $session_speaker_ids );

			// Map speaker IDs to their corresponding tracks
			$session_terms = wp_get_object_terms( $session->ID, 'RWC_track' );
			foreach ( $session_speaker_ids as $speaker_id ) {
				if ( isset( $speakers_tracks[ $speaker_id ] ) ) {
					$speakers_tracks[ $speaker_id ] = array_merge( $speakers_tracks[ $speaker_id ], wp_list_pluck( $session_terms, 'slug' ) );
				} else {
					$speakers_tracks[ $speaker_id ] = wp_list_pluck( $session_terms, 'slug' );
				}
			}
		}

		// Remove duplicate entries
		$speaker_ids = array_unique( $speaker_ids );
		foreach ( $speakers_tracks as $speaker_id => $tracks ) {
			$speakers_tracks[ $speaker_id ] = array_unique( $tracks );
		}

		// Fetch all specified speakers
		$speaker_args = array(
			'post_type'      => 'wpcsp_speaker',
			'posts_per_page' => intval( $attr['posts_per_page'] ),
			'orderby'        => $attr['orderby'],
			'order'          => $attr['order'],
		);

		if ( ! empty( $attr['track'] ) ) {
			$speaker_args['post__in'] = $speaker_ids;
		}

		if ( ! empty( $attr['groups'] ) ) {
			$speaker_args['tax_query'] = array(
				array(
					'taxonomy' => 'wpcsp_speaker_level',
					'field'    => 'slug',
					'terms'    => $attr['groups'],
				),
			);
		}

		$speakers = new WP_Query( $speaker_args );

		if ( ! $speakers->have_posts() ) {
			return '';
		}

		// Render the HTML for the shortcode
		ob_start();
		?>

		<div class="wpcsp-speakers" style="text-align: <?php echo $attr['align']; ?>; display: grid; grid-template-columns: repeat(<?php echo $attr['columns']; ?>, 1fr); grid-gap: <?php echo $attr['gap']; ?>px;">

			<?php while ( $speakers->have_posts() ) :
				$speakers->the_post();

				$post_id = get_the_ID();
				$first_name = get_post_meta( $post_id, 'wpcsp_first_name', true );
				$last_name = get_post_meta( $post_id, 'wpcsp_last_name', true );
				$full_name = $first_name.' '.$last_name;
				$title_organization = [];
				$title = (get_post_meta( $post_id, 'wpcsp_title', true )) ? $title_organization[] = get_post_meta( $post_id, 'wpcsp_title', true ) : null;
				$organization = (get_post_meta( $post_id, 'wpcsp_organization', true )) ? $title_organization[] = get_post_meta( $post_id, 'wpcsp_organization', true ) : null;

				$speaker_classes = array( 'wpcsp-speaker', 'wpcsp-speaker-' . sanitize_html_class( $post->post_name ) );

				if ( isset( $speakers_tracks[ get_the_ID() ] ) ) {
					foreach ( $speakers_tracks[ get_the_ID() ] as $track ) {
						$speaker_classes[] = sanitize_html_class( 'wpcsp-track-' . $track );
					}
				}

				?>

				<!-- Organizers note: The id attribute is deprecated and only remains for backwards compatibility, please use the corresponding class to target individual speakers -->
				<div class="wpcsp-speaker" id="wpcsp-speaker-<?php echo sanitize_html_class( $post->post_name ); ?>" class="<?php echo implode( ' ', $speaker_classes ); ?>">
					
					<?php if(has_post_thumbnail($post_id) && $attr['show_image'] == true) echo get_the_post_thumbnail($post_id, [$attr['image_size'],$attr['image_size']], array( 'alt' => $full_name, 'class' => 'wpcsp-speaker-image' ) ); ?>
				
					<h2 class="wpcsp-speaker-name">
						<?php if ( 'permalink' === $attr['speaker_link'] ) : ?>

							<a href="<?php the_permalink(); ?>">
								<?php echo $full_name; ?>
							</a>

						<?php else : ?>

							<?php echo $full_name; ?>

						<?php endif; ?>
					</h2>

					<?php if($title_organization){ ?>
						<p class="wpcsp-speaker-title-organization">
							<?php echo implode(', ',$title_organization); ?>	
						</p>
					<?php } ?>

					<div class="wpcsp-speaker-description">
						<?php if($attr['show_content'] == true) the_content(); ?>
					</div>
				</div>

			<?php endwhile; ?>

		</div>

		<?php

		wp_reset_postdata();
		return ob_get_clean();
	}

	/**
	 * Convert a string representation of a boolean to an actual boolean
	 *
	 * @param string|bool
	 *
	 * @return bool
	 */
	function str_to_bool( $value ) {
		if ( true === $value ) {
			return true;
		}

		if ( in_array( strtolower( trim( $value ) ), array( 'yes', 'true', '1' ) ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Filter session speaker meta field
	 *
	 * @param array $cmb
	 * @return void
	 */
	function filter_session_speaker_meta_field($cmb){

		$cmb->add_field( array(
			'name'             => 'Speaker Display',
			'id'               => 'wpcsp_session_speaker_display',
			'type'             => 'radio',
			'show_option_none' => false,
			'options'          => array(
				'typed' => __( 'Speaker Names (Typed)', 'wpcsp' ),
				'cpt'   => __( 'Speaker Select (from Speakers CPT)', 'wpcsp' ),
			),
			'default'		   => 'typed'
		) );

		// get speakers
		$args = [
			'numberposts' => -1,
			'post_type'   => 'wpcsp_speaker',
		];
		$speakers = get_posts($args);
		$speakers = wp_list_pluck( $speakers, 'post_title','ID' );

		$cmb->add_field( array(
			'name'    => 'Speakers',
			'id'      => 'wpcsp_session_speakers',
			'desc'    => 'Select speakers. Drag to reorder.',
			'type'    => 'pw_multiselect',
			'options' => $speakers,
			'attributes'    => array(
				'data-conditional-id'     => 'wpcsp_session_speaker_display',
				'data-conditional-value'  => 'cpt',
				// 'data-conditional-invert' => true
			),
		));

		// Speaker Name(s)
		$cmb->add_field( array(
			'name'       => __( 'Speaker Name(s)', 'wpcsp' ),
			//'desc'       => __( 'field description (optional)', 'wpcsp' ),
			'id'         => '_wpcs_session_speakers',
			'type'       => 'text',
			'attributes'    => array(
				'data-conditional-id'     => 'wpcsp_session_speaker_display',
				'data-conditional-value'  => 'typed',
				// 'data-conditional-invert' => true
			),
		) );
		
		// get sponsors
		$args = [
			'numberposts' => -1,
			'post_type'   => 'wpcsp_sponsor',
		];
		$sponsor = get_posts($args);
		$sponsor = wp_list_pluck( $sponsor, 'post_title','ID' );

		$cmb->add_field( array(
			'name'    => 'Sponsors',
			'id'      => 'wpcsp_session_sponsors',
			'desc'    => 'Select sponsor. Drag to reorder.',
			'type'    => 'pw_multiselect',
			'options' => $sponsor,
		));

	}

	public function filter_session_speakers($speakers_typed, $session_id){

		$speaker_display = get_post_meta($session_id,'wpcsp_session_speaker_display',true);
		
		if($speaker_display == 'typed') return $speakers_typed;

		$html = '';
		$speakers_cpt = get_post_meta($session_id,'wpcsp_session_speakers',true);
		
		if($speakers_cpt){
			ob_start();
			foreach ($speakers_cpt as $post_id) {
				$first_name = get_post_meta( $post_id, 'wpcsp_first_name', true );
				$last_name = get_post_meta( $post_id, 'wpcsp_last_name', true );
				$full_name = $first_name.' '.$last_name;
				$title_organization = [];
				$title = (get_post_meta( $post_id, 'wpcsp_title', true )) ? $title_organization[] = get_post_meta( $post_id, 'wpcsp_title', true ) : null;
				$organization = (get_post_meta( $post_id, 'wpcsp_organization', true )) ? $title_organization[] = get_post_meta( $post_id, 'wpcsp_organization', true ) : null;
				
				?>
				<div class="wpcsp-session-speaker">

					<?php if($full_name){ ?>
						<div class="wpcsp-session-speaker-name">
							<?php echo $full_name; ?>
						</div>
					<?php } ?>

					<?php if($title_organization){ ?>
						<div class="wpcsp-session-speaker-title-organization">
							<?php echo implode(', ',$title_organization); ?>	
						</div>
					<?php } ?>
					
				</div>
				<?php
			}
			$html .= ob_get_clean();
		}

		return $html;
	}

	public function filter_single_session_speakers($speakers_typed, $session_id){

		$speaker_display = get_post_meta($session_id,'wpcsp_session_speaker_display',true);
		
		if($speaker_display == 'typed') return $speakers_typed;

		$html = '';
		$speakers_cpt = get_post_meta($session_id,'wpcsp_session_speakers',true);
		
		if($speakers_cpt){ 
			ob_start();
			?>
			<div class="wpcsp-single-session-speakers">
				<h2 class="wpcsp-single-session-speakers-title">Speakers</h2>
				<?php foreach ($speakers_cpt as $post_id) {
					$first_name = get_post_meta( $post_id, 'wpcsp_first_name', true );
					$last_name = get_post_meta( $post_id, 'wpcsp_last_name', true );
					$full_name = $first_name.' '.$last_name;
					$title_organization = [];
					$title = (get_post_meta( $post_id, 'wpcsp_title', true )) ? $title_organization[] = get_post_meta( $post_id, 'wpcsp_title', true ) : null;
					$organization = (get_post_meta( $post_id, 'wpcsp_organization', true )) ? $title_organization[] = get_post_meta( $post_id, 'wpcsp_organization', true ) : null;
					
					?>
					<div class="wpcsp-single-session-speakers-speaker">

						<?php if(has_post_thumbnail($post_id)) echo get_the_post_thumbnail($post_id, 'thumbnail', array( 'alt' => $full_name, 'class' => 'wpcsp-single-session-speakers-speaker-image' ) ); ?>

						<?php if($full_name){ ?>
							<h3 class="wpcsp-single-session-speakers-speaker-name">
								<a href="<?php echo get_the_permalink($post_id); ?>"><?php echo $full_name; ?></a>
							</h3>
						<?php } ?>

						<?php if($title_organization){ ?>
							<div class="wpcsp-single-session-speakers-speaker-title-organization">
								<?php echo implode(', ',$title_organization); ?>	
							</div>
						<?php } ?>
						
					</div>
					<?php
				}
				?>
			</div>
			<?php
			$html .= ob_get_clean();
		}

		return $html;
	}

	public function session_content_header($session_id){
		$html = '';
		$session_tags = get_the_terms( $session_id, 'wpcs_session_tag' );
		if($session_tags){
			ob_start();
			?>
			<ul class="wpcsp-session-tags">
				<?php foreach ($session_tags as $session_tag) { ?>
					<li class="wpcsp-session-tags-tag">
						<a href="<?php echo get_term_link($session_tag->term_id, 'wpcs_session_tag'); ?>" class="wpcsp-session-tags-tag-link"><?php echo $session_tag->name;  ?></a>
					</li>
				<?php } ?>
			</ul>
			<?php
			$html = ob_get_clean();
		}
		return $html;
	}

	public function single_session_tags(){
		//$tags = get_the_term_list( get_the_ID(), 'wpcs_session_tag', '<li class="wpsc-single-session-meta-item wpsc-single-session-location"><i class="fas fa-tag"></i>', ', ', '</li>');
		$terms = get_the_terms(get_the_ID(), 'wpcs_session_tag');
		if ( !is_wp_error($terms) && !empty($terms)){
			$term_names = wp_list_pluck($terms, 'name'); 
			$terms = implode(", ", $term_names);
			if($terms)
				echo '<li class="wpsc-single-session-taxonomies-taxonomy wpsc-single-session-location"><i class="fas fa-tag"></i>'.$terms.'</li>';
		}
	}

	/**
	 * Output Session Sponsors
	 *
	 * @param int $session_id
	 * @return mixed
	 */
	public function session_sponsors($session_id){
		
		$session_sponsors = get_post_meta( $session_id, 'wpcsp_session_sponsors', true );
		if(!$session_sponsors) return;

		$sponsors = [];
		foreach($session_sponsors as $sponser_li){	
			$sponsors[] .= get_the_title($sponser_li);	
		}
		
		ob_start();

		if($sponsors){
			echo '<div class="wpcs-session-sponsor"><span class="wpcs-session-sponsor-label">Presented by: </span>'.implode(', ', $sponsors).'</div>';
		}

		$html = ob_get_clean();
		return $html;

	}

}

// Load the plugin class.
$GLOBALS['wpcs_plugin'] = new WP_Conference_Schedule_Pro();