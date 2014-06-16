<script type="text/javascript">
  jQuery(document).ready(function ($) {
    $('#speaker_video_description_mce').addClass('mceEditor');
    if (typeof(tinyMCE) == 'object' && typeof(tinyMCE.execCommand) == 'function') {
      tinyMCE.execCommand('mcsAddControl', true, "speaker_video_description_mce");
    }
  });
</script>

<?php
wp_editor($speaker_video_description, 'speaker_video_description_mce', array(
  'media_buttons' => false,
  'textarea_name' => '_speaker_video_description',
  'textarea_rows' => 3,
  'teeny'         => true,
  'tinymce'       => array(
    'theme_advanced_layout_manager'   => "SimpleLayout",
    'theme_advanced_toolbar_location' => "top",
    'theme_advanced_toolbar_align'    => "left",
    'theme_advanced_buttons1'         => "bold,italic,underline,strikethrough"
  )
));
?>
<input type="hidden" name="_speaker_video_description_nonce" value="<?=  wp_create_nonce('tedx_speaker_video_description_nonce'); ?>"/>
<p class="description">Appears within the TEDx theatre on the right hand side.</p>
