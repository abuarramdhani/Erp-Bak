<div class="col-md-12">
<div class="col-md-6">
<h3 style="margin-left:-30px;">Terdapat <?= count($blm_plot)?> order belum di plotting.</h3>
</div>
<div class="col-md-6 text-right">
<button type="button" id="btn_plotting" class="btn btn-warning" style="margin-right:-30px;margin-bottom:-40px" onclick="plotting_order()"><i class="fa fa-plus"></i></button>
</div>
</div>
<table class="table table-bordered table-hover table-striped text-center" id="tb_order" <?= count($tgl) < 23 ? 'style="width:100%"' : ''?>>
  <thead style="background-color:#337ab7;color:white">
    <tr>
      <th <?= !empty($tgl) ? 'rowspan="2"' : ''; ?> style="width:20px;vertical-align:middle;background-color:#337ab7;color:white">No</th>
      <th <?= !empty($tgl) ? 'rowspan="2"' : ''; ?> style="width:200px;vertical-align:middle;background-color:#337ab7;color:white">Order</th>
      <th <?= !empty($tgl) ? 'rowspan="2"' : ''; ?> style="vertical-align:middle;background-color:#337ab7;color:white">QTY</th>
      <?php foreach ($bulan as $bln) { ?>
        <th colspan="<?= $bln['jumlah']?>"><?= DateTime::createFromFormat('m', $bln['bulan'])->format('F')?></th>
      <?php }?>
    </tr>
    <?php if (!empty($tgl)) { ?>
    <tr>
      <?php for ($i=0; $i < count($tgl) ; $i++) { ?>
        <th><?= DateTime::createFromFormat('dmY', $tgl[$i])->format('d')?></th>
      <?php }?>
    </tr>
    <?php }?>
  </thead>
  <tbody>
    <?php foreach ($data as $key => $value): ?>
      <tr>
        <td><?php echo $key+1 ?>
            <input type="hidden" id="id_order<?= $key+1?>" value="<?php echo $value['order_number']?>">
        </td>
        <td><?php echo $value['handling_name']?></td>
        <td><?php echo $value['quantity']?></td>
        <?php for ($i=0; $i < count($tgl) ; $i++) { ?>
          <td style="background-color:<?php echo $value[$tgl[$i]] == 1 ? '#FFCA75' : ''; ?>"></td>
        <?php }?>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
