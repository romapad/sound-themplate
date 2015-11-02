<?php
/**
 * Display the review qualifiers
 *
 * @since 1.0.0
 *
 * @author SkyVerge
 * @package WC-Product-Reviews-Pro/Templates
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Output review qualifiers for contribution
 *
 * @since 1.0.0
 */

global $product;

$review_qualifiers = wp_get_post_terms( $product->id, 'product_review_qualifier' );
?>

<?php if ( ! empty( $review_qualifiers ) ) :  ?>

<div class="contribution-review-qualifiers">
	<?php foreach ( $review_qualifiers as $review_qualifier ) : ?>

		<?php if ( $value = get_comment_meta( $contribution->get_id(), 'wc_product_reviews_pro_review_qualifier_' . $review_qualifier->term_id, true ) ) : ?>
			<p>
				<strong class="review-qualifier-title"><?php echo $review_qualifier->name; ?></strong>
				<span class="review-qualifier-value"><?php echo $value; ?></span>
			</p>
		<?php endif; ?>

	<?php endforeach; ?>
</div>

<?php endif; ?>
