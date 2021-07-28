<table class="table table-bordered table-hover text-center" id="tb_order">
  <thead class="bg-primary">
    <tr>
      <th style="width:5%;">No</th>
      <th style="width:25%;">Order</th>
      <th>QTY</th>
      <th>Tanggal Mulai</th>
      <th>Tanggal Selesai</th>
      <th>Due Date</th>
      <th>Gambar</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody id="">
    <?php foreach ($data as $key => $value): ?>
      <tr row-id="">
        <td><?php echo $key+1 ?>
            <input type="hidden" id="id_order<?= $key+1?>" class="id_order" value="<?php echo $value['order_number']?>">
            <input type="hidden" id="id_revisi<?= $key+1?>" class="id_revisi" value="<?php echo $value['revision_number']?>">
            <input type="hidden" id="start_time<?= $key+1?>" class="start_time" value="<?php echo $value['start_date']?>">
            <input type="hidden" id="end_time<?= $key+1?>" class="end_time" value="<?php echo $value['finish_date']?>">
            <input type="hidden" id="nomor<?= $key+1?>" class="nomor" value="<?php echo $key+1?>">
            <input type="hidden" id="qty<?= $key+1?>" class="qty" value="<?php echo $value['quantity']?>">
            <input type="hidden" id="action<?= $key+1?>" class="action" value="<?php echo $value['action']?>">
        </td>
        <td><?php echo $value['handling_name']?></td>
        <td id="td_qty<?= $key+1?>"><?php echo $value['quantity'] - $value['pengecatan_qty']?></td>
        <td><?php echo $value['plot_startdate']?></td>
        <td><?php echo $value['plot_enddate']?></td>
        <td><?php echo $value['due_date']?></td>
        <td>
          <?php if (empty($value['design'])) { ?>
              <button class="btn btn-default" disabled><i class="fa fa-picture-o"></i></button>
          <?php }else { ?>
            <a href="<?php echo base_url("./assets/upload/OrderTimHandling/design/".$value['design']."")?>" target="_blank">
              <button class="btn btn-default"><i class="fa fa-picture-o"></i></button>
            </a>
          <?php }?>
        </td>
        <td>
            <p id="timer<?= $key+1?>">
                <label id="hours<?= $key+1?>" ><?= $value['jam']?></label>:<label id="minutes<?= $key+1?>"><?= $value['menit']?></label>:<label id="seconds<?= $key+1?>"><?= $value['detik']?></label>
                <input type="hidden" id="jam<?= $key+1?>" value="<?= $value['jam']?>">
                <input type="hidden" id="menit<?= $key+1?>" value="<?= $value['menit']?>">
                <input type="hidden" id="detik<?= $key+1?>" value="<?= $value['detik']?>">
            </p>
            <button type="button" id="button_mulai<?= $key+1?>" class="btn btn-success" style="<?= empty($value['start_date']) || $value['action'] == 1 ? '' : 'display:none'; ?>" onclick="oth_timer_progres(<?= $key+1?>, 'mulai')">Kerjakan</button>
            <button type="button" id="button_selesai<?= $key+1?>" class="btn btn-danger" style="<?= empty($value['start_date']) || $value['action'] == 1 ? 'display:none' : ''; ?>" onclick="oth_timer_progres(<?= $key+1?>, 'selesai')">Selesai</button>
            <!-- <button type="button" id="btn_selesai<?= $key+1?>" class="btn btn-danger" style="<?= empty($value['start_date']) ? 'display:none' : ''; ?>" onclick="selesai_progres(<?= $key+1?>)">Selesai</button> -->
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
