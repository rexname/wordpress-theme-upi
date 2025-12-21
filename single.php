<?php get_header(); ?>
<main class="container">
  <section class="section">
    <?php if (have_posts()): the_post(); ?>
      <article>
        <div class="post-header">
          <div class="post-meta">
            <?php
              $cats = get_the_category();
              $cat_name = $cats ? $cats[0]->name : '';
            ?>
            <span class="cat"><?php echo esc_html($cat_name); ?></span>
            <span class="time">• <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> ago</span>
          </div>
          <h1 class="post-title"><?php the_title(); ?></h1>
        </div>
        <?php if (has_post_thumbnail()): ?>
          <div class="post-thumb"><?php the_post_thumbnail('large'); ?></div>
        <?php endif; ?>
        <div class="post-content"><?php the_content(); ?></div>
        <div class="post-tags">
          <?php the_tags('', ' '); ?>
        </div>
      </article>
    <?php endif; ?>
  </section>
</main>
<?php get_footer(); ?>
