<input type="text" value="<?php echo $schedule_item_description ?>" name="_schedule_item_description" size="80"/>
<p class="description">A short description of the schedule item <em>(appears on the right hand side of the schedule item)</em></p>
<input type="hidden" name="_schedule_item_description_nonce" value="<?php echo wp_create_nonce('tedx_schedule_item_description_nonce'); ?>"/>
