<?php
/**
 * @var $settings
 * @var $testimonials
 */

?>

<div class="db-testimonials-slider db-flexslider db-container" <?php foreach ($settings as $key => $val) : ?>
    <?php if (!empty($val)) : ?>
        data-<?php echo $key . '="' . esc_attr($val) . '"' ?>
    <?php endif ?>
<?php endforeach; ?>>

    <div class="db-slides">

        <?php foreach ($testimonials as $testimonial) : ?>

            <div class="db-slide db-testimonial-wrapper">

                <div class="db-testimonial">

                    <div class="db-testimonial-text">

                        <i class="db-icon-quote"></i>

                        <?php echo wp_kses_post($testimonial['text']) ?>

                    </div>

                    <div class="db-testimonial-user">

                        <div class="db-image-wrapper">
                            <?php echo wp_get_attachment_image($testimonial['image'], 'thumbnail', false, array('class' => 'db-image full')); ?>
                        </div>

                        <div class="db-text">
                            <h4 class="db-author-name"><?php echo esc_html($testimonial['name']) ?></h4>
                            <div class="db-author-credentials"><?php echo wp_kses_post($testimonial['credentials']); ?></div>
                        </div>

                    </div>

                </div>

            </div>

        <?php

        endforeach;

        ?>

    </div>

</div>