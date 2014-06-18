<div class="col-md-12">
  <?php
    global $post; 
    $post = $sticky_posts[0];
    setup_postdata($post);
    WP_Render::partial('partials/blog/_post_excerpt.php', ['post' => $post, 'feature_image' => 'post-sticky']);
  ?>
</div><!-- .col-md-12 -->
