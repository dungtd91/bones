<?php

$quicksand_categories = $instance['filter_categories'];

function get_post_excerpt_by_id( $post_id, $limit = 20, $url=null ) {
	global $post;
	$post = get_post( $post_id );
	setup_postdata( $post );
	$excerpt = get_the_excerpt();
	wp_reset_postdata();

	$excerpt = explode(' ', $excerpt, $limit);

	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'... <a class="read-more" href='.$url.'><span>Xem Thêm</span></a>';
	} else {
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);

	return $excerpt;

}


if ( ! empty( $quicksand_categories ) ) {


	?>
	<div class="options-container">
		<ul id="filterOptions">
			<?php $cat_descriptions = array(); ?>
				<li class="active"><a href="#" class="all">All</a></li>

			<?php foreach ( $quicksand_categories as $catID ) {
				if ( $catID == 0 ) {
				} else {
					$filter_category = get_cat_name( $catID );
					?>
					<li><a href="#" class="<?php echo $catID; ?>"><?php echo $filter_category; ?></a></li>
					<?php $cat_descriptions[ $catID ] = category_description( $catID ); ?>
				<?php }
			} ?>
		</ul>
	</div>
	<ul class="ourHolder">
		<?php
		$args  = array(
			'posts_per_page' => '-1',
			'post_type'      => 'post',
			'post_status'    => 'publish',
			'category__in'   => $quicksand_categories
		);
		$query = new WP_Query( $args );
		foreach ( $query->posts as $item ) {
			$categories = wp_get_post_categories( $item->ID );
			?>
			<li id="item" class="item" data-id="id-<?php echo $item->ID ?>"
			    data-type="<?php foreach ( $categories as $c ) {
				    echo $c . ' ';
			    } ?>">
				<div class="post-img-feature">
					<a class="img-responsive img-post-thumnail" href="<?php echo get_permalink( $item->ID ); ?>">
						<?php
						$img_url = get_the_post_thumbnail_url( $item->ID, 'full' );
						$image   = aq_resize( $img_url, 370, 227, true );
						if ( $image ) {
							echo '<img src="' . $image . '"/>';
						} else {
							echo '<img src="http://placehold.it/370x227">';
						}
						?></a>
				</div>


				<h2 class="post-title"><a href="<?php echo get_permalink( $item->ID ); ?>">
						<?php echo get_the_title( $item->ID ); ?>
					</a></h2>

				<div class="post-meta">
					<span class="author"><?php echo get_the_author_meta('display_name', $item->post_author);?></span>
					<span class="date"><?php echo get_the_date("d/m/Y",$item->ID);?></span>
				</div>
				<div class="post-description"><?php echo get_post_excerpt_by_id( $item->ID, 20, get_permalink( $item->ID ) ) ?></div>
			</li>
		<?php } ?>
	</ul>

<?php } ?>