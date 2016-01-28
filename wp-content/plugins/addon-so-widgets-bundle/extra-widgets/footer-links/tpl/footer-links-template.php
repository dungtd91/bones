<div class="wow fadeIn footer" data-wow-duration="1s" data-wow-delay="0s" data-wow-offset="10" data-wow-iteration="1">
	<div class="main-widget widget_footer_links">
		<?php
		$widget_title = wp_kses_post( $instance['widget_title'] );
		if ( $widget_title ) { ?>
			<h4 class="widget-title"><?php echo $widget_title ?></h4>
		<?php } ?>
		<ul class="footer-links">
			<?php foreach ( $instance['links'] as $i => $link ) : ?>
				<li><a href="<?php if ($link['more_url']) echo $link['title'];?>"><?php if ($link['title']) echo $link['title'];?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>