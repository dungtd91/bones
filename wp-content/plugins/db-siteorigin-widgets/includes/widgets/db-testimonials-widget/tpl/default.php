<?php
/**
 * @var $settings
 * @var $testimonials
 */
?>

<?php $column_style = db_get_column_class(intval($settings['per_line'])); ?>

<div class="db-testimonials db-container">

    <?php foreach ($testimonials as $testimonial) : ?>

        <div class="db-testimonial <?php echo $column_style; ?>">

            <div class="db-testimonial-text">
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

    <?php

    endforeach;

    ?>

</div>