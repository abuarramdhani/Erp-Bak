
<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
<script>
$(document).ready(function () {
    $('.tblhiskgs').dataTable({
        "scrollX": true,
    });
    $('.datepicktgl').datepicker({
        format: 'dd/mm/yyyy',
        todayHighlight: true,
        autoClose: true
    }).on('change', function(){
        $('.datepicker').hide();
    });
});
</script>

<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>
                                    <b>
                                        <?= $Title ?> 
                                    </b>
                                </h1>
                            </div>
                        </div>
                        <div class="col-lg-1 ">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg"
                                    href="<?php echo site_url('MonitoringPelayananSPB/History/');?>">
                                    <i class="fa fa-2x fa-file-text-o">
                                    </i>
                                    <span>
                                        <br />
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-primary box-solid">
                            <div class="panel-body text-right">
                                <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                            </div>

                            <nav class="navbar" style="width:30%">
                                <div class="container-fluid">
                                    <ul class="nav nav-pills nav-justified">
                                        <li class="active text-nowrap"><a data-toggle="tab" href="#data_dospb_history" id="ini_dospb">Data DO/SPB</a></li>
                                        <li class="text-nowrap"><a data-toggle="tab"  href="#data_pic" id="ini_pic">Data PIC</a></li>
                                    </ul>
                                </div>
                            </nav>

                            <div class="box-body">
                            <div class="tab-content">
                                <div class="panel-body tab-pane fade in active" id="data_dospb_history"></div>

                                <div class="panel-body tab-pane fade" id="data_pic">
                                    <div class="col-md-12">
                                        <div class="col-md-3">
                                            <label>Tanggal Awal</label>
                                            <input id="tglAwal" name="tglAwal" class="form-control pull-right datepicktgl" placeholder="dd/mm/yyyy" autocomplete="off">
                                        </div>
                                        <div class="col-md-3">
                                            <label>Tanggal Akhir</label>
                                            <div class="input-group">
                                            <input id="tglAkhir" name="tglAkhir" class="form-control pull-right datepicktgl" placeholder="dd/mm/yyyy" autocomplete="off">
                                            <span class="input-group-btn">
                                                <button type="button" onclick="schPICdospb(this)" class="btn btn-flat" style="background:inherit; text-align:left;padding:0px;padding-left:10px;"><i class="fa fa-2x fa-arrow-circle-right" ></i></button>    
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <br><br>
                                        <div class="table-responsive" id="tbl_pic_dospb">
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
    </div>
</section>

<div class="modal fade" id="detailjenisitem" tabindex="-1" role="dialog" aria-labelledby="myModalDetail">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 style="text-align:center">Detail Jenis Item DO/SPB Masuk</h3>
			</div>
			<div class="modal-body">
            <div class="panel-body" id="datajenisitem"></div>
		    </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal" aria-label="Close">Close</button>
		    </div>
		</div>
	</div>
</div>