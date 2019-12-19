<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 3/12/19
 * Time: 14:02
 */

function stm_ma_register_menu_page()
{
    add_menu_page(
        __( 'Motors App Settings', 'textdomain' ),
        'Motors App Settings',
        'manage_options',
        'ma_settings',
        'stm_ma_settings_page',
        '',
        6
    );
}

add_action( 'admin_menu', 'stm_ma_register_menu_page' );

/**
 * Display a custom menu page
 */
function stm_ma_settings_page()
{
    wp_enqueue_style( 'ma-bootstrap' );
    wp_enqueue_style( 'ma-multi-select' );
    wp_enqueue_style( 'ma-select2' );
    wp_enqueue_style( 'ma-styles' );
    wp_enqueue_script( 'ma-bootstrap' );
    wp_enqueue_script( 'ma-multi-select' );
    wp_enqueue_script( 'ma-select2' );
    wp_enqueue_script( 'ma-app' );

    require_once __DIR__ . '/admin/parts/main.php';
}

if ( !function_exists( 'stm_ma_generate_title_from_slugs' ) ) {
    function stm_ma_generate_title_from_slugs( $post_id, $title_from, $show_labels = false )
    {
        if ( !empty( $title_from ) ) {
            $title_return = '';
            $title = stm_ma_replace_curly_brackets( $title_from );
            $title_counter = 0;

            if ( !empty( $title ) ) {
                foreach ( $title as $title_part ) {
                    $title_counter++;
                    if ( $title_counter == 1 ) {
                        if ( $show_labels ) {
                            $title_return .= '<div class="labels">';
                        }
                    }

                    $term = wp_get_post_terms( $post_id, strtolower( $title_part ), array( 'orderby' => 'none' ) );
                    if ( !empty( $term ) and !is_wp_error( $term ) ) {
                        if ( !empty( $term[0] ) ) {
                            if ( !empty( $term[0]->name ) ) {
                                if ( $title_counter == 1 ) {
                                    $title_return .= $term[0]->name;
                                } else {
                                    $title_return .= ' ' . $term[0]->name;
                                }
                            } else {
                                $number_affix = get_post_meta( $post_id, strtolower( $title_part ), true );
                                if ( !empty( $number_affix ) ) {
                                    $title_return .= ' ' . $number_affix . ' ';
                                }
                            }
                        }
                    } else {
                        $number_affix = get_post_meta( $post_id, strtolower( $title_part ), true );
                        if ( !empty( $number_affix ) ) {
                            $title_return .= ' ' . $number_affix . ' ';
                        }
                    }
                    if ( $show_labels and $title_counter == 2 ) {
                        $title_return .= '</div>';
                    }
                }
            }

            if ( empty( $title_return ) ) {
                $title_return = get_the_title( $post_id );
            }
        }

        return $title_return;
    }
}

if ( !function_exists( 'stm_ma_replace_curly_brackets' ) ) {
    function stm_ma_replace_curly_brackets( $string )
    {
        $matches = array();
        //preg_match_all( '/{(.*?)}/', $string, $matches );


        return explode( ',', $string );
    }
}

function stm_ma_getoption_value( $id, $middle_info )
{
    $data_meta = get_post_meta( $id, $middle_info['slug'], true );
    $data_value = '';

    if ( $data_meta !== '' and $data_meta !== 'none' and $middle_info['slug'] != 'price' ):
        if ( !empty( $middle_info['numeric'] ) and $middle_info['numeric'] ):
            $affix = '';
            if ( !empty( $middle_info['number_field_affix'] ) ) {
                $affix = esc_html__( $middle_info['number_field_affix'], 'motors' );
            }
            $data_value = ucfirst( $data_meta ) . ' ' . $affix;
        else:
            $data_meta_array = explode( ',', $data_meta );
            $data_value = array();

            if ( !empty( $data_meta_array ) ) {
                foreach ( $data_meta_array as $data_meta_single ) {
                    $data_meta = get_the_terms( $id, $middle_info['slug'] );

                    if ( !empty( $data_meta ) and !is_wp_error( $data_meta ) ) {
                        foreach ( $data_meta as $data_metas ) {
                            $data_value[] = esc_attr( $data_metas->name );
                        }
                    }
                    break;
                }
            }

        endif;

    endif;

    return $data_value;
}

function stm_ma_get_option_key_value( $id, $middle_info )
{
    $data_meta = get_post_meta( $id, $middle_info['slug'], true );
    $data_value = '';

    if ( $data_meta !== '' and $data_meta !== 'none' and $middle_info['slug'] != 'price' ):
        if ( !empty( $middle_info['numeric'] ) and $middle_info['numeric'] ):
            if(in_array($middle_info['slug'], array('mileage', 'engine'))) {
                $data_value = $data_meta;
            } else {
                $data_value = array();
                $data_value[] = array($data_meta => ucfirst( $data_meta ));
            }
        else:
            $data_meta_array = explode( ',', $data_meta );

            if ( !empty( $data_meta_array ) ) {
                foreach ( $data_meta_array as $data_meta_single ) {
                    $data_meta = get_the_terms( $id, $middle_info['slug'] );

                    if ( !empty( $data_meta ) and !is_wp_error( $data_meta ) ) {
                        foreach ( $data_meta as $data_metas ) {
                            $data_value = array();
                            $data_value[] = array($data_metas->slug => esc_attr( $data_metas->name ));
                        }
                    }
                    break;
                }
            }

        endif;

    endif;

    return $data_value;
}

