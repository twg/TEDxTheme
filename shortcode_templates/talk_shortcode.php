<section>

  <?php if (!empty($title) && !$for_homepage): ?>
    <header>
      <h2 class="minor"><?= $title ?> </h2>
    </header>
  <?php endif; ?>

  <div class="row animated-tiles">
    <?php if ($talks->have_posts()): while ($talks->have_posts()) : $talks->the_post(); ?>
      <?php
      $post         = get_post();
      $video_id     = get_post_meta($post->ID, '_talk_video_id', true);
      $speaker_name = get_post_meta($post->ID, '_talk_speaker_name', true);
      $speaker_role = get_post_meta($post->ID, '_talk_speaker_role', true);
      $width        = ($for_homepage) ? "4" : "3";
      ?>
      <div class="col-xs-12 col-sm-6 col-md-<?= $width ?> col-lg-<?= $width ?> talk-tile" data-remote="true" data-href="<?php the_permalink(); ?>">
        <div class="talk-photo-wrapper">
          <a class="talk-tile-container" href="<?= get_permalink($post->ID) ?>">
            <img alt='<?php the_title(); ?>' src="http://img.youtube.com/vi/<?= $video_id; ?>/0.jpg" class="talk-photo">
          </a>
        </div>
        <div class="row ">
          <div class="col-md-6 talk-meta">
            <?php single_term($post, 'talk_types'); ?>
          </div>
          <div class="col-md-6 talk-meta">
            <span class="pull-right"><?php single_term($post, 'talk_years'); ?></span>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 ">
            <a class="talk-tile-container" href="<?= get_permalink($post->ID) ?>">
              <?= $speaker_name ?>
            </a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 talk-meta talk-speaker-role">
            <?= $speaker_role ?>
          </div>
        </div>
      </div>
    <?php endwhile; endif; ?>
  </div>
</section>