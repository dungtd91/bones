<?php
$last_row = floor( ( count( $instance['features'] ) - 1 ) / $instance['per_row'] );
if ( ! empty( $instance['widget_title'] ) ) : ?>
	<h2 class="db-features-title"><?php echo $instance['widget_title']; ?></h2>
<?php endif; ?>

<div class="db-features-list">

	<?php foreach ( $instance['features'] as $i => $feature ) : ?>

		<?php if ( $i % $instance['per_row'] == 0 && $i != 0 ) : ?>
			<div class="db-features-clear"></div>
		<?php endif; ?>

		<div class="db-features-feature media <?php if ( floor( $i / $instance['per_row'] ) == $last_row )
			echo 'db-features-feature-last-row' ?>"
		     style="width: <?php echo round( 100 / $instance['per_row'], 3 ) ?>%">

			<?php if ( ! empty( $feature['more_url'] ) && $instance['icon_link'] ) {
				echo '<a href="' . sow_esc_url( $feature['more_url'] ) . '" ' . ( $instance['new_window'] ? 'target="_blank"' : '' ) . '>';
			} ?>
			<div class="db-icon-container media-left">
				<?php
				if ( ! empty( $feature['icon_image'] ) ) {
					$attachment = wp_get_attachment_image_src( $feature['icon_image'] );
					$icon_image = aq_resize( $attachment[0], 92, 92, false, false );
					if ( ! empty( $attachment ) ) {
						?>
					<div class="db-icon-image"
					     style="width:<?php echo $icon_image[1] ?>px;height:<?php echo $icon_image[2] ?>px">
						<img class="media-object" src="<?php echo $icon_image[0] ?>"
						     width="<?php echo $icon_image[1] ?>" height="<?php echo $icon_image[2] ?>">
						</div><?php
					}
				}
				?>
			</div>
			<?php if ( ! empty( $feature['more_url'] ) && $instance['icon_link'] ) {
				echo '</a>';
			} ?>

			<div class="textwidget media-body">
				<?php if ( ! empty( $feature['title'] ) ) : ?>
					<h5>
						<?php if ( ! empty( $feature['more_url'] ) && $instance['title_link'] ) {
							echo '<a href="' . sow_esc_url( $feature['more_url'] ) . '" ' . ( $instance['new_window'] ? 'target="_blank"' : '' ) . '>';
						} ?>
						<?php echo wp_kses_post( $feature['title'] ) ?>
						<?php if ( ! empty( $feature['more_url'] ) && $instance['title_link'] ) {
							echo '</a>';
						} ?>
					</h5>
				<?php endif; ?>

				<?php if ( ! empty( $feature['text'] ) ) : ?>
					<p><?php echo wp_kses_post( $feature['text'] ) ?></p>
				<?php endif; ?>

				<?php if ( ! empty( $feature['more_text'] ) ) : ?>
					<p class="db-more-text">
						<?php if ( ! empty( $feature['more_url'] ) ) {
							echo '<a href="' . sow_esc_url( $feature['more_url'] ) . '" ' . ( $instance['new_window'] ? 'target="_blank"' : '' ) . '>';
						} ?>
						<?php echo wp_kses_post( $feature['more_text'] ) ?>
						<?php if ( ! empty( $feature['more_url'] ) ) {
							echo '</a>';
						} ?>
					</p>
				<?php endif; ?>
			</div>
		</div>

	<?php endforeach; ?>
	<?php
	$callout_section = $instance['callout_section'];
	if ( $callout_section['cta_link'] ) {
		$callout_styles = array();
		$btn_position = $callout_section['cta_alignment'];
		$icon = siteorigin_widget_get_icon( $callout_section['cta_icon'], ['font-size: 18px', 'color: #fff'] );
		$callout_styles[] = "float: $btn_position";
		printf( '<a class="read-more" href="%1$s" style="%3$s">'.$icon.'%2$s</a>', sow_esc_url( $callout_section['cta_link'] ), $callout_section['cta_text'], implode('; ', $callout_styles));
	}
	?>
</div>