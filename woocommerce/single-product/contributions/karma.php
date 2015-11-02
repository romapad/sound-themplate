<?php
/**
 * Display a contribution's upvotes and downvotes
 *
 * @since 1.2.0
 *
 * @author SkyVerge
 * @package WC-Product-Reviews-Pro/Templates
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<small class="contribution-karma">
    <?php if ( $contribution->get_vote_count() ) : ?>
        <?php printf( __( '%1$d out of %2$d people found this helpful', WC_Product_Reviews_Pro::TEXT_DOMAIN ), $contribution->get_positive_votes(), $contribution->get_vote_count() ); ?>
    <?php endif; ?>
</small>
