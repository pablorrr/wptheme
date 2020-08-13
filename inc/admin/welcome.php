<div class="col two-col" style="margin-bottom: 1.618em; overflow: hidden;">
    <div class="col">
        <h1 style="margin-right: 0;"><?php echo '<strong>wptheme</strong>'; ?></h1>
        <?php $formatted_string = wpautop('				In this theme you can:

														
														- print phone number
														- print opening time

														'); ?>


        <p style="font-size: 1.2em;"><?php _e($formatted_string, 'wptheme'); ?></p>

    </div>

    <div class="col last-feature">
        <img src="<?php echo esc_url(get_template_directory_uri()) . '/screenshot.png'; ?>" alt="wptheme"
             class="image-50" width="440"/>
    </div>
</div>
<div id="" class="col two-col panel"  style="margin-bottom: 1.618em; padding-top: 1.618em; overflow: hidden;">

    <h2><?php echo sprintf(esc_html__('Welcome to the %swptheme%s Theme , enjoy it!!!', 'wptheme'), '<strong>', '</strong>'); ?></h2>
    <p class="tagline"><?php _e('The theme contains many ways to configure.', 'wptheme'); ?></p>

    <div class="col-1">




        <!-- AJAX lOAD POSTS BUTTON WITH JETPACK -->
        <h4><?php _e('Load your posts with the Ajax through jetpack &nbsp <span class="dashicons dashicons-format-aside"></span>', 'wptheme'); ?></h4>
        <p><?php _e('To load posts using the Ajax button, download and activate the Jetpack plugin and then configure the plugin settings. Go to the Reading Settings and set the number of posts loaded on the page. Make sure that the Jetpack plugin option is selected in this section.Of course, you should first drag all segments to the container to the right in the Theme Options.', 'wptheme'); ?></p>
        <p><?php printf(wp_kses(__(' <a href="%1$s" target="%2$s" class="%3$s">Open Reading Settings</a>', 'wptheme'), array('a' => array('href' => array(), 'target' => array(), 'class' => array()))),
                esc_url(self_admin_url('options-reading.php')), '_blank', 'button'); ?></p>

        <!-- MENUS -->
        <h4><?php _e('Configure menu location &nbsp<span class="dashicons dashicons-menu"></span>', 'wptheme'); ?></h4>
        <p><?php _e('Configure your menu. The theme supports scrolling from the menu to selected segments on the front page. To do this, go to the Menu in the Administration Panel, choose your own links and paste - (http: // yourdomainname / #services) and add to the Menu. Other names of segments to be used are: restaurants, booking, slideshow, contact, menu, opinion, team, about_us, gallery', 'wptheme'); ?></p>
        <p><a href="<?php echo esc_url(self_admin_url('nav-menus.php')); ?>" target="_blank"
              class="button"><?php _e('Configure menus', 'wptheme'); ?></a></p>

    </div><!--.col-1-->

    <div class="col-2 last-feature">


        <!-- SET UP CUSTOM PERMALINKS -->
        <h4><?php _e('Set up your permalinks &nbsp <span class="dashicons dashicons-admin-site"></span>', 'wptheme'); ?></h4>

        <p><?php echo sprintf(esc_html__('Create %sCustom Links%s to this theme. Customized links simplify the readability of links and are more friendly seo.', 'wptheme'), '<strong>', '</strong>'); ?>
            <a href="https://codex.wordpress.org/Using_Permalinks"> Visit Wordpress Codex</a> to see custom permalinks
            examples. Recommended custom permalink: /%category%/%postname%/</p>
        <p><?php printf(wp_kses(__(' <a href="%1$s" target="%2$s" class="%3$s">Open Permalink Settings</a>', 'wptheme'), array('a' => array('href' => array(), 'target' => array(), 'class' => array()))),
                esc_url(self_admin_url('options-permalink.php')), '_blank', 'button'); ?></p>

        <!-- WOOCOMMERCE  -->
        <h4><?php _e('Sell products through Woocommerce plugin &nbsp <span class="dashicons dashicons-cart"></span>', 'wptheme'); ?></h4>

        <p><?php _e('To sell products, download and install the Woocommerce plugin. It is necessary to pre-configure the plugin; create products, choose a template for a store, cart etc.', 'wptheme'); ?>
        </p>
        <p><a class="button" href="https://docs.woocommerce.com/document/start-with-woocommerce-in-5-steps/"
              target="_blank">Woocomerce link</a></p>

    </div><!--.col-2 .last-feature-->
</div><!--#lets_started-->
<?php
/**
 * Welcome screen add-ons template
 */
?>
<div id="" class="wptheme-add-ons panel" style="padding-top: 1.618em; clear: both;">
    <h2><?php echo  esc_html__( 'Install recommended plugins','wptheme'); ?></h2>

    <p class="tagline">
        <?php echo sprintf( esc_html__( 'Add to the subject plugins supporting take care of seo, security and 	inform users that you are using cookie in %swptheme%s', 'wptheme' ), '<strong>', '</strong>'); ?>
    </p>

    <div class="add-on">

        <div class="content">
            <!-- Plugins -->
            <div class="section plugins">
                <h4><?php _e( 'Install recommended plugins <span class="dashicons dashicons-admin-plugins"></span>' ,'wptheme' ); ?></h4>
                <p style="margin-bottom:10px;"><?php echo sprintf( esc_html__( '%sIncrease the functionality%s of your theme by applying extensions in the form of plugins. take care of seo, security on the network, cookie privacy policy and commercial selling- %sWoocommerce%s', 'wptheme' ), '<strong>', '</strong>', '<a target="_blank" href="' . esc_url('https://wordpress.org/plugins/woocommerce/') . '"><strong>', '</strong></a>'); ?></p>


                <p><a href="<?php echo esc_url( self_admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button button-primary"><?php _e( 'Install &amp; Activate Recommended Plugins', 'wptheme' ); ?></a></p>
            </div>
        </div>
    </div>

    <hr style="clear: both;" />
</div>
<?php
/**
 * Welcome screen add-ons template
 */
$formatted_string = wpautop('wptheme is a:
													- responsive ( Bootsrap 4 framework ),
													- customizable ( Wp Customizer),
													- translatable,
													- supported e-shoping ( Woocommerce )
													
							You can also extend possibilities of this theme by applying recommended plugins.			
 
							The theme includes the following template files:
										archive.php- for archive pages
										index.php
										page.php - for static pages
										header.php
										sidebar.php
										footer.php
										woocommerce.php -for supporting woocommerce (dispalying woo pages)
										functions.php
										 
										The theme supports featured images, menus and widgets.
										 
										Menus:
										The default menu is in header.php, and uses the Menus admin
										 
										Widget Areas
										There are three widget areas, all added via the widgets.php file in the footer.
										
							This theme takes advantage of these generous tools:

									

									WP Bootstrap Starter
									https://afterimagedesigns.com/wp-bootstrap-starter/
									https://afterimagedesigns.com/

									
									
							Theme Screenshot image from Pixabay:
									https://www.pexels.com/photo-license/
									
							License:
									License: GNU General Public License v2.0
									License URI:http://www.gnu.org/licenses/gpl-2.0.html'); ?>

<div id="" class="add-ons panel" style="padding-top: 1.618em; clear: both;">
    <h2><?php echo esc_html__('Read documentation', 'wptheme'); ?></h2>

    <p class="tagline">
        <?php echo $formatted_string; ?>
    </p>
    <hr style="clear: both;"/>
</div>
<?php
/**
 * Welcome screen who are woo template
 */
?>
<hr/>
<div id="" class="wptheme-add-ons panel" style="padding-top: 1.618em; clear: both;">

    <div class="col-1">

        <h2><?php echo esc_html__('About me', 'wptheme'); ?></h2>
        <p><?php _e( 'Im a freelancer.My passion is webmastering , especially Wordpress.', 'wptheme' ); ?></p>
        <p><?php echo sprintf( esc_html__('%sVisit my website%s', 'wptheme'), '<a href="https://www.websitecreator.cba.pl" target="_blank" class="button">', '</a>'); ?></p>
    </div>
</div>

