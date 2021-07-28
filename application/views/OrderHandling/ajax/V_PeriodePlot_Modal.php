<form method="post" action="<?php echo base_url("OrderHandling/PlottingOrder/save_plotting_order")?>">
<div class="panel-body" >
    <div class="col-md-1"></div>
    <div class="col-md-5 text-center">
        <label>Tanggal Mulai</label>
        <input id="tgl_awal" name="tgl_awal" class="form-control oth_datepicker" autocomplete="off">
        <input type="hidden" id="id_order" name="id_order" value="<?= $id_order?>">
        <input type="hidden" id="id_revisi" name="id_revisi" value="<?= $id_revisi?>">
    </div>
    <div class="col-md-5 text-center">
        <label>Tanggal Selesai</label>
        <input id="tgl_akhir" name="tgl_akhir" class="form-control oth_datepicker" autocomplete="off">
    </div>
</div>
<div class="panel-body text-center">
    <button class="btn btn-success">Submit</button>
</div>
</form>