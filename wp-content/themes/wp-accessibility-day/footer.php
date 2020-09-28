<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package gutenberg-starter-theme
 */

?>

<footer id="colophon" class="site-footer">
	<div class="site-info">
		<div class="event-info"><p>Follow us on Twitter: <a href="https://twitter.com/hashtag/WPAccessibilityDay">#WPAccessibilityDay</a> <a href="https://twitter.com/hashtag/WPAD2020">#WPAD2020</a> <a href="https://twitter.com/WPAccessibility">@WPAccessibility</a></p></div>

		<div class="event-sponsors">
		<h2>Meet our Sponsors</h2>
		<p>Our amazing and generous sponsors have made this event possible! Please give our sponsors a visit and thank them for their support!</p>
		<h3>Gold Sponsors</h3>
		<ul class='gold'>
			<li><a href="https://yoast.com/"><img src="https://wpaccessibilityday.org/wpaccessibilityday/wp-content/uploads/2020/08/Yoast_Logo_tagline_Large_RGB.png" alt="Yoast SEO"></a></li>
			<li><a href="https://infoaxia.co.jp/"><img src="https://wpaccessibilityday.org/wpaccessibilityday/wp-content/uploads/2020/08/Infoaxia_logo_Global-1.png" alt="Infoaxia Tokyo, Japan"></a></li>
			<li><a href="https://www.godaddy.com/pro?utm_source=events_sponsor_page&utm_medium=events&utm_campaign=en-us_events_prd_awa_partners_part_wpad_conf_001"><img src="https://wpaccessibilityday.org/wpaccessibilityday/wp-content/uploads/2020/08/GD_PRO_RGB_BLACK.svg" alt="GoDaddy Pro"></a></li>
		</ul>
		<h3>Silver Sponsors</h3>
		<ul class='silver'>
			<li><a href="https://a11y-collective.com/"><img src="https://wpaccessibilityday.org/wpaccessibilityday/wp-content/uploads/2020/08/A11Y-Collective-Logo.png" alt="The A11y Collective"></a></li>
			<li><a href="https://alley.co/"><img src="https://wpaccessibilityday.org/wpaccessibilityday/wp-content/uploads/2020/09/alley_logotype-transparent-rgb-1024x635.png" alt="Alley"></a></li>
			<li><a href="https://americaneagle.com/"><img src="https://wpaccessibilityday.org/wpaccessibilityday/wp-content/uploads/2020/09/Americaneaglecom_Logo_2020.jpg" alt="American Eagle"></a></li>
		</ul>
		<h3>Bronze Sponsors</h3>
		<ul class='bronze'>
			<li><a href="https://rocketvalidator.com/"><img src="https://wpaccessibilityday.org/wpaccessibilityday/wp-content/uploads/2020/08/rocket-validator-dark.png" alt="Rocket Validator"></a></li>
			<li><a href="https://www.joedolson.com/"><img src="https://wpaccessibilityday.org/wpaccessibilityday/wp-content/uploads/2020/08/awd_logo_sm_print.jpg" alt="Joe Dolson Accessible Web Design"></a></li>
			<li><a href="https://www.codegeek.net/"><img src="https://wpaccessibilityday.org/wpaccessibilityday/wp-content/uploads/2020/09/CG-Logo-Lines-Pos-RGB-300dpi-1024x712.png" alt="CodeGeek"></a></li>
			<li><a href="https://bhmbizsites.com/"><img src="https://wpaccessibilityday.org/wpaccessibilityday/wp-content/uploads/2020/09/bhm-2020-logo.jpg" alt="Bet Hannon Business Websites"></a></li>
			<li><a href="https://www.nerdpress.net/"><img src="https://wpaccessibilityday.org/wpaccessibilityday/wp-content/uploads/2020/09/nerdpress-logo-blue-transparent-3630x820-1-1024x231.png" alt="nerdpress"></a></li>
		</ul>
		</div>
		<?php
		/* translators: %s: CMS name, i.e. WordPress. */
		printf( esc_html__( 'Proudly powered by %s', 'gutenberg-starter-theme' ), '<a href="https://wordpress.org/">WordPress</a>' );
		?>
		<span class="sep"> | </span>
		<?php
			/* translators: 1: Theme name, 2: Theme author. */
			printf( esc_html__( 'Theme: %s', 'gutenberg-starter-theme' ), '<a href="https://github.com/WordPress/gutenberg-starter-theme/">Gutenberg Starter Theme</a>' );
		?>
		<span class="sep"> | </span>
		<?php
			/* translators: 1: Theme name, 2: Theme author. */
			printf( esc_html__( 'Hosting: %s', 'gutenberg-starter-theme' ), '<a href="https://whodunit.fr">Whodunit</a>' );
		?>
	</div><!-- .site-info -->
</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