function stm_ma_get_tax_info( $id, $info )
{
    $middle_infos = stm_listings_attributes( array(
        'where' => array( 'slug' => $info ),
        'key_by' => ''
    ) );

    $optVal = stm_ma_getoption_value( $id, $middle_infos[0] );
    $dataInfo = ( is_array( $optVal ) ) ? implode( ' ', $optVal ) : $optVal;

    $ico = str_replace( array( 'stm-icon-', 'stm-boats-', 'stm-service-icon-', 'icon-' ), '', $middle_infos[0]['font'] );

    return array( 'info_1' => $middle_infos[0]['single_name'], 'info_2' => $dataInfo, 'info_3' => $ico );
}

function stm_ma_get_featured_listings( $ppp = 10 )
{
    $args = array(
        'post_type' => 'listings',
        'post_status' => 'publish',
        'posts_per_page' => $ppp
    );

    $args['meta_query'][] = array(
        'key' => 'special_car',
        'value' => 'on',
        'compare' => '='
    );

    $args['orderby'] = 'rand';

    $featuredQuery = new WP_Query( $args );

    $featured = array();

    if ( $featuredQuery->have_posts() ) {
        while ( $featuredQuery->have_posts() ) {
            $featuredQuery->the_post();

            $id = get_the_ID();

            $price = get_post_meta( $id, 'price', true );
            $sale_price = get_post_meta( $id, 'sale_price', true );

            if ( empty( $price ) and !empty( $sale_price ) ) {
                $price = $sale_price;
            }


            $featureImg = wp_get_attachment_image_url( get_post_thumbnail_id( $id ), 'stm-img-690-410' );

            if ( !$featureImg ) {
                $plchldr_id = get_option( 'plchldr_attachment_id', 0 );
                $featureImg = ( $plchldr_id == 0 ) ? STM_MOTORS_APP_URL . '/assets/img/car_plchldr.png' : wp_get_attachment_image_url( $plchldr_id );
            }

            if ( strpos( $featureImg, 'motors.loc' ) ) {
                $featureImg = stm_ma_replace_host( $featureImg );
            }

            $featured[] = array(
                'ID' => $id,
                'title' => get_the_title(),
                'views' => get_post_meta( get_the_ID(), 'stm_car_views', true ),
                'sold_status' => (get_post_meta( get_the_ID(), 'car_mark_as_sold', true )) ? get_post_meta( get_the_ID(), 'car_mark_as_sold', true ) : 'off',
                'price' => ( !empty( $price ) ) ? str_replace( '   ', ' ', stm_listing_price_view( trim( $price ) ) ) : 'No Price',
                'img' => $featureImg
            );

        }
    }

    wp_reset_postdata();

    return $featured;
}

function stm_ma_get_last_listings( $offset, $limit )
{
    $listings = new WP_Query( array(
        'post_type' => 'listings',
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'offset' => $offset,
        'orderby' => 'DESC'
    ) );

    $newListings = array();

    if ( $listings->have_posts() ) {
        $gridOpt = get_option( 'grid_view_settings', array() );
        $listOpt = get_option( 'list_view_settings', array() );

        $title = ( !empty( $gridOpt['go_two'] ) ) ? $gridOpt['go_two'] : '';
        $subTitle = ( !empty( $gridOpt['go_one'] ) ) ? $gridOpt['go_one'] : '';
        $info = ( !empty( $gridOpt['go_three'] ) ) ? $gridOpt['go_three'] : '';

        $listTitle = ( !empty( $listOpt['list_title'] ) ) ? $listOpt['list_title'] : '';
        $listInfoOne = ( !empty( $listOpt['list_info_one'] ) ) ? $listOpt['list_info_one'] : '';
        $listInfoTwo = ( !empty( $listOpt['list_info_two'] ) ) ? $listOpt['list_info_two'] : '';
        $listInfoThree = ( !empty( $listOpt['list_info_three'] ) ) ? $listOpt['list_info_three'] : '';
        $listInfoFour = ( !empty( $listOpt['list_info_four'] ) ) ? $listOpt['list_info_four'] : '';

        while ( $listings->have_posts() ) {
            $listings->the_post();

            $car_media = stm_get_car_medias( get_the_id() );
            $gallery = array();
            if ( !empty( $car_media ) ) {
                foreach ( $car_media['car_photos'] as $link ) {
                    if ( strpos( $link, 'motors.loc' ) ) {
                        $link = stm_ma_replace_host( $link );
                    }
                    $gallery[] = array( 'url' => $link );
                }
            }

            $featureImg = wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'stm-img-690-410' );

            if ( !$featureImg ) {
                $featureImg = STM_MOTORS_APP_URL . '/assets/img/car_plchldr.png';
            }

            if ( strpos( $featureImg, 'motors.loc' ) ) {
                $featureImg = stm_ma_replace_host( $featureImg );
            }

            if ( !$featureImg ) $featureImg = '';

            $price = get_post_meta( get_the_id(), 'price', true );
            $sale_price = get_post_meta( get_the_id(), 'sale_price', true );

            if ( empty( $price ) and !empty( $sale_price ) ) {
                $price = $sale_price;
            }

            $genTitle = stm_ma_generate_title_from_slugs( get_the_ID(), $title );
            $genSubTitle = stm_ma_generate_title_from_slugs( get_the_ID(), $subTitle );

            $genListTitle = stm_ma_generate_title_from_slugs( get_the_ID(), $listTitle );

            $infos = stm_ma_get_tax_info( get_the_ID(), $info );

            $infosListOne = stm_ma_get_tax_info( get_the_ID(), $listInfoOne );
            $infosListTwo = stm_ma_get_tax_info( get_the_ID(), $listInfoTwo );
            $infosListThree = stm_ma_get_tax_info( get_the_ID(), $listInfoThree );
            $infosListFour = stm_ma_get_tax_info( get_the_ID(), $listInfoFour );

            $newListings[] = array(
                'ID' => get_the_ID(),
                'imgUrl' => $featureImg,
                'sold_status' => (get_post_meta( get_the_ID(), 'car_mark_as_sold', true )) ? get_post_meta( get_the_ID(), 'car_mark_as_sold', true ) : 'off',
                'views' => get_post_meta( get_the_ID(), 'stm_car_views', true ),
                'gallery' => $gallery,
                'imgCount' => count( $gallery ),
                'price' => ( !empty( $price ) ) ? str_replace( '   ', ' ', stm_listing_price_view( trim( $price ) ) ) : 'No Price',
                'grid' => array(
                    'title' => $genTitle,
                    'subTitle' => $genSubTitle,
                    'infoIcon' => $infos['info_3'],
                    'infoTitle' => $infos['info_1'],
                    'infoDesc' => $infos['info_2'],
                ),
                'list' => array(
                    'title' => $genListTitle,
                    'infoOneIcon' => $infosListOne['info_3'],
                    'infoOneTitle' => $infosListOne['info_1'],
                    'infoOneDesc' => $infosListOne['info_2'],

                    'infoTwoIcon' => $infosListTwo['info_3'],
                    'infoTwoTitle' => $infosListTwo['info_1'],
                    'infoTwoDesc' => $infosListTwo['info_2'],

                    'infoThreeIcon' => $infosListThree['info_3'],
                    'infoThreeTitle' => $infosListThree['info_1'],
                    'infoThreeDesc' => $infosListThree['info_2'],

                    'infoFourIcon' => $infosListFour['info_3'],
                    'infoFourTitle' => $infosListFour['info_1'],
                    'infoFourDesc' => $infosListFour['info_2'],
                )
            );
        }
    }

    wp_reset_postdata();

    $lstngs = array('data' => $newListings, 'foundPosts' => $listings->found_posts);

    return $lstngs;
}

