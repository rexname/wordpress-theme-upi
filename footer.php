<?php
?>
<footer class="site-footer">
  <div class="container footer-toprow">
    <div class="brand">
      <?php
        if (function_exists('the_custom_logo') && has_custom_logo()) {
          the_custom_logo();
        } else {
          echo esc_html(get_bloginfo('name'));
        }
      ?>
    </div>
    <a href="#top" class="back-to-top">Back to Top</a>
  </div>
  <div class="bar"></div>
  <div class="container links">
    <a href="<?php echo esc_url(home_url('/about')); ?>">About</a>
    <a href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a>
    <a href="<?php echo esc_url(home_url('/corrections')); ?>">Corrections</a>
    <a href="<?php echo esc_url(home_url('/ads')); ?>">Advertisements</a>
  </div>
  <div class="bar"></div>
  <div class="container legal">
    <div>Copyright © <?php echo date('Y'); ?> <?php echo esc_html(get_bloginfo('name')); ?>. All Rights Reserved.</div>
    <div><a href="<?php echo esc_url(home_url('/terms')); ?>">Terms of Use</a> | <a href="<?php echo esc_url(home_url('/privacy')); ?>">Privacy Policy</a></div>
  </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>
