<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-left">
								<span><h2><b>Laporan Data Asset Non Oracle  - </b>Draft</h2></span>
						
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div style="padding-top: 20px" class="box-header with-border">
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover text-center" id="tblACLDAO" style="font-size:14px;">
										<thead>
											<tr style="background-color: #3c8dbc;" class="bg-primary">
												<th width="5%"><center>No</center></th>
												<th width="15%"><center>Judul Proposal</center></th>
												<th width="15%"><center>Received Date</center></th>
												<th width="15%"><center>Kategori Asset</center></th>
												<th width="20%"><center>Cabang</center></th>
												<th width="10%"><center>Status</center></th>
												<th width="10%"><center>Attachment Title</center></th>
												<th width="10%"><center>Action</center></th>
											</tr>
										</thead>
										<tbody>
											<?php $i=1; foreach ($draft as $k) {?>
												<tr>
													<td><?= $i;?></td>
													<td><?= $k['batch_number'];?></td>
													<td><?= $k['log_time'];?></td>
													<td><?= $k['nama_ka'];?></td>
													<td><?= $k['nama_cabang'];?></td>
													<?php if ($k['status'] == '4') { ?>
													<td>
													<span><label class="label label-default"><i class="fa fa-paper-plane"></i>&nbsp;Sent to Akuntansi</label></span>
													</td>
													<?php } ?>
													<?php if ($k['pict_title_cbg'] == null) { ?> 
													<td style="background-color: pink;"><i>Not Yet Uploaded</i></td>
													<?php }else{ ?>
													<td><b><?php echo $k['pict_title_cbg'];?></b></td>
													<?php }?>
													<td>
													<a href="<?php echo base_url('AssetCabangAkuntansi/Detail/'.$k['id_proposal'])?>">
													<button type="button" class="btn btn-success btn-xs" style="width:100px;" id="btnDetail"><i class="fa fa-pencil"></i> Detail</button>
													</a>

													<a target="_blank" href="<?php echo base_url('./assets/upload/AssetCabang/Marketing').'/'.$k['pdf_title_mkt']?>">
													<button type="button" class="btn btn-primary btn-xs" style="width:100px;margin-top: 5px;margin-bottom: 5px" id="btnDeleteDraft"><i class="fa fa-check"></i> View File</button></a>

													<a href="<?php echo base_url('AssetCabangAkuntansi/downloadMkt/'.$k['pdf_title_mkt'])?>">
													<button type="button" class="btn btn-warning btn-xs" style="width:100px;" id="btnDownloadPPA"><i class="fa fa-download"></i> Download</button></a>
													
													<a target="_blank" href="<?php echo base_url('./assets/upload/AssetCabang/AdminCabang/Berkas').'/'.$k['pict_title_cbg']?>">
													<button type="button" class="btn btn-info btn-xs" style="width:100px;margin-top: 5px;margin-bottom: 5px" id="btnDeleteDraft"><i class="fa fa-tag"></i> Attachment</button>
													</a>
													</td>
												</tr>
											<?php $i++;} ?>
													
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
</section>
<script type="text/javascript">
	$( document ).ready(function() {
	$('#tblACLDAO').DataTable({
		"pageLength": 50
	});
})
</script>