function stm_ma_get_listing_obj( $query )
{
    $newListings = array();

    if ( $query->have_posts() ) {
        $gridOpt = get_option( 'grid_view_settings', array() );
        $listOpt = get_option( 'list_view_settings', array() );

        $title = ( !empty( $gridOpt['go_two'] ) ) ? $gridOpt['go_two'] : '';
        $subTitle = ( !empty( $gridOpt['go_one'] ) ) ? $gridOpt['go_one'] : '';
        $info = ( !empty( $gridOpt['go_three'] ) ) ? $gridOpt['go_three'] : '';

        $listTitle = ( !empty( $listOpt['list_title'] ) ) ? $listOpt['list_title'] : '';
        $listInfoOne = ( !empty( $listOpt['list_info_one'] ) ) ? $listOpt['list_info_one'] : '';
        $listInfoTwo = ( !empty( $listOpt['list_info_two'] ) ) ? $listOpt['list_info_two'] : '';
        $listInfoThree = ( !empty( $listOpt['list_info_three'] ) ) ? $listOpt['list_info_three'] : '';
        $listInfoFour = ( !empty( $listOpt['list_info_four'] ) ) ? $listOpt['list_info_four'] : '';

        while ( $query->have_posts() ) {
            $query->the_post();

            $car_media = stm_get_car_medias( get_the_id() );
            $gallery = array();
            if ( !empty( $car_media ) ) {
                foreach ( $car_media['car_photos'] as $link ) {
                    if ( strpos( $link, 'motors.loc' ) ) {
                        $link = stm_ma_replace_host( $link );
                    }
                    $gallery[] = array( 'url' => $link );
                }
            }

            $featureImg = wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'stm-img-690-410' );

            if ( !$featureImg ) {
                $featureImg = STM_MOTORS_APP_URL . '/assets/img/car_plchldr.png';
            }

            if ( strpos( $featureImg, 'motors.loc' ) ) {
                $featureImg = stm_ma_replace_host( $featureImg );
            }

            if ( !$featureImg ) $featureImg = '';

            $price = get_post_meta( get_the_id(), 'price', true );
            $sale_price = get_post_meta( get_the_id(), 'sale_price', true );

            if ( empty( $price ) and !empty( $sale_price ) ) {
                $price = $sale_price;
            }

            $genTitle = stm_ma_generate_title_from_slugs( get_the_ID(), $title );
            $genSubTitle = stm_ma_generate_title_from_slugs( get_the_ID(), $subTitle );

            $genListTitle = stm_ma_generate_title_from_slugs( get_the_ID(), $listTitle );

            $infos = stm_ma_get_tax_info( get_the_ID(), $info );

            $infosListOne = stm_ma_get_tax_info( get_the_ID(), $listInfoOne );
            $infosListTwo = stm_ma_get_tax_info( get_the_ID(), $listInfoTwo );
            $infosListThree = stm_ma_get_tax_info( get_the_ID(), $listInfoThree );
            $infosListFour = stm_ma_get_tax_info( get_the_ID(), $listInfoFour );

            $newListings[] = array(
                'ID' => get_the_ID(),
                'imgUrl' => $featureImg,
                'sold_status' => (get_post_meta( get_the_ID(), 'car_mark_as_sold', true )) ? get_post_meta( get_the_ID(), 'car_mark_as_sold', true ) : 'off',
                'views' => get_post_meta( get_the_ID(), 'stm_car_views', true ),
                'post_status' => get_post_status( get_the_ID() ),
                'gallery' => $gallery,
                'imgCount' => count( $gallery ),
                'price' => ( !empty( $price ) ) ? str_replace( '   ', ' ', stm_listing_price_view( trim( $price ) ) ) : 'No Price',
                'grid' => array(
                    'title' => $genTitle,
                    'subTitle' => $genSubTitle,
                    'infoIcon' => $infos['info_3'],
                    'infoTitle' => $infos['info_1'],
                    'infoDesc' => $infos['info_2'],
                ),
                'list' => array(
                    'title' => $genListTitle,
                    'infoOneIcon' => $infosListOne['info_3'],
                    'infoOneTitle' => $infosListOne['info_1'],
                    'infoOneDesc' => $infosListOne['info_2'],

                    'infoTwoIcon' => $infosListTwo['info_3'],
                    'infoTwoTitle' => $infosListTwo['info_1'],
                    'infoTwoDesc' => $infosListTwo['info_2'],

                    'infoThreeIcon' => $infosListThree['info_3'],
                    'infoThreeTitle' => $infosListThree['info_1'],
                    'infoThreeDesc' => $infosListThree['info_2'],

                    'infoFourIcon' => $infosListFour['info_3'],
                    'infoFourTitle' => $infosListFour['info_1'],
                    'infoFourDesc' => $infosListFour['info_2'],
                )
            );
        }
    }

    wp_reset_postdata();
    return $newListings;
}

