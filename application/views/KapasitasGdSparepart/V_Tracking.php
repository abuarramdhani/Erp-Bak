<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
     <script>
         $(document).ready(function () {
            $('.tbltrack').dataTable({
                "scrollX": true,
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
                                    href="<?php echo site_url('MonitoringPelayananSPB/Tracking/');?>">
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
                            <div class="box-header with-border"><b>Tracking</b></div>
                            <div class="box-body">
                                <div class="col-md-12 text-right">
                                    <label class="control-label"><?php echo gmdate("l, d F Y, H:i:s", time()+60*60*7) ?></label>
                                </div>
                                <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="table-responsive" >
                                        <table class="datatable table table-bordered table-hover table-striped text-center tbltrack" style="width: 100%;">
                                            <thead class="btn-info" style="color:black">
                                                <tr>
                                                    <th>No</th>
                                                    <th></th>
                                                    <th>Tanggal</th>
                                                    <th>Jenis Dokumen</th>
                                                    <th>No Dokumen</th>
                                                    <th>Jumlah Item</th>
                                                    <th>Jumlah Pcs</th>
                                                    <th>Keterangan</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i=0; $no=1; foreach($data as $val){ 
                                                    if ($val['URGENT'] != '') {
                                                        $td = 'bg-danger';
                                                    }else{
                                                        $td = '';
                                                    }
                                                    if ($val['SELESAI_PELAYANAN'] == '') {
                                                        $status = "PELAYANAN";
                                                    }elseif ($val['SELESAI_PELAYANAN'] != '' && $val['SELESAI_PENGELUARAN'] == '') {
                                                        $status = "PENGELUARAN";
                                                    }elseif ($val['SELESAI_PELAYANAN'] != '' && $val['SELESAI_PENGELUARAN'] != '' && $val['SELESAI_PACKING'] == '') {
                                                        $status = "PACKING";
                                                    }
                                                    ?>
                                                    <tr id="baris<?= $no?>">
                                                        <td class="<?= $td?>" ><?= $no; ?></td>
                                                        <td class="<?= $td?>"><button type="button" style="color:black" class="btn btn-xs" id="detail<?= $val['NO_DOKUMEN'] ?>" data-toggle="modal" data-target="#mdl<?= $val['NO_DOKUMEN']?>"><i class="fa fa-eye"></i></button></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jam<?= $no?>" value="<?= $val['TGL_DIBUAT']?>"><?= $val['TGL_DIBUAT']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jenis<?= $no?>" value="<?= $val['JENIS_DOKUMEN']?>"><?= $val['JENIS_DOKUMEN']?></td>
                                                        <td class="<?= $td?>" style="font-size:17px; font-weight: bold"><input type="hidden" id="nodoc<?= $no?>" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jml_item<?= $no?>" value="<?= $val['JUMLAH_ITEM']?>"><?= $val['JUMLAH_ITEM']?></td>
                                                        <td class="<?= $td?>"><input type="hidden" id="jml_pcs<?= $no?>" value="<?= $val['JUMLAH_PCS']?>"><?= $val['JUMLAH_PCS']?></td>
                                                        <td class="<?= $td?>"><?= $val['URGENT'] ?>  <?= $val['BON'] ?></td>
                                                        <td class="<?= $td?>"><?= $status ?></td>
                                                        <td class="<?= $td?>"><button type="button" class="btn btn-danger" id="btncancelSPB" onclick="btnCancelKGS(<?= $no?>)"><i class="fa fa-close"></i></button></td>
                                                    </tr>
                                                <?php $no++; $i++; }?>
                                                
                                            </tbody>
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

<?php foreach ($data as $key) {?>
<div class="modal fade" id="mdl<?= $key['NO_DOKUMEN']?>" tabindex="-1" role="dialog" aria-labelledby="myModalDetail">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" style="text-align:center;">Detail <br> <b> No Dokumen : <?= $key['NO_DOKUMEN']?></b></h4>
			</div>
			<div class="modal-body">
				<div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center" style="width:100%" id="">
                        <thead>
                            <tr class="bg-info">
                                <th colspan="2">Pelayanan</th>
                                <th colspan="2">Pengeluaran</th>
                                <th colspan="2">Packing</th>
                            </tr>
                            <tr class="bg-info">
                                <td>Mulai</td>
                                <td>Selesai</td>
                                <td>Mulai</td>
                                <td>Selesai</td>
                                <td>Mulai</td>
                                <td>Selesai</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo $key['MULAI_PELAYANAN']?></td>
                                <td><?php echo $key['SELESAI_PELAYANAN']?></td>
                                <td><?php echo $key['MULAI_PENGELUARAN']?></td>
                                <td><?php echo $key['SELESAI_PENGELUARAN']?></td>
                                <td><?php echo $key['MULAI_PACKING']?></td>
                                <td><?php echo $key['SELESAI_PACKING']?></td>
                            </tr>  
                        </tbody>
                    </table>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>
<?php }?>