<?php
/**
 * @var $odometers
 */

?>

<?php $column_style = db_get_column_class(intval($settings['per_line'])); ?>

<div class="db-odometers db-container">

    <?php foreach ($odometers as $odometer): ?>

        <?php

        $prefix = (!empty ($odometer['prefix'])) ? '<span class="prefix">' . $odometer['prefix'] . '</span>' : '';
        $suffix = (!empty ($odometer['suffix'])) ? '<span class="suffix">' . $odometer['suffix'] . '</span>' : '';

        ?>

        <div class="db-odometer <?php echo $column_style; ?>">

            <?php echo (!empty ($odometer['prefix'])) ? '<span class="db-prefix">' . $odometer['prefix'] . '</span>' : ''; ?>

            <div class="db-number odometer" data-stop="<?php echo intval($odometer['stop_value']); ?>">

                <?php echo intval($odometer['start_value']); ?>

            </div>

            <? echo (!empty ($odometer['suffix'])) ? '<span class="db-suffix">' . $odometer['suffix'] . '</span>' : ''; ?>

            <?php $icon_type = esc_html($odometer['icon_type']); ?>

            <?php if ($icon_type == 'icon_image') : ?>

                <?php $icon_html = '<span class="db-image-wrapper">' . wp_get_attachment_image($odometer['icon_image'], 'full', false, array('class' => 'db-image full')) . '</span>'; ?>

            <?php else : ?>

                <?php $icon_html = '<span class="db-icon-wrapper">' . siteorigin_widget_get_icon($odometer['icon']) . '</span>'; ?>

            <?php endif; ?>

            <div class="db-stats-title-wrap">

                <div class="db-stats-title"><?php echo $icon_html . esc_html($odometer['stats_title']); ?></div>

            </div>

        </div>

    <?php

    endforeach;

    ?>

</div>