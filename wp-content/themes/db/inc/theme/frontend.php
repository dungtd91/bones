<?php

require get_template_directory() . '/inc/db-nav-walker.php';

class DbFrontEnd {

	var $templateURL;

	var $imageSizes = array(
		'db_271x169' => array(
			'label'  => 'Fixed Size 271x169 px',
			'width'  => 271,
			'height' => 169,
			'crop'   => true,
		),
	);

	function __construct() {

		$this->templateURL = get_bloginfo( 'template_url' );

		foreach ( $this->imageSizes as $type => $details ) {
			add_image_size( $type, $details['width'], $details['height'], $details['crop'] );
		}
		add_filter( 'image_size_names_choose', array( &$this, 'image_size_names_choose' ) );

		// actions
		add_action( 'wp_enqueue_scripts', array( &$this, 'wp_enqueue_scripts' ) );
		// filers
		add_filter( 'the_content', array( $this, 'filter_html' ) );
		add_filter( 'comment_form_defaults', array( $this, 'comment_form_defaults' ) );
	}

	function wp_enqueue_scripts() {
		// Remove Open Sans that WP adds from frontend
		wp_deregister_style( 'open-sans' );
		wp_register_style( 'open-sans', false );
		// Enqueue google fonts
		$fonts = db_google_font_enqueue();
		wp_enqueue_style( 'db-enqueue-fonts', $fonts );
		wp_enqueue_script( 'jquery' );

		wp_enqueue_style( 'db-smartmenus', get_template_directory_uri() . '/js/smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.css', array(), null, 'all' );
		wp_enqueue_style( 'db-lazyloadxt-fadein', get_template_directory_uri() . '/js/lazyloadxt/dist/jquery.lazyloadxt.fadein.css', array(), null, 'all' );
		wp_enqueue_style( 'db-header-style', get_template_directory_uri() . '/layouts/header.css' );
		wp_enqueue_style( 'db-footer-style', get_template_directory_uri() . '/layouts/footer.css' );
		wp_enqueue_style( 'db-content-sidebar', get_template_directory_uri() . '/layouts/content-sidebar.css' );

		$jsObject = array(
			'ajaxurl'        => admin_url( 'admin-ajax.php' ),
			'themeurl'       => get_bloginfo( 'template_url' ),
			'is_tpl_default' => ( is_page() AND ! is_page_template() ),
		);
		wp_localize_script( 'jquery', 'db', $jsObject );

		wp_enqueue_script( 'lazyloadxt', $this->templateURL . '/js/lazyloadxt/dist/jquery.lazyloadxt.js', array( 'jquery' ) );
		wp_enqueue_script( 'bootstrap', $this->templateURL . '/js/bootstrap.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'smooth-scroll', $this->templateURL . '/js/smoothscroll.js', array( 'jquery' ) );
		wp_enqueue_script( 'smartmenus', $this->templateURL . '/js/smartmenus/jquery.smartmenus.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'smartmenus-bootstrap', $this->templateURL . '/js/smartmenus/addons/bootstrap/jquery.smartmenus.bootstrap.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'imagesloaded', '//cdnjs.cloudflare.com/ajax/libs/jquery.imagesloaded/4.0.0/imagesloaded.pkgd.min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'matchHeight', $this->templateURL . '/js/jquery.matchHeight-min.js', array( 'jquery' ), false, true );
		wp_enqueue_script( 'db', $this->templateURL . '/js/db.js', array( 'jquery' ), false, true );

		if (is_singular('post') && in_category('phan-cung')) {
			wp_enqueue_script( 'bxslider', $this->templateURL . '/js/bxslider/jquery.bxslider.min.js', array( 'jquery' ), false, true );
			wp_enqueue_style( 'bxslider', get_template_directory_uri() . '/js/bxslider/jquery.bxslider.css', array(), null, 'all' );
			wp_enqueue_script( 'category-product', $this->templateURL . '/js/category-product.js', array(
					'jquery',
					'bxslider'
			), false, true );
		}

		wp_enqueue_style( 'db-common-style', get_template_directory_uri() . '/layouts/common.css', array( 'bootstrap' ) );
	}

	function filter_html( $content ) {
		if ( is_feed() ) {
			return $content;
		}

		if ( strlen( $content ) ) {
			$newcontent = $content;
			$newcontent = $this->preg_replace_html( $newcontent, array( 'img', 'iframe', 'embed', 'video', 'audio' ) );

			return $newcontent;
		} else {
			return $content;
		}
	}

	function preg_replace_html( $content, $tags ) {
		$dom = new DOMDocument();
		if ( ! @$dom->loadHTML( '<?xml encoding="UTF-8">' . $content ) ) // trick to set charset
		{
			return $content;
		}
		foreach ( $dom->childNodes as $item ) {
			if ( $item->nodeType === XML_PI_NODE ) {
				$dom->removeChild( $item );
				break;
			}
		}
		$dom->encoding = 'UTF-8';
		$images        = $dom->getElementsByTagName( 'img' );
		$blankImage    = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
		for ( $i = $images->length - 1; $i >= 0; $i -- ) {
			$node     = $images->item( $i );
			$clone    = $node->cloneNode();
			$noscript = $dom->createElement( 'noscript' );
			$noscript->appendChild( $clone );
			$node->parentNode->insertBefore( $noscript, $node );
			$node->setAttribute( 'data-src', $node->getAttribute( 'src' ) );
			$node->setAttribute( 'src', $blankImage );
			$node->setAttribute( 'class', trim( $node->getAttribute( 'class' ) . ' lazy' ) );
		}
		$newHtml = $dom->saveHTML();
		if ( ! $newHtml ) {
			return $content;
		}

		return $newHtml;
	}

	function image_size_names_choose( $sizes ) {
		foreach ( $this->imageSizes as $type => $details ) {
			$sizes[ $type ] = $details['label'];
		}

		return $sizes;
	}


	function comment_form_defaults( $args ) {
		$comment_args = array(
			'class_submit'  => 'btn btn-default submit',
			'label_submit' => 'Gửi bình luận',
			'title_reply' => 'Bình luận',
			'comment_notes_before' =>  '<p class="comment-notes"><span id="email-notes">Địa chỉ email sẽ không công khai.</span> Vui lòng điền đủ các trường <span class="required">*</span></p>',
			'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x( 'Tin nhắn', 'db' ) . '</label> <textarea id="comment" name="comment" class="form-control" cols="45" rows="8" aria-required="true" required="required"></textarea></p>',
			'fields'        => array(
				'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Tên' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
				            '<input id="author" name="author" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . $html_req . ' /></p>',
				'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
				            '<input id="email" name="email" class="form-control" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req . ' /></p>',
				'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label> ' .
				            '<input id="url" name="url" class="form-control" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>',
			)
		);

		return $comment_args;
	}

}