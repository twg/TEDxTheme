<?php get_header(); ?>
  <div class="container spacing-top">
    <div class="row">
      <div class="col-md-9">
        <div class="post-content">
          <?php if (have_posts()): while (have_posts()) : the_post(); ?>
            <?php
            $speaker     = get_post();
            $video_id    = get_post_meta($speaker->ID, '_speaker_video_id', true);
            $name        = $speaker->post_title;
            $excerpt     = $speaker->post_excerpt;
            $description = get_post_meta($speaker->ID, '_speaker_video_description', true);
            $image       = wp_get_attachment_image_src(get_post_thumbnail_id($speaker->ID), 'speaker');
            if (is_array($image) && !empty($image[0])) {
              $image = $image[0];
            }
            ?>
            <div class="page-header">
              <h2><?php the_title(); ?>
                <small><?= $excerpt ?></small>
              </h2>
            </div>
            <?php if (has_post_thumbnail()): ?>
              <div class="feature-image">

                <div class="video-container">
                  <iframe width="100%" height="100%" src="//www.youtube.com/embed/<?= $video_id ?>" frameborder="0" allowfullscreen></iframe>
                </div>
              </div>
            <?php endif; ?>


            <div class="row">
              <div class="col-md-6"></div>
              <div class="col-md-6">
                <div class="pull-right">

                  <span class="social social-facebook">
                    <div class="fb-like" data-href="<?= get_permalink($speaker->ID); ?>" data-layout="button" data-action="like" data-show-faces="true" data-share="true"></div>
                  </span>

                  <span class="social social-twitter">
                    <a href="https://twitter.com/share" class="twitter-share-button" data-via="<?= get_theme_mod('twitter_account') ?>">Tweet</a>
                  </span>
                </div>
              </div>
            </div>


            <div class="user-generated-content">
              <?php the_content(); ?>
            </div><!-- .user-generated-content -->

            <?php comments_template(); ?>



          <?php endwhile;
          else: ?>

          <?php endif; ?>

        </div>
        <!-- .post-content -->


      </div>
      <!-- .col-md-8 -->

      <div class="col-md-3">
        <?php get_sidebar('speaker'); ?>
      </div>
      <!-- .col-md-4 -->

    </div>
    <!-- .row -->
  </div><!-- .container -->

<?php get_footer(); ?>