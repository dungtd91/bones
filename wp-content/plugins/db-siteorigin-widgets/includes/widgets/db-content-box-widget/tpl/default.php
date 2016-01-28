<?php
/**
 * @var $settings
 * @var $style
 * @var $services
 */

?>

<?php $column_style = db_get_column_class(intval($settings['per_line'])); ?>

<div class="db-services db-<?php echo $style; ?> db-container">

    <?php foreach ($contents as $content): ?>

        <div class="db-content-box-wrapper <?php echo $column_style; ?>">

            <div class="db-content-box">

                    <h3 class="db-title"><?php echo esc_html($content['title']) ?></h3>

                    <div class="db-details"><?php echo wp_kses_post($content['content']) ?></div>

            </div>

        </div>

    <?php

    endforeach;

    ?>

</div>