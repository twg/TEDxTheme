<section>
  <header>
    <h1 class="minor"><?= $name; ?></h1>
  </header>
  <div class="row">
    <?php if ($partners->have_posts()): while ($partners->have_posts()) : $partners->the_post(); ?>
      <?php
      if (has_post_thumbnail()):
        $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'small-partner');
        if (is_array($thumb) && !empty($thumb[0])) {
          $thumbnail_src = $thumb[0];
        } else {
          $thumbnail_src = '';
        }
        ?>
        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 partner-tile">
          <a href='<?= get_post_meta(get_the_ID(), '_partner_url', true); ?>' target="_blank">
            <img alt='<?php the_title(); ?>' src='<?= $thumbnail_src; ?>'/>
          </a>
        </div>
      <?php endif; ?>
    <?php endwhile; endif; ?>
  </div>
</section>