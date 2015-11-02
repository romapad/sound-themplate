<?php
/**
 * Display Video contributions
 *
 * @since 1.2.0
 *
 * @author SkyVerge
 * @package WC-Product-Reviews-Pro/Templates
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<li itemprop="video" itemscope itemtype="http://schema.org/VideoObject" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<?php // Display the karma markup.
		wc_product_reviews_pro_contribution_karma( $contribution ); ?>

		<div class="comment-text">

			<?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '60' ), '', get_comment_author() ); ?>

			<?php if ( $title = $contribution->get_title() ) : ?>
				<h3 class="contribution-title video-title" itemprop="name">
					<?php echo esc_html( $title ); ?>
				</h3>
			<?php endif; ?>

			<?php // Display the meta markup.
			wc_product_reviews_pro_contribution_meta( $contribution ); ?>

			<div itemprop="description" class="description"><?php comment_text(); ?></div>

			<?php // Display the attachments.
			wc_product_reviews_pro_contribution_attachments( $contribution, false ); ?>

			<?php // Display the actions markup.
			wc_product_reviews_pro_contribution_actions( $contribution ); ?>

			<?php wc_product_reviews_pro_contribution_flag_form( $comment ); ?>

		</div>
	</div>
