<?php

$widget_title = wp_kses_post( $instance['widget_title'] );
$column_style = db_get_column_class( intval( $settings['per_line'] ) );
$query_args   = siteorigin_widget_post_selector_process_query( $products );
$loop         = new WP_Query( $query_args );

if ( $loop->have_posts() ) : ?>
	<?php if ( $widget_title ) { ?>
		<h3 class="widget-title">
			<span><?php echo $widget_title ?></span>
		</h3>
	<?php } ?>
	<div class="db-products db-container">
			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
				<?php $postID = get_the_ID();?>
				<div class="db-product-wrapper <?php echo $column_style; ?>">
					<?php if (has_post_thumbnail()):
						$product_image_url = get_the_post_thumbnail_url($postID,'full');
						$product_image = aq_resize($product_image_url, '', 200, false, false );
						$product_sku = get_field('db_product_sku', $postID);
						$product_price = get_field('db_product_price', $postID);
					?>
					<a class="product-feature-image" href="<?php the_permalink();?>">
						<img class="img-responsive" src="<?php echo $product_image[0];?>" width="<?php echo $product_image[1];?>" height="<?php echo $product_image[2];?>">
					</a>
					<?php endif;?>
					<div class="info" data-mh="product-info">
						<a class="product-title" href="<?php the_permalink();?>"><?php the_title();?></a>
						<p class="product-sku">Mã sản phẩm: <?php echo $product_sku;?></p>
						<p class="product-price">Giá: <?php echo $product_price;?></p>
					</div>
				</div>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		</div>
	</div>
<?php endif; ?>

