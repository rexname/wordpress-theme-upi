<?php
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
  $desc = '';
  if (is_single() || is_page()) {
    $excerpt = get_the_excerpt();
    $desc = $excerpt ? wp_trim_words($excerpt, 30) : get_bloginfo('description');
  } elseif (is_category()) {
    $cat = get_queried_object();
    $desc = $cat && !empty($cat->description) ? wp_trim_words($cat->description, 30) : ('Latest posts in ' . ($cat->name ?? 'Category'));
  } elseif (is_search()) {
    $q = get_search_query();
    $desc = $q ? ('Search results for "' . $q . '"') : get_bloginfo('description');
  } else {
    $desc = get_bloginfo('description');
  }
?>
<meta name="description" content="<?php echo esc_attr($desc); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="top">
<header class="site-header">
  <div class="topbar container">
    <div class="logo">
      <?php
      if (function_exists('the_custom_logo') && has_custom_logo()) {
        the_custom_logo();
      } else {
        echo '<a href="' . esc_url(home_url('/')) . '">' . esc_html(get_bloginfo('name')) . '</a>';
      }
      ?>
    </div>
    <nav class="primary-nav">
      <?php
        $cats = get_categories(['hide_empty' => true, 'orderby' => 'count', 'order' => 'DESC', 'number' => 10]);
        foreach ($cats as $c) {
          $active = (is_category($c->term_id)) ? ' class="active"' : '';
          echo '<a'.$active.' href="' . esc_url(get_category_link($c->term_id)) . '">' . esc_html($c->name) . '</a>';
        }
      ?>
    </nav>
    <button class="search-toggle" aria-label="Open search">🔍</button>
    <div class="header-search">
      <?php get_search_form(); ?>
      <button class="close-search" aria-label="Close search">✖</button>
    </div>
  </div>
</header>

<div class="trending-ticker">
  <div class="container">
    <div class="ticker-wrapper">
      <span class="ticker-label">TRENDING</span>
      <div class="ticker-list">
        <?php
        $trending = new WP_Query([
          'post_type' => 'post',
          'posts_per_page' => 8,
          'orderby' => 'comment_count',
          'order' => 'DESC',
          'date_query' => [['after' => '1 month ago']],
        ]);
        if (!$trending->have_posts()) {
          $trending = new WP_Query([
            'post_type' => 'post',
            'posts_per_page' => 8,
            'orderby' => 'date',
            'order' => 'DESC',
          ]);
        }
        $count = 0;
        while ($trending->have_posts()) : $trending->the_post();
          if ($count > 0) echo '<span class="sep">|</span>';
          ?>
          <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
          <?php
          $count++;
        endwhile;
        wp_reset_postdata();
        ?>
      </div>
    </div>
  </div>
</div>

