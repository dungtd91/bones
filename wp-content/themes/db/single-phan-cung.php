<?php
/**
 * The template for displaying all single posts - phan cung.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package db
 */

get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>

	<?php $postID = get_the_ID(); ?>

	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<div id="product-header"><?php get_product_header($postID);?></div>

		<div id="primary" class="content-area">
			<main id="main" class="site-main" role="main">


				<?php get_template_part( 'template-parts/content', 'product' ); ?>


			</main><!-- #main -->
		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div>

<?php endwhile; // End of the loop. ?>

<?php get_footer(); ?>
