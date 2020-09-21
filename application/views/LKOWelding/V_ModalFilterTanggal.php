<form name="Orderform" enctype="multipart/form-data" onsubmit="return validasi();window.location.reload();" method="post">
    <div class="panel-body">
        <div class="col-md-12">
            <div class="col-md-3" style="text-align: right;"> <label>Tanggal</label></div>
            <div class="col-md-8"><input type="text" autocomplete="off" placeholder="Tanggal Laporan" id="tgl_lko" name="tgl_lko" class="form-control" /></div>
        </div>
    </div>
    <div class="panel-body">
        <div class="col-md-12" style="text-align: right;">
            <button formaction="<?php echo base_url('LaporanKerjaOperator/Input/Printlaporan'); ?>" formtarget="_blank" class="btn btn-danger button_print" style="text-align: right;">Print</button>
        </div>
    </div>
</form>