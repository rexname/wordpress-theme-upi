<?php get_header(); ?>
<main class="container">
  <?php
  $q = new WP_Query([
    'post_type' => 'post',
    'posts_per_page' => 10,
    'ignore_sticky_posts' => true,
  ]);
  if ($q->have_posts()):
    $q->the_post();
  ?>
  <section class="grid">
    <article class="hero">
      <a href="<?php the_permalink(); ?>">
        <?php if (has_post_thumbnail()) the_post_thumbnail('large'); ?>
      </a>
      <div class="overlay">
        <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
      </div>
    </article>
    <div class="tiles">
      <?php
      $count = 0;
      while ($q->have_posts() && $count < 4) {
        $q->the_post();
        $count++;
      ?>
      <article class="tile">
        <a href="<?php the_permalink(); ?>">
          <?php if (has_post_thumbnail()) the_post_thumbnail('medium'); ?>
        </a>
        <a href="<?php the_permalink(); ?>" class="caption"><?php the_title(); ?></a>
      </article>
      <?php } ?>
    </div>
  </section>
  <section class="section">
    <div class="section-title">Top Stories</div>
    <div class="two-col">
      <div class="left">
        <?php
          $cats_all = upi_get_all_categories();
          $total = is_array($cats_all) ? count($cats_all) : 0;
          $display = ($total >= 3) ? (int) floor($total / 3) * 3 : $total;
          if ($display === 0 && $total > 0) $display = min(3, $total);
          $cats = array_slice($cats_all, 0, $display);
        ?>
        <div class="category-grid">
        <?php foreach ($cats as $cat): ?>
          <?php
            $cat_q = new WP_Query([
              'post_type' => 'post',
              'cat' => $cat->term_id,
              'posts_per_page' => 5,
              'ignore_sticky_posts' => true,
            ]);
          ?>
          <?php if ($cat_q->have_posts()): $cat_q->the_post(); ?>
            <div class="cat-block">
              <a class="badge" href="<?php echo esc_url(get_category_link($cat->term_id)); ?>"><?php echo esc_html($cat->name); ?></a>
              <article class="lead">
                <a href="<?php the_permalink(); ?>">
                  <?php if (has_post_thumbnail()) the_post_thumbnail('large'); ?>
                </a>
                <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
              </article>
              <ul class="mini-list">
                <?php $i = 0; while ($cat_q->have_posts() && $i < 4) { $cat_q->the_post(); $i++; ?>
                  <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php } ?>
              </ul>
            </div>
            <?php wp_reset_postdata(); ?>
          <?php endif; ?>
        <?php endforeach; ?>
        </div>
      </div>
      <aside class="right">
        <div class="sub-title line">Most Popular</div>
        <ul class="popular-list">
          <?php
          $groups = ($display > 0) ? intval($display / 3) : 1;
          $popular_count = max(8, $groups * 8);
          $pop = new WP_Query([
            'post_type' => 'post',
            'posts_per_page' => $popular_count,
            'orderby' => 'comment_count',
            'order' => 'DESC',
            'ignore_sticky_posts' => true,
          ]);
          while ($pop->have_posts()) { $pop->the_post();
          ?>
            <li>
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              <span class="meta"><span class="cat"><?php echo esc_html(get_the_category()[0]->name ?? ''); ?></span> <span class="sep">//</span> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> ago</span>
            </li>
          <?php } wp_reset_postdata(); ?>
        </ul>
      </aside>
    </div>
  </section>
  <section class="section headlines">
    <div class="two-col">
      <div class="left">
        <div class="section-title line">Latest Headlines</div>
        <div class="headlines-list">
      <?php
      $latest = new WP_Query([
        'post_type' => 'post',
        'posts_per_page' => 8,
        'ignore_sticky_posts' => true,
      ]);
      while ($latest->have_posts()) { $latest->the_post();
        $cat = get_the_category();
        $cat_name = $cat ? $cat[0]->name : '';
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
      <?php } wp_reset_postdata(); ?>
        </div>
        <div class="load-more-wrap"><button class="load-more" type="button">Load More</button></div>
      </div>
      <aside class="right"></aside>
    </div>
  </section>
  <?php wp_reset_postdata(); endif; ?>
</main>
<?php get_footer(); ?>
