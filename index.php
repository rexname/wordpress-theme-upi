<?php get_header(); ?>
<main class="container">
  <?php if (have_posts()): ?>
    <div class="more-grid">
      <?php while (have_posts()): the_post(); ?>
        <article class="card">
          <a href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) the_post_thumbnail('large'); ?>
          </a>
          <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
        </article>
      <?php endwhile; ?>
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
  <?php else: ?>
    <p>Tidak ada konten.</p>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
