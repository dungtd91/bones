<?php
/**
 * @var $stats_bars
 */
?>

<div class="db-stats-bars">

    <?php foreach ($stats_bars as $stats_bar) :

        $color_style = '';
        $color = $stats_bar['color'];
        if ($color)
            $color_style = ' style="background:' . esc_attr($color) . ';"';

        ?>

        <div class="db-stats-bar">

            <div class="db-stats-title">
                <?php echo esc_html($stats_bar['title']) ?><span><?php echo esc_attr($stats_bar['value']); ?>%</span>
            </div>

            <div class="db-stats-bar-wrap">

                <div <?php echo $color_style; ?> class="db-stats-bar-content"
                                                 data-perc="<?php echo esc_attr($stats_bar['value']); ?>"></div>

                <div class="db-stats-bar-bg"></div>

            </div>

        </div>

    <?php

    endforeach;

    ?>

</div>