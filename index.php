<?php wp_head(); ?>


<div id="hero-squares">

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
      	<?php
            $image = get_field('image');
            $type = get_field('type');
            $type = strtolower($type);
            ob_start(); ?>
              <div class="item item-<?php echo $type; ?>">
                <?php echo show_image($image, get_permalink(), 'large'); ?>
              </div>
            <?php
            echo ob_get_clean();
      	?>
    <?php endwhile;endif ?>

</div>
<button class="load-more-posts" data-nonce="<?php echo wp_create_nonce('mft_load_more_ajax'); ?>" data-offset="10">Load More Posts</button>
       
<?php wp_footer(); ?>