function stm_ma_get_user_favourites( $userId )
{
    $favourites = get_the_author_meta( 'stm_user_favourites', $userId );

    if ( !empty( $favourites ) ) {

        $args = array(
            'post_type' => stm_listings_post_type(),
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'post__in' => array_unique( explode( ',', $favourites ) )
        );

        $fav = new WP_Query( $args );
        $newListings = array();

        if ( $fav->have_posts() ) {
            $gridOpt = get_option( 'grid_view_settings', array() );
            $listOpt = get_option( 'list_view_settings', array() );

            $title = ( !empty( $gridOpt['go_two'] ) ) ? $gridOpt['go_two'] : '';
            $subTitle = ( !empty( $gridOpt['go_one'] ) ) ? $gridOpt['go_one'] : '';
            $info = ( !empty( $gridOpt['go_three'] ) ) ? $gridOpt['go_three'] : '';

            $listTitle = ( !empty( $listOpt['list_title'] ) ) ? $listOpt['list_title'] : '';
            $listInfoOne = ( !empty( $listOpt['list_info_one'] ) ) ? $listOpt['list_info_one'] : '';
            $listInfoTwo = ( !empty( $listOpt['list_info_two'] ) ) ? $listOpt['list_info_two'] : '';
            $listInfoThree = ( !empty( $listOpt['list_info_three'] ) ) ? $listOpt['list_info_three'] : '';
            $listInfoFour = ( !empty( $listOpt['list_info_four'] ) ) ? $listOpt['list_info_four'] : '';

            while ( $fav->have_posts() ) {
                $fav->the_post();

                $car_media = stm_get_car_medias( get_the_id() );
                $gallery = array();
                if ( !empty( $car_media ) ) {
                    foreach ( $car_media['car_photos'] as $link ) {
                        if ( strpos( $link, 'motors.loc' ) ) {
                            $link = stm_ma_replace_host( $link );
                        }
                        $gallery[] = array( 'url' => $link );
                    }
                }

                $featureImg = wp_get_attachment_image_url( get_post_thumbnail_id( get_the_ID() ), 'stm-img-690-410' );

                if ( !$featureImg ) {
                    $featureImg = STM_MOTORS_APP_URL . '/assets/img/car_plchldr.png';
                }

                if ( strpos( $featureImg, 'motors.loc' ) ) {
                    $featureImg = stm_ma_replace_host( $featureImg );
                }

                if ( !$featureImg ) $featureImg = '';

                $price = get_post_meta( get_the_id(), 'price', true );
                $sale_price = get_post_meta( get_the_id(), 'sale_price', true );

                if ( empty( $price ) and !empty( $sale_price ) ) {
                    $price = $sale_price;
                }

                $genTitle = stm_ma_generate_title_from_slugs( get_the_ID(), $title );
                $genSubTitle = stm_ma_generate_title_from_slugs( get_the_ID(), $subTitle );

                $genListTitle = stm_ma_generate_title_from_slugs( get_the_ID(), $listTitle );

                $infos = stm_ma_get_tax_info( get_the_ID(), $info );

                $infosListOne = stm_ma_get_tax_info( get_the_ID(), $listInfoOne );
                $infosListTwo = stm_ma_get_tax_info( get_the_ID(), $listInfoTwo );
                $infosListThree = stm_ma_get_tax_info( get_the_ID(), $listInfoThree );
                $infosListFour = stm_ma_get_tax_info( get_the_ID(), $listInfoFour );

                $newListings[] = array(
                    'ID' => get_the_ID(),
                    'imgUrl' => $featureImg,
                    'gallery' => $gallery,
                    'imgCount' => count( $gallery ),
                    'price' => ( !empty( $price ) ) ? str_replace( '   ', ' ', stm_listing_price_view( trim( $price ) ) ) : 'No Price',
                    'grid' => array(
                        'title' => $genTitle,
                        'subTitle' => $genSubTitle,
                        'infoIcon' => $infos['info_3'],
                        'infoTitle' => $infos['info_1'],
                        'infoDesc' => $infos['info_2'],
                    ),
                    'list' => array(
                        'title' => $genListTitle,
                        'infoOneIcon' => $infosListOne['info_3'],
                        'infoOneTitle' => $infosListOne['info_1'],
                        'infoOneDesc' => $infosListOne['info_2'],

                        'infoTwoIcon' => $infosListTwo['info_3'],
                        'infoTwoTitle' => $infosListTwo['info_1'],
                        'infoTwoDesc' => $infosListTwo['info_2'],

                        'infoThreeIcon' => $infosListThree['info_3'],
                        'infoThreeTitle' => $infosListThree['info_1'],
                        'infoThreeDesc' => $infosListThree['info_2'],

                        'infoFourIcon' => $infosListFour['info_3'],
                        'infoFourTitle' => $infosListFour['info_1'],
                        'infoFourDesc' => $infosListFour['info_2'],
                    )
                );
            }
        }
    }

    return $newListings;
}

