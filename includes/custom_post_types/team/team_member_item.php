<?php
$speaker_image = '';
$speaker_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'speaker');
if (is_array($speaker_image) && !empty($speaker_image[0])) {
  $speaker_image = $speaker_image[0];
} else {
  $speaker_image = get_bloginfo('template_url') . "/images/defaults/speaker.jpg";
}
?>

<li class="col" data-remote="true" data-video="<?php echo $video_id; ?>" data-href="<?php the_permalink(); ?>" data-name="<?php the_title(); ?>">
  <div class="speaker-photo-wrapper">
    <img src="<?php echo $speaker_image; ?>" class="speaker-photo" alt="Speaker Photo"/>
  </div>
  <!-- .speaker-photo-wrapper -->
  <div class="speaker-info">
    <div class='speaker-links pull-right'>
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
    <!-- .speaker-links -->
    <div class="speaker-title">
      <h2><?php echo $post->post_title; ?></h2>
      <span class="speaker-role">
        <?php echo get_post_meta($post->ID, '_team_job_description', true) ?>
      </span>
    </div>
    <!-- .speaker-title -->
    <div class='speaker-details-container'>
      <div class='pretty-scroll'>
        <div class='speaker-details'>
          <p>
            <?php echo $post->post_content; ?>
          </p>
        </div>
        <!-- .speaker-details -->
      </div>
      <!-- .pretty-scroll -->
    </div>
    <!-- .speaker-details-container -->
  </div>
  <!-- .speaker-info -->
</li>