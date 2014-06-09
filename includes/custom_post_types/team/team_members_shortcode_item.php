<?php global $TeamPostType; ?>
<ul class="speaker-list gutter-top animated-tiles">
  <?php foreach ($TeamPostType->get_team_members()->posts as $post): ?>
    <?php setup_postdata($post); ?>
    <?php require 'team_member_item.php'; ?>
  <?php endforeach; ?>
</ul>
<!-- .speaker-list .gutter-top .animated-tiles -->
