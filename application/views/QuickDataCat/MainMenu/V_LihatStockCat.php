<!-- Content Header (Page header) -->
<section class="content-header">
<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>DATA STOK CAT</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('QuickDataCat');?>">
                                <i class="fa fa-tint fa-2x"></i>
                                <span><br/></span>	
                            </a>
						</div>
					</div>
				</div>
			</div>
 </section>
   
<section class="content">
     <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">	
				<div class="box-header with-border">
							<b>Find KHS Lihat Stock</b>
						</div>
					<div class="box-body">				
						<tr>
							<div class="col-md-8">
								<div class="col-md-3">
									<label>
										<h4 class="box-title">Periode</h4>
									</label>
								</div>
								<div class="col-md-4">							
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-addon">
												<i class="fa fa-calendar"></i>
											</div>
											<input  name="txtStartDate" id="txtStartDate" class="form-control datepicker" data-date-format="yyyy-mm-dd" placeholder="Start Date" required></input>
										</div><!-- /.input group -->
									</div><!-- /.form group -->
								</div>
								<div class="col-md-1">
									 <h4 class="box-title">s/d</h4>
								</div>
								<div class="col-md-4">							
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
											</div>
											<input name="txtEndDate" id="txtEndDate" class="form-control datepicker" required data-date-format="yyyy-mm-dd" placeholder="End Date" required></input>
										</div><!-- /.input group -->
									 </div><!-- /.form group -->
								</div>
							</div>
							<div class="col-md-8">
								<div class="col-md-3">
									<label>
										<h4 class="box-title">Kode Cat</h4>
									</label>
								</div>
								<div class="col-md-4" >	
									<div class="form-group">
										<input class="form-control" type="text" id="txtPaintCode"  name="kode" placeholder="input Kode Cat">
									</div><!-- /.form group -->
								</div>
							</div>
							<div class="col-md-8">
								<div class="col-md-3">
									<label>
										<h4 class="box-title">Description</h4>
									</label>
								</div>
								<div class="col-md-4" >	
									<div class="form-group">
										<input class="form-control" type="text" id="txtPaintDesc" name="deskripsi" placeholder="input Description">
									</div><!-- /.form group -->
								</div>
							</div>
						</tr>
						<tr>
							<div class="col-md-3"></div>
							<div class="col-md-2">
								<a href="" onclick="searchPaint('<?php echo base_url();?>');return false;" class="btn btn-primary btn-md btn-rect"> Search </a>
							</div>
						</tr>
					</div>
            </div>
        </div>
    </div>
</section>


<section class="content">
<form method="post" action="<?php echo site_url('#')?>" class="form-horizontal" id="form1">
		<div class="row">
            <div class="col-md-12">
				<div class="col-md-13">
					<div class="box box-primary box-solid">
						<div class="box-header with-border">
							<b>Stock Cat</b>
						</div>
						<div id ="loading2"></div> 
						<div id="resultpaint" class="box-body">
							<table id="tabelcat_all" class="table table-striped table-bordered table-hover text-left" style="font-size:12px;">
								<thead>
									<tr class="bg-primary">
										<td width="5%"><center><b>NO</center></td>
										<td width="10%"><center><b>KODE CAT</center></td>
										<td width="20%"><center><b>DESCRIPTION</center></td>
										<td width="15%"><center><b>TGL EXPIRED</center></td>
										<td width="5%"><center><b>QTY</center></td>
										<td width="5%"><center><b>UOM</center></td>
										<td width="10%"><center><b>BUKTI & NO BUKTI</center></td>
										<td width="10%"><center><b>PETUGAS</center></td>
										<td width="15%"><center><b>TGL INPUT</center></td>
										<td width="10%"><center><b>KETERANGAN</center></td>
									</tr>
								</thead>
								<tbody>
								<?php
									$no = 1;
									foreach ($data_cat_masuk_keluar as $msk) {
										if($msk['on_hand'] == ''){
											$keterangan = 'Cat Masuk';
										}
										else{
											$keterangan = 'Cat Keluar';
										}
								?>
									<tr>
										<td style="text-align:center;"><?php echo $no++ ?></td>
										<td style="text-align:center;"><?php echo $msk['paint_code'] ?></td>
										<td><?php echo $msk['paint_description'] ?></td>
										<td style="text-align:center;"><?php echo $msk['expired_date'] ?></td>
										<td style="text-align:center;"><?php echo $msk['quantity'] ?></td>
										<td style="text-align:center;">kg</td>
										<td style="text-align:center;"><?php echo $msk['evidence_number'] ?></td>
										<td><?php echo $msk['employee'] ?></td>
										<td style="text-align:center;"><?php echo $msk['sysdate'] ?></td>
										<td><?php echo $keterangan ?></td>
									</tr>
								<?php
									}
								?>
								</tbody>
							</table>
								<table align="left">
									<td width="20%"><a id="modalDelOnHand" class="btn btn-danger btn-ls col-md-10" style="background:#fff;color:#ff1a1a;"><b> DELETE <b></a></td>
									<td width="20%"><a href="<?php echo site_url('QuickDataCat/LihatStokCat/exportpdfDataStock');?>" class="btn btn-primary btn-ls col-md-10" style="background:#fff;color:#06f;"><b> PDF <b></a></td>
									<td width="20%"><a href="<?php echo site_url('QuickDataCat/LihatStokCat/exportexcelDataStock');?>" class="btn btn-primary btn-ls col-md-10" style="background:#fff;color:#06f;"><b> EXCEL <b></a></td>
								</table>
							</div>
							<br>
						</div><!-- /.box-body -->
					</div><!-- /.box -->
				</div><!-- /.box -->
            </div>
	</form>		
</section>
<!-- Modal -->
<div id="modalOnHandConfirmationDel" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background:#2E6DA4; color:#FFFFFF;">
        <button type="button" class="close " data-dismiss="modal">&times;</button>
        <b>Are you sure will delete all data ?</b>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-primary btn-s" id="executeDel" style="background:#fff;color:#06f;width:45%;">Execute</button>
        <button type="button" class="btn btn-danger btn-s" style="background:#fff;color:#ff1a1a;float:right;width:45%;" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


