<?php
/**
 * Welcome Screen Class
 * Sets up the welcome screen page, hides the menu item
 * and contains the screen content.
 */
class wptheme_Welcome_Screen {

	/**
	 * Constructor  
	 * Sets up the welcome screen
	 */
	public function __construct() {

		add_action( 'admin_menu', array( $this, 'wptheme_welcome_register_menu' ) );
		add_action( 'load-themes.php', array( $this, 'wptheme_activation_admin_notice' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'wptheme_welcome_style' ) );
		add_action( 'wptheme_welcome', array( $this, 'wptheme_welcome_page' ), 			10 );


	} // end constructor

	/**
	 * Adds an admin notice upon successful activation.
	 * @since 0.1
	 */
	public function wptheme_activation_admin_notice() {
		global $pagenow;

		if ( is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) { // input var okay
			add_action( 'admin_notices', array( $this, 'wptheme_welcome_admin_notice' ), 99 );
		}
	}

	/**
	 * Display an admin notice linking to the welcome screen
	 * @since 0.1
	 */
	public function wptheme_welcome_admin_notice() {
		?>
			<div class="updated notice is-dismissible">
				<p><?php echo sprintf( esc_html__( 'Thanks for choosing wptheme! Learn how to get the most out of your new theme on the %swelcome screen%s.', 'wptheme' ), '<a href="' . esc_url( admin_url( 'themes.php?page=wptheme-welcome' ) ) . '">', '</a>' ); ?></p>
				<p><a href="<?php echo esc_url( admin_url( 'themes.php?page=wptheme-welcome' ) ); ?>" class="button" style="text-decoration: none;"><?php _e( 'Get started with wptheme', 'wptheme' ); ?></a></p>
			</div>
		<?php
	}

	/**
	 * Load welcome screen css
	 * @return void
	 * @since  0.1
	 */
	public function wptheme_welcome_style() {
		
		wp_enqueue_style( 'wptheme-welcome-screen', get_template_directory_uri() . '/inc/admin/css/welcome.css' );
	}

	/**
	 * Creates the dashboard page
	 * @see  add_theme_page()
	 * @since 1.0.0
	 */
	public function wptheme_welcome_register_menu() {
		add_theme_page( 
		'wptheme Theme Welcome Page',
		'wptheme Theme',
		'read',
		'wptheme-welcome',
		array( $this, 'wptheme_welcome_screen' )
		);
	}

	/**
	 * The welcome screen
	 * @since 1.0.0
	 */
	public function wptheme_welcome_screen() {
		?>
		<div class="wrap about-wrap">

			<?php  do_action( 'wptheme_welcome' ); ?>

		</div>
		<?php
	}


	public function wptheme_welcome_page() {
		get_template_part( 'inc/admin/welcome' );
	}



}

$GLOBALS['wptheme_Welcome_Screen'] = new wptheme_Welcome_Screen();