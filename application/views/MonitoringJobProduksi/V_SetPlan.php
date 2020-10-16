<script>
$(document).ready(function () {
    $('.datepickbln').datepicker({
        format: 'mm/yyyy',
        todayHighlight: true,
        viewMode: "months",
        minViewMode: "months",
        autoClose: true
    }).on('change', function(){
            $('.datepicker').hide();
        });
})
</script>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-success">
                        <div class="box-header">
                            <h2 style="font-weight:bold"><i class="fa fa-calendar"></i> <?= $Title?></h2>
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-3">
                                        <label>Kategori :</label>
                                        <select id="kategori" name="kategori" class="form-control select2" style="width:100%" data-placeholder="Kategori">
                                            <option></option>
                                            <?php foreach ($kategori as $key => $val) { ?>
                                            <option value="<?= $val['ID_CATEGORY']?>"><?= $val['CATEGORY_NAME']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                            <label>Bulan :</label>
                                        <div class="input-group">
                                            <input id="periode_bulan" class="form-control datepickbln" placeholder="mm/yyyy" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn" style="background-color:#0AA86C;color:white;margin-left:15px" onclick="schSetPlan(this)"><i class="fa fa-search"></i> Search</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" id="tbl_setplan">
                                </div>
                            </div>
                        <form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<form method="post"  enctype="multipart/form-data">
<div class="modal fade" id="mdlimportsetplan" role="dialog">
    <div class="modal-dialog" style="padding-left:5px;">
      <!-- Modal content-->
      <div class="modal-content">
            <div class="modal-header text-center" style="background-color:#49D3F5;font-size:18px">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <label>UPLOAD DOKUMEN SET PLAN</label>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="file" class="form-control" id="file_setplan" name="file_setplan" accept=".xls, .xlsx, .csv">
                            <span class="input-group-btn">
                                <button class="btn btn-success" style="margin-left:15px;" formaction="<?= base_url('MonitoringJobProduksi/SetPlan/importPlan')?>"><i class="fa fa-check"></i> Submit</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
</form>