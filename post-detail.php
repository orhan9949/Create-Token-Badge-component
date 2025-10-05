<?php

/**
 * Post Detail.
 */

 $categories = get_the_terms( $post, 'category' );

 if ( $sponsored_types = get_the_terms( $post, 'cn_sponsored_type' ) ) {
     $sponsored_types = wp_list_pluck( $sponsored_types, 'name', 'slug' );
 }

$author_id = get_the_author_meta( 'ID' );
$editor    = get_field( 'cn_post_editor' );
$alm_page  = $args['alm_page'] ?? 1;
?>

<article <?php post_class( 'post-detail' ); ?>>

    <header class="post-detail__header">

        <h1 class="post-detail__title">
            <?php the_title(); ?>
        </h1>

        <div class="post-detail__meta">

            <?php if ( ! cn_is_user_sponsored( $author_id ) ) : ?>

                <?php get_template_part( 'template-parts/components/author-list', null, [
                    'ids' => cn_get_post_author( get_the_ID() )
                ] ); ?>

            <?php endif; ?>

            <?php cn_the_post_detail_date(); ?>

            <?php if ( ! cn_is_user_sponsored( $author_id ) ) : ?>

                <?php if ( $editor_ids = cn_get_post_editor( get_the_ID() ) ) : ?>

                    <?php get_template_part( 'template-parts/components/author-list', null, [
                        'template' => __( 'Edited by %s', 'base' ),
                        'ids'      => $editor_ids
                    ] ); ?>

                <?php endif; ?>

            <?php endif; ?>

            <?php if ( get_the_modified_date( 'U' ) < strtotime( '-4 years', current_time( 'timestamp' ) ) ) : ?>

                <span class="post-detail__outdated">
                    <?php cn_the_svg_icon( 'calendar' ); ?>
                    <?php _e( 'This article is more than 4 years old', 'base' ); ?>
                </span>

            <?php endif; ?>

            <?php if ( $categories ) : ?>

                <span class="post-detail__categories">

                    <?php foreach ( $categories as $category ) : ?>

                        <?php get_template_part( 'template-parts/components/category-badge', null, [
                            'term' => $category
                        ] ); ?>

                    <?php endforeach; ?>

                </span><!-- .post-detail__categories -->

            <?php endif; ?>

        </div><!-- .post-detail__meta -->

    </header><!-- .post-detail__header -->

    <div class="post-detail__media">

        <?php if ( has_post_thumbnail() ) : ?>

            <?php the_post_thumbnail( 'post-thumbnail', [
                'class' => 'post-detail__image',
                'alt'   => get_the_title()
            ] ); ?>

        <?php else : ?>

            <img src="<?php echo get_theme_file_uri( 'images/post-image-default.svg' ); ?>" width="1380" height="776" alt="<?php echo get_the_title(); ?>" class="post-detail__image">

        <?php endif; ?>

        <?php if ( ! empty( $sponsored_types ) ) : ?>

            <div class="post-detail__sponsored">

                <?php
                foreach( $sponsored_types as $slug => $name ) {
                    get_template_part( 'template-parts/components/sponsored-badge', null, [
                        'name' => $name,
                        'type' => $slug,
                    ] );
                }
                ?>

            </div><!-- .post-detail__sponsored -->

        <?php endif; ?>

    </div><!-- .post-detail__media -->

    <div class="post-detail__container">

        <div class="post-detail__share">

            <?php
            do_action( 'cn_post_detail_share_before' );

            get_template_part( 'template-parts/components/share', null, [
                'has_border' => true
            ] );

            do_action( 'cn_post_detail_share_after' );
            ?>

        </div><!-- .post-detail__share -->

        <div class="post-detail__content blocks">
            <?php
            do_action( 'cn_post_detail_content_before' );

            the_content();

            do_action( 'cn_post_detail_content_after' );
            ?>

        </div><!-- .page-detail__content -->

        <footer class="post-detail__footer">

            <?php do_action( 'cn_post_detail_footer_before' ); ?>

            <div class="post-detail__tags">

                <?php get_template_part( 'template-parts/components/tags', null, [
                    'title' => __( 'Read more about', 'base' ),
                    'tags'  => get_the_tags()
                ] ); ?>

            </div><!-- .post-detail__tags -->

            <?php
            if ( 1 == $alm_page ) {
                do_action( 'cn_post_detail_footer_after' );
            } else {
                do_action( 'cn_post_detail_footer_after_random' );
            }
            ?>


            <?php

            $tokens_data = get_field('cn_post_cryptocurrency');

            if($tokens_data !== false):

                $token_ids_data = [];

                $token_names_data = [];

                foreach($tokens_data as $token):

                    $token_id = get_field( 'cn_cryptocurrency_coingecko_id', $token->ID );

                    $token_ids_data[] = $token_id;

                    $token_names_data[] = [$token_id =>$token->post_title];

                endforeach;

                $token_ids_data = json_encode($token_ids_data);

                $token_names_data = json_encode($token_names_data);

                ?>

                <div class="post-detail__tokens"

                     data-tokens-name='<?php echo ($token_names_data == null) ? '' : $token_names_data; ?>'

                     data-tokens-id='<?php echo ($token_ids_data == null) ? '' : $token_ids_data; ?>'

                     data-show-change="true"

                     data-show-price="false"

                ></div><!-- .post-detail__tokens -->

            <?php

            endif;

            ?>

        </footer><!-- .post-detail__footer" -->

    </div><!-- .post-detail__container -->

</article><!-- .post-detail -->