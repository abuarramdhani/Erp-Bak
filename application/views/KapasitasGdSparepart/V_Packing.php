<input type="hidden" id="punyaPacking" value="1">
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
                                    href="<?php echo site_url('KapasitasGdSparepart/Packing/');?>">
                                    <i class="icon-wrench icon-2x">
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
                            <div class="box-header with-border">
                                <b>Packing</b>
                            </div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label">
                                        <?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?>
                                    </label>
                                </div>
                                <br>
                                <div id="loadingAreaPacking" style="display:none;">
                                    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                </div>
                                <div class="table_area_packing">

                                </div>


                                <br>
                                <br>

                                <div id="loadingArea6" style="display: none;">
                                    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                                </div>
                                <div class="table_area_selesai2">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="modal fade" id="modalPacking" tabindex="-1" role="dialog" aria-labelledby="myModalDetail" data-backdrop="static">
	<div class="modal-dialog modal-xl" style="width: initial; margin-left: 20px; margin-right: 20px;">
		<div class="modal-content">
			<div class="modal-header">
				<!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
                <p id="headPack" style="float: right; font-weight: bold; font-size: 22px;"></p>
                <hr>
			<div class="modal-body">
                <div id="loadingAreaColly" style="display:none;">
                    <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                </div>
                <div class="table_area_colly">

                </div>
		    </div>
            <div class="modal-footer">
                <input type="button" class="btn btn-md btn-success" id="" onclick="transactDOSP(this)" value="Transact">
            </div>
		</div>
	</div>
</div>

<!-- <div class="modal fade" id="mdlcolly" tabindex="-1" role="dialog" aria-labelledby="myModalDetail">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <div id="datahidden"></div>
			</div>
			<div class="modal-body">
            <div class="panel-body">
                <div class="col-md-4 text-right">
                    <label>Pilih Kemasan</label>
                </div>
                <div class="col-md-5">
                    <select class="form-control select2" id="jenis_kemasan" name="jenis_kemasan" style="width:100%" data-placeholder="pilih kemasan">
                    <option></option>
                    <option value="1">KARDUS KECIL</option>
                    <option value="2">KARDUS SEDANG</option>
                    <option value="3">KARDUS PANJANG</option>
                    <option value="4">KARUNG</option>
                    <option value="5">PETI</option>
                    </select>
                </div>
            </div>

            <div class="panel-body">
                <div class="col-md-4 text-right">
                    <label>Berat</label>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="berat" name="berat" placeholder="masukkan berat (KG)">
                    <span style="text-align:center;font-size:12px">*Gunakan titik (.) bukan koma (,) jika dibutuhkan saat menulis berat.</span>
                </div>
            </div>
            <center><span id="peringatan" style="color:red;"></span></center>
            <div class="panel-body">
                <div class="col-md-12 text-center">
                    <button type="button" class="btn btn-danger" onclick="savePacking(this)">SAVE</button>
                </div>
            </div>
		    </div>
            <div class="modal-footer">
		</div>
		</div>
	</div>
</div> -->

<script type="text/javascript">
    $(document).ready(function () {
        // $('.tblpacking').dataTable({
        //     "scrollX": true,
        //     paging:false,
        //     scrollY: 500,
        //     ordering: false,
        // });
        // $('.tblpacking2').dataTable({
        //     "scrollX": true,
        // });

        // $('#tblColly').dataTable();
            $('.modal').on('shown.bs.modal', function() {
              $(this).find('[autofocus]').focus();
            });
    });
</script>
