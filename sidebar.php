<div id="sidebar">
  <ul>
    <?php
    if (is_page_template('page_templates/template_home.php')) {
      dynamic_sidebar('home-sidebar');
    } elseif (is_page()) {
      dynamic_sidebar('page-sidebar');
    } else {
      dynamic_sidebar('blog-sidebar');
    }
    ?>
  </ul>
</div>