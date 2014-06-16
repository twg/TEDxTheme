<?php
global $SpeakerPostType;
$speakers = $SpeakerPostType->get_speakers_for(2013);
$speakers = $speakers->posts
?>
<style type="text/css">
  .chzn-container-multi .chzn-choices .search-field input {
    height: 20px;
    padding: 14px 6px 6px 6px;
  }
</style>

<h4>The Type of Event</h4>
<select id="schedule_item_type" name="_schedule_item_type" style="width: 200px;">

  <?php
  $selected = false;
  if ($schedule_item_type == 'speaker') {
    $selected = true;
  }
  ?>
  <option value="speaker" <?php if ($selected): ?>selected="selected"<?php endif; ?>>Speaker(s)</option>

  <?php
  $selected = false;
  if ($schedule_item_type == 'other') {
    $selected = true;
  }
  ?>
  <option value="other" <?php if ($selected): ?>selected="selected"<?php endif; ?>>Other</option>

</select>
<p class="description">The type of the schedule item (speaker or other)</p>
<input type="hidden" name="_schedule_item_type_nonce" value="<?=  wp_create_nonce('tedx_schedule_item_type_nonce'); ?>"/>


<div class="speaker-list">
  <h4>Choose the Speaker(s) </h4>

  <select multiple="multiple" name="_schedule_item_speaker_ids[]" id="speaker_ids">
    <?php foreach ($speakers as $key => $speaker): ?>
      <?php
      $selected = false;

      if (is_array($schedule_item_speaker_ids) && in_array($speaker->ID, $schedule_item_speaker_ids)) {
        $selected = true;
      }
      ?>
      <option value="<?=  $speaker->ID; ?>" <?php if ($selected): ?> selected="selected"<?php endif; ?>><?=  $speaker->post_title; ?></option>
    <?php endforeach; ?>
  </select>

  <p class="description">Select the speaker(s) of this schedule item</p>
</div>
<input type="hidden" name="_schedule_item_speaker_ids_nonce" value="<?=  wp_create_nonce('tedx_schedule_item_speaker_ids_nonce'); ?>"/>

<div class="other-input">
  <h4>Event Label</h4>
  <input type="text" id="schedule_item_other_label" name="_schedule_item_other_label" value="<?=  $schedule_item_other_label ?>">

  <p class="description">The label for this schedule item (eg. Lunch Break)</p>
</div>
<input type="hidden" name="_schedule_item_other_label_nonce" value="<?=  wp_create_nonce('tedx_schedule_item_other_label_nonce'); ?>"/>
