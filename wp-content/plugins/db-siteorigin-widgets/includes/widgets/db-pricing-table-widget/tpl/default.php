<?php
/**
 * @var $pricing_plans
 */

?>

<?php $column_style = db_get_column_class(intval($settings['per_line'])); ?>

<div class="db-pricing-table db-container">

    <?php

    foreach ($pricing_plans as $pricing_plan) :

        $pricing_title = esc_html($pricing_plan['pricing_title']);
        $tagline = esc_html($pricing_plan['tagline']);
        $price_tag = htmlspecialchars_decode(wp_kses_post($pricing_plan['price_tag']));
        $pricing_img = $pricing_plan['image'];
        $pricing_url = esc_url($pricing_plan['url']);
        $pricing_button_text = esc_html($pricing_plan['button_text']);
        $button_new_window = esc_html($pricing_plan['button_new_window']);
        $highlight = esc_html($pricing_plan['highlight']);


        $price_tag = (empty($price_tag)) ? '' : $price_tag;
        $pricing_url = (empty($pricing_url)) ? '#' : esc_url($pricing_url);

        ?>

        <div
            class="db-pricing-plan <?php echo(!empty($highlight) ? ' db-highlight' : ''); ?> <?php echo $column_style; ?>">

            <div class="db-top-header">

                <?php if (!empty($tagline))
                    echo '<p class="db-tagline center">' . $tagline . '</p>'; ?>

                <h3 class="db-center"><?php echo $pricing_title; ?></h3>

                <?php

                if (!empty($pricing_img)) :
                    echo wp_get_attachment_image($pricing_img, 'full', false, array('class' => 'db-image full', 'alt' => $pricing_title));
                endif;

                ?>

            </div>

            <h4 class="db-plan-price db-plan-header db-center">

                <span class="db-text">

                    <?php echo wp_kses_post($price_tag); ?>

                </span>

            </h4>

            <div class="db-plan-details">

                    <?php

                    foreach ($pricing_plan['items'] as $pricing_item) : ?>

                            <div class="db-pricing-item">

                                <div class="db-title">

                                    <?php echo htmlspecialchars_decode(wp_kses_post($pricing_item['title'])); ?>

                                </div>

                                <div class="db-value-wrap">

                                    <?php

                                    if (!empty($pricing_item['icon_new'])) {
                                        echo siteorigin_widget_get_icon($pricing_item['icon_new']);
                                    }

                                    ?>

                                    <div class="db-value">

                                        <?php echo htmlspecialchars_decode(wp_kses_post($pricing_item['value'])); ?>

                                    </div>

                                </div>

                            </div>

                    <?php endforeach; ?>

            </div>
            <!-- .db-plan-details -->

            <div class="db-purchase">

                <a class="db-button default" href="<?php echo esc_url($pricing_url); ?>"
                    <?php if (!empty($button_new_window))
                        echo 'target="_blank"'; ?>><?php echo esc_html($pricing_button_text); ?></a>

            </div>

        </div>
        <!-- .db-pricing-plan -->

    <?php

    endforeach;

    ?>

</div><!-- .db-pricing-table -->

<div class="db-clear"></div>