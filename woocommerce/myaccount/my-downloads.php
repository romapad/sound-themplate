<?php
/**
 * My Orders
 *
 * Shows recent orders on the account page
 *
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     2.0.0
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

function wdm_print_download_file_name( $download, $product_meta ) {
    if ( is_numeric( $download['downloads_remaining'] ) )
        echo apply_filters( 'woocommerce_available_download_count', '<span class="count">' . sprintf( _n( '%s download remaining', '%s downloads remaining', $download['downloads_remaining'], 'woocommerce' ), $download['downloads_remaining'] ) . '</span> ', $download );

    echo apply_filters( 'woocommerce_available_download_link', '<a href="' . esc_url( $download['download_url'] ) . '">' . $product_meta[$download['download_id']]['name'] . '</a>', $download ); //Print file name
}

if ( $downloads = WC()->customer->get_downloadable_products() ) :
    ?>
<div class="main digital-downloads">
        <?php
        $downloads_cat = array();
        $download_tag = array();
        foreach ( $downloads as $download2 ) {

            $term_list = wp_get_post_terms( $download2['product_id'], 'product_cat', array("fields" => "all"));
            $tags_list = wp_get_post_terms( $download2['product_id'], 'product_tag', array("fields" => "all"));
            $prod_cat_dw = $term_list[0]->name;
            $prod_tag_dw = $tags_list[0]->name;
            $download2['product_cat_dw'] = $prod_cat_dw;
            $download2['product_tag_dw'] = $prod_tag_dw;
            $download3[] = $download2;
        }

        foreach ( $download3 as $download4 ) {

            $prod_tag_dw = $download4['product_tag_dw'];

            if (!array_key_exists( $prod_tag_dw, $download_tag)):
                $download_tag[$prod_tag_dw] = array();
            endif;
            array_push($download_tag[$prod_tag_dw], $download4);
        }

        foreach ( $download_tag as $key => $value ) {
            $i = 0;
            $prod_cat_dw = $value[$i]['product_cat_dw'];
            if (!array_key_exists( $prod_cat_dw, $downloads_cat)):
                $downloads_cat[$prod_cat_dw] = array();
            endif;
            $downloads_cat[$prod_cat_dw][$key] = $value;
            $i++;
        }

        foreach ( $downloads_cat as $key => $value ) {
            echo '<div class="category_block">';
            echo '<h2>'. $key .' Downloads</h2>';
            foreach ( $value as $tags => $elements ) {
                echo '<div class="tag_block"><h4>'. $tags .'</h4><ul>';

                foreach ( $elements as $element ) {
                    do_action( 'woocommerce_available_download_start', $element );
                    $product_meta = get_post_meta( $element['product_id'], '_downloadable_files', true );

                    echo '<li>';
                    wdm_print_download_file_name( $element, $product_meta );
                    echo '</li>';
                    do_action( 'woocommerce_available_download_end', $element );
                }
                echo '</ul></div>';

            }
            echo '</div>';
        }
        echo '</div>';
endif; ?>
