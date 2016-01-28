<?php

if(!class_exists('Aq_Resize')) require get_template_directory() . '/inc/aq_resizer.php';

/**
 * Recent Posts Widget Class
 */
class DB_Recent_Posts_Widget_Pro extends WP_Widget {

	/** constructor */
	function DB_Recent_Posts_Widget_Pro() {
		parent::WP_Widget(false, $name = __('DB Recent Posts Pro (Sidebar)', 'db'));
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {
		extract( $args );
		$title 			= apply_filters('widget_title', $instance['title']);
		$post_title		= strip_tags($instance['post_title']);
		$author			= strip_tags($instance['author']);
		$time			= strip_tags($instance['time']);
		$comments		= strip_tags($instance['comments']);
		$excerpt		= strip_tags($instance['excerpt']);
		$excerpt_length	= strip_tags($instance['excerpt_length']);
		$order 			= strip_tags($instance['order']);
		$sortby 		= strip_tags($instance['sortby']);
		$number 		= strip_tags($instance['number']);
		$offset 		= strip_tags($instance['offset']);
		$cat 			= strip_tags($instance['cat']);
		$cat_ids		= strip_tags($instance['cat_ids']);
		$thumbnail_size_width = strip_tags($instance['thumbnail_size_width']);
		$thumbnail_size_height = strip_tags($instance['thumbnail_size_height']);
		$thumbnail 		= $instance['thumbnail'];
		$posttype 		= $instance['posttype'];
		?>
		<?php echo $before_widget; ?>
		<?php if ( $title )
			echo $before_title . $title . $after_title; ?>
		<ul class="no-bullets">
			<?php
			global $post;
			$tmp_post = $post;
			$args = array( 'numberposts' => $number, 'offset'=> $offset, 'post_type' => $posttype, 'orderby' => $sortby, 'order' => $order );
			if($cat != 'All') {
				$cats = explode(',', $cat_ids);
				if(is_numeric($cats[0])) { $field = 'id'; } else { $field = 'slug'; }
				$args['tax_query'] = array(
					array(
						'taxonomy' 	=> $cat,
						'field' 	=> $field,
						'terms'		=> $cats,
						'operator'	=> 'IN'
					)
				);
			}
			$myposts = get_posts( $args );
			foreach( $myposts as $post ) : setup_postdata($post); ?>
				<?php $post_class = get_post_class('', $post); $post_class = implode(' ', $post_class); ?>
				<li <?php if(!empty($thumbnail_size_width) && has_post_thumbnail()) { $size = $thumbnail_size_width + 8; echo 'style="height: auto!important; height: 100%;"'; } ?> id="db_<?php echo $post->ID; ?>" class="<?php echo $post_class; ?>">
					<?php if($thumbnail == true && has_post_thumbnail()) { ?>
						<a href="<?php the_permalink(); ?>" style="float: left; margin: 0 5px 0 0;" class="db-thumb-link">
							<?php
							$post_image_url = get_the_post_thumbnail_url($post->ID,'full');
							$post_image = aq_resize($post_image_url, $thumbnail_size_width, $thumbnail_size_height, true, false );
							?>
							<img class="img-responsive" src="<?php echo $post_image[0];?>" width="<?php echo $post_image[1];?>" height="<?php echo $post_image[2];?>">
						</a>
					<?php } ?>
					<?php if($post_title == true) { ?>
						<span class="db-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></span>
					<?php } ?>
					<?php if($comments == true) { ?> (<a href="<?php comments_link(); ?>" title="<?php _e('View comments on:', 'db'); echo ' ' . $post->post_title; ?>"><?php comments_number('0', '1', '%'); ?></a>)<?php } ?>
					<?php if($author == true) { _e('by' , 'db'); echo ' '; the_author(); ?> - <?php } ?>
					<?php if($time == true) { ?>
						<span class="time"><?php echo $this->time_stamp(get_the_time('U')); ?></span>
					<?php } ?>
					<?php if($excerpt == true) {
						$content_excerpt = $post->post_excerpt;
						if($content_excerpt == '') {
							$content_excerpt = $post->post_content;
						}
						$content_excerpt = strip_shortcodes(strip_tags(stripslashes($content_excerpt), '<a><em><strong><style>'));
						if (!isset($excerpt_length)) { $excerpt_length = 10; }
						$content_excerpt = preg_split('/\b/', $content_excerpt, $excerpt_length*2+1);
						$body_excerpt_waste = array_pop($content_excerpt);
						$content_excerpt = implode($content_excerpt);
						$content_excerpt .= '...';
						echo wpautop($content_excerpt);

					} ?>

				</li>
			<?php endforeach; ?>
			<?php $post = $tmp_post; ?>
		</ul>
		<?php echo $after_widget; ?>
		<?php
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['post_title'] 	= strip_tags($new_instance['post_title']);
		$instance['author'] 		= strip_tags($new_instance['author']);
		$instance['time'] 			= strip_tags($new_instance['time']);
		$instance['comments'] 		= strip_tags($new_instance['comments']);
		$instance['excerpt'] 		= strip_tags($new_instance['excerpt']);
		$instance['excerpt_length'] = strip_tags($new_instance['excerpt_length']);
		$instance['order'] 			= strip_tags($new_instance['order']);
		$instance['sortby'] 		= strip_tags($new_instance['sortby']);
		$instance['number']	 		= strip_tags($new_instance['number']);
		$instance['offset'] 		= strip_tags($new_instance['offset']);
		$instance['cat'] 			= strip_tags($new_instance['cat']);
		$instance['cat_ids']		= strip_tags($new_instance['cat_ids']);
		$instance['thumbnail_size_width'] = strip_tags($new_instance['thumbnail_size_width']);
		$instance['thumbnail_size_height'] = strip_tags($new_instance['thumbnail_size_height']);
		$instance['thumbnail'] 		= $new_instance['thumbnail'];
		$instance['posttype'] 		= $new_instance['posttype'];
		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {

		$posttypes = get_post_types('', 'objects');

		$title 			= esc_attr($instance['title']);
		$post_title		= esc_attr($instance['post_title']);
		$author			= esc_attr($instance['author']);
		$time			= esc_attr($instance['time']);
		$excerpt		= esc_attr($instance['excerpt']);
		$excerpt_length	= esc_attr($instance['excerpt_length']);
		$comments		= esc_attr($instance['comments']);
		$order			= esc_attr($instance['order']);
		$sortby			= esc_attr($instance['sortby']);
		$number 		= esc_attr($instance['number']);
		$offset 		= esc_attr($instance['offset']);
		$cat 			= esc_attr($instance['cat']);
		$cat_ids		= esc_attr($instance['cat_ids']);
		$thumbnail_size_width = esc_attr($instance['thumbnail_size_width']);
		$thumbnail_size_height = esc_attr($instance['thumbnail_size_height']);
		$thumbnail 		= esc_attr($instance['thumbnail']);
		$posttype		= esc_attr($instance['posttype']);
		?>

		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:', 'db'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('post_title'); ?>" name="<?php echo $this->get_field_name('post_title'); ?>" type="checkbox" value="1" <?php checked( '1', $post_title ); ?>/>
			<label for="<?php echo $this->get_field_id('post_title'); ?>"><?php _e('Display Post Title?', 'db'); ?></label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('author'); ?>" name="<?php echo $this->get_field_name('author'); ?>" type="checkbox" value="1" <?php checked( '1', $author ); ?>/>
			<label for="<?php echo $this->get_field_id('author'); ?>"><?php _e('Display Post Author?', 'db'); ?></label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('time'); ?>" name="<?php echo $this->get_field_name('time'); ?>" type="checkbox" value="1" <?php checked( '1', $time ); ?>/>
			<label for="<?php echo $this->get_field_id('time'); ?>"><?php _e('Display Post Date?', 'db'); ?></label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('comments'); ?>" name="<?php echo $this->get_field_name('comments'); ?>" type="checkbox" value="1" <?php checked( '1', $comments ); ?>/>
			<label for="<?php echo $this->get_field_id('comments'); ?>"><?php _e('Display Comment Count?', 'db'); ?></label>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="checkbox" value="1" <?php checked( '1', $excerpt ); ?>/>
			<label for="<?php echo $this->get_field_id('excerpt'); ?>"><?php _e('Display Post Excerpt?', 'db'); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e('Excerpt length in words', 'db'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('excerpt_length'); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" type="text" value="<?php echo $excerpt_length; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('order'); ?>"><?php _e('Choose the Order to Display Posts', 'db'); ?></label>
			<select name="<?php echo $this->get_field_name('order'); ?>" id="<?php echo $this->get_field_id('order'); ?>" class="widefat">
				<?php
				$orders = array('ASC', 'DESC');
				foreach ($orders as $post_order) {
					echo '<option value="' . $post_order . '" id="' . $post_order . '"', $order == $post_order ? ' selected="selected"' : '', '>', $post_order, '</option>';
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('sortby'); ?>"><?php _e('Choose the Post Sorting Method', 'db'); ?></label>
			<select name="<?php echo $this->get_field_name('sortby'); ?>" id="<?php echo $this->get_field_id('sortby'); ?>" class="widefat">
				<?php
				$sort_options = array('title', 'post_date', 'rand', 'menu_order');
				foreach ($sort_options as $sort) {
					echo '<option id="' . $sort . '"', $sortby == $sort ? ' selected="selected"' : '', '>', $sort, '</option>';
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number to Show:', 'db'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('offset'); ?>"><?php _e('Offset (the number of posts to skip):', 'db'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('offset'); ?>" name="<?php echo $this->get_field_name('offset'); ?>" type="text" value="<?php echo $offset; ?>" />
		</p>
		<p>
			<input id="<?php echo $this->get_field_id('thumbnail'); ?>" name="<?php echo $this->get_field_name('thumbnail'); ?>" type="checkbox" value="1" <?php checked( '1', $thumbnail ); ?> class="extra-options-thumb"/>
			<label for="<?php echo $this->get_field_id('thumbnail'); ?>"><?php _e('Display Thumbnails?', 'db'); ?></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('thumbnail_size_width'); ?>" class="disabled-thumb-fields" ><?php _e('Size of the thumbnails, e.g.', 'db'); ?> <em>80</em> = 80px x 80px</label>
			<input class="widefat disabled-thumb-fields" id="<?php echo $this->get_field_id('thumbnail_size_width'); ?>" name="<?php echo $this->get_field_name('thumbnail_size_width'); ?>" type="text" value="<?php echo $thumbnail_size_width; ?>" col="4" />
			<input class="widefat disabled-thumb-fields" id="<?php echo $this->get_field_id('thumbnail_size_height'); ?>" name="<?php echo $this->get_field_name('thumbnail_size_height'); ?>" type="text" value="<?php echo $thumbnail_size_height; ?>" col="4"  />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e('Choose the Taxonomy to Display Posts From', 'db'); ?></label>
			<select name="<?php echo $this->get_field_name('cat'); ?>" id="<?php echo $this->get_field_id('cat'); ?>" class="widefat extra-options-select">
				<?php
				$cats = get_taxonomies('','names');
				echo '<option id="cats-all"', $cat == 'cats-all' ? ' selected="selected"' : '', '>All</option>';
				foreach ($cats as $tax) {
					echo '<option id="' . $tax . '"', $cat == $tax ? ' selected="selected"' : '', '>', $tax, '</option>';
				}
				?>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('cat_ids'); ?>" class="disabled-select-fields" ><?php _e('Taxonomy Term IDs to Display Posts From', 'db'); ?></label>
			<input class="widefat disabled-select-fields" id="<?php echo $this->get_field_id('cat_ids'); ?>" name="<?php echo $this->get_field_name('cat_ids'); ?>" type="text" value="<?php echo $cat_ids; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('posttype'); ?>"><?php _e('Choose the Post Type to Display', 'db'); ?></label>
			<select name="<?php echo $this->get_field_name('posttype'); ?>" id="<?php echo $this->get_field_id('posttype'); ?>" class="widefat">
				<?php
				foreach ($posttypes as $option) {
					echo '<option id="' . $option->name . '"', $posttype == $option->name ? ' selected="selected"' : '', '>', $option->name, '</option>';
				}
				?>
			</select>
		</p>
		<?php
	}

	function time_stamp($time_ago) {
		$cur_time     = time();
		$time_elapsed = $cur_time - $time_ago;
		$seconds      = $time_elapsed;
		$minutes      = round( $time_elapsed / 60 );
		$hours        = round( $time_elapsed / 3600 );
		$days         = round( $time_elapsed / 86400 );
		$weeks        = round( $time_elapsed / 604800 );
		$months       = round( $time_elapsed / 2600640 );
		$years        = round( $time_elapsed / 31207680 );

		// Seconds

		if ( $seconds <= 60 ) {
			return " Cách đây $seconds giây ";
		} // Minutes
		else if ( $minutes <= 60 ) {
			if ( $minutes == 1 ) {
				return " Cách đây 1 phút ";
			} else {
				return " Cách đây $minutes phút";
			}
		} // Hours
		else if ( $hours <= 24 ) {
			if ( $hours == 1 ) {
				return "Cách đây 1 tiếng ";
			} else {
				return " Cách đây $hours tiếng ";
			}
		} // Days
		else if ( $days <= 7 ) {
			if ( $days == 1 ) {
				return " Ngày hôm qua ";
			} else {
				return " Cách đây $days ngày ";
			}
		} // Weeks
		else if ( $weeks <= 4.3 ) {
			if ( $weeks == 1 ) {
				return " Cách đây 1 tuần ";
			} else {
				return " Cách đây $weeks tuần";
			}
		} // Months
		else if ( $months <= 12 ) {
			if ( $months == 1 ) {
				return " Cách đây 1 tháng ";
			} else {
				return " Cách đây $months tháng";
			}
		} // Years
		else {
			if ( $years == 1 ) {
				return " Cách đây 1 năm ";
			} else {
				return " Cách đây $years năm ";
			}
		}
	}
}