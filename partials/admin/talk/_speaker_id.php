<select name="_talk_speaker_id">
  <option name="none">Not Available</option>
  <?php foreach ($speakers as $name => $id): ?>
    <option value="<?=  $id; ?>" <?php if ($talk_speaker_id == $id): ?> selected="selected" <?php endif; ?>><?=  $name; ?></option>
  <?php endforeach; ?>
  <select>
    <input type="hidden" name="_talk_speaker_id_nonce" value="<?=  wp_create_nonce('tedx_talk_speaker_id_nonce'); ?>"/>
