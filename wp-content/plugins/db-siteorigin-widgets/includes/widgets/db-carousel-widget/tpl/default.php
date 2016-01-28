<?php
/**
 * @var $carousel_settings
 * @var $settings
 * @var $elements
 */

// Loop through the elements and do something with them.

if (!empty($elements)) : ?>

    <div
        class="db-carousel db-container"  <?php foreach ($carousel_settings as $key => $val) : ?>

        <?php if (!empty($val)) : ?>
            data-<?php echo $key . '="' . esc_attr($val) . '"' ?>
        <?php endif ?>

    <?php endforeach; ?>>

        <?php foreach ($elements as $element) : ?>

            <div class="db-carousel-item">

                <?php echo do_shortcode(wp_kses_post($element['text'])); ?>

            </div><!--.db-carousel-item -->

        <?php endforeach; ?>

    </div> <!-- .db-carousel -->

<?php endif; ?>