<?php
/**
 * Display Review contributions
 *
 * @since 1.2.0
 *
 * @author SkyVerge
 * @package WC-Product-Reviews-Pro/Templates
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$rating = $contribution->get_rating();
$title  = $contribution->get_title();
$rating_enabled = $rating && get_option( 'woocommerce_enable_review_rating' ) == 'yes';
?>
<li itemprop="review" itemscope itemtype="http://schema.org/Review" <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">

	<div id="comment-<?php comment_ID(); ?>" class="comment_container">

		<?php // Display the karma markup.
		wc_product_reviews_pro_contribution_karma( $contribution ); ?>

		<div class="comment-text">

			<?php echo get_avatar( $comment, apply_filters( 'woocommerce_review_gravatar_size', '60' ), '', get_comment_author() ); ?>

			<?php if ( $title || $rating_enabled ) : ?>

				<h3 class="contribution-title review-title">

					<?php if ( $rating_enabled ) : ?>

						<span itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo esc_attr( sprintf( __( 'Rated %d out of 5', WC_Product_Reviews_Pro::TEXT_DOMAIN ), $rating ) ); ?>">
							<span style="width:<?php echo esc_attr( ( $rating / 5 ) * 100 ); ?>%">
								<?php printf( __( '<strong itemprop="ratingValue">%d</strong> out of 5', WC_Product_Reviews_Pro::TEXT_DOMAIN ), esc_attr( $rating ) ) ; ?>
							</span>
						</span>

					<?php endif; ?>

					<?php if ( $title ) : ?>

						<span itemprop="name"><?php echo esc_html( $title ); ?></span>

					<?php endif; ?>

				</h3>

			<?php endif; ?>

			<?php // Display the meta markup.
			wc_product_reviews_pro_contribution_meta( $contribution ); ?>

			<?php wc_product_reviews_pro_review_qualifiers( $contribution ); ?>

			<div itemprop="reviewBody" class="description"><?php comment_text(); ?></div>

			<?php // Display the attachments.
			wc_product_reviews_pro_contribution_attachments( $contribution ); ?>

			<?php // Display the actions markup.
			wc_product_reviews_pro_contribution_actions( $contribution ); ?>

			<?php wc_product_reviews_pro_contribution_flag_form( $comment ); ?>

		</div>
	</div>
