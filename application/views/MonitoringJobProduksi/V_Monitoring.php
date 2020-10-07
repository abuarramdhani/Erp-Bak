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
                        <div class="box box-primary box-solid">
                        <div class="box-header">
                            <label style="font-weight:bold"><i class="fa fa-search"></i> <?= $Title?></label>
                        </div>
                            <div class="box-body">
                                <div class="panel-body">
                                    <div class="col-md-1">
                                        <label>Kategori:</label>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="kategori" class="form-control select2" style="width:100%" data-placeholder="Kategori">
                                            <option></option>
                                            <?php foreach ($kategori as $key => $val) { ?>
                                            <option value="<?= $val['ID_CATEGORY']?>"><?= $val['CATEGORY_NAME']?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                    <div class="col-md-1 text-right">
                                        <label>Bulan:</label>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input id="periode_bulan" class="form-control datepickbln" placeholder="mm/yyyy" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button type="button" class="btn btn-success" style="margin-left:15px" onclick="schMonJob(this)"><i class="fa fa-search"></i> Search</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body" id="tbl_monjob_produksi">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<form method="post">
<div class="modal fade" id="mdlcommentmin" role="dialog">
    <div class="modal-dialog" style="padding-left:5px;">
      <!-- Modal content-->
      <div class="modal-content">
            <div id="datacommentmin"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
</form>