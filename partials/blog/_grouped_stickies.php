<?php $first_post = array_shift($sticky_posts); ?>

<div class="col-md-6 col-sm-12">
  <?php 
    global $post; 
    $post = $first_post;
    setup_postdata($post);
  ?>
  <?php WP_Render::partial('partials/blog/_post_excerpt.php', ['post' => $post]); ?>
</div><!-- .col-md-6 -->

<div class="col-md-6 col-sm-12">
  <div class="row">

    <?php foreach($sticky_posts as $sticky_post): ?>
      <?php
      // Skip the first post, as it was displayed already
      if($index === 0) { continue; }
      $post = $sticky_post;
      setup_postdata($post);php
      ?>
      <div class="col-md-6">
        <?php WP_Render::partial('partials/blog/_post_excerpt.php', ['post' => $post, 'hide_excerpt' => true, 'hide_comment' => true, 'append_class' => 'grouped']); ?>
      </div><!-- .col-md-6 -->
    <?php endforeach; ?>

  </div><!-- .row -->
</div><!-- .col-md-6 -->