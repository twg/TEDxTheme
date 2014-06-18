<?php get_header(); ?>

  <div class="container spacing-top">
    <div class="row">

      <div class="col-md-9">
        <?php WP_Render::partial('partials/blog/_content.php'); ?>
      </div>
      <!-- .col-md-9 -->

      <div class="col-md-3">
        <?php get_sidebar(); ?>
      </div>
      <!-- .col-md-3 -->

    </div>
    <!-- .row -->
  </div>
  <!-- .container -->

<?php get_footer(); ?>