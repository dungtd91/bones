<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package db
 */

?>
		</div><!-- .container -->
	</div><!-- #content -->

	<footer>
		<div id="footer">
			<div class="container">
				<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			</div>
		</div>
	</footer>

	<div class="wrap-list-address">
		<?php db_get_list_address();?>
	</div>

	<div id="wrap-bottom">
		<?php db_get_footer_bottom();?>
	</div>


</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
