<?php get_header(); ?>
<main class="container">
  <section class="section">
    <?php if (have_posts()): the_post(); ?>
      <div class="two-col narrow-left">
        <article class="left">
          <div class="post-header">
            <div class="post-meta">
              <?php
                $cats = get_the_category();
                $cat_name = $cats ? $cats[0]->name : '';
              ?>
              <span class="cat"><?php echo esc_html($cat_name); ?></span>
              <span class="sep">//</span>
              <span class="date"><?php echo esc_html(strtoupper(get_the_date('M j, Y'))); ?> / <?php echo esc_html(strtoupper(get_the_time('g:i A'))); ?></span>
            </div>
            <h1 class="post-title"><?php the_title(); ?></h1>
            <div class="byline-row">
              <div class="post-byline">By <a href="<?php echo esc_url(get_author_posts_url(get_the_author_meta('ID'))); ?>"><?php the_author(); ?></a></div>
              <div class="share-actions">
                <a class="btn fb" href="#">F</a>
                <a class="btn x" href="#">X</a>
                <a class="btn print" href="#" onclick="window.print();return false;">⎙</a>
                <a class="btn mail" href="mailto:?subject=<?php echo rawurlencode(get_the_title()); ?>&body=<?php echo rawurlencode(get_permalink()); ?>">✉</a>
              </div>
            </div>
          </div>
          <?php if (has_post_thumbnail()): ?>
            <div class="post-thumb"><?php the_post_thumbnail('large'); ?></div>
          <?php endif; ?>
          <div class="post-content"><?php the_content(); ?></div>
          <div class="topics">
            <span class="label">Topics</span>
            <div class="tag-list"><?php the_tags('', ' '); ?></div>
          </div>
          <div class="read-more">
            <div class="sub-title">Read More</div>
            <ul class="read-more-list">
              <?php
              $cats = get_the_category();
              $cat_id = $cats ? $cats[0]->term_id : 0;
              $rm = new WP_Query([
                'post_type' => 'post',
                'cat' => $cat_id,
                'posts_per_page' => 3,
                'post__not_in' => [get_the_ID()],
                'ignore_sticky_posts' => true,
              ]);
              while ($rm->have_posts()) { $rm->the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
              <?php } wp_reset_postdata(); ?>
            </ul>
          </div>
          <div class="section-title line">Latest Headlines</div>
          <div class="headlines-list">
            <?php
            $latest = new WP_Query([
              'post_type' => 'post',
              'posts_per_page' => 4,
              'post__not_in' => [get_the_ID()],
              'ignore_sticky_posts' => true,
            ]);
            while ($latest->have_posts()) { $latest->the_post(); ?>
              <article class="headline-item left-thumb">
                <a href="<?php the_permalink(); ?>" class="thumb" aria-label="<?php echo esc_attr(get_the_title()); ?>">
                  <?php if (has_post_thumbnail()) the_post_thumbnail('medium', ['alt' => esc_attr(get_the_title())]); ?>
                </a>
                <div class="text">
                  <?php
                    $lcats = get_the_category();
                    $lname = $lcats ? $lcats[0]->name : '';
                  ?>
                  <div class="meta"><span class="cat"><?php echo esc_html($lname); ?></span> <span class="sep">//</span> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> ago</div>
                  <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                  <div class="excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 26)); ?></div>
                </div>
              </article>
            <?php } wp_reset_postdata(); ?>
          </div>
        </article>
        <aside class="right">
          <div class="sub-title line">Trending Stories</div>
          <ul class="trending-list">
            <?php
            $trend = new WP_Query([
              'post_type' => 'post',
              'posts_per_page' => 6,
              'orderby' => 'comment_count',
              'order' => 'DESC',
              'ignore_sticky_posts' => true,
            ]);
            while ($trend->have_posts()) { $trend->the_post(); ?>
              <li>
                <a href="<?php the_permalink(); ?>" class="title"><?php the_title(); ?></a>
                <a href="<?php the_permalink(); ?>" class="thumb" aria-label="<?php echo esc_attr(get_the_title()); ?>">
                  <?php if (has_post_thumbnail()) the_post_thumbnail('thumbnail', ['alt' => esc_attr(get_the_title())]); ?>
                </a>
              </li>
            <?php } wp_reset_postdata(); ?>
          </ul>
          <?php
            $cats = get_the_category();
            $cat_id = $cats ? $cats[0]->term_id : 0;
          ?>
          <div class="sub-title line">More From Category</div>
          <ul class="popular-list">
            <?php
            $morecat = new WP_Query([
              'post_type' => 'post',
              'cat' => $cat_id,
              'posts_per_page' => 6,
              'post__not_in' => [get_the_ID()],
              'ignore_sticky_posts' => true,
              'orderby' => 'date',
              'order' => 'DESC',
            ]);
            while ($morecat->have_posts()) { $morecat->the_post(); ?>
              <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <span class="meta"><span class="cat"><?php echo esc_html(get_the_category()[0]->name ?? ''); ?></span> <span class="sep">//</span> <?php echo human_time_diff(get_the_time('U'), current_time('timestamp')); ?> ago</span>
              </li>
            <?php } wp_reset_postdata(); ?>
          </ul>
        </aside>
      </div>
    <?php endif; ?>
  </section>
</main>
<?php get_footer(); ?>
