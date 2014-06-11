<?php
//-- Default Arguments
$hide_excerpt = (isset($hide_excerpt) ? $hide_excerpt : false);
$include_social = (isset($include_social) ? $include_social : false);
$append_class = (isset($append_class) ? $append_class : '');
?>

<article class="<?= $append_class; ?> post-excerpt">

  <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

  <ul class="inline post-meta">
    <li><small><i class="fa fa-clock-o"></i> <?php the_time('F j, Y'); ?></small></li>
    <li><small><a href='<?php the_permalink(); ?>#comment'><?php comments_number('Leave a Comment', '<strong>1</strong> comment', '<strong>%</strong> comments'); ?></a></small></li>
    <?php if($include_social): ?>

    <?php endif; ?>
  </ul>

  <?php if(!$hide_excerpt): ?>
    <div class="excerpt">
      <?php
        if(isset($excerpt_length)):
          echo WP_Render::truncateHtml(get_the_excerpt(), $excerpt_length);
        else:
          the_excerpt();
        endif;
      ?>
    </div>
  <?php endif; ?>

  <small><a class="learn-more uppercase" href="<?php the_permalink(); ?>">Learn More</a></small>

</article>