function stm_ma_replace_host( $url )
{
    return str_replace( 'http://motors.loc', 'http://192.168.0.188:3000', $url );
}

function addACarStepParse( $paramms )
{
    foreach ( $paramms as $param ) {
        if ( $param == 'add_media' ) {
            $forApp[$param] = array(
                'label' => 'Add Media',
            );
            continue;
        }

        if ( $param == 'seller_notes' ) {
            $forApp[$param] = array(
                'label' => 'Seller Notes',
            );
            continue;
        }

        if ( $param == 'location' ) {
            $forApp[$param] = array(
                'label' => 'Location',
            );
            continue;
        }

        $getTerms = get_terms( array( 'taxonomy' => $param, 'hide_empty' => false, 'update_term_meta_cache' => false ) );

        if ( $param != 'price' && $param != 'ca-year' ) {
            $newFilter = array();
            foreach ( $getTerms as $term ) {
                $image = get_term_meta( $term->term_id, 'stm_image', true );
                $image = wp_get_attachment_image_src( $image, 'stm-img-190-132' );
                $category_image = $image[0];

                if ( !$category_image ) {
                    $plchldr_id = get_option( 'plchldr_attachment_id', 0 );
                    $category_image = ( $plchldr_id == 0 ) ? STM_MOTORS_APP_URL . '/assets/img/car_plchldr.png' : wp_get_attachment_image_url( $plchldr_id );
                }

                if ( strpos( $category_image, 'motors.loc' ) ) {
                    $category_image = stm_ma_replace_host( $category_image );
                }

                $newFilter[] = array(
                    'label' => $term->name,
                    'slug' => $term->slug,
                    'count' => $term->count,
                    'logo' => ( $category_image ) ? $category_image : '',
                    'parent' => get_term_meta( $term->term_id, 'stm_parent', true )
                );

            }

            $forApp[$param] = $newFilter;
        } else {
            $newFilter = array();
            foreach ( $getTerms as $term ) {
                $newFilter[] = array(
                    'label' => $term->name,
                    'value' => $term->slug,
                    'slug' => $term->slug,
                    'count' => $term->count,
                );

            }

            $param = ( $param == 'ca-year' ) ? 'year' : $param;
            if ( $param == 'year' || $param == 'price' ) {
                asort( $newFilter );
                $newFilter = array_values( $newFilter );
            }
            $forApp[$param] = $newFilter;
        }
    }

    return $forApp;
}

