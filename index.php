<?php 
get_header();
$query = new TEDxQuery();
$sticky_posts = $query->sticky_posts(5);
$unsticky_posts = $query->unsticky_posts();
?>
<div class="container spacing-top">
  <div class="row">

    <div class="col-md-9">

      <div class="page-header">
        <h4>Blog Posts</h4>
      </div><!-- .page-header -->

      <?php
        if(count($unsticky_posts) > 0):
          foreach ($unsticky_posts as $index => $post): setup_postdata($post);
            WP_Render::partial('partials/blog/_post_excerpt.php');
          endforeach;
        else:
          WP_Render::partial('partials/_not_found.php', ['message' => 'There does not appear to be any posts here...']);
        endif;
      ?>

      <?php WP_Render::partial('partials/_pagination.php', ['offset' => count($sticky_posts)]); ?>

    </div><!-- .col-md-8 -->

    <div class="col-md-3">
      <?php get_sidebar(); ?>
    </div><!-- .col-md-4 -->

  </div><!-- .row -->
</div><!-- .container -->

<?php get_footer(); ?>