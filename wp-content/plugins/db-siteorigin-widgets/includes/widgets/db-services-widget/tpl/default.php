<?php
/**
 * @var $settings
 * @var $style
 * @var $services
 */

?>

<?php $column_style = db_get_column_class(intval($settings['per_line'])); ?>

<?php if( !empty( $instance['title'] ) ) {
    echo '<div class="db-services-title">';
    echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'];
    echo '</div>';
}

?>

<div class="db-services db-<?php echo $style; ?> db-container">

    <?php foreach ($services as $service): ?>

        <?php $icon_type = esc_html($service['icon_type']); ?>

        <div class="db-service-wrapper <?php echo $column_style; ?>">

            <div class="db-service">

                <?php if ($icon_type == 'icon_image') : ?>

                    <div class="db-image-wrapper">

                        <?php echo wp_get_attachment_image($service['icon_image'], 'full', false, array('class' => 'db-image full')); ?>

                    </div>

                <?php else : ?>

                    <div class="db-icon-wrapper">

                        <?php echo siteorigin_widget_get_icon($service['icon']); ?>

                    </div>

                <?php endif; ?>

                <div class="db-service-text">

                    <h3 class="db-title"><?php echo esc_html($service['title']) ?></h3>

                    <div class="db-service-details"><?php echo wp_kses_post($service['excerpt']) ?></div>

                </div>

            </div>

        </div>

    <?php

    endforeach;

    ?>

</div>