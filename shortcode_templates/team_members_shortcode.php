<section>
  <div class="row">
    <?php if ($team_members->have_posts()): while ($team_members->have_posts()) :
      $team_members->the_post(); ?>
      <?php $post = get_post(); ?>

      <?php
      if (has_post_thumbnail()):
        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'speaker');
        if (is_array($thumb) && !empty($thumb[0])) {
          $thumbnail_src = $thumb[0];
        } else {
          $thumbnail_src = '';
        }
        ?>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 team-tile" data-remote="true"
             data-href="<?php the_permalink(); ?>">

          <div class="team-photo-wrapper">
            <img alt='<?php the_title(); ?>' src='<?php echo $thumbnail_src; ?>'/>
          </div>
          <!-- .team-photo-wrapper -->
          <div class="team-info">
            <div class='team-links pull-right'>
              <?php $twitter = get_post_meta($post->ID, '_team_twitter_link', true); ?>
              <?php if (!empty($twitter)): ?>
                <div class='ir ico tweet ico-box'>
                  <a href='<?php echo $twitter; ?>' target='_blank'>
                    View Tweets
                  </a>
                </div>
              <?php endif; ?>
              <!-- END TODO -->
            </div>
            <!-- .team-links -->
            <div class="team-title">
              <h2><?php echo $post->post_title; ?></h2>

              <div class="team-role">
                <?php echo get_post_meta($post->ID, '_team_job_description', true) ?>
              </div>
            </div>
            <!-- .team-title -->
            <div class='team-details-container'>
              <div class='pretty-scroll'>
                <div class='team-details'>
                  <p>
                    <?php echo $post->post_content; ?>
                  </p>
                </div>
                <!-- .team-details -->
              </div>
              <!-- .pretty-scroll -->
            </div>
            <!-- .team-details-container -->
          </div>
          <!-- .team-info -->


        </div>
      <?php endif; ?>
    <?php endwhile;
    endif; ?>
  </div>
</section>