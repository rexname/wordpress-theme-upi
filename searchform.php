<?php
$query = get_search_query();
?>
<form role="search" method="get" class="searchbar" action="<?php echo esc_url(home_url('/')); ?>">
  <input type="search" class="input" placeholder="Search news..." value="<?php echo esc_attr($query); ?>" name="s" />
  <button type="submit" class="btn" aria-label="Search">
    <span class="icon">🔍</span>
  </button>
</form>
