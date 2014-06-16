<select name="_schedule_item_icon">
  <?php foreach($icon_options as $name => $value): ?>
    <?php if($schedule_item_icon == $value): ?>
      <option value="<?=  $value; ?>" selected="selected"><?=  $name; ?></option>
    <?php else: ?>
      <option value="<?=  $value; ?>"><?=  $name; ?></option>
    <?php endif; ?>
  <?php endforeach; ?>
</select>

<p class="description">Choose an optional icon for non-speaker schedule items</p>
<input type="hidden" name="_schedule_item_icon_nonce" value="<?=  wp_create_nonce('tedx_schedule_item_icon_nonce');?>" />
