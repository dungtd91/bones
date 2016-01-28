<?php
/**
 * @var $piecharts
 */

?>

<?php $column_style = db_get_column_class(intval($settings['per_line'])); ?>

<?php

$bar_color = ' data-bar-color="' . esc_attr($settings['bar_color']) . '"';
$track_color = ' data-track-color="' . esc_attr($settings['track_color']) . '"';

?>

<div class="db-piecharts db-container">

    <?php foreach ($piecharts as $piechart): ?>

        <div class="db-piechart <?php echo $column_style; ?>">

            <div class="db-percentage" <?php echo $bar_color; ?> <?php echo $track_color; ?>
                 data-percent="<?php echo intval($piechart['percentage']); ?>">

                <span><?php echo intval($piechart['percentage']); ?><sup>%</sup></span>

            </div>

            <div class="db-label"><?php echo esc_html($piechart['stats_title']); ?></div>

        </div>

    <?php

    endforeach;

    ?>

</div>