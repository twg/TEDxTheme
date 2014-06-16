<?php
$message = isset($message) ? $message : 'Whoops, looks like there are no posts here...';
?>

<div class='not-found'>
  <h4><i class="fa fa-question-circle animated rotateIn"></i> <?= $message; ?></h4>
</div>