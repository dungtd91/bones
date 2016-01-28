<?php
/**
 * @var $carousel_settings
 * @var $settings
 * @var $posts
 */

$query_args = siteorigin_widget_post_selector_process_query($posts);

// Use the processed post selector query to find posts.
$loop = new WP_Query($query_args);

// Loop through the posts and do something with them.
if ($loop->have_posts()) : ?>

    <div class="db-posts-carousel db-container"  <?php foreach ($carousel_settings as $key => $val) : ?>
        <?php if (!empty($val)) : ?>
            data-<?php echo $key . '="' . esc_attr($val) . '"' ?>
        <?php endif ?>
    <?php endforeach; ?>>

        <?php while ($loop->have_posts()) : $loop->the_post(); ?>

            <div data-id="id-<?php the_ID(); ?>" class="db-posts-carousel-item">

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                    <?php if ($thumbnail_exists = has_post_thumbnail()): ?>

                        <div class="db-project-image">

                            <?php if ($settings['image_linkable']): ?>

                                <a href="<?php the_permalink(); ?>"> <?php the_post_thumbnail('large'); ?> </a>

                            <?php else: ?>

                                <?php the_post_thumbnail('large'); ?>

                            <?php endif; ?>

                        </div>

                    <?php endif; ?>

                    <?php if ($settings['display_title'] || $settings['display_summary']) : ?>

                        <div class="db-entry-text-wrap <?php echo($thumbnail_exists ? '' : ' nothumbnail'); ?>">

                            <?php if ($settings['display_title']) : ?>

                                <?php the_title('<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . get_the_title() . '"
                                               rel="bookmark">', '</a></h3>'); ?>

                            <?php endif; ?>

                            <?php if (get_post_type() == 'post')
                                echo db_entry_terms_list('category');
                            ?>

                            <?php if ($settings['display_summary']) : ?>

                                <div class="entry-summary">

                                    <?php echo get_the_excerpt(); ?>

                                </div>

                            <?php endif; ?>

                        </div>

                    <?php endif; ?>

                </article>
                <!-- .hentry -->

            </div><!--.db-posts-carousel-item -->

        <?php endwhile; ?>

        <?php wp_reset_postdata(); ?>

    </div> <!-- .db-posts-carousel -->

<?php endif; ?>