<?php
/**
 * Template for displaying content of page for processing checkout feature.
 *
 * @author   ThimPress
 * @package  LearnPress/Templates
 * @version  4.0.0
 */

namespace App;

defined( 'ABSPATH' ) or die;

/**
 * Header for page
 */
echo template('partials.head');
do_action('get_header');
echo template('partials.header-course');

// do_action( 'learn-press/before-main-content' );
do_action( 'learnpress/template/pages/checkout/before-content' );
?>


<main class="quiz">
	<div class="container">
		<div id="learn-press-checkout"  class="quiz__container lp-content-wrap">
			<h4 class="quiz__title"><?php the_title(); ?></h4>

			<?php
			/**
			 * LP Hook
			 *
			 * @since 4.0.0
			 */
			do_action( 'learn-press/before-checkout-page' );

			// Shortcode for displaying checkout form
			echo do_shortcode( '[learn_press_checkout]' );

			/**
			 * LP Hook
			 *
			 * @since 4.0.0
			 */
			do_action( 'learn-press/after-checkout-page' );
			?>

		</div>
	</div>
</main>

<?php
do_action( 'learn-press/after-main-content' );
// do_action( 'learnpress/template/pages/checkout/after-content' );

/**
 * Footer for page
 */
do_action('get_footer');
echo template('partials.footer');
wp_footer();