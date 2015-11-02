<?php
/**
 * Display a contribution's attachments
 *
 * @since 1.2.0
 *
 * @author SkyVerge
 * @package WC-Product-Reviews-Pro/Templates
 * @version 1.2.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>

<?php if ( 'photo' == $contribution->get_attachment_type() ) : ?>

    <?php if ( $image = wc_product_reviews_pro_get_contribution_attachment_image( $contribution ) ) : ?>

        <?php if ( $wrap_microdata ) : ?>
            <span itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
        <?php endif; ?>

        <?php echo $image; ?>

        <?php if ( $wrap_microdata ) : ?>
            </span>
        <?php endif; ?>

    <?php else : ?>
        <p class="attachment-removed"><?php _e( 'Photo has been removed', WC_Product_Reviews_Pro::TEXT_DOMAIN ); ?></p>
    <?php endif; ?>

<?php endif; ?>

<?php if ( 'video' == $contribution->get_attachment_type() ) : ?>

    <?php if ( $attachment_url = $contribution->get_attachment_url() ) : ?>

        <?php if ( $wrap_microdata ) : ?>
            <span itemprop="associatedMedia" itemscope itemtype="http://schema.org/VideoObject">
        <?php endif; ?>

        <?php $embed_code = wp_oembed_get( $attachment_url ); ?>
        <?php echo $embed_code ? $embed_code : sprintf( '<a href="%s">%s</a>', esc_url( $attachment_url ), $attachment_url ); ?>

        <?php if ( $wrap_microdata ) : ?>
            </span>
        <?php endif; ?>

    <?php else : ?>
        <p class="attachment-removed"><?php _e( 'Video has been removed', WC_Product_Reviews_Pro::TEXT_DOMAIN ); ?></p>
    <?php endif; ?>

<?php endif; ?>
