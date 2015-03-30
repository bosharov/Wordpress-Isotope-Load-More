<?php
	add_action( 'wp_enqueue_scripts', 'add_javascript');
	function add_javascript() {
		wp_enqueue_script('mft_ajax', get_template_directory_uri() . '/js/ajax-load-more.js' );
		wp_localize_script('mft_ajax', 'mft_load_more_ajax', array(
			'ajaxurl' =>admin_url('admin-ajax.php'),
		));
	}

	function mft_load_more_ajax() {

		if( ! wp_verify_nonce($_POST['nonce'], 'mft_load_more_ajax'))
			return;

		$offset = $_POST['offset'];

		if($offset != NULL && absint($offset)) {

			// Finally, we'll set the query arguments and instantiate WP_Query
			$query_args = array(
			  'post_type'  =>  'portfolio',
			  'posts_per_page'     =>  $offset,
			  'offset'     =>  $offset
			);
			$post_list = array();
			$i = 0;
			$custom_query = new WP_Query ( $query_args );
			if ( $custom_query->have_posts() ) {
				while ( $custom_query->have_posts() ) {
					$custom_query->the_post();
					$image = get_field('image');
                    $type = get_field('type');
                    $type = strtolower($type);
                    ob_start(); ?>
                      <div class="item item-<?php echo $type; ?>">
                        <?php echo show_image($image, get_permalink(), 'large'); ?>
                      </div>
                    <?php
                    $post_list[$i] = ob_get_clean();
                    $i++;
				}
				echo json_encode($post_list);

			} else {
				// no posts found
			}
		}

		die();
	}
	add_action( 'wp_ajax_mft_load_more_ajax', 'mft_load_more_ajax' );
	add_action( 'wp_ajax_nopriv_mft_load_more_ajax', 'my_action_callback' );
