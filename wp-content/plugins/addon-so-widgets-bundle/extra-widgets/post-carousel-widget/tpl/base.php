<?php
$query = siteorigin_widget_post_selector_process_query( $instance['posts'] );
$posts = new WP_Query( $query );
?>

<?php if($posts->have_posts()) : ?>
	<div class="sow-carousel-title">
		<?php if($instance['title']):?>
		<?php echo $args['before_title'] . esc_html($instance['title']) . $args['after_title'] ?>
		<?php endif;?>
		<a href="#" class="sow-carousel-next" title="<?php esc_attr_e('Next', 'db') ?>"></a>
		<a href="#" class="sow-carousel-previous" title="<?php esc_attr_e('Previous', 'db') ?>"></a>
	</div>

	<div class="sow-carousel-container<?php if( is_rtl() ) echo ' js-rtl' ?>">

		<a href="#" class="sow-carousel-previous" title="<?php esc_attr_e('Previous', 'db') ?>"></a>

		<a href="#" class="sow-carousel-next" title="<?php esc_attr_e('Next', 'db') ?>"></a>

		<div class="sow-carousel-wrapper"
		     data-query="<?php echo esc_attr($instance['posts']) ?>"
		     data-found-posts="<?php echo esc_attr($posts->found_posts) ?>"
		     data-ajax-url="<?php echo sow_esc_url( wp_nonce_url( admin_url('admin-ajax.php'), 'widgets_action', '_widgets_nonce' ) ) ?>"
			>
			<div class="sow-carousel-items owl-carousel owl-theme">
				<?php include 'carousel-post-loop.php' ?>
			</div>
		</div>
	</div>
<?php endif; ?>