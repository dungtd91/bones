<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package db
 */

if ( ! function_exists( 'db_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function db_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date('d/m/Y') ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date('d/m/Y') )
		);

		$byline = sprintf(
				esc_html_x( '%s - ', 'post author', 'db' ),
				'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		$posted_on = sprintf(
			esc_html_x( '%s ', 'post date', 'db' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);



		echo '<span class="byline">' . $byline . '</span><span class="posted-on"> ' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'db_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function db_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
//			$categories_list = get_the_category_list( esc_html__( ', ', 'db' ) );
//			if ( $categories_list && db_categorized_blog() ) {
//				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'db' ) . '</span>', $categories_list ); // WPCS: XSS OK.
//			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html__( '', 'db' ) );

			if ( $tags_list ) {
				printf( '<div class="tags-links"><h3 class="sd-title">Tags</h3>' . esc_html__( '%1$s', 'db' ) . '</div>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( esc_html__( 'Leave a comment', 'db' ), esc_html__( '1 Comment', 'db' ), esc_html__( '% Comments', 'db' ) );
			echo '</span>';
		}

		edit_post_link(
			sprintf(
			/* translators: %s: Name of current post */
				esc_html__( 'Edit %s', 'db' ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function db_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'db_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'db_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so db_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so db_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in db_categorized_blog.
 */
function db_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'db_categories' );
}

add_action( 'edit_category', 'db_category_transient_flusher' );
add_action( 'save_post', 'db_category_transient_flusher' );

/**
 * Gets the Logo Site
 */
function db_get_logo() {

	$description = esc_attr( get_bloginfo( 'description' ) );
	$name        = esc_attr( get_bloginfo( 'name' ) );

	$db_site_logo = get_field( 'db_site_logo', 'options' );
	if ( ! empty( $db_site_logo ) ) {
		echo '<a class="link-logo" href="' . esc_url( home_url( '/' ) ) . '" title="' . $description . '" rel="home"><img class="logo" src="' . $db_site_logo['url'] . '" alt="' . $description . '"/></a>';
	} else {
		echo '<a class="logo-description" href="' . esc_url( home_url( '/' ) ) . '" title="' . $description . '" rel="home"><img class="logo" src="' . get_template_directory_uri() . '/images/logo.png' . '" alt="' . $description . '"/></a>';
	}
}

/**
 * Get primary nav
 */
function db_get_primary_nav() {
	wp_nav_menu( array(
			'menu'            => 'primary',
			'theme_location'  => 'primary',
			'depth'           => 2,
			'container'       => 'div',
			'container_class' => 'collapse navbar-collapse',
			'container_id'    => 'db-navbar-collapse',
			'menu_class'      => 'nav navbar-nav',
			'fallback_cb'     => 'DB_Nav_Walker::fallback',
			'walker'          => new DB_Nav_Walker()
		)
	);
}

/**
 * Get address
 */
function db_get_list_address() {
	$db_list_address = get_field( 'db_contact_address', 'options' );
	if ( count( $db_list_address ) ) {
		$column_width = ( ( 100 / count( $db_list_address ) ) > 3 ) ? 3 : ( 100 / count( $db_list_address ) );
		echo '<div class="wow fadeIn list-address" data-wow-duration="1s" data-wow-delay="0s" data-wow-offset="10" data-wow-iteration="1"><div class="container">';
		echo '<p class="title">LIÊN HỆ</p><ul class="list-inline list-unstyled">';
		foreach ( $db_list_address as $address ) {
			echo '<li style="width: ' . 100 / $column_width . '%;"><div>';
			if ( $address['db_contact_address_title'] ) {
				echo '<p class="address-title">' . $address['db_contact_address_title'] . '</p>';
			}
			if ( $address['db_contact_address_content'] ) {
				echo $address['db_contact_address_content'];
			}
			echo '</div></li>';
		}
		echo '</ul></div></div>';
	}
}

/**
 * Get footer bottom
 */
function db_get_footer_bottom() {
	$db_copyright_text  = get_field( 'db_copyright_text', 'options' );
	$db_facebook_url    = get_field( 'db_facebook_url', 'options' );
	$db_youtube_url     = get_field( 'db_youtube_url', 'options' );
	$db_google_plus_url = get_field( 'db_google_plus_url', 'options' );
	$db_twitter_url     = get_field( 'db_twitter_url', 'options' );
	echo '<div id="bottom" class="container"><div class="row"><div class="social col-sm-5">';
	if ( $db_facebook_url ) {
		printf( '<a rel="nofollow" href="%1$s" target="_balnk"><img src="%2$s" class="img img1">
			</a>', $db_facebook_url, get_template_directory_uri() . '/images/social_fb.png' );
	}
	if ( $db_youtube_url ) {
		printf( '<a rel="nofollow" href="%1$s" target="_balnk"><img src="%2$s" class="img img1">
			</a>', $db_youtube_url, get_template_directory_uri() . '/images/social_yt.png' );
	}
	if ( $db_google_plus_url ) {
		printf( '<a rel="nofollow" href="%1$s" target="_balnk"><img src="%2$s" class="img img1">
			</a>', $db_google_plus_url, get_template_directory_uri() . '/images/social_gplus.png' );
	}
	if ( $db_twitter_url ) {
		printf( '<a rel="nofollow" href="%1$s" target="_balnk"><img src="%2$s" class="img img1">
			</a>', $db_twitter_url, get_template_directory_uri() . '/images/social_tw.png' );
	}
	echo '</div>';
	if ( $db_copyright_text ) {
		echo '<p class="copy col-sm-7"><span>' . $db_copyright_text . '</span>
		</p>';
	}
	echo '</div></div>';
}

/**
 * Get page header
 */
function db_get_page_header() {
	$page_id = '';
	if ( is_home() ) {
		$page_object = get_queried_object();
		$page_id     = get_queried_object_id();
	} elseif (is_singular( 'post' )) {
		// post in category blog
		if (in_category('blog', get_the_ID())) {
			$page_id = get_option('page_for_posts');
		}
	}

	if (!$page_id) return;

	$enable_page_header = get_field( 'enable_page_header', $page_id );
	if ( $enable_page_header ) {
		$background_image = get_field( 'background_image', $page_id );
		$page_title       = get_field( 'page_title', $page_id );
		$page_description = get_field( 'page_description', $page_id );
		$button_label     = get_field( 'button_label', $page_id );
		$button_link      = get_field( 'button_link', $page_id ); ?>

		<div class="db-page-header <?php if(!isset($background_image)) echo 'no-bg'; ?>">
			<div class="container">
				<?php if ( $page_title || $page_description ): ?>
					<div class="page-header-caption">
						<?php if ( $page_title ): ?>
							<h1 class="page-title"><?php echo $page_title ?></h1>
							<div class="line"></div>
						<?php endif; ?>
						<?php if ( $page_description ): ?>
							<div class="page-description"><?php echo $page_description; ?></div>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
		if ( function_exists( 'yoast_breadcrumb' )) {
			yoast_breadcrumb( '<div id="db-breadcrumbs"><div class="container">', '</div></div>' );
		}
	}
}

/*
 * Paginition
 */
function db_numeric_posts_nav() {

	if( is_singular() )
		return;

	global $wp_query;

	/** Stop execution if there's only 1 page */
	if( $wp_query->max_num_pages <= 1 )
		return;

	$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
	$max   = intval( $wp_query->max_num_pages );

	/**	Add current page to the array */
	if ( $paged >= 1 )
		$links[] = $paged;

	/**	Add the pages around the current page to the array */
	if ( $paged >= 3 ) {
		$links[] = $paged - 1;
		$links[] = $paged - 2;
	}

	if ( ( $paged + 2 ) <= $max ) {
		$links[] = $paged + 2;
		$links[] = $paged + 1;
	}

	echo '<div class="navigation"><ul>' . "\n";

	/**	Previous Post Link */
	if ( get_previous_posts_link() )
		printf( '<li>%s</li>' . "\n", get_previous_posts_link('&laquo;') );

	/**	Link to first page, plus ellipses if necessary */
	if ( ! in_array( 1, $links ) ) {
		$class = 1 == $paged ? ' class="active"' : '';

		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

		if ( ! in_array( 2, $links ) )
			echo '<li>…</li>';
	}

	/**	Link to current page, plus 2 pages in either direction if necessary */
	sort( $links );
	foreach ( (array) $links as $link ) {
		$class = $paged == $link ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
	}

	/**	Link to last page, plus ellipses if necessary */
	if ( ! in_array( $max, $links ) ) {
		if ( ! in_array( $max - 1, $links ) )
			echo '<li>…</li>' . "\n";

		$class = $paged == $max ? ' class="active"' : '';
		printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
	}

	/**	Next Post Link */
	if ( get_next_posts_link() )
		printf( '<li>%s</li>' . "\n", get_next_posts_link('&raquo;') );

	echo '</ul></div>' . "\n";

}

function get_product_header($postID) { ?>
	<div class="images">
		<?php

		$product_gallery_images = get_field( 'product_gallery_image', $postID );
		$slider_width = 570;
		$slider_height = 420;

		if ( has_post_thumbnail() && count( $product_gallery_images ) ) { ?>
			<div id="product-slider">
				<ul class="slides">
					<?php
					if ( has_post_thumbnail() ) {
						$product_image_url = get_the_post_thumbnail_url( $postID, 'full' );
						$product_image     = aq_resize( $product_image_url, $slider_width, $slider_height, true, false );
						if ( ! $product_image ) {
							$product_image = db_aq_resize( $product_image_url );
						}
						?>
						<li style="width: <?php echo $slider_width; ?>px; height: <?php echo $slider_height; ?>px">
							<img data-src="<?php echo $product_image[0]; ?>" width="<?php echo $product_image[1]; ?>"
							     height="<?php echo $product_image[2]; ?>"/>
						</li>
					<?php }
					foreach ( $product_gallery_images as $image ):
						$image_resize = aq_resize( $image['url'], $slider_width, $slider_height, true, false, true );
						?>
						<li style="width: <?php echo $slider_width; ?>px; height: <?php echo $slider_height; ?>px">
							<img data-src="<?php echo $image_resize[0]; ?>" width="<?php echo $image_resize[1]; ?>"
							     height="<?php echo $image_resize[2]; ?>" alt="<?php echo $image['alt']; ?>"/>
						</li>
					<?php endforeach; ?>
				</ul>
				<div id="product-thumbnails">
					<?php $i = 0; ?>
					<?php if ( has_post_thumbnail() ):
						$product_image_url = get_the_post_thumbnail_url( $postID, 'full' );
						$product_image     = aq_resize( $product_image_url, 170, 130, true, false, true );
						?>
						<a data-slide-index="<?php echo $i; ?>" href="#"><img
									data-src="<?php echo $product_image[0]; ?>" width="<?php echo $product_image[1]; ?>"
									height="<?php echo $product_image[2]; ?>"/></a>
						<?php $i ++; endif; ?>
					<?php
					foreach ( $product_gallery_images as $image ):
						$image_resize = aq_resize( $image['url'], 170, 130, true, false, true );
						?>
						<a data-slide-index="<?php echo $i; ?>" href="#"><img
									data-src="<?php echo $image_resize[0]; ?>" width="<?php echo $image_resize[1]; ?>"
									height="<?php echo $image_resize[2]; ?>"/></a>
						<?php $i++;?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php } else if (has_post_thumbnail()){ ?>
			<div id="product-slider">
				<?php
				$product_image_url = get_the_post_thumbnail_url( $postID, 'full' );
				$product_image     = aq_resize( $product_image_url, 570, 420, true, false );
				if ( ! $product_image ) {
					$product_image = db_aq_resize( $product_image_url );
				}
				?>
				<img data-src="<?php echo $product_image[0]; ?>" width="<?php echo $product_image[1]; ?>"
				     height="<?php echo $product_image[2]; ?>"/>
			</div>
		<?php } ?>
	</div>
	<div class="summary entry-summary">
		<?php
		$db_product_sku      = get_field( 'db_product_sku', $postID );
		$db_product_brand    = get_field( 'db_product_brand', $postID );
		$db_product_warranty = get_field( 'db_product_warranty', $postID );
		$db_product_price    = get_field( 'db_product_price', $postID );
		?>
		<h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>

		<div class="description" itemprop="description">
			<?php the_content(); ?>
		</div>
		<?php if ( $db_product_sku ): ?>
			<div class="product-sku"><strong>Mã sản phẩm:</strong> <?php echo $db_product_sku; ?></div>
		<?php endif; ?>
		<div class="info">
			<?php if ( $db_product_brand ): ?>
				<p class="product-brand"><strong>Hãng sản xuất:</strong> <?php echo $db_product_brand; ?></p>
			<?php endif; ?>
			<?php if ( $db_product_warranty ): ?>
				<p class="product-arranty"><strong>Bảo hành:</strong> <?php echo $db_product_warranty; ?></p>
			<?php endif; ?>
			<?php if ( $db_product_price ): ?>
				<p class="product-price"><strong>Giá bán:</strong> <?php echo $db_product_price; ?></p>
			<?php endif; ?>
		</div>
	</div>
<?php }
