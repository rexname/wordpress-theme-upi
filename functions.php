<?php
add_action('after_setup_theme', function () {
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_theme_support('custom-logo', [
    'height'      => 64,
    'width'       => 64,
    'flex-height' => true,
    'flex-width'  => true,
  ]);
  register_nav_menus([
    'primary' => 'Primary Menu',
  ]);
});

add_action('wp_enqueue_scripts', function () {
  wp_enqueue_style('upi-style', get_stylesheet_uri(), [], '0.1.0');
  wp_enqueue_script('upi-header', get_template_directory_uri() . '/assets/js/header.js', [], '0.1.0', true);
  wp_enqueue_script('upi-loadmore', get_template_directory_uri() . '/assets/js/loadmore.js', [], '0.1.0', true);
  wp_localize_script('upi-loadmore', 'upiAjax', [
    'url' => admin_url('admin-ajax.php')
  ]);
});


function upi_get_top_categories($limit = 3) {
  return get_categories(['number' => $limit, 'orderby' => 'count', 'order' => 'DESC']);
}
function upi_get_all_categories() {
  return get_categories(['hide_empty' => true, 'orderby' => 'count', 'order' => 'DESC']);
}

function upi_render_headline_item($post) {
  setup_postdata($post);
  $cat = get_the_category();
  $cat_name = $cat ? $cat[0]->name : '';
  ob_start();
  ?>
  <article class="headline-item">
    <div class="text">
      <div class="meta"><span class="cat"><?php echo esc_html($cat_name); ?></span> <span class="sep">//</span> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> ago</div>
      <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
      <div class="excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 28)); ?></div>
    </div>
    <a href="<?php the_permalink(); ?>" class="thumb">
      <?php if (has_post_thumbnail()) the_post_thumbnail('medium_large'); ?>
    </a>
  </article>
  <?php
  return ob_get_clean();
}

function upi_load_more() {
  $page = isset($_POST['page']) ? max(2, intval($_POST['page'])) : 2;
  $per_page = 8;
  $q = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => $per_page,
    'paged' => $page,
    'ignore_sticky_posts' => true,
  ]);
  $html = '';
  if ($q->have_posts()) {
    while ($q->have_posts()) { $q->the_post();
      $html .= upi_render_headline_item(get_post());
    }
    wp_reset_postdata();
  }
  wp_send_json([
    'html' => $html,
    'has_more' => ($q->max_num_pages > $page)
  ]);
}
add_action('wp_ajax_upi_load_more', 'upi_load_more');
add_action('wp_ajax_nopriv_upi_load_more', 'upi_load_more');
