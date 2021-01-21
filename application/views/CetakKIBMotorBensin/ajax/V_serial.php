<p style="margin-left:7px;margin-bottom:18px;font-size:15px;">Detail serial dengan kode barang <strong><?php echo $segment1 ?></strong></p>
<div style="margin-bottom:12px">
  <?php foreach ($get_serial as $key => $value): ?>
        <label class="label label-secondary" style="color:black;font-size:14px;box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.20);padding:7px;margin-left:5px">
          <?php echo $value['SERIAL_NUMBER'] ?>
        </label>
  <?php endforeach; ?>
</div>
<hr style="margin: 20px 8px 11px;">
<div style="margin-left:7px;margin-top:10px;">
  <button type="button" name="button" class="btn btn-sm btn-danger" onclick="cetakCKMB()" style="font-weight:bold"> <i class="fa fa-file-pdf-o"></i> Cetak QR </button>
  <button type="button" name="button" class="btn btn-sm btn-success" onclick="checklistCKMB()" style="margin-left:4px;font-weight:bold"> <i class="fa fa-file-pdf-o"></i> Cetak Checklist </button>
</div>

<script type="text/javascript">
function cetakCKMB (){
  // const range_tanggal = $('.tanggal_ckmb').val();
  // let range = range_tanggal.split(' - ');
  // const tipe = $('.select2_ckmb').val();
  // window.open(`${baseurl}CetakKIBMotorBensin/pdf/${range[0]}/${range[1]}/${tipe}`);
  window.open(`${baseurl}CetakKIBMotorBensin/pdf/<?php echo $no_po ?>/<?php echo $surat_jalan ?>/<?php echo $segment1 ?>/<?php echo $receipt_date ?>`);
}

function checklistCKMB() {
  // const range_tanggal = $('.tanggal_ckmb').val();
  // let range = range_tanggal.split(' - ');
  // const tipe = $('.select2_ckmb').val();
  // window.open(`${baseurl}CetakKIBMotorBensin/Checklist/${range[0]}/${range[1]}/${tipe}`);
  window.open(`${baseurl}CetakKIBMotorBensin/Checklist/<?php echo $no_po ?>/<?php echo $surat_jalan ?>/<?php echo $segment1 ?>/<?php echo $receipt_date ?>`);
}
</script>
