<input type="text" name="_schedule_item_end" id="schedule_item_end" value="<?= $schedule_item_end ?>">
<p class="description">The time when the event item ends</p>
<input type="hidden" name="_schedule_item_end_nonce" value="<?=  wp_create_nonce('tedx_schedule_item_end_nonce'); ?>"/>
