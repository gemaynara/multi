<?php
/**
 * Porto Speed Optimze Wizard Class
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Porto_Speed_Optimize_Wizard' ) ) {
	/**
	 * Porto_Speed_Optimize_Wizard class
	 */
	class Porto_Speed_Optimize_Wizard {

		protected $version = '1.1.0';

		protected $theme_name = '';

		protected $step = '';

		protected $steps = array();

		protected $page_slug;

		protected $page_url;

		private static $instance = null;

		protected $tgmpa_instance;

		protected $tgmpa_menu_slug = 'tgmpa-install-plugins';

		protected $tgmpa_url = 'themes.php?page=tgmpa-install-plugins';

		public static function get_instance() {
			if ( ! self::$instance ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		public function __construct() {
			$this->init_globals();
			$this->init_actions();
		}

		public function init_globals() {
			$current_theme    = wp_get_theme();
			$this->theme_name = strtolower( preg_replace( '#[^a-zA-Z]#', '', $current_theme->get( 'Name' ) ) );
			$this->page_slug  = 'porto-speed-optimize-wizard';
			$this->page_url   = 'admin.php?page=' . $this->page_slug;
		}

		public function init_actions() {
			if ( apply_filters( $this->theme_name . '_enable_speed_optimize_wizard', true ) && current_user_can( 'manage_options' ) ) {
				if ( class_exists( 'TGM_Plugin_Activation' ) && isset( $GLOBALS['tgmpa'] ) ) {
					add_action( 'init', array( $this, 'get_tgmpa_instanse' ), 30 );
					add_action( 'init', array( $this, 'set_tgmpa_url' ), 40 );
				}

				add_action( 'admin_menu', array( $this, 'admin_menus' ) );

				add_action( 'admin_init', array( $this, 'init_wizard_steps' ), 30 );
				add_action( 'admin_init', array( $this, 'speed_optimize_wizard' ), 30 );
				add_action( 'wp_ajax_porto_speed_optimize_wizard_plugins', array( $this, 'ajax_plugins' ) );
				add_action( 'wp_ajax_porto_speed_optimize_wizard_shortcodes', array( $this, 'get_unused_shortcodes' ) );

				if ( isset( $_GET['page'] ) && $this->page_slug === $_GET['page'] ) {
					add_action( 'wp_title', array( $this, 'page_title' ) );
				}
			}

			add_action( 'upgrader_post_install', array( $this, 'upgrader_post_install' ), 10, 2 );
		}

		public function page_title() {
			return esc_html__( 'Theme &rsaquo; Speed Optimize Wizard', 'porto' );
		}

		public function upgrader_post_install( $return, $theme ) {
			if ( is_wp_error( $return ) ) {
				return $return;
			}
			if ( get_stylesheet() != $theme ) {
				return $return;
			}
			update_option( 'porto_speed_optimize_complete', false );

			return $return;
		}

		public function admin_menus() {
			add_submenu_page( 'porto', esc_html__( 'Speed Optimize Wizard', 'porto' ), esc_html__( 'Speed Optimize Wizard', 'porto' ), 'manage_options', $this->page_slug, array( $this, $this->page_slug ) );
		}

		public function init_wizard_steps() {

			$this->steps = array(
				'introduction' => array(
					'name'    => esc_html__( 'Welcome', 'porto' ),
					'view'    => array( $this, 'porto_speed_optimize_wizard_welcome' ),
					'handler' => array( $this, 'porto_speed_optimize_wizard_welcome_save' ),
				),
			);

			$this->steps['shortcodes'] = array(
				'name'    => esc_html__( 'JS Composer & Shortcodes', 'porto' ),
				'view'    => array( $this, 'porto_speed_optimize_wizard_shortcodes' ),
				'handler' => array( $this, 'porto_speed_optimize_wizard_shortcodes_save' ),
			);

			$this->steps['revslider'] = array(
				'name'    => esc_html__( 'Revolution Slider', 'porto' ),
				'view'    => array( $this, 'porto_speed_optimize_wizard_revslider' ),
				'handler' => array( $this, 'porto_speed_optimize_wizard_revslider_save' ),
			);

			$this->steps['lazyload'] = array(
				'name'    => esc_html__( 'Lazy Load', 'porto' ),
				'view'    => array( $this, 'porto_speed_optimize_wizard_lazyload' ),
				'handler' => array( $this, 'porto_speed_optimize_wizard_lazyload_save' ),
			);

			$this->steps['general'] = array(
				'name'    => esc_html__( 'Other Minify', 'porto' ),
				'view'    => array( $this, 'porto_speed_optimize_wizard_general' ),
				'handler' => array( $this, 'porto_speed_optimize_wizard_general_save' ),
			);

			$this->steps['next_steps'] = array(
				'name'    => esc_html__( 'Final Optimize', 'porto' ),
				'view'    => array( $this, 'porto_speed_optimize_wizard_ready' ),
				'handler' => '',
			);

			$this->steps = apply_filters( $this->theme_name . '_speed_optimize_wizard_steps', $this->steps );
		}

		/**
		 * Display the setup wizard
		 */
		public function speed_optimize_wizard() {
			if ( empty( $_GET['page'] ) || $this->page_slug !== $_GET['page'] ) {
				return;
			}
			ob_end_clean();
			global $porto_settings_optimize;

			$this->step = isset( $_GET['step'] ) ? sanitize_key( $_GET['step'] ) : current( array_keys( $this->steps ) );

			wp_register_script( 'jquery-blockui', PORTO_URI . '/inc/admin/setup_wizard/assets/js/jquery.blockUI.js', array( 'jquery' ), '2.70', true );
			wp_register_script( 'porto-admin', PORTO_JS . '/admin/admin.min.js', array( 'jquery' ), $this->version, true );
			wp_register_script( 'porto-speed-optimize', PORTO_URI . '/inc/admin/setup_wizard/assets/js/setup-wizard.js', array( 'jquery', 'porto-admin', 'jquery-blockui' ), $this->version );
			wp_localize_script(
				'porto-speed-optimize',
				'porto_speed_optimize_wizard_params',
				array(
					'wpnonce'              => wp_create_nonce( 'porto_speed_optimize_wizard_nonce' ),
					'shortcodes_to_remove' => isset( $porto_settings_optimize['shortcodes_to_remove'] ) ? $porto_settings_optimize['shortcodes_to_remove'] : false,
				)
			);

			wp_enqueue_style( 'porto-speed-optimize', PORTO_URI . '/inc/admin/setup_wizard/assets/css/style.css', array( 'wp-admin', 'dashicons', 'install' ), $this->version );

			wp_enqueue_style( 'wp-admin' );
			wp_enqueue_media();
			wp_enqueue_script( 'media' );

			ob_start();
			$this->setup_wizard_header();
			$this->setup_wizard_steps();
			$show_content = true;
			echo '<div class="porto-setup-content">';
			if ( ! empty( $_REQUEST['save_step'] ) && isset( $this->steps[ $this->step ]['handler'] ) ) {
				$show_content = call_user_func( $this->steps[ $this->step ]['handler'] );
			}
			if ( $show_content ) {
				$this->setup_wizard_content();
			}
			echo '</div>';
			$this->setup_wizard_footer();
			exit;
		}

		public function get_step_link( $step ) {
			return add_query_arg( 'step', $step, esc_url( admin_url( 'admin.php?page=' . $this->page_slug ) ) );
		}
		public function get_next_step_link() {
			$keys = array_keys( $this->steps );
			return add_query_arg( 'step', $keys[ array_search( $this->step, array_keys( $this->steps ) ) + 1 ], remove_query_arg( 'translation_updated' ) );
		}

		public function get_tgmpa_instanse() {
			$this->tgmpa_instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
		}

		public function set_tgmpa_url() {

			$this->tgmpa_menu_slug = ( property_exists( $this->tgmpa_instance, 'menu' ) ) ? $this->tgmpa_instance->menu : $this->tgmpa_menu_slug;
			$this->tgmpa_menu_slug = apply_filters( $this->theme_name . '_theme_setup_wizard_tgmpa_menu_slug', $this->tgmpa_menu_slug );

			$tgmpa_parent_slug = ( property_exists( $this->tgmpa_instance, 'parent_slug' ) && 'themes.php' !== $this->tgmpa_instance->parent_slug ) ? 'admin.php' : 'themes.php';

			$this->tgmpa_url = apply_filters( $this->theme_name . '_theme_setup_wizard_tgmpa_url', $tgmpa_parent_slug . '?page=' . $this->tgmpa_menu_slug );

		}

		/**
		 * Setup Wizard Header
		 */
		public function setup_wizard_header() {
			?>
			<!DOCTYPE html>
			<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
			<head>
				<meta name="viewport" content="width=device-width" />
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<title><?php wp_title(); ?></title>
				<script type="text/javascript">
					var ajaxurl = '<?php echo esc_url( admin_url( 'admin-ajax.php', 'relative' ) ); ?>';
				</script>
				<?php wp_print_scripts( 'porto-speed-optimize' ); ?>
				<?php do_action( 'admin_print_styles' ); ?>
				<?php do_action( 'admin_print_scripts' ); ?>
			</head>
			<body class="porto-setup wp-core-ui">
			<h1 id="porto-logo">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> - <?php bloginfo( 'description' ); ?>" class="overlay-logo">
					<img class="img-responsive" src="<?php echo PORTO_URI; ?>/images/logo/logo.png" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" width="111" height="54" />
				</a>
			</h1>
			<?php
		}

		/**
		 * Setup Wizard Footer
		 */
		public function setup_wizard_footer() {
			?>
			<a class="wc-return-to-dashboard" href="<?php echo esc_url( admin_url() ); ?>"><?php esc_html_e( 'Return to the WordPress Dashboard', 'porto' ); ?></a>
			<?php
			@do_action( 'admin_footer' );
			do_action( 'admin_print_footer_scripts' );
			?>
			</body>
			</html>
			<?php
		}

		/**
		 * Output the steps
		 */
		public function setup_wizard_steps() {
			$ouput_steps = $this->steps;
			array_shift( $ouput_steps );
			?>
			<ol class="porto-setup-steps">
			<?php foreach ( $ouput_steps as $step_key => $step ) : ?>
				<?php
				$show_link        = true;
				$li_class_escaped = '';
				if ( $step_key === $this->step ) {
					$li_class_escaped = 'active';
				} elseif ( array_search( $this->step, array_keys( $this->steps ) ) > array_search( $step_key, array_keys( $this->steps ) ) ) {
					$li_class_escaped = 'done';
				}
				if ( $step_key === $this->step ) {
					$show_link = false;
				}
				?>
				<li class="<?php echo esc_attr( $li_class_escaped ); ?>">
				<?php
				if ( $show_link ) {
					?>
						<a href="<?php echo esc_url( $this->get_step_link( $step_key ) ); ?>"><?php echo esc_html( $step['name'] ); ?></a>
						<?php
				} else {
					echo esc_html( $step['name'] );
				}
				?>
					</li>
			<?php endforeach; ?>
			</ol>
			<?php
		}

		/**
		 * Output the content for the current step
		 */
		public function setup_wizard_content() {
			isset( $this->steps[ $this->step ] ) ? call_user_func( $this->steps[ $this->step ]['view'] ) : false;
		}

		/**
		 * Welcome step
		 */
		public function porto_speed_optimize_wizard_welcome() {
			?>
			<?php /* translators: %s: Theme name */ ?>
			<h1><?php printf( esc_html__( 'Welcome to the Speed Optimize Wizard for %s.', 'porto' ), wp_get_theme() ); ?></h1>
			<p class="lead" style="font-size: 14px;"><?php esc_html_e( 'This Speed Optimize Wizard is introduced to optimize all resources that are unnecessary for your site content. We experienced many customers asking to remove unused resources as customers use certain feature from bunch of Porto features. Each steps have enough description about how it works. Some options may occur some conflicts if your site is still in development progress, we recommend you to enable all options once site development is completed.', 'porto' ); ?></p>
			<p><?php esc_html_e( "No time right now? If you don't want to go through the wizard, you can skip and return to the WordPress dashboard. Come back anytime if you change your mind!", 'porto' ); ?></p>
			<p class="porto-setup-actions step">
				<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button-primary button button-large button-next"><?php esc_html_e( "Let's Go!", 'porto' ); ?></a>
				<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url( '' ) ); ?>" class="button button-large"><?php esc_html_e( 'Not right now', 'porto' ); ?></a>
			</p>
			<?php
		}

		public function porto_speed_optimize_wizard_welcome_save() {

			check_admin_referer( 'porto-speed-optimize' );
			return false;
		}

		/**
		 * Shortcodes Optimization Step
		 */
		public function porto_speed_optimize_wizard_shortcodes() {
			global $porto_settings_optimize;
			?>
			<h1><?php esc_html_e( 'Optimize Visual Composer & Shortcodes', 'porto' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'This will help you to optimize visual composer and shortcodes css files by removing unused shortcodes\' style', 'porto' ); ?></p>
			<?php
			if ( isset( $_POST['porto_speed_optimize_compile_shortcodes'] ) && ! $_POST['porto_speed_optimize_compile_shortcodes'] ) {
				echo '<div class="notice-error notice-alt"><p>' . esc_html__( 'Failed Shortcodes CSS compilation!', 'porto' ) . '</p></div>';
			}
			?>
			<form action="" method="post">
				<p style="margin-bottom: 8px;"><?php esc_html_e( 'Below shortcodes are never used in your site content. By choosing below shortcodes, you can remove all resources related to those features. This will reduce hundreds of KB of page size.', 'porto' ); ?></p>
				<p class="notice-warning notice-alt" style="font-size: 14px; padding: 5px 10px;"><?php esc_html_e( 'Attention: You should uncheck necessary shortcodes and compile again to use removed shortcodes features.', 'porto' ); ?></p>
				<p style="margin-bottom: 0;"><?php esc_html_e( 'Please select shortcodes to remove.', 'porto' ); ?></p>
				<label class="checkbox">
					<input type="checkbox" id="toggle_select">
					<?php esc_html_e( 'Toggle All', 'porto' ); ?>
				</label>
				<style>
					.shortcode_list { display: -ms-flexbox; display: flex; -ms-flex-wrap: wrap; flex-wrap: wrap; min-height: 200px; }
					.shortcode_list li { width: 33.3333%; margin-bottom: 4px; padding-right: 10px; box-sizing: border-box; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
					.shortcode_list li .checkbox { font-size: 13px; font-weight: 400; word-break: break-all; }
					.shortcode_list .blockOverlay:before { content: 'Loading unused shortcodes...'; position: absolute; top: 50%; margin-top: -10px; left: 0; width: 100%; text-align: center; }
					@media (max-width: 480px ) {
						.shortcode_list li { width: 100%; }
					}
				</style>
				<ul class="shortcode_list"></ul>
				<p class="porto-setup-actions step">
					<input type="submit" name="save_step" class="button button-primary button-next button-next" value="<?php esc_attr_e( 'Compile & Continue', 'porto' ); ?>" disabled="disabled" />
					<?php wp_nonce_field( 'porto-speed-optimize' ); ?>
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'porto' ); ?></a>
				</p>
			</form>
			<script>
				jQuery("#toggle_select").click(function() {
					if (jQuery(this).is(":checked")) {
						jQuery(this).closest('form').find('input[type="checkbox"]').attr('checked', 'checked');
					} else {
						jQuery(this).closest('form').find('input[type="checkbox"]').removeAttr('checked');
					}
				});
			</script>
			<?php
		}

		public function porto_speed_optimize_wizard_shortcodes_save() {
			check_admin_referer( 'porto-speed-optimize' );

			global $porto_settings_optimize;
			if ( isset( $_POST['shortcodes'] ) && ! empty( $_POST['shortcodes'] ) ) {
				$porto_settings_optimize['shortcodes_to_remove'] = array_map( 'sanitize_text_field', $_POST['shortcodes'] );
			} else {
				unset( $porto_settings_optimize['shortcodes_to_remove'] );
			}
			update_option( 'porto_settings_optimize', $porto_settings_optimize );
			$result = porto_compile_css( 'shortcodes' );
			if ( $result ) {
				wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
				exit;
			} else {
				$_POST['porto_speed_optimize_compile_shortcodes'] = false;
				return true;
			}
		}

		/**
		 * Revolution Slider Optimization Step
		 */
		public function porto_speed_optimize_wizard_revslider() {
			global $porto_settings_optimize, $porto_settings;
			$rev_pages         = $this->get_used_shortcode_list( array( 'rev_slider', 'rev_slider_vc' ), true );
			$portfolio_use_rev = false;
			if ( 'carousel' == $porto_settings['portfolio-content-layout'] ) {
				$portfolio_use_rev = true;
			} else {
				$args  = array(
					'post_type'      => 'portfolio',
					'post_status'    => 'publish',
					'posts_per_page' => 20,
					'meta_query'     => array(
						array(
							'key'   => 'portfolio_layout',
							'value' => 'carousel',
						),
					),
				);
				$query = new WP_Query( $args );
				if ( $query->have_posts() ) {
					$portfolio_use_rev = true;
					while ( $query->have_posts() ) {
						$query->the_post();
						$rev_pages[] = get_the_ID();
					}
				}
				wp_reset_postdata();
			}
			if ( ! $portfolio_use_rev ) {
				foreach ( $rev_pages as $page_id ) {
					if ( get_post_type( $page_id ) == 'portfolio' ) {
						$portfolio_use_rev = true;
						break;
					}
				}
			}
			if ( $portfolio_use_rev ) {
				$portfolio_pages = $this->get_used_shortcode_list( array( 'porto_portfolios', 'porto_recent_portfolios' ), true, array( 'ajax_load' => 'yes' ) );
				$rev_pages       = array_unique( array_merge( $rev_pages, $portfolio_pages ) );
			}

			$portfolio_name = empty( $porto_settings['portfolio-name'] ) ? esc_html__( 'Portfolios', 'porto' ) : $porto_settings['portfolio-name'];
			?>
			<h1><?php esc_html_e( 'Optimize Revolution Slider', 'porto' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'This will help you to avoid loading revolution slider js/css resources for the pages that does not use revolution slider feature.', 'porto' ); ?></p>
			<?php if ( ! empty( $rev_pages ) ) : ?>
				<?php /* translators: %s: Page names which using rev sliders */ ?>
				<p style="margin-bottom: 5px;"><?php printf( esc_html__( 'Only %sbelow pages are using revolution slider feature.', 'porto' ), ( $portfolio_use_rev ? sprintf( esc_html__( '%s and ', 'porto' ), $portfolio_name ) : '' ) ); ?></p>
				<ul>
				<?php
				foreach ( $rev_pages as $page_id ) {
					$page = get_post( $page_id );
					if ( $page ) {
						echo '<li>' . esc_html( $page->post_type ) . ': <a href="' . esc_url( get_permalink( $page_id ) ) . '" target="_blank">' . esc_html( $page->post_title ) . '</a></li>';
					}
				}
				?>
				</ul>
				<p style="margin: 5px 0 15px;"><?php esc_html_e( 'By choosing this option rest pages will not load revolution js/css resources that are around 200KB.', 'porto' ); ?></p>
			<?php endif; ?>
			<form action="" method="post">
				<label class="checkbox checkbox-inline">
					<input type="checkbox" value="true" name="optimize_revslider" <?php echo isset( $porto_settings_optimize['optimize_revslider'] ) ? checked( $porto_settings_optimize['optimize_revslider'], true, false ) : ''; ?>> <?php esc_html_e( 'Optimize Revolution Slider', 'porto' ); ?>
				</label>
				<input type="hidden" name="portfolio_use_rev" value="<?php echo ! $portfolio_use_rev ? 'false' : 'true'; ?>" />
				<input type="hidden" name="rev_pages" value="<?php echo implode( ',', $rev_pages ); ?>" />
				<p></p>
				<p class="porto-setup-actions step">
					<input type="submit" name="save_step" class="button button-primary button-next button-next" value="<?php esc_attr_e( 'Save & Continue', 'porto' ); ?>" />
					<?php wp_nonce_field( 'porto-speed-optimize' ); ?>
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'porto' ); ?></a>
				</p>
			</form>
			<?php
		}

		public function porto_speed_optimize_wizard_revslider_save() {
			check_admin_referer( 'porto-speed-optimize' );

			global $porto_settings_optimize, $porto_settings;
			if ( isset( $_POST['optimize_revslider'] ) && 'true' == $_POST['optimize_revslider'] && isset( $_POST['rev_pages'] ) ) {
				$porto_settings_optimize['optimize_revslider'] = true;
				if ( $_POST['rev_pages'] ) {
					$porto_settings_optimize['optimize_revslider_pages'] = explode( ',', sanitize_text_field( $_POST['rev_pages'] ) );
				}
				$porto_settings_optimize['optimize_revslider_portfolio'] = ( isset( $porto_settings['portfolio-archive-ajax'] ) && $porto_settings['portfolio-archive-ajax'] && 'true' == $_POST['portfolio_use_rev'] ? true : false );
			} else {
				unset( $porto_settings_optimize['optimize_revslider_pages'] );
				unset( $porto_settings_optimize['optimize_revslider_portfolio'] );
				$porto_settings_optimize['optimize_revslider'] = false;
			}
			update_option( 'porto_settings_optimize', $porto_settings_optimize );

			wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
			exit;
		}

		/**
		 * Other Minify Step
		 */
		public function porto_speed_optimize_wizard_general() {
			global $porto_settings_optimize, $porto_settings;
			?>
			<h1><?php esc_html_e( 'General', 'porto' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'This will help you to set up general optimization settings such as follows.', 'porto' ); ?></p>
			<form action="" method="post">
				<ul>
					<li>
						<label class="checkbox checkbox-inline">
							<input type="checkbox" value="true" name="minify_css" <?php echo isset( $porto_settings_optimize['minify_css'] ) ? checked( $porto_settings_optimize['minify_css'], true, false ) : ''; ?>> <?php esc_html_e( 'Minify CSS/JS', 'porto' ); ?>
						</label>
						<p><?php esc_html_e( 'This will minify all css files which Porto theme generates such as skin, dynamic_style, shortcodes, etc. Also if you check this option, it uses minified javascript files.', 'porto' ); ?></p>
					</li>
					<li>
						<label class="checkbox checkbox-inline">
							<?php /* translators: $1: opening A tag which has link to the Google Webfont loader docs $2: closing A tag */ ?>
							<input type="checkbox" value="true" name="google_webfont" <?php echo isset( $porto_settings['google-webfont-loader'] ) ? checked( $porto_settings['google-webfont-loader'], true, false ) : ''; ?>> <?php printf( esc_html__( 'Enable %1$sWeb Font Loader%2$s for Google Fonts', 'porto' ), '<a href="https://developers.google.com/fonts/docs/webfont_loader" target="_blank">', '</a>' ); ?>
						</label>
						<?php /* translators: $1: opening A tag which has link to the Google PageSpeed Insights $2: closing A tag */ ?>
						<p><?php printf( esc_html__( 'By using this option, you can increase page speed about 4 percent in %1$sGoogle PageSpeed Insights%2$s for both of mobile and desktop.', 'porto' ), '<a href="https://developers.google.com/speed/pagespeed/insights/" target="_blank">', '</a>' ); ?></p>
					</li>
					<li>
						<label class="checkbox checkbox-inline">
							<input type="checkbox" value="true" name="optimize_bootstrap" <?php echo isset( $porto_settings_optimize['optimize_bootstrap'] ) ? checked( $porto_settings_optimize['optimize_bootstrap'], true, false ) : ''; ?>> <?php esc_html_e( 'Optimize Bootstrap', 'porto' ); ?>
						</label>
						<p><?php esc_html_e( 'By using this option, you can use bootstrap features only what Porto theme used. This will reduce around 150KB of page size.', 'porto' ); ?></p>
					</li>
					<li>
						<label class="checkbox checkbox-inline">
							<input type="checkbox" value="true" name="optimize_fontawesome" <?php echo isset( $porto_settings_optimize['optimize_fontawesome'] ) ? checked( $porto_settings_optimize['optimize_fontawesome'], true, false ) : ''; ?>> <?php esc_html_e( 'Optimze FontAwesome', 'porto' ); ?>
						</label>
						<p><?php esc_html_e( 'By using this option, you can use fontawesome icons only what Porto theme used. This will reduce around 40KB of page size.', 'porto' ); ?></p>
					</li>
					<li>
						<h4 style="margin-bottom: .25rem;"><?php esc_html_e( 'Disable Unused Content Types', 'porto' ); ?></h4>
						<?php
							$post_types = array(
								'portfolio' => __( 'Portfolio', 'porto' ),
								'member'    => __( 'Member', 'porto' ),
								'event'     => __( 'Event', 'porto' ),
								'faq'       => __( 'Faq', 'porto' ),
							);
						foreach ( $post_types as $post_type => $title ) {
							?>
							<label class="checkbox checkbox-inline">
								<input type="checkbox" value="<?php echo esc_attr( $post_type ); ?>" name="optimize_post_types[]" <?php echo isset( $porto_settings[ 'enable-' . $post_type ] ) ? checked( ! $porto_settings[ 'enable-' . $post_type ], true, false ) : ''; ?>> <?php echo esc_html( $title ); ?>
							</label>&nbsp;
							<?php
						}
						?>
						<p><?php esc_html_e( 'By disabling unused content types, you can reduce server response time and free up server space by deleting thumbnail files for these content types. We recommend to use Regenerate Thumbnails to remove image files for unregistered sizes after modifying these options.', 'porto' ); ?></p>
					</li>
				</ul>
				<p class="porto-setup-actions step">
					<input type="submit" name="save_step" class="button button-primary button-next button-next" value="<?php esc_attr_e( 'Compile & Continue', 'porto' ); ?>" />
					<?php wp_nonce_field( 'porto-speed-optimize' ); ?>
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'porto' ); ?></a>
				</p>
			</form>
			<?php
		}

		public function porto_speed_optimize_wizard_general_save() {
			check_admin_referer( 'porto-speed-optimize' );

			global $porto_settings_optimize, $porto_settings;
			$need_compile = false;
			if ( isset( $_POST['minify_css'] ) && 'true' == $_POST['minify_css'] ) {
				if ( ! isset( $porto_settings_optimize['minify_css'] ) || ! $porto_settings_optimize['minify_css'] ) {
					$need_compile = true;
				}
				$porto_settings_optimize['minify_css'] = true;
			} else {
				if ( isset( $porto_settings_optimize['minify_css'] ) && $porto_settings_optimize['minify_css'] ) {
					$need_compile = true;
				}
				$porto_settings_optimize['minify_css'] = false;
			}
			if ( $need_compile && isset( $porto_settings_optimize['shortcodes_to_remove'] ) ) {
				porto_compile_css( 'shortcodes' );
			}

			$need_compile = false;
			if ( isset( $_POST['optimize_bootstrap'] ) && 'true' == $_POST['optimize_bootstrap'] ) {
				if ( ! isset( $porto_settings_optimize['optimize_bootstrap'] ) || ! $porto_settings_optimize['optimize_bootstrap'] ) {
					$need_compile = true;
				}
				$porto_settings_optimize['optimize_bootstrap'] = true;
			} else {
				if ( isset( $porto_settings_optimize['optimize_bootstrap'] ) && $porto_settings_optimize['optimize_bootstrap'] ) {
					$need_compile = true;
				}
				$porto_settings_optimize['optimize_bootstrap'] = false;
			}
			if ( $need_compile ) {
				porto_compile_css( 'bootstrap_rtl' );
				porto_compile_css( 'bootstrap' );
			}

			$need_save = false;
			if ( isset( $_POST['google_webfont'] ) && 'true' == $_POST['google_webfont'] ) {
				if ( ! isset( $porto_settings['google-webfont-loader'] ) || ! $porto_settings['google-webfont-loader'] ) {
					$porto_settings['google-webfont-loader'] = true;
					$need_save                               = true;
				}
			} else {
				if ( isset( $porto_settings['google-webfont-loader'] ) && $porto_settings['google-webfont-loader'] ) {
					$porto_settings['google-webfont-loader'] = false;
					$need_save                               = true;
				}
			}

			$disabled_content_types = isset( $_POST['optimize_post_types'] ) && is_array( $_POST['optimize_post_types'] ) ? $_POST['optimize_post_types'] : array();
			$post_types             = array( 'portfolio', 'member', 'event', 'faq' );
			foreach ( $post_types as $post_type ) {
				if ( in_array( $post_type, $disabled_content_types ) && ( ! isset( $porto_settings[ 'enable-' . $post_type ] ) || $porto_settings[ 'enable-' . $post_type ] ) ) {
					$porto_settings[ 'enable-' . $post_type ] = false;
					$need_save                                = true;
				} elseif ( ! in_array( $post_type, $disabled_content_types ) && isset( $porto_settings[ 'enable-' . $post_type ] ) && ! $porto_settings[ 'enable-' . $post_type ] ) {
					$porto_settings[ 'enable-' . $post_type ] = true;
					$need_save                                = true;
				}
			}

			if ( $need_save ) {
				ob_start();
				$redux = ReduxFrameworkInstances::get_instance( 'porto_settings' );
				$redux->set_options( $porto_settings );
				ob_end_clean();
			}

			if ( isset( $_POST['optimize_fontawesome'] ) && 'true' == $_POST['optimize_fontawesome'] ) {
				$porto_settings_optimize['optimize_fontawesome'] = true;
			} else {
				$porto_settings_optimize['optimize_fontawesome'] = false;
			}
			update_option( 'porto_settings_optimize', $porto_settings_optimize );

			wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
			exit;
		}

		/**
		 * Lazy Load Images Step
		 */
		public function porto_speed_optimize_wizard_lazyload() {
			global $porto_settings_optimize;
			?>
			<h1><?php esc_html_e( 'Lazy Load', 'porto' ); ?></h1>
			<p class="lead"><?php esc_html_e( 'Enable lazy loading images and menu.', 'porto' ); ?></p>
			<form action="" method="post">
				<label class="checkbox checkbox-inline">
					<input type="checkbox" value="true" name="lazyload" <?php echo isset( $porto_settings_optimize['lazyload'] ) ? checked( $porto_settings_optimize['lazyload'], true, false ) : ''; ?>> <?php esc_html_e( 'Lazy Load Images', 'porto' ); ?>
				</label>
				<p><?php esc_html_e( 'Use with caution! Disable this option if you have any compability problems.', 'porto' ); ?></p>
				<label><?php esc_html_e( 'Lazy Load Sub Menus', 'porto' ); ?></label>
				<p>
					<label class="radio radio-inline">
						<input type="radio" name="lazyload_menu" value="" <?php echo checked( ! isset( $porto_settings_optimize['lazyload_menu'] ) || ! $porto_settings_optimize['lazyload_menu'], true, false ); ?>><?php esc_html_e( 'Disable', 'porto' ); ?>
					</label>
					<label class="radio radio-inline">
						<input type="radio" name="lazyload_menu" value="pageload" <?php echo checked( isset( $porto_settings_optimize['lazyload_menu'] ) && 'pageload' == $porto_settings_optimize['lazyload_menu'], true, false ); ?>><?php esc_html_e( 'After Page Loading', 'porto' ); ?>
					</label>
					<label class="radio radio-inline">
						<input type="radio" name="lazyload_menu" value="firsthover" <?php echo checked( isset( $porto_settings_optimize['lazyload_menu'] ) && 'firsthover' == $porto_settings_optimize['lazyload_menu'], true, false ); ?>><?php esc_html_e( 'On First Hover', 'porto' ); ?>
					</label>
				</p>
				<p class="porto-setup-actions step">
					<input type="submit" name="save_step" class="button button-primary button-next button-next" value="<?php esc_attr_e( 'Save & Continue', 'porto' ); ?>" />
					<?php wp_nonce_field( 'porto-speed-optimize' ); ?>
					<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>" class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'porto' ); ?></a>
				</p>
			</form>
			<?php
		}

		public function porto_speed_optimize_wizard_lazyload_save() {
			check_admin_referer( 'porto-speed-optimize' );
			global $porto_settings_optimize;
			if ( isset( $_POST['lazyload'] ) && 'true' == $_POST['lazyload'] ) {
				$porto_settings_optimize['lazyload'] = true;
			} else {
				$porto_settings_optimize['lazyload'] = false;
			}

			$need_compile = false;
			if ( ! isset( $porto_settings_optimize['lazyload_menu'] ) || ( isset( $_POST['lazyload_menu'] ) && $porto_settings_optimize['lazyload_menu'] != sanitize_title( $_POST['lazyload_menu'] ) ) ) {
				$need_compile = true;
			}
			if ( isset( $_POST['lazyload_menu'] ) ) {
				$porto_settings_optimize['lazyload_menu'] = sanitize_title( $_POST['lazyload_menu'] );
			}
			update_option( 'porto_settings_optimize', $porto_settings_optimize );
			if ( $need_compile ) {
				do_action( 'porto_admin_save_theme_settings' );
			}

			wp_redirect( esc_url_raw( $this->get_next_step_link() ) );
			exit;
		}

		/**
		 * Final step
		 */
		public function porto_speed_optimize_wizard_ready() {

			update_option( 'porto_speed_optimize_complete', time() );
			?>

			<h1><?php esc_html_e( 'Your Website is now optimized much better than before!', 'porto' ); ?></h1>

			<form method="post">
			<?php
			$plugins = $this->_get_plugins();
			if ( count( $plugins['all'] ) ) {
				?>
				<p style="color: #c00;"><?php esc_html_e( 'Note: You should disable below plugins while development. They may affect your changes not applied.', 'porto' ); ?></p>
				<ul class="porto-setup-wizard-plugins">
				<?php foreach ( $plugins['all'] as $slug => $plugin ) { ?>
					<li data-slug="<?php echo esc_attr( $slug ); ?>">
						<label class="checkbox checkbox-inline">
							<input type="checkbox" name="setup-plugin">
							<?php
								$key = '';
							if ( isset( $plugins['install'][ $slug ] ) ) {
								$key = esc_html__( 'Install', 'porto' );
							} elseif ( isset( $plugins['update'][ $slug ] ) ) {
								$key = esc_html__( 'Update', 'porto' );
							} elseif ( isset( $plugins['activate'][ $slug ] ) ) {
								$key = esc_html__( 'Activate', 'porto' );
							}
							?>
							<?php /* translators: %s: Plugin url and name */ ?>
							<?php printf( __( $key . ' <a href="%s" target="_blank">%s</a>', 'porto' ), 'https://wordpress.org/plugins/' . esc_attr( $slug ) . '/', $plugin['name'] ); ?>
							<span></span>
						</label>
						<div class="spinner"></div>
						<?php if ( $plugin['desc'] ) : ?>
							<p><?php echo esc_html( $plugin['desc'] ); ?></p>
						<?php endif; ?>
					</li>
				<?php } ?>
				</ul>
			<?php } ?>
				<ul>
					<li class="howto">
						<a href="https://gtmetrix.com/leverage-browser-caching.html" target="_blank"><?php esc_html_e( 'How to enable leverage browser  caching.', 'porto' ); ?></a>
						<p>Page load times can be significantly improved by asking visitors to save and reuse the files included in your website.</p>
					</li>
				</ul>

				<p class="porto-setup-actions step">
					<?php if ( count( $plugins['all'] ) ) : ?>
						<a href="#" class="button-primary button button-large button-next" data-callback="install_plugins"><?php esc_html_e( 'Install Plugins', 'porto' ); ?></a>
					<?php endif; ?>
					<?php wp_nonce_field( 'porto-setup' ); ?>
					<a class="button button-large" href="<?php echo esc_url( home_url() ); ?>"><?php esc_html_e( 'View your new website!', 'porto' ); ?></a>
				</p>
			</form>
			<?php
		}

		public function ajax_plugins() {
			if ( ! check_ajax_referer( 'porto_speed_optimize_wizard_nonce', 'wpnonce' ) || empty( $_POST['slug'] ) ) {
				wp_send_json_error(
					array(
						'error'   => 1,
						'message' => esc_html__(
							'No Slug Found',
							'porto'
						),
					)
				);
			}
			$json = array();
			// send back some json we use to hit up TGM
			$plugins = $this->_get_plugins();
			// what are we doing with this plugin?
			foreach ( $plugins['activate'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => esc_url( admin_url( $this->tgmpa_url ) ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-activate',
						'action2'       => -1,
						'message'       => esc_html__( 'Activating Plugin', 'porto' ),
					);
					break;
				}
			}
			foreach ( $plugins['update'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => esc_url( admin_url( $this->tgmpa_url ) ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-update',
						'action2'       => -1,
						'message'       => esc_html__( 'Updating Plugin', 'porto' ),
					);
					break;
				}
			}
			foreach ( $plugins['install'] as $slug => $plugin ) {
				if ( $_POST['slug'] == $slug ) {
					$json = array(
						'url'           => esc_url( admin_url( $this->tgmpa_url ) ),
						'plugin'        => array( $slug ),
						'tgmpa-page'    => $this->tgmpa_menu_slug,
						'plugin_status' => 'all',
						'_wpnonce'      => wp_create_nonce( 'bulk-plugins' ),
						'action'        => 'tgmpa-bulk-install',
						'action2'       => -1,
						'message'       => esc_html__( 'Installing Plugin', 'porto' ),
					);
					break;
				}
			}

			if ( $json ) {
				$json['hash'] = md5( serialize( $json ) ); // used for checking if duplicates happen, move to next plugin
				wp_send_json( $json );
			} else {
				wp_send_json(
					array(
						'done'    => 1,
						'message' => esc_html__(
							'Success',
							'porto'
						),
					)
				);
			}
			exit;
		}

		private function _get_plugins() {
			$instance         = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
			$plugin_func_name = 'is_plugin_active';
			$plugins          = array(
				'all'      => array(), // Meaning: all plugins which still have open actions.
				'install'  => array(),
				'update'   => array(),
				'activate' => array(),
			);

			foreach ( $instance->plugins as $slug => $plugin ) {
				if ( ! isset( $plugin['visibility'] ) || 'speed_wizard' != $plugin['visibility'] || $instance->$plugin_func_name( $slug ) && false === $instance->does_plugin_have_update( $slug ) ) {
					continue;
				} else {
					$plugins['all'][ $slug ] = $plugin;

					if ( ! $instance->is_plugin_installed( $slug ) ) {
						$plugins['install'][ $slug ] = $plugin;
					} else {
						if ( false !== $instance->does_plugin_have_update( $slug ) ) {
							$plugins['update'][ $slug ] = $plugin;
						}

						if ( $instance->can_plugin_activate( $slug ) ) {
							$plugins['activate'][ $slug ] = $plugin;
						}
					}
				}
			}
			return $plugins;
		}

		/**
		 * Get unused shortcodes list
		 */
		public function get_unused_shortcodes() {
			$all_shortcodes    = $this->get_all_shortcode_list();
			$used_shortcodes   = $this->get_used_shortcode_list();
			$unused_shortcodes = array_diff( $all_shortcodes, $used_shortcodes );
			echo json_encode( $unused_shortcodes );
			die();
		}

		/**
		 * Get All Shortcodes List
		 */
		private function get_all_shortcode_list() {
			$shortcode_list = array();
			if ( ! class_exists( 'WPBMap' ) ) {
				if ( class_exists( 'PortoShortcodesClass' ) ) {
					$shortcode_list = array_merge( PortoShortcodesClass::$shortcodes, PortoShortcodesClass::$woo_shortcodes );
				}
			} else {
				$all_vc_shortcodes = WPBMap::getAllShortCodes();
				$all_vc_categories = WPBMap::getCategories();
				if ( ! empty( $all_vc_shortcodes ) ) {
					foreach ( $all_vc_shortcodes as $key => $s ) {
						if ( 'vc_row' == $key || 'vc_row_inner' == $key || 'vc_column' == $key || 'vc_column_inner' == $key ) {
							continue;
						}
						$shortcode_list[] = $key;
					}
				}
			}
			return apply_filters( 'porto_all_shortcode_list', $shortcode_list );
		}

		/**
		 * Get shortcodes from porto header builder html elements
		 */
		private function header_builder_html_shortcode( $elements ) {
			if ( ! $elements || empty( $elements ) ) {
				return false;
			}
			$post_short_contents = array();
			foreach ( $elements as $element ) {
				if ( is_array( $element ) ) {
					$result = $this->header_builder_html_shortcode( $element );
					if ( ! empty( $result ) ) {
						$post_short_contents = array_merge( $post_short_contents, $result );
					}
				} else {
					foreach ( $element as $key => $value ) {
						if ( 'html' == $key && $value ) {
							$str = '';
							if ( is_string( $value ) ) {
								$str = $value;
							} elseif ( is_object( $value ) && isset( $value->html ) ) {
								$str = $value->html;
							}
							if ( $str ) {
								$post_short_contents[] = $str;
							}
						}
					}
				}
			}
			return $post_short_contents;
		}

		/**
		 * Get Used Shortcodes List
		 */
		private function get_used_shortcode_list( $shortcode_list = array(), $return_ids = false, $attrs = array() ) {
			if ( empty( $shortcode_list ) ) {
				$shortcode_list = $this->get_all_shortcode_list();
			}
			global $wpdb, $porto_settings;
			$post_contents = $wpdb->get_results( $wpdb->prepare( "SELECT ID, post_content, post_excerpt FROM $wpdb->posts WHERE post_type not in (%s, %s) AND post_status = 'publish' AND (post_content != '' or post_excerpt != '')", 'revision', 'attachment' ) );

			$post_meta_contents = $wpdb->get_results( $wpdb->prepare( "SELECT post_id as ID, meta_value as post_content FROM $wpdb->postmeta WHERE meta_key in (%s, %s) and meta_value != ''", 'video_code', 'member_overview' ) );
			$post_contents      = array_merge( $post_contents, $post_meta_contents );

			$sidebars_array = get_option( 'sidebars_widgets' );
			if ( empty( $post_contents ) || ! is_array( $post_contents ) ) {
				$post_contents = array();
			}
			foreach ( $sidebars_array as $sidebar => $widgets ) {
				if ( ! empty( $widgets ) && is_array( $widgets ) ) {
					foreach ( $widgets as $sidebar_widget ) {
						$widget_type = trim( substr( $sidebar_widget, 0, strrpos( $sidebar_widget, '-' ) ) );
						if ( ! array_key_exists( $widget_type, $post_contents ) ) {
							$post_contents[ $widget_type ] = get_option( 'widget_' . $widget_type );
						}
					}
				}
			}

			$porto_settings_keys = array(
				'footer-tooltip',
				'welcome-msg',
				'header-contact-info',
				'menu-title',
				'menu-block',
				'header-copyright',
				'post-banner-block',
				'portfolio-banner-block',
				'member-banner-block',
				'event-banner-block',
			);
			$custom_tabs_count   = isset( $porto_settings['product-custom-tabs-count'] ) ? (int) $porto_settings['product-custom-tabs-count'] : 2;
			for ( $index = 1; $index <= $custom_tabs_count; $index++ ) {
				$porto_settings_keys[] = 'custom_tab_content' . $index;
			}
			foreach ( $porto_settings_keys as $key ) {
				if ( isset( $porto_settings[ $key ] ) ) {
					$post_contents[] = $porto_settings[ $key ];
				}
			}

			// header builder elements
			$current_layout  = porto_header_builder_layout();
			$header_elements = isset( $current_layout['elements'] ) ? $current_layout['elements'] : array();
			foreach ( $header_elements as $elements ) {
				$elements = json_decode( $elements );
				$result   = $this->header_builder_html_shortcode( $elements );
				if ( ! empty( $result ) ) {
					$post_contents = array_merge( $post_contents, $result );
				}
			}

			$used = array();
			if ( $return_ids ) {
				foreach ( $post_contents as $post_content ) {
					if ( isset( $post_content->ID ) ) {
						$content = $post_content->post_content;
						foreach ( $shortcode_list as $shortcode ) {
							if ( false === strpos( $content, '[' ) && false === strpos( $content, 'wp:porto/porto-' ) ) {
								continue;
							}
							if ( empty( $attrs ) && ! in_array( $post_content->ID, $used ) && ( stripos( $content, '[' . $shortcode . ' ' ) !== false || stripos( $content, 'wp:porto/' . str_replace( '_', '-', $shortcode ) ) !== false ) ) {
								$used[] = $post_content->ID;
							} elseif ( ! empty( $attrs ) && ! in_array( $post_content->ID, $used ) ) {
								$attr_text  = '';
								$attr_text1 = '';
								foreach ( $attrs as $key => $value ) {
									$attr_text = $key . '="' . $value . '"';
									if ( 'yes' == $value ) {
										$attr_text1 = '"' . $key . '":true';
									} else {
										$attr_text1 = '"' . $key . '":"' . $value . '"';
									}
								}
								if ( preg_match( '/\[' . $shortcode . '\s[^]]*' . $attr_text . '[^]]*\]/', $content ) || preg_match( '/wp:porto\/' . str_replace( '_', '-', $shortcode ) . '\s[^>]*' . $attr_text1 . '[^>]*\>/', $content ) ) {
									$used[] = $post_content->ID;
								}
							}
						}
					}
				}

				if ( defined( 'ELEMENTOR_VERSION' ) ) {
					$post_ids = array();
					foreach ( $shortcode_list as $shortcode ) {
						$arr = $wpdb->get_results( 'SELECT m.post_id AS id, m.meta_value AS data FROM ' . esc_sql( $wpdb->postmeta ) . ' AS m INNER JOIN ' . esc_sql( $wpdb->posts ) . ' AS p ON m.post_id = p.ID WHERE p.post_status = "publish" AND p.post_type NOT IN ( "revision", "attachment" ) AND m.meta_key="_elementor_data" AND m.meta_value LIKE "%' . esc_sql( $wpdb->esc_like( '"widgetType":"' . $shortcode . '"' ) ) . '%"' );
						if ( is_array( $arr ) ) {
							foreach ( $arr as $v ) {
								if ( ! array_key_exists( $v->id, $post_ids ) ) {
									$post_ids[ $v->id ] = $v->data;
								}
							}
						}
					}
					foreach ( $post_ids as $post_id => $data ) {
						$data = json_decode( $data, true );
						if ( ! in_array( $post_id, $used ) && $this->elementor_check_widgets( $data, $shortcode_list, $attrs ) ) {
							$used[] = $post_id;
						}
					}
				}
			} else {
				$excerpt_arr = array(
					'post_content',
					'post_excerpt',
				);
				foreach ( $post_contents as $post_content ) {
					foreach ( $excerpt_arr as $excerpt_key ) {
						if ( is_string( $post_content ) && 'post_excerpt' == $excerpt_key ) {
							break;
						}
						if ( ! is_string( $post_content ) && 'post_excerpt' == $excerpt_key && ! isset( $post_content->post_excerpt ) ) {
							break;
						}
						$content = is_string( $post_content ) ? $post_content : ( isset( $post_content->{$excerpt_key} ) ? $post_content->{$excerpt_key} : '' );

						foreach ( $shortcode_list as $shortcode ) {
							if ( false === strpos( $content, '[' ) && false === strpos( $content, 'wp:porto/porto-' ) ) {
								continue;
							}
							if ( ! in_array( $shortcode, $used ) && ( stripos( $content, '[' . $shortcode . ' ' ) !== false || stripos( $content, 'wp:porto/' . str_replace( '_', '-', $shortcode ) ) !== false ) ) {
								$used[] = $shortcode;
							}
						}
						$shortcode_list = array_diff( $shortcode_list, $used );
					}
				}

				if ( defined( 'ELEMENTOR_VERSION' ) ) {
					$widgets = array(
						'porto_blog',
						'porto_portfolios',
						'porto_products',
						'porto_ultimate_heading',
						'porto_info_box',
						'porto_recent_posts',
						'porto_stat_counter',
						'porto_one_page_category_products',
						'porto_modal',
						'porto_products_filter',
					);
					$widgets = array_diff( $widgets, $used );
					foreach ( $widgets as $widget ) {
						$post_ids = $wpdb->get_col( 'SELECT post_id FROM ' . $wpdb->postmeta . ' as meta left join ' . $wpdb->posts . ' as posts on meta.post_id = posts.ID WHERE posts.post_type not in ("revision", "attachment") AND posts.post_status = "publish" and meta_key = "_elementor_data" and meta_value LIKE \'%"widgetType":"' . $widget . '"%\'' );
						if ( ! empty( $post_ids ) ) {
							$used[] = $widget;
						}
					}

					$params = array(
						'porto_interactive_banner'       => array( 'as_param' => 'banner' ),
						'porto_interactive_banner_layer' => array( 'as_banner_layer' => 'yes' ),
						'porto_grid_container'           => array( 'as_param' => 'creative' ),
						'porto_grid_item'                => array( 'as_param' => 'grid_item' ),
					);
					foreach ( $params as $key => $param_arr ) {
						if ( in_array( $key, $used ) ) {
							continue;
						}
						$search_str = '';
						foreach ( $param_arr as $c => $n ) {
							if ( $search_str ) {
								$search_str .= ' AND';
							}
							$search_str .= ' meta_value LIKE \'%"' . $c . '":"' . $n . '"%\'';
						}
						$post_ids = $wpdb->get_col( 'SELECT post_id FROM ' . $wpdb->postmeta . ' as meta left join ' . $wpdb->posts . ' as posts on meta.post_id = posts.ID WHERE posts.post_type not in ("revision", "attachment") AND posts.post_status = "publish" and meta_key = "_elementor_data" and' . $search_str );
						if ( ! empty( $post_ids ) ) {
							$used[] = $key;
						}
					}
				}
			}

			return apply_filters( 'porto_used_shortcode_list', $used, $return_ids );
		}

		private function elementor_check_widgets( $data, $shortcode_list, $attrs ) {
			if ( empty( $attrs ) || empty( $data ) ) {
				return false;
			}
			foreach ( $data as $d ) {
				if ( ! empty( $d['elements'] ) ) {
					$result = $this->elementor_check_widgets( $d['elements'], $shortcode_list, $attrs );
					if ( $result ) {
						return true;
					}
				} elseif ( isset( $d['widgetType'] ) && in_array( $d['widgetType'], $shortcode_list ) ) {
					$attr_exists = true;
					foreach ( $attrs as $key => $val ) {
						if ( ! isset( $d['settings'][ $key ] ) || $val !== $d['settings'][ $key ] ) {
							$attr_exists = false;
							break;
						}
					}
					if ( $attr_exists ) {
						return true;
					}
				}
			}
			return false;
		}

	}
}

add_action( 'after_setup_theme', 'porto_speed_optimize_wizard', 10 );

if ( ! function_exists( 'porto_speed_optimize_wizard' ) ) :
	function porto_speed_optimize_wizard() {
		Porto_Speed_Optimize_Wizard::get_instance();
	}
endif;
