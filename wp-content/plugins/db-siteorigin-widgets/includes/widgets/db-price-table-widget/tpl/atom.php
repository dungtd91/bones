<?php if( !empty( $instance['title'] ) ) echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>

<div class="db-pt-columns-atom">

	<?php foreach($instance['columns'] as $i => $column) : ?>
		<div class="db-pt-column <?php echo $this->get_column_classes($column, $i, $instance['columns']) ?>" style="width: <?php echo round(100/count($instance['columns']), 3) ?>%">
			<div class="db-pt-title">
				<?php echo esc_html( $column['title'] ) ?>
				<?php if( !empty( $column['subtitle'] ) ) : ?><div class="db-pt-subtitle"><?php echo esc_html( $column['subtitle'] ) ?></div><?php endif; ?>
			</div>

			<div class="db-pt-details">
				<div class="db-pt-price"><?php echo esc_html($column['price']) ?></div>
				<div class="db-pt-per"><?php echo esc_html($column['per']) ?></div>
			</div>

			<?php if(!empty($column['image'])) : ?>
				<div class="db-pt-image">
					<?php $this->column_image($column['image']) ?>
				</div>
			<?php endif; ?>

			<div class="db-pt-features">
				<?php foreach($column['features'] as $i => $feature) : ?>
					<div class="db-pt-feature db-pt-feature-<?php echo $i % 2 == 0 ? 'even' : 'odd' ?>">

						<?php
						if( !empty($feature['icon_new']) ) {
							$icon_styles = array();
							if(!empty($feature['icon_color'])) $icon_styles[] = 'color: '.$feature['icon_color'];
							echo siteorigin_widget_get_icon($feature['icon_new'], $icon_styles);
						}
						?>

						<p data-tooltip-text="<?php echo esc_attr($feature['hover']) ?>">
							<?php echo wp_kses_post($feature['text']) ?>
						</p>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="db-pt-button">
				<a href='<?php echo sow_esc_url($column['url']) ?>' class="db-pt-link" <?php if( !empty( $instance['button_new_window'] ) ) echo 'target="_blank"' ?>><?php echo esc_html($column['button']) ?></a>
			</div>
		</div>
	<?php endforeach; ?>


	<?php
	global $siteorigin_price_table_icons;
	if( empty($siteorigin_price_table_icons) ) $siteorigin_price_table_icons = array();
	foreach($instance['columns'] as $i => $column){
		foreach($column['features'] as $feature) {
			if(!empty($feature['icon']) && empty($siteorigin_price_table_icons[$feature['icon']])) {
				$siteorigin_price_table_icons[$feature['icon']] = true;
				echo '<div style="display:none" id="so-pt-icon-'.$feature['icon'].'">';
				readfile(plugin_dir_path(__FILE__).'../fontawesome/'.$feature['icon'].'.svg');
				echo '</div>';
			}
		}
	}
	?>

</div>