<section>
  <div class="row animated-tiles">

    <?php foreach ($slugs as $slug): ?>
      <?php
      $speaker     = $this->get_speaker_by_slug($slug);
      $video_id    = $this->get_video_id($slug);
      $name        = $speaker->post_title;
      $excerpt     = $speaker->post_excerpt;
      $description = get_post_meta($speaker->ID, '_speaker_video_description', true);
      $image       = wp_get_attachment_image_src(get_post_thumbnail_id($speaker->ID), 'speaker');
      if (is_array($image) && !empty($image[0])) {
        $image = $image[0];
      }

      ?>

      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 speaker-tile" data-remote="true" data-href="<?php the_permalink(); ?>">
        <a class="speaker-tile-container" href="<?php echo get_permalink($speaker->ID) ?>">
          <div class="speaker-description" style="background-image: url(<?php echo $image ?>);">
            <div class="speaker-border"></div>
            <div class="speaker-info">
              <div class="speaker-title">
                Speaker
              </div>
              <h2>
                <?php echo $name; ?>
              </h2>

              <div class="speaker-position">
                <?php echo $excerpt ?>
              </div>
            </div>

          </div>
          <!-- .speaker-title -->
          <div class="speaker-video-thumb">
            <div class="hover-container">
              <div class="hover-table">
                <div>
                    <span>
                      See Intro Video
                    </span>
                </div>
              </div>
            </div>
            <img src="http://img.youtube.com/vi/<?php echo $video_id; ?>/0.jpg">
          </div>
          <!-- .speaker-video-thumb -->
        </a>


      </div>

    <?php endforeach; ?>
  </div>
</section>

<?php if (false): ?>




  <section>
    <div class="row animated-tiles">

      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 team-tile" data-remote="true"
           data-href="<?php the_permalink(); ?>">

        <div class="team-photo-wrapper">
          <img alt='<?php the_title(); ?>' src='<?php echo $thumbnail_src; ?>' class="team-photo">
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
          <!--
          <div class='team-details-container'>
            <?php echo $post->post_content; ?>
          </div>-->
          <!-- .team-details-container -->
        </div>
        <!-- .team-info -->


      </div>

    </div>
  </section>

<?php endif ?>