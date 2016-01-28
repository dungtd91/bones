<?php

/**
 * related Posts Widget Class
 */
class DB_Related_Posts_Widget_Pro extends WP_Widget {


    /** constructor */
    function DB_Related_Posts_Widget_Pro() {
        parent::WP_Widget(false, $name = 'DB Related Posts Pro (Sidebar)', 'db');
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {	
        extract( $args );
        $title 			= apply_filters('widget_title', $instance['title']);
        $post_title		= $instance['post_title'];
        $author			= $instance['author'];
        $time			= $instance['time'];
        $comments		= $instance['comments'];
        $excerpt		= $instance['excerpt'];
        $excerpt_length	= $instance['excerpt_length'];
        $number 		= $instance['number'];
        $cat 			= $instance['cat'];
        $thumbnail_size = $instance['thumbnail_size'];
        $thumbnail 		= $instance['thumbnail'];
		$float	 		= $instance['float'];
		$cache	 		= $instance['cache'];
		if(!$cache) $cache = false;
        
		if(is_single()) {
		?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
							<?php echo db_related_posts($cat, $number, $author, $time, $comments, $post_title, $thumbnail, $thumbnail_size, $excerpt, $excerpt_length, $float, $cache); ?>
              <?php echo $after_widget; ?>
        <?php
		}
    }
/* Released by http://www.96ｄown.com */
    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {		
		$instance = $old_instance;
		$instance['title'] 			= strip_tags($new_instance['title']);
		$instance['post_title'] 	= strip_tags($new_instance['post_title']);
		$instance['author'] 		= strip_tags($new_instance['author']);
		$instance['time'] 			= strip_tags($new_instance['time']);
		$instance['comments'] 		= strip_tags($new_instance['comments']);
		$instance['excerpt'] 		= strip_tags($new_instance['excerpt']);
		$instance['excerpt_length'] = strip_tags($new_instance['excerpt_length']);
		$instance['number']	 		= strip_tags($new_instance['number']);
		$instance['cat'] 			= strip_tags($new_instance['cat']);
		$instance['thumbnail_size'] = strip_tags($new_instance['thumbnail_size']);
		$instance['thumbnail'] 		= $new_instance['thumbnail'];
		$instance['float'] 			= $new_instance['float'];
		$instance['cache'] 			= $new_instance['cache'];
		
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
        $number 		= esc_attr($instance['number']);
        $cat 			= esc_attr($instance['cat']);
        $thumbnail_size = esc_attr($instance['thumbnail_size']);
        $thumbnail 		= esc_attr($instance['thumbnail']);
		$float 			= esc_attr($instance['float']);
		$cache 			= esc_attr($instance['cache']);
        ?>

        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title:'); ?></label> 
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('post_title'); ?>" name="<?php echo $this->get_field_name('post_title'); ?>" type="checkbox" value="1" <?php checked( '1', $post_title ); ?>/>
          <label for="<?php echo $this->get_field_id('post_title'); ?>"><?php _e('Display Post Title?'); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('author'); ?>" name="<?php echo $this->get_field_name('author'); ?>" type="checkbox" value="1" <?php checked( '1', $author ); ?>/>
          <label for="<?php echo $this->get_field_id('author'); ?>"><?php _e('Display Post Author?'); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('time'); ?>" name="<?php echo $this->get_field_name('time'); ?>" type="checkbox" value="1" <?php checked( '1', $time ); ?>/>
          <label for="<?php echo $this->get_field_id('time'); ?>"><?php _e('Display Post Date?'); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('comments'); ?>" name="<?php echo $this->get_field_name('comments'); ?>" type="checkbox" value="1" <?php checked( '1', $comments ); ?>/>
          <label for="<?php echo $this->get_field_id('comments'); ?>"><?php _e('Display Comment Count?'); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('excerpt'); ?>" name="<?php echo $this->get_field_name('excerpt'); ?>" type="checkbox" value="1" <?php checked( '1', $excerpt ); ?>/>
          <label for="<?php echo $this->get_field_id('excerpt'); ?>"><?php _e('Display Post Excerpt?'); ?></label> 
        </p>
		<p>
          <input style="width: 30px;" id="<?php echo $this->get_field_id('excerpt_length'); ?>" name="<?php echo $this->get_field_name('excerpt_length'); ?>" type="text" value="<?php echo $excerpt_length; ?>" />
          <label for="<?php echo $this->get_field_id('excerpt_length'); ?>"><?php _e('Excerpt length in words'); ?></label> 
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('thumbnail'); ?>" name="<?php echo $this->get_field_name('thumbnail'); ?>" type="checkbox" value="1" <?php checked( '1', $thumbnail ); ?> class="extra-options-thumb"/>
          <label for="<?php echo $this->get_field_id('thumbnail'); ?>"><?php _e('Display Thumbnails?'); ?></label> 
        </p>
		<p>
          <input style="width: 30px;"  id="<?php echo $this->get_field_id('thumbnail_size'); ?>" name="<?php echo $this->get_field_name('thumbnail_size'); ?>" type="text" value="<?php echo $thumbnail_size; ?>"  />
          <label for="<?php echo $this->get_field_id('thumbnail_size'); ?>" ><?php _e('Size of the thumbnails, e.g. <em>80</em> = 80px x 80px'); ?></label> 
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('float'); ?>"><?php _e('Float the post image?'); ?></label> 
			<select name="<?php echo $this->get_field_name('float'); ?>" id="<?php echo $this->get_field_id('float'); ?>" class="widefat">
				<?php
				$floats = array('left', 'right', 'none');
				foreach ($floats as $float_option) {
					echo '<option id="' . $float_option . '"', $float_option == $float ? ' selected="selected"' : '', '>', $float_option, '</option>';
				}
				?>
			</select>	
        </p>
		<p>
          <input style="width: 30px;" id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" />
          <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number to Show'); ?></label> 
        </p>
		<p>
			<label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e('Choose the Taxonomy on which to Relate Posts'); ?></label> 
			<select name="<?php echo $this->get_field_name('cat'); ?>" id="<?php echo $this->get_field_id('cat'); ?>" class="widefat extra-options-select">
				<?php
				$cats = get_taxonomies('','names'); 
				foreach ($cats as $tax) {
					echo '<option id="' . $tax . '"', $cat == $tax ? ' selected="selected"' : '', '>', $tax, '</option>';
				}
				?>
			</select>	
        </p>
		<p>
          <input id="<?php echo $this->get_field_id('cache'); ?>" name="<?php echo $this->get_field_name('cache'); ?>" type="checkbox" value="1" <?php checked( '1', $cache ); ?>/>
          <label for="<?php echo $this->get_field_id('cache'); ?>"><?php _e('Cache the related items? Disable this for testing.'); ?></label> 
        </p>
        <?php 
    }


}

function db_related_posts($taxonomy = '', $number = 4, $author = false, $time = false, $comments = false, $title = true, $thumbnail = false, $thumbnail_size = 40, $excerpt = true, $excerpt_length = 10, $float = 'left', $cache = true) {
	
	global $post;
	
	if($taxonomy == '') { $taxonomy = 'post_tag'; }
	if($excerpt_length == '') { $excerpt_length = 10; }
	
	if($cache) {
		$terms = get_transient('db_terms_' . $post->ID);	
		if(false === $terms) {

			$terms = wp_get_post_terms($post->ID, $taxonomy);
			set_transient('db_terms_' . $post->ID, $terms, 3600);
		}
	} else {
		$terms = wp_get_post_terms($post->ID, $taxonomy);
		delete_transient('db_terms_' . $post->ID);
	}
		
	if ($terms) {
		$first_term 	= $terms[0]->term_id;
		$second_term 	= $terms[1]->term_id;
		$third_term 	= $terms[2]->term_id;
		$args = array(
			'post_type' 		=> get_post_type($post->ID),
			'posts_per_page' 	=> $number,
			'exclude'			=> $post->ID,
			'tax_query' => array(
				'relation' => 'OR',
				array(
					'taxonomy' => $taxonomy,
					'terms' => $first_term,
					'field' => 'id',
					'operator' => 'IN',
				),
				array(
					'taxonomy' => $taxonomy,
					'terms' => $second_term,
					'field' => 'id',
					'operator' => 'IN',
				),
				array(
					'taxonomy' => $taxonomy,
					'terms' => $third_term,
					'field' => 'id',
					'operator' => 'IN',
				)
			)
		);
		if($cache) {
			$related = get_transient('db_query_' . $post->ID);
			if(false === $related) {

				$related = get_posts($args);
				set_transient('db_query_' . $post->ID, $related, 3600);
			}
		} else {
			delete_transient('db_query_' . $post->ID);
			$related = get_posts($args);
		}
		
		$i = 0;
		if( $related ) {
			global $post;
			$temp_post = $post;
				$content .= '<ul class="related-posts-box">';
				foreach($related as $post) : setup_postdata($post);
					
						if($float != 'none' && $thumbnail == true) {	
							$item_height = $thumbnail_size + 8;
							$content .= '<li style="min-height:' . $item_height . 'px; height: auto!important; height: 100%;" class="' . get_post_class() . '">';
						} else {
							$content .= '<li class="' . get_post_class() . '">';
						}
							if($thumbnail) {
								if($float != 'none') {
									if($float == 'left') { $margin = 'right'; } else { $margin = 'left'; }
									$content .= '<div style="float: ' . $float . '; height: ' . $thumbnail_size . 'px; margin-' . $margin . ': 5px;">';
								}
								$content .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_post_thumbnail($post->ID, array($thumbnail_size)) . '</a>';
								if($float != 'none') {
									$content .= '</div>';
								}
							}	
							if($title) {
								$content .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a>';
								if($comments == true) { 
									$content .= ' (<a href="' . get_comments_link() . '" title="View comments on ' .  $post->post_title . '">' . get_comments_number('0', '1', '%') . '</a>)';
								}
							}
							if($author) {
								$content .= '<div class="related-post-author">by ' . get_the_author() . '</div>';
							}
							if($time) {
								$content .= '<div class="related-post-date"><em>' . get_the_time('F j, Y') . '</em></div>';
							}
							if($excerpt) {
								$content_excerpt = $post->post_excerpt;
								if($content_excerpt == '') {
									$content_excerpt = $post->post_content;
								}
								$content_excerpt = strip_tags(stripslashes($content_excerpt), '<a><em><strong>');
								$content_excerpt = preg_split('/\b/', $content_excerpt, $excerpt_length*2+1);
								$body_excerpt_waste = array_pop($content_excerpt);
								$content_excerpt = implode($content_excerpt);
								$content_excerpt .= '...';
								$content .= apply_filters('the_content',$content_excerpt);	
							}
						$content .= '</li>';
			
				endforeach;
				$content .= '</ul>';
					
			$post = $temp_post;
		} else {		
			$content = '<p>Sorry, no related items found.</p>';
		}
	}

	return $content;
}