<?php
$sj_convert = str_replace("/","__", $surat_jalan);
?>
<div class="alert bg-primary alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">
      <i class="fa fa-close"></i>
    </span>
  </button>
  <strong>Sekilas Info! </strong> Klik <b>no serial</b> untuk update serial</strong>
</div>
<p style="margin-left:7px;margin-bottom:18px;font-size:15px;">Detail serial dengan kode barang <strong><?php echo $segment1 ?></strong> Total (<?php echo sizeof($get_serial) ?> Serial)</p>
<div style="margin-bottom:12px">
  <?php foreach ($get_serial as $key => $value): ?>
      <button punya="serial_<?php echo $segment1 ?>_<?php echo $key+1 ?>" class="btn label-secondary ckmb_update_serial_terbaru_<?php echo $segment1 ?>_<?php echo $value['SERIAL_NUMBER'] ?>" data-toggle="modal" data-target="#modal-kib-motor-bensin-<?php echo $segment1 ?>" onclick="ckmb_set_param('<?php echo $value['SERIAL_NUMBER'] ?>', '<?php echo $key+1 ?>', '<?php echo $segment1 ?>')" style="color:black;font-size:14px;box-shadow: 0 1px 1px 0 rgba(0,0,0,0.14), 0 2px 1px -1px rgba(0,0,0,0.12), 0 1px 3px 0 rgba(0,0,0,0.20);padding:7px;margin-left:6px;margin-top:7px;font-weight:bold">
        <?php echo $value['SERIAL_NUMBER'] ?>
      </button>
  <?php endforeach; ?>
</div>
<hr style="margin: 20px 8px 11px;">
<div style="margin-left:7px;margin-top:10px;">
  <!-- <button type="button" name="button" class="btn btn-sm btn-danger" onclick="cetakCKMB()" style="font-weight:bold"> <i class="fa fa-file-pdf-o"></i> Cetak QR </button> -->
  <!-- <button type="button" name="button" class="btn btn-sm btn-success" onclick="checklistCKMB()" style="margin-left:4px;font-weight:bold"> <i class="fa fa-file-pdf-o"></i> Cetak Checklist </button> -->
  <a href="<?php echo base_url('CetakKIBMotorBensin/pdf/'.$no_po.'/'.$sj_convert.'/'.$segment1.'/'.$receipt_date) ?>" target="_blank" class="btn btn-sm btn-danger" style="font-weight:bold"> <i class="fa fa-file-pdf-o"></i> Cetak QR </a>
  <a href="<?php echo base_url('CetakKIBMotorBensin/Checklist/'.$no_po.'/'.$sj_convert.'/'.$segment1.'/'.$receipt_date) ?>" target="_blank" class="btn btn-sm btn-success" style="margin-left:4px;font-weight:bold"> <i class="fa fa-file-pdf-o"></i> Cetak Checklist </a>
</div>
</div>

<div class="modal fade bd-example-modal-sm" id="modal-kib-motor-bensin-<?php echo $segment1 ?>" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Serial <span id="ckmd_txt_serial_old_<?php echo $segment1 ?>"></span> </h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold;float:right" data-dismiss="modal"><i class="fa fa-close"></i></button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12" style="margin-top:5px">
                    <input type="hidden" class="ckmb_serial_key_<?php echo $segment1 ?>" value="">
                    <input type="text" class="form-control ckmb_serial_<?php echo $segment1 ?>" style="width:100%" name="" value="">
                  </div>
                </div>
              </div>
              <div class="box-footer">
                <div class="row">
                  <div class="col-md-12">
                    <button type="button" class="btn btn-primary btn-sm" name="button" style="float:right" onclick="ckmb_update_serial('<?php echo $no_po ?>', '<?php echo $sj_convert ?>', '<?php echo $segment1 ?>', '<?php echo $receipt_date ?>')"> <i class="fa fa-file"></i> Update</button>
                  </div>
                </div>
              </div>
            </div>
      		</div>
      	</div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">


</script>
