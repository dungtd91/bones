<?php
/**
 * @var $settings
 * @var $terms
 * @var $post_count
 */


$taxonomy = 'jetpack-portfolio-type';

$query_args = array();
$query_args ['post_type'] = 'jetpack-portfolio';

if (intval($post_count) !== 0)
    $query_args['posts_per_page'] = $post_count;
else
    $query_args['posts_per_page'] = -1;

if (!empty($terms)) {
    $query_args['tax_query'] = array(array('taxonomy' => $taxonomy,
                                           'field' => 'term_id',
                                           'terms' => $terms));
}

// Use the processed post selector query to find posts.
$loop = new WP_Query($query_args);

// Loop through the posts and do something with them.
if ($loop->have_posts()) : ?>

    <div class="db-portfolio-wrap db-container">

        <?php $column_style = db_get_column_class(intval($settings['per_line'])); ?>

        <?php if ($settings['packed'] || $settings['layout_mode'] == 'masonry'): ?>

            <?php $column_style = $column_style . ' db-zero-margin'; ?>

        <?php endif; ?>

        <div class="db-portfolio-header">

            <?php if (!empty($settings['heading'])) ?>

            <h3 class="db-heading"><?php echo wp_kses_post($heading); ?></h3>

            <?php

            if ($settings['filterable'])
                echo db_get_taxonomy_terms_filter($taxonomy, $terms);

            ?>

        </div>

        <div class="db-portfolio js-isotope db-<?php echo $settings['layout_mode']; ?>"
             data-isotope-options='{ "itemSelector": ".db-portfolio-item", "layoutMode": "<?php echo esc_attr($settings['layout_mode']); ?>" }'>

            <?php while ($loop->have_posts()) : $loop->the_post(); ?>

                <?php
                $style = '';
                $terms = get_the_terms(get_the_ID(), $taxonomy);
                if (!empty($terms)) {
                    foreach ($terms as $term) {
                        $style = ' term-' . $term->term_id;
                    }
                }
                ?>

                <div data-id="id-<?php the_ID(); ?>"
                     class="db-portfolio-item <?php echo $style; ?> <?php echo $column_style; ?>">

                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                        <?php if ($thumbnail_exists = has_post_thumbnail()): ?>

                            <div class="db-project-image">

                                <?php if ($settings['image_linkable']): ?>

                                    <a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail('large'); ?> </a>

                                <?php else: ?>

                                    <?php the_post_thumbnail('large'); ?>

                                <?php endif; ?>

                                <div class="db-image-info">

                                    <div class="db-entry-info">

                                        <?php the_title('<h3 class="db-post-title"><a href="' . get_permalink() . '" title="' . get_the_title() . '"
                                               rel="bookmark">', '</a></h3>'); ?>

                                        <?php echo db_get_taxonomy_info($taxonomy); ?>

                                    </div>

                                </div>

                                <div class="db-image-overlay"></div>

                            </div>

                        <?php endif; ?>

                        <?php if ($settings['display_title'] || $settings['display_summary']) : ?>

                            <div class="db-entry-text-wrap <?php echo($thumbnail_exists ? '' : ' nothumbnail'); ?>">

                                <?php if ($settings['display_title']) : ?>

                                    <?php the_title('<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . get_the_title() . '"
                                               rel="bookmark">', '</a></h3>'); ?>

                                <?php endif; ?>

                                <?php if ($settings['display_summary']) : ?>

                                    <div class="entry-summary">

                                        <?php echo get_the_excerpt(); ?>

                                    </div>

                                <?php endif; ?>

                            </div>

                        <?php endif; ?>

                    </article>
                    <!-- .hentry -->

                </div><!--Isotope element -->

            <?php endwhile; ?>

            <?php wp_reset_postdata(); ?>

        </div>
        <!-- Isotope items -->

    </div>

<?php endif; ?>