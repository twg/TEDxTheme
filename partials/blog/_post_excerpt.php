<?php
// Default Arguments
$hide_excerpt = (isset($hide_excerpt) ? $hide_excerpt : false);
?>

<article>

  <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>

  <ul class="inline post-meta">
    <li><small><?php the_time('F j, Y'); ?></small></li>
    <li><small><a href='<?php the_permalink(); ?>#comment'><?php comments_number('Leave a Comment', '<strong>1</strong> comment', '<strong>%</strong> comments'); ?></a></small></li>
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