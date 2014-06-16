<div id="sidebar">
  <?php
  $year = get_theme_mod('promoted_speaker_year', date('Y'));
  global $SpeakerPostType;
  $related_videos = $SpeakerPostType->get_speakers_for($year, array('limit' => 3, 'exclude' => true));
  ?>

  <h2>Related Speakers</h2>

  <div class="row">
    <?php foreach ($related_videos->posts as $post): setup_postdata($post); ?>
      <div class="col-xs-12 related-speaker-tile">
        <a href="<?php the_permalink(); ?>" class="video-thumb">
          <?php
          $video_id = get_post_meta($post->ID, '_speaker_video_id', true);
          if (empty($video_id)) {
            $video_thumb_src = get_template_directory_uri() . '/images/defaults/video-placeholder.jpg';
          } else {
            $video_thumb_src = "http://img.youtube.com/vi/$video_id/0.jpg";
          }
          ?>
          <img src="<?= $video_thumb_src; ?>">
        </a>

        <div class="media-type">Intro Video</div>
        <div class="related-speaker-name"><p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p></div>
        <div class="related-speaker-position"><?= str_replace(array("<p>", "</p>"), "", get_the_excerpt()); ?></div>
        <hr>
      </div>
    <?php endforeach; ?>
  </div>
</div>
