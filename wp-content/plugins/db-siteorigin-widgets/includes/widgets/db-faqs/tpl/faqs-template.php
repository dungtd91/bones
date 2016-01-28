<?php
$widget_title = wp_kses_post( $instance['widget_title'] );
$query        = siteorigin_widget_post_selector_process_query( $instance['posts'] );
$the_query    = new WP_Query( $query );

?>

<?php $column_style = db_get_column_class( intval( $settings['per_line'] ) );?>

<?php if ( $widget_title ) { ?>
	<h3 class="widget-title">
		<span><?php echo $widget_title ?></span>
	</h3>
<?php } ?>


<div class="db-main db-container">
	<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
		<div class="db-accordion <?php echo $column_style; ?>">
			<a class="db-accordion-title"> <?php the_title(); ?></a>

			<div class="db-accordion-content active"><?php the_content(); ?></div>
		</div>
	<?php endwhile; ?>
</div> <!-- / accordion -->


