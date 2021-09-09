<tr style="background: #ffffc6" class="empty-car">
  <td class="text-center js-row-number">
    <input type="hidden" name="action[]" value="INSERT">
    <input type="hidden" name="car_id[]" value="">
    <input type="hidden" name="sub_car_revision_id[]" value="<?= $kecelakaan_car_id ?>" readonly>
  </td>
  <td>
    <?php
    $factors = ['Man', 'Machine', 'Method', 'Working', 'Area', 'Other'];
    ?>
    <select class="form-control" name="factor[]" required <?= $isUnit ? 'disabled' : ''; ?>>
      <?php foreach ($factors as $factor) : ?>
        <option value="<?= $factor ?>"><?= $factor ?></option>
      <?php endforeach ?>
    </select>
  </td>
  <td>
    <input autocomplete="off" type="text" placeholder="Tulis akar masalah ..." value="" name="root_cause[]" class="form-control" required <?= $isUnit ? 'disabled' : ''; ?>>
  </td>
  <td>
    <input autocomplete="off" type="text" placeholder="Tulis tindakan ..." value="" name="corrective_action[]" class="form-control" required <?= $isUnit ? 'disabled' : ''; ?>>
  </td>
  <td>
    <select class="form-control js-pic-select2" value="" name="noind_pic[]" required <?= $isUnit ? 'disabled' : ''; ?>>
    </select>
  </td>
  <td>
    <input type="text" autocomplete="off" placeholder="Tanggal jatuh tempo" value="" name="due_date[]" class="form-control js-datepicker" required <?= $isUnit ? 'disabled' : ''; ?>>
  </td>
  <td style="display: flex; align-items: center;">
    <!-- <span class="status process">
      <?= CAR_STATUS::getStatus('process') ?>
    </span> -->
  </td>
  <td></td>
</tr>