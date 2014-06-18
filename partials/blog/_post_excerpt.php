<?php
//-- Default Arguments
$hide_excerpt = (isset($hide_excerpt) ? $hide_excerpt : false);
$include_social = (isset($include_social) ? $include_social : false);
$append_class = (isset($append_class) ? $append_class : '');
$hide_thumb = (isset($hide_thumb) ? $hide_thumb : false);
$hide_comment = (isset($hide_comment) ? $hide_comment : false);
$feature_image = (isset($feature_image) ? $feature_image : 'post_sticky');
?>

<article class="<?= $append_class; ?> post-excerpt">

  <?php if (has_post_thumbnail() && !$hide_thumb): ?>
    <div class="post-thumbnail">
      <a href="<?= get_the_permalink(); ?>">
        <?php the_post_thumbnail($feature_image); ?>
      </a>
    </div>
  <?php endif; ?>

  <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

  <ul class="inline post-meta">
    <li>
      <small><i class="fa fa-clock-o"></i> <?php the_time('F j, Y'); ?></small>
    </li>

    <?php if (!$hide_comment): ?>
      <li>
        <small><a href='<?php the_permalink(); ?>#comment'><?php comments_number('Leave a Comment', '<strong>1</strong> comment', '<strong>%</strong> comments'); ?></a></small>
      </li>
    <?php endif; ?>

    <?php if ($include_social): ?>

    <?php endif; ?>
  </ul>

  <?php if (!$hide_excerpt): ?>
    <div class="excerpt">
      <?php
      if (isset($excerpt_length)):
        echo WP_Render::truncateHtml(get_the_excerpt(), $excerpt_length);
      else:
        the_excerpt();
      endif;
      ?>
    </div>
  <?php endif; ?>

  <small><a class="learn-more uppercase" href="<?php the_permalink(); ?>">Learn More</a></small>

</article>