function stm_ma_add_a_car($update = false)
{
    $response = array();
    $first_step = array(); //needed fields
    $second_step = array(); //secondary fields
    $car_features = array(); //array of features car
    $videos = array(); /*videos links*/
    $notes = esc_html__( 'N/A', 'stm_vehicles_listing' );
    $registered = '';
    $vin = '';
    $history = array(
        'label' => '',
        'link' => ''
    );
    $location = array(
        'label' => '',
        'lat' => '',
        'lng' => '',
    );

    if ( empty( $_POST['user_id'] ) && empty( $_POST['user_token'] ) && get_user_meta( $_POST['user_id'], 'stm_app_token', true ) != $_POST['user_token'] ) {
        $response['message'] = esc_html__( 'Please, log in', 'stm_vehicles_listing' );

        return false;
    } else {
        $user = stm_get_user_custom_fields( $_POST['user_id'] );
        $restrictions = stm_get_post_limits( $_POST['user_id'] );
    }


    $response['message'] = '';
    $error = false;

    $demo = stm_is_site_demo_mode();
    if ( $demo ) {
        $error = true;
        $response['message'] = esc_html__( 'Site is on demo mode', 'stm_vehicles_listing' );
    }

    if ( !empty( $_POST['stm_current_car_id'] ) ) {
        $post_id = intval( $_POST['stm_current_car_id'] );
        $car_user = get_post_meta( $post_id, 'stm_car_user', true );
        $update = true;

        /*Check if current user edits his car*/
        if ( intval( $car_user ) != intval( $user['user_id'] ) ) {
            return false;
        }
    }

    /*Get first step*/

    $stepOne = explode( ',', get_option( 'add_car_step_one', "add_media,make,serie,ca-year" ) );

    foreach ( $stepOne as $k ) {
        if ( $k == 'add_media' ) continue;

        $k = ( $k == 'ca-year' ) ? 'year' : $k;

        if ( !empty( $_POST['stm_f_s_' . $k] ) ) {
            $postKey = str_replace( "_pre_", "-", $k );
            $postKey = ( $postKey == 'year' ) ? 'ca-year' : $postKey;

            $first_step[sanitize_title( $postKey )] = sanitize_title( $_POST['stm_f_s_' . $k] );
        } else {
            $error = true;
            $response['message'] = esc_html__( 'Enter required fields', 'motors' );
        }
    }

    if ( empty( $first_step ) ) {
        $error = true;
        $response['message'] = esc_html__( 'Enter required fields', 'motors' );
    }

    /*Get if no available posts*/
    if ( $restrictions['posts'] < 1 and !$update ) {
        $error = true;
        $response['message'] = esc_html__( 'You do not have available posts', 'stm_vehicles_listing' );
    }

    /*Getting second step*/
    foreach ( $_POST as $second_step_key => $second_step_value ) {
        if ( strpos( $second_step_key, 'stm_s_s_' ) !== false ) {
            if ( $_POST[$second_step_key] != "" ) {
                $original_key = str_replace( 'stm_s_s_', '', $second_step_key );
                $second_step[sanitize_title( $original_key )] = sanitize_text_field( $_POST[$second_step_key] );
            }
        }
    }

    /*Getting car features*/
    if ( !empty( $_POST['stm_additional_features'] ) ) {
        foreach ( $_POST['stm_additional_features'] as $car_feature ) {
            $car_features[] = sanitize_text_field( $car_feature );
        }
    }

    /*Videos*/
    if ( !empty( $_POST['stm_video'] ) ) {
        foreach ( $_POST['stm_video'] as $video ) {
            $videos[] = esc_url( $video );
        }
    }

    /*Note*/
    if ( !empty( $_POST['stm_seller_notes'] ) ) {
        $notes = esc_html( $_POST['stm_seller_notes'] );
    }

    /*Registration date*/
    if ( !empty( $_POST['stm_registered'] ) ) {
        $registered = sanitize_text_field( $_POST['stm_registered'] );
    }

    /*Vin*/
    if ( !empty( $_POST['stm_vin'] ) ) {
        $vin = sanitize_text_field( $_POST['stm_vin'] );
    }

    /*History*/
    if ( !empty( $_POST['stm_history_label'] ) ) {
        $history['label'] = sanitize_text_field( $_POST['stm_history_label'] );
    }

    if ( !empty( $_POST['stm_history_link'] ) ) {
        $history['link'] = esc_url( $_POST['stm_history_link'] );
    }

    /*Location*/
    if ( !empty( $_POST['stm_location_text'] ) ) {
        $location['label'] = sanitize_text_field( $_POST['stm_location_text'] );
    }

    if ( !empty( $_POST['stm_lat'] ) ) {
        $location['lat'] = sanitize_text_field( $_POST['stm_lat'] );
    }

    if ( !empty( $_POST['stm_lng'] ) ) {
        $location['lng'] = sanitize_text_field( $_POST['stm_lng'] );
    }

    if ( empty( $_POST['stm_car_price'] ) ) {
        $error = true;
        $response['message'] = esc_html__( 'Please add car price', 'stm_vehicles_listing' );
    } else {
        $price = stm_convert_to_normal_price( abs( intval( $_POST['stm_car_price'] ) ) );
    }

    if ( !empty( $_POST['car_price_form_label'] ) ) {
        $location['car_price_form_label'] = sanitize_text_field( $_POST['car_price_form_label'] );
    }

    if ( !empty( $_POST['stm_car_sale_price'] ) ) {
        $location['stm_car_sale_price'] = stm_convert_to_normal_price( abs( sanitize_text_field( $_POST['stm_car_sale_price'] ) ) );
    }

    $generic_title = '';

    if ( !empty( $_POST['stm_car_main_title'] ) ) {
        $generic_title = sanitize_text_field( $_POST['stm_car_main_title'] );
    } else {
        if ( !empty( $_POST['smt_f_s_make'] ) || !empty( $_POST['smt_s_s_make'] ) ) {
            $generic_title .= ( !empty( $_POST['smt_f_s_make'] ) ) ? $_POST['smt_f_s_make'] : $_POST['smt_s_s_make'];
            $generic_title .= ' ';
        }

        if ( !empty( $_POST['smt_f_s_serie'] ) || !empty( $_POST['smt_s_s_serie'] ) ) {
            $generic_title .= ( !empty( $_POST['smt_f_s_serie'] ) ) ? $_POST['smt_f_s_serie'] : $_POST['smt_s_s_serie'];
        }
    }

    $generic_title = sanitize_text_field( $generic_title );

    /*Generating post*/
    if ( !$error ) {
        if ( $restrictions['premoderation'] ) {
            $status = 'pending';
        } else {
            $status = 'publish';
        }

        $post_data = array(
            'post_type' => 'listings',
            'post_title' => '',
            'post_content' => '',
            'post_status' => $status,
        );

        $post_data['post_content'] = $notes;

        if ( !empty( $generic_title ) ) {
            $post_data['post_title'] = $generic_title;
        }

        if ( !$update ) {
            $post_id = wp_insert_post( $post_data, true );
        }

        if ( !is_wp_error( $post_id ) ) {

            if ( $update ) {
                $post_data_update = array(
                    'ID' => $post_id,
                    'post_content' => $post_data['post_content'],
                    'post_status' => $status,
                );

                if ( !empty( $generic_title ) ) {
                    $post_data_update['post_title'] = $generic_title;
                }

                wp_update_post( $post_data_update );
            }

            update_post_meta( $post_id, 'stock_number', $post_id );
            update_post_meta( $post_id, 'stm_car_user', $user['user_id'] );

            /*Set categories*/
            foreach ( $first_step as $tax => $term ) {
                $tax_info = stm_get_all_by_slug( $tax );
                if ( !empty( $tax_info['numeric'] ) and $tax_info['numeric'] ) {
                    update_post_meta( $post_id, $tax, abs( sanitize_title( $term ) ) );
                } else {
                    wp_delete_object_term_relationships( $post_id, $tax );
                    wp_add_object_terms( $post_id, $term, $tax, true );
                    update_post_meta( $post_id, $tax, sanitize_title( $term ) );
                }
            }

            if ( !empty( $second_step ) ) {
                /*Set categories*/
                foreach ( $second_step as $tax => $term ) {
                    if ( !empty( $tax ) and !empty( $term ) ) {
                        $tax_info = stm_get_all_by_slug( $tax );
                        if ( !empty( $tax_info['numeric'] ) and $tax_info['numeric'] ) {
                            update_post_meta( $post_id, $tax, sanitize_text_field( $term ) );
                        } else {
                            wp_delete_object_term_relationships( $post_id, $tax );
                            wp_add_object_terms( $post_id, $term, $tax, true );
                            update_post_meta( $post_id, $tax, sanitize_text_field( $term ) );
                        }
                    }
                }
            }

            if ( !empty( $videos ) ) {
                update_post_meta( $post_id, 'gallery_video', $videos[0] );

                if ( count( $videos ) > 1 ) {
                    array_shift( $videos );
                    update_post_meta( $post_id, 'gallery_videos', array_filter( array_unique( $videos ) ) );
                }

            }

            if ( !empty( $vin ) ) {
                update_post_meta( $post_id, 'vin_number', $vin );
            }

            if ( !empty( $registered ) ) {
                update_post_meta( $post_id, 'registration_date', $registered );
            }

            if ( !empty( $history['label'] ) ) {
                update_post_meta( $post_id, 'history', $history['label'] );
            }

            if ( !empty( $history['link'] ) ) {
                update_post_meta( $post_id, 'history_link', $history['link'] );
            }

            if ( !empty( $location['label'] ) ) {
                update_post_meta( $post_id, 'stm_car_location', $location['label'] );
            }

            if ( !empty( $location['lat'] ) ) {
                update_post_meta( $post_id, 'stm_lat_car_admin', $location['lat'] );
            }

            if ( !empty( $location['lng'] ) ) {
                update_post_meta( $post_id, 'stm_lng_car_admin', $location['lng'] );
            }

            if ( !empty( $car_features ) ) {
                update_post_meta( $post_id, 'additional_features', implode( ',', $car_features ) );
            }

            update_post_meta( $post_id, 'price', $price );
            update_post_meta( $post_id, 'stm_genuine_price', $price );

            if ( !empty( $location['car_price_form_label'] ) ) {
                update_post_meta( $post_id, 'car_price_form_label', $location['car_price_form_label'] );
            }

            if ( isset( $location['stm_car_sale_price'] ) && !empty( $location['stm_car_sale_price'] ) ) {
                update_post_meta( $post_id, 'sale_price', $location['stm_car_sale_price'] );
                update_post_meta( $post_id, 'stm_genuine_price', $location['stm_car_sale_price'] );
            } else {
                update_post_meta( $post_id, 'sale_price', '' );
            }

            update_post_meta( $post_id, 'title', 'hide' );
            update_post_meta( $post_id, 'breadcrumbs', 'show' );

            $response['post_id'] = $post_id;

            if ( ( $update ) ) {
                $response['message'] = esc_html__( 'Car Updated, uploading photos', 'stm_vehicles_listing' );
            } else {
                $response['message'] = esc_html__( 'Car Added, uploading photos', 'stm_vehicles_listing' );
            }
        } else {
            $response['message'] = $post_id->get_error_message();
        }
    }
    wp_send_json( $response );
}

