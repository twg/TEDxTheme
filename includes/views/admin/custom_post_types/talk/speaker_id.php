<select name="_talk_speaker_id">
  <option name="none">Not Available</option>
  <?php foreach ($this->data['speakers'] as $name => $id): ?>
    <option value="<?php echo $id; ?>" <?php if ($this->data['talk_speaker_id'] == $id): ?> selected="selected" <?php endif; ?>><?php echo  $name; ?></option>
  <?php endforeach; ?>
  <select>
    <input type="hidden" name="_talk_speaker_id_nonce" value="<?php echo wp_create_nonce('tedx_talk_speaker_id_nonce'); ?>"/>
