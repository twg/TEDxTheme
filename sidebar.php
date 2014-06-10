<div id="sidebar">
  <ul>
    <?php
      if(is_page()):
        dynamic_sidebar('page-sidebar');
      else:
        dynamic_sidebar('blog-sidebar');
      endif;
    ?>
  </ul>
</div>