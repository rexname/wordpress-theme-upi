<?php get_header(); ?>
<main class="container">
  <section class="section">
    <div class="two-col">
      <div class="left">
        <div class="section-title line">Search Results</div>
        <div class="headlines-list">
          <?php
            $i = 0;
            $opened_small = false;
            if (have_posts()):
              while (have_posts()): the_post();
                $i++;
                $cat = get_the_category();
                $cat_name = $cat ? $cat[0]->name : '';
                if ($i === 1) {
                  ?>
                  <article class="headline-item">
                    <div class="text">
                      <div class="meta"><span class="cat"><?php echo esc_html($cat_name); ?></span> <span class="sep">//</span> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> ago</div>
                      <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                      <div class="excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 26)); ?></div>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="thumb">
                      <?php if (has_post_thumbnail()) the_post_thumbnail('medium_large'); ?>
                    </a>
                  </article>
                  <?php
                } elseif ($i >= 2 && $i <= 4) {
                  if (!$opened_small) { echo '<div class="more-grid">'; $opened_small = true; }
                  ?>
                  <article class="card">
                    <a href="<?php the_permalink(); ?>">
                      <?php if (has_post_thumbnail()) the_post_thumbnail('medium_large'); ?>
                    </a>
                    <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                  </article>
                  <?php
                  if ($i === 4) { echo '</div>'; $opened_small = false; }
                } else {
                  ?>
                  <article class="headline-item">
                    <div class="text">
                      <div class="meta"><span class="cat"><?php echo esc_html($cat_name); ?></span> <span class="sep">//</span> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> ago</div>
                      <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                      <div class="excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 26)); ?></div>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="thumb">
                      <?php if (has_post_thumbnail()) the_post_thumbnail('medium_large'); ?>
                    </a>
                  </article>
                  <?php
                }
              endwhile;
              if ($opened_small) { echo '</div>'; }
            else:
              ?>
              <p>No results found.</p>
              <?php
            endif;
          ?>
        </div>
        <?php
          global $wp_query;
          $max = (int) $wp_query->max_num_pages;
          $paged = max(1, get_query_var('paged'));
          if ($max > 1):
        ?>
        <div class="pagination">
          <nav class="pager" aria-label="Pagination">
            <div class="pager-left">
              <?php if ($paged > 1): ?>
                <a class="first" href="<?php echo esc_url(get_pagenum_link(1)); ?>">First</a>
                <a class="prev" href="<?php echo esc_url(get_pagenum_link($paged - 1)); ?>">Prev</a>
              <?php else: ?>
                <span class="first disabled">First</span>
                <span class="prev disabled">Prev</span>
              <?php endif; ?>
            </div>
            <span class="page-status">Page <?php echo esc_html($paged); ?> of <?php echo esc_html($max); ?></span>
            <div class="pager-right">
              <?php if ($paged < $max): ?>
                <a class="last" href="<?php echo esc_url(get_pagenum_link($max)); ?>">Last</a>
                <a class="next" href="<?php echo esc_url(get_pagenum_link($paged + 1)); ?>">Next</a>
              <?php else: ?>
                <span class="last disabled">Last</span>
                <span class="next disabled">Next</span>
              <?php endif; ?>
            </div>
          </nav>
        </div>
        <?php endif; ?>
      </div>
      <aside class="right">
        <div class="sub-title line">Most Popular</div>
        <ul class="popular-list">
          <?php
          $pop = new WP_Query([
            'post_type' => 'post',
            'posts_per_page' => 10,
            'orderby' => 'comment_count',
            'order' => 'DESC',
            'ignore_sticky_posts' => true,
          ]);
          while ($pop->have_posts()) { $pop->the_post(); ?>
            <li>
              <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
              <span class="meta"><span class="cat"><?php echo esc_html(get_the_category()[0]->name ?? ''); ?></span> <span class="sep">//</span> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> ago</span>
            </li>
          <?php } wp_reset_postdata(); ?>
        </ul>
      </aside>
    </div>
  </section>
</main>
<?php get_footer(); ?>
