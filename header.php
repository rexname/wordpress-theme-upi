<?php
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
