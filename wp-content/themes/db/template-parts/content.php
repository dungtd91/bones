<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package db
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="entry-wrapper">
		<?php if ( ! is_single() && has_post_thumbnail() ) : ?>
			<div class="entry-image">
				<?php
				$post_image_thumbnail_url = get_the_post_thumbnail_url( get_the_ID(), 'full' );
				$post_image_thumbnail     = aq_resize( $post_image_thumbnail_url, 310, '', false, false );
				?>
				<a class="post-feature-image" href="<?php the_permalink(); ?>">
					<img class="img-responsive" src="<?php echo $post_image_thumbnail[0]; ?>"
					     width="<?php echo $post_image_thumbnail[1]; ?>"
					     height="<?php echo $post_image_thumbnail[2]; ?>">
				</a>
				<p class="post-create-date">
					<span class="d"><?php echo get_the_date('d/m');?></span><span class="l"></span><span class="y"><?php echo get_the_date('Y');?></span></p>
			</div>
		<?php endif; ?>
		<div class="entry-content<?php if ( ! has_post_thumbnail() )
			echo ' no-image' ?>">
			<header class="entry-header">
				<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

				<?php if ( 'post' === get_post_type() ) : ?>
					<div class="entry-meta">
						<?php db_posted_on(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</header><!-- .entry-header -->
			<?php if ( ! is_single() ) : ?>
				<div class="entry-excerpt">
					<?php the_excerpt(); ?>
				</div>
				<div class="entry-read-more">
					<a class="btn-readmore" href="<?php the_permalink(); ?>" rel="bookmark"
					   title="<?php _e( "Read more", "db" ); ?>"><?php _e( "Xem thêm", "db" ); ?></a>
				</div>
			<?php else : ?>
				<div class="entry-content">
					<?php
					the_content( sprintf(
					/* translators: %s: Name of current post. */
						wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'db' ), array( 'span' => array( 'class' => array() ) ) ),
						the_title( '<span class="screen-reader-text">"', '"</span>', false )
					) );
					?>

					<?php
					wp_link_pages( array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'db' ),
						'after'  => '</div>',
					) );
					?>
				</div><!-- .entry-content -->
				<footer class="entry-footer">
					<?php db_entry_footer(); ?>
				</footer><!-- .entry-footer -->
			<?php endif; ?>
		</div>
	</div>
</article><!-- #post-## -->
