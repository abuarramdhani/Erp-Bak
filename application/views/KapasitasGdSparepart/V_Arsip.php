<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
            $('.tblarsipkgs').dataTable({
                "scrollX": true,
                "searching": true,
                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('KapasitasGdSparepart/Arsip/cari_data')?>",
                    "type": "POST",
                    // "dataSrc": ""
                },
                //Set column definition initialisation properties.
                "columnDefs": [
                { 
                    "targets": [ 0 ], //first column / numbering column
                    "orderable": false, //set not orderable
                },
                ],
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
                                    href="<?php echo site_url('MonitoringPelayananSPB/Arsip/');?>">
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
                            <div class="box-header with-border"><b>Arsip</b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                                </div>
                                <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="table-responsive" >
                                        <table class="datatable table table-bordered table-hover table-striped text-center tblarsipkgs" style="width: 100%;">
                                            <thead class="bg-black">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Tanggal Dibuat</th>
                                                    <th>Tanggal Input</th>
                                                    <th>Jenis Dokumen</th>
                                                    <th>No Dokumen</th>
                                                    <th>Jumlah Item</th>
                                                    <th>Jumlah Pcs</th>
                                                    <th>Mulai Pelayanan</th>
                                                    <th>Selesai Pelayanan</th>
                                                    <th>Waktu Pelayanan</th>
                                                    <th>PIC Pelayanan</th>
                                                    <th>Mulai Pengeluaran</th>
                                                    <th>Selesai Pengeluaran</th>
                                                    <th>Waktu Pengeluaran</th>
                                                    <th>PIC Pengeluaran</th>
                                                    <th>Mulai Packing</th>
                                                    <th>Selesai Packing</th>
                                                    <th>Waktu Packing</th>
                                                    <th>PIC Packing</th>
                                                    <th>Keterangan</th>
                                                    <th>Tanggal Cancel</th>
                                                    <th>Jumlah Coly</th>
                                                    <th>Edit Coly</th>
                                                </tr>
                                            </thead>
                                        </table>
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

<div class="modal fade" id="editcoly" tabindex="-1" role="dialog" aria-labelledby="myModalDetail">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 style="text-align:center">Detail Coly</h3>
            <!-- <div id="datahidden"></div> -->
			</div>
			<div class="modal-body">
            <div id="datacoly2"></div>
            <div class="panel-body">
                <div class="col-md-12 text-center">
                    <button type="button" class="btn btn-danger">SAVE</button>
                </div>
            </div>
		    </div>
            <div class="modal-footer">
		</div>
		</div>
	</div>
</div>
