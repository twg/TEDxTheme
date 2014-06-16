<?php
global $ScheduleItemsPostType;
$items = $ScheduleItemsPostType->get_items();
?>

<table class="event-listing">
  <colgroup>
    <col class="time">
    </col>
    <col class="activity">
    </col>
    <col class="description">
    </col>
  </colgroup>
  <tbody>
  <?php foreach ($items as $item): setup_postdata($item->post); ?>
    <?php if ($item->type === 'speaker'): ?>
      <tr>
        <td class="time">
          <time data-endtime="<?= $item->rfc_end; ?>" datetime="<?= $item->rfc_start; ?>">
            <?= $item->start; ?>
          </time>
        </td>
        <td class="activity">
          <div class="scheduled-speaker"><?= $item->formatted_speakers; ?></div>
        </td>
        <td class="description"><?= $item->role; ?></td>
      </tr>
    <?php else: ?>
      <tr class="no-talks <?= $item->class_name; ?>">
        <td class="time">
          <time data-endtime="<?= $item->rfc_end; ?>" datetime="<?= $item->rfc_start; ?>">
            <?= $item->start; ?>
          </time>
        </td>
        <td class="activity">
          <?= $item->label; ?>
        </td>
        <td class="description">
          <?php if (!empty($item->description)): ?>
            <div class="<?= $item->class_name; ?>-description">
              <?= $item->description; ?>
            </div>
          <?php endif; ?>
          <?php if (!empty($item->extra_html)): ?>
            <div class="special-html">
              <?= $item->extra_html; ?>
            </div>
          <?php endif; ?>
        </td>
      </tr>
    <?php endif; ?>
  <?php endforeach; ?>
  </tbody>
</table>