function upload_media( $user_id, $meta_key )
{
    $response = array(
        'message' => '',
        'user_id' => $user_id,
        'errors' => array(),
    );

    if ( !empty( $_POST['avatar'] ) ) {
        if ( !function_exists( 'media_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/image.php' );
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
            require_once( ABSPATH . 'wp-admin/includes/media.php' );
        }

        $upload_dir = wp_upload_dir();
        $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

        $image = $_POST['avatar']; // your base64 encoded
        $image = str_replace( 'data:image/*;charset=utf-8;base64,', '', $image );
        $image = str_replace( 'data:image/*;base64,', '', $image );
        $image = str_replace( 'data:image/jpeg;base64,', '', $image );
        $image = str_replace( ' ', '+', $image );

        $decoded = base64_decode( $image );
        $filename = 'my-base64-image.png';

        $hashed_filename = md5( $filename . microtime() ) . '_' . $filename;

        $image_upload = file_put_contents( $upload_path . $hashed_filename, $decoded );

        if ( !function_exists( 'wp_handle_sideload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        if ( !function_exists( 'wp_get_current_user' ) ) {
            require_once( ABSPATH . 'wp-includes/pluggable.php' );
        }

        $file = array();
        $file['error'] = '';
        $file['tmp_name'] = $upload_path . $hashed_filename;
        $file['name'] = $hashed_filename;
        $file['type'] = 'image/png';
        $file['size'] = filesize( $upload_path . $hashed_filename );

        $file_return = wp_handle_sideload( $file, array( 'test_form' => false ) );

        $filename = $file_return['file'];
        $guid = $wp_upload_dir['url'] . '/' . basename( $filename );
        $attachment = array(
            'post_mime_type' => $file_return['type'],
            'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
            'post_content' => '',
            'post_status' => 'inherit',
            'guid' => $guid
        );
        $uploaded = wp_insert_attachment( $attachment, $filename );

        $imgSrc = wp_get_attachment_image_url($uploaded);

        update_user_meta( $user_id, $meta_key, $imgSrc );

        /*$response['user_id'] = $user_id;
        $response['attach'] = $attachment;
        $response['uploaded'] = $uploaded;
        $response['guid'] = wp_get_attachment_image_url($uploaded);
        $response['success'] = true;*/

        return $imgSrc;
    }
}

function stm_ma_add_a_car_media_two( $user_id, $token, $post_id )
{
    if ( empty( $user_id ) && empty( $token ) && !empty( $post_id ) && get_user_meta( $user_id, 'stm_app_token', true ) != $token ) {
        $response['message'] = esc_html__( 'Upload Image Filed', 'stm_vehicles_listing' );
        return false;
    }

    if ( !$post_id ) {
        /*No id passed from first ajax Call?*/
        wp_send_json( array( 'message' => esc_html__( 'Some error occurred, try again later', 'stm_vehicles_listing' ) ) );
        exit;
    }

    $limits = stm_get_post_limits( $user_id );
    $position = $_POST['position'];

    $updating = !empty( $_POST['stm_edit'] ) and $_POST['stm_edit'] == 'update';

    if ( intval( get_post_meta( $post_id, 'stm_car_user', true ) ) != intval( $user_id ) ) {
        /*User tries to add info to another car*/
        wp_send_json( array( 'message' => esc_html__( 'You are trying to add car to another car user, or your session has expired, please sign in first', 'stm_vehicles_listing' ) ) );
        exit;
    }

    $attachs = get_post_meta( $post_id, 'gallery' );

    $attachments_ids = ( $_POST['position'] != 0 ) ? array_unique($attachs[0]) : array();

    $error = false;
    $response = array(
        'message' => '',
        'post' => $post_id,
        'errors' => array(),
    );

    if ( !empty( $_POST['photo'] ) ) {

        $max_uploads = intval( $limits['images'] ) - count( $attachments_ids );

        if ( count( $_POST['photo']['name'] ) > $max_uploads ) {
            $error = true;
            $response['message'] = sprintf( esc_html__( 'Sorry, you can upload only %d images per add', 'stm_vehicles_listing' ), $max_uploads );
        } else {

            if ( $error ) {
                if ( !$updating ) {
                    wp_delete_post( $post_id, true );
                }
                wp_send_json( $response );
                exit;
            }

            if(!isset($_POST['img_id'])) {
                if ( !function_exists( 'media_handle_upload' ) ) {
                    require_once( ABSPATH . 'wp-admin/includes/image.php' );
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                    require_once( ABSPATH . 'wp-admin/includes/media.php' );
                }

                /*-------*/
                $upload_dir = wp_upload_dir();
                $upload_path = str_replace( '/', DIRECTORY_SEPARATOR, $upload_dir['path'] ) . DIRECTORY_SEPARATOR;

                $image = $_POST['photo']; // your base64 encoded
                $image = str_replace( 'data:image/*;charset=utf-8;base64,', '', $image );
                $image = str_replace( 'data:image/*;base64,', '', $image );
                $image = str_replace( 'data:image/jpeg;base64,', '', $image );
                $image = str_replace( ' ', '+', $image );

                $decoded = base64_decode( $image );
                $filename = 'my-base64-image.png';

                $hashed_filename = md5( $filename . microtime() ) . '_' . $filename;

                $image_upload = file_put_contents( $upload_path . $hashed_filename, $decoded );

                if ( !function_exists( 'wp_handle_sideload' ) ) {
                    require_once( ABSPATH . 'wp-admin/includes/file.php' );
                }

                if ( !function_exists( 'wp_get_current_user' ) ) {
                    require_once( ABSPATH . 'wp-includes/pluggable.php' );
                }

                $file = array();
                $file['error'] = '';
                $file['tmp_name'] = $upload_path . $hashed_filename;
                $file['name'] = $hashed_filename;
                $file['type'] = 'image/png';
                $file['size'] = filesize( $upload_path . $hashed_filename );

                $file_return = wp_handle_sideload( $file, array( 'test_form' => false ) );

                $filename = $file_return['file'];
                $attachment = array(
                    'post_mime_type' => $file_return['type'],
                    'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
                    'post_content' => '',
                    'post_status' => 'inherit',
                    'guid' => $wp_upload_dir['url'] . '/' . basename( $filename )
                );
                $uploaded = wp_insert_attachment( $attachment, $filename );
                /*-------*/

                if ( $uploaded['error'] ) {
                    $response['errors'][$_POST['photo']['name']] = $uploaded;
                    wp_send_json( $response );
                }
            } else {
                $uploaded = $_POST['img_id'];
            }


            if($_POST['position'] == $_POST['count'] - 1) {
                $current_attachments = get_posts( array(
                    'fields' => 'ids',
                    'post_type' => 'attachment',
                    'posts_per_page' => -1,
                    'post_parent' => $post_id,
                ) );

                $delete_attachments = array_diff( $current_attachments, $attachments_ids );
                foreach ( $delete_attachments as $delete_attachment ) {
                    stm_delete_media( intval( $delete_attachment ) );
                }
            }

            $attachments_ids[] = $uploaded;

            if ( $position == 0 ) {
                if ( !empty( $uploaded ) ) {
                    update_post_meta( $post_id, '_thumbnail_id', $uploaded );
                }
            }

            update_post_meta( $post_id, 'gallery', $attachments_ids );

            do_action( 'stm_after_listing_gallery_saved', $post_id, $attachments_ids );

            $response['attach'] = $attachments_ids;
            $response['uploaded'] = $uploaded;
            $response['current'] = $current_attachments;
            $response['position'] = $position;
            $response['success'] = true;

            wp_send_json( $response );
        }
    }
}

function stm_ma_get_image_mime_type($image_path)
{
    $mimes  = array(
        IMAGETYPE_GIF => "image/gif",
        IMAGETYPE_JPEG => "image/jpg",
        IMAGETYPE_PNG => "image/png",
        IMAGETYPE_SWF => "image/swf",
        IMAGETYPE_PSD => "image/psd",
        IMAGETYPE_BMP => "image/bmp",
        IMAGETYPE_TIFF_II => "image/tiff",
        IMAGETYPE_TIFF_MM => "image/tiff",
        IMAGETYPE_JPC => "image/jpc",
        IMAGETYPE_JP2 => "image/jp2",
        IMAGETYPE_JPX => "image/jpx",
        IMAGETYPE_JB2 => "image/jb2",
        IMAGETYPE_SWC => "image/swc",
        IMAGETYPE_IFF => "image/iff",
        IMAGETYPE_WBMP => "image/wbmp",
        IMAGETYPE_XBM => "image/xbm",
        IMAGETYPE_ICO => "image/ico");

    if (($image_type = exif_imagetype($image_path))
        && (array_key_exists($image_type ,$mimes)))
    {
        return $mimes[$image_type];
    }
    else
    {
        return FALSE;
    }
}