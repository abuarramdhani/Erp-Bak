<style type="text/css">
	#filter tr td{padding: 5px}
	.text-left span {
		font-size: 36px
	}

</style>
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="text-left ">
							<span><b>List Data Batch LPPB</b></span>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-body">
								<table id="tabel_list_batch" class="table text-center datatable">
									<thead>
										<tr class="bg-primary">
											<th width="5%" class="text-center">No</th>
											<th width="10%" class="text-center">Action</th>
											<th class="text-center">Batch LPPB Number</th>
											<th class="text-center">Create Date</th>
											<th class="text-center">Jumlah LPPB</th>
											<th class="text-center">Status Detail</th>
										</tr>
									</thead>
									<tbody>
									<?php $no=1; if ($lppb) { foreach($lppb as $lb){ ?>
									<tr>
										<td><?php echo $no?></td>
										<td>
											<a title="Detail Lppb" href="<?php echo base_url('MonitoringLppbKasieGudang/Unprocess/detailLppbKasieGudang/'.$lb['BATCH_NUMBER'])?>" class="btn btn-default btn-xs"><i class="fa fa-file-text-o"></i></a>
											<?php if ($lb['KASIE_GUDANG_APPROVED'] >= 1 and $lb['KASIE_GUDANG_REJECT'] == 0 AND $lb['CHECKING_KASIE_GUDANG'] == 0 and $lb['CHECKING_AKUNTANSI'] == 0) { ?>
											<a title="Submit to Kasie Akuntansi" id="btnSubmitCheckingToAkuntansi" onclick="submitToKasie(this)" data-id="<?php echo $lb['BATCH_NUMBER']?>" class="btn btn-primary btn-xs"><i class="fa fa-paper-plane"></i></a>
											<?php } ?>
										</td>
										<td><?php echo $lb['BATCH_NUMBER']?></td>
										<td><?php echo $lb['CREATE_DATE']?></td>
										<td><?php echo $lb['JUMLAH_LPPB']?></td>
										<td>
											<?php 
											if ($lb['NEW_DRAF']>0) {
												echo $lb['NEW_DRAF']." New/Draf"."<br>";
											}
											if ($lb['ADMIN_EDIT']>0) {
												echo $lb['ADMIN_EDIT']." Admin Edit"."<br>";
											}
											if ($lb['CHECKING_KASIE_GUDANG']>0) {
												echo $lb['CHECKING_KASIE_GUDANG']." Checking Kasie Gudang"."<br>";
											}
											if ($lb['KASIE_GUDANG_APPROVED']>0) {
												echo $lb['KASIE_GUDANG_APPROVED']." Kasie Gudang Approve"."<br>";
											}
											if ($lb['KASIE_GUDANG_REJECT']>0) {
												echo $lb['KASIE_GUDANG_REJECT']." Kasie Gudang Reject"."<br>";
											}
											if ($lb['CHECKING_AKUNTANSI']>0) {
												echo $lb['CHECKING_AKUNTANSI']." Checking Akuntansi"."<br>";
											}
											if ($lb['AKUNTANSI_APPROVED']>0) {
												echo $lb['AKUNTANSI_APPROVED']." Akuntansi Approve"."<br>";
											}
											if ($lb['AKUNTANSI_REJECT']>0) {
												echo $lb['AKUNTANSI_REJECT']." Akuntansi Reject"."<br>";
											}
											?>
										</td>
									</tr>
									<?php $no++; }}?>
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
<!-- Modal Submit For Checking -->
<div id="mdlSubmitToKasieAkuntansi" class="modal fade" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content"  id="content1" >
		  <div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		    <h5 class="modal-title">Submit For Checking Confirmation</h5>
		  </div>
		  <div class="modal-body">
		    <div class="row">
		      <div class="col-md-12">Apakah Anda yakin akan melakukan Submit ke Kasie Batch Number Akuntansi : <b id="id"></b> ?</div>
		    </div>
		  </div>
		  <div class="modal-footer">
		    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
		    <button type="button" class="btn btn-primary" id="mdlYesAkt" >Yes</button>
		  </div>
		</div>
 	</div>
</div>
