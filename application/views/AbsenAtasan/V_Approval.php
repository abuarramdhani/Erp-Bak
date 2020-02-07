<section class="content">
<style type="text/css">
	.margin-top{
		margin-top: 10px;
	}

</style>
<style type="text/css">
	#cover-spin {
    position:fixed;
    width:100%;
    left:0;right:0;top:0;bottom:0;
    z-index:9999;
    display: none;
    background: url(<?php echo base_url('assets/img/gif/loading11.gif'); ?>) 
              50% 50% no-repeat rgba(0,0,0,0.7);
}
</style>
<div id="cover-spin">
</div>
	<div class="inner" >
			<div class="box box-header"  style="padding-left:20px">
				<h3 class="pull-left"><strong>Detail Approval Absen</strong></h3>
			</div>
		</div>
		<div class="panel box-body" style="padding-left: 50px;" >
			<div class="text-left">
				<h4><strong>Detail Pekerja</strong></h4>
			</div>
			<div class="row margin-top">
				<div class="col-md-2">
				</div>
				<div class="col-md-8">
						<a href="<?php echo $dataEmployee[0]['gambar'];?>">
							<img src="<?php echo $dataEmployee[0]['gambar'];?>" style="width: 300px;height: 300px;margin-bottom: 15px;"/> 
						</a>
				</div>
			</div>
			<div class="row margin-top">
				<div class="col-md-2">
					<h5>No Induk</h5>
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" readonly value="<?php echo $dataEmployee[0]['noind'];?>" />	
				</div>
			</div>
			<div class="row margin-top">
				<div class="col-md-2">
					<h5>Nama</h5>
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" readonly value="<?php echo $dataEmployee[0]['nama'];?>" />	
				</div>
			</div>
			<div class="row margin-top">
				<div class="col-md-2">
					<h5>Seksi</h5>
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" readonly value="<?php echo $employeeInfo[0]['section_name'];?>" />	
				</div>
			</div>
			<div class="row margin-top">
				<div class="col-md-2">
					<h5>Unit</h5>
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" readonly value="<?php echo $employeeInfo[0]['unit_name'];?>" />	
				</div>
			</div>
			<div class="row margin-top">
				<div class="col-md-2">
					<h5>Bidang</h5>
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" readonly value="<?php echo $employeeInfo[0]['field_name'];?>" />	
				</div>
			</div>
			<div class="row margin-top">
				<div class="col-md-2">
					<h5>Departemen</h5>
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" readonly value="<?php echo $employeeInfo[0]['department_name'];?>" />	
				</div>
			</div>
			<div class="text-left">
				<h4><strong>Detail Absen</strong></h4>
			</div>
			<div class="row margin-top">
				<div class="col-md-2">
					<h5>Status</h5>
				</div>
				<div class="col-md-8">
				<?php
					if($dataEmployee[0]['status'] == 1){
						$status = "Approved";
						$classLabel = "label label-success";
					}elseif ($dataEmployee[0]['status'] == 2) {
						$status = "Rejected";
						$classLabel = "label label-dangre";
					}else{
						$status = "New Entry";
						$classLabel = "label label-default";
					}
					 ?>
					<p style="font-size: 18px;"><span class="<?= $classLabel ?>"><?= $status ?></span></p>
				</div>
			</div>
			<?php if($dataEmployee[0]['status'] == 1): ?>
			<div class="row margin-top">
				<div class="col-md-2">
					<h5>Approver</h5>
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" readonly value="<?php echo $dataEmployee[0]['approver'];?>" />	
				</div>
			</div>	
			<?php endif; ?>	

			<div class="row margin-top">
				<div class="col-md-2">
					<h5>Waktu</h5>
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" readonly value="<?php echo $dataEmployee[0]['waktu'];?>" />	
				</div>
			</div>
			<div class="row margin-top">
				<div class="col-md-2">
					<h5>Lokasi</h5>
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" readonly value="<?php echo $dataEmployee[0]['lokasi'];?>" />	
				</div>
			</div>
			<div class="row margin-top">
				<div class="col-md-2">
					<h5>Jenis Absen</h5>
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" readonly value="<?php echo $dataEmployee[0]['jenis_absen'];?>" />	
				</div>
			</div>
			<div class="row margin-top">
				<div class="col-md-2">
					
				</div>
				<?php if(!strpos(base_url(),"erp.quick.com")): ?>
			 	<div class="col-md-2">
			 		<button data-toggle="modal" data-target="#locationModal" class="btn btn-success" href="#"><i class="fa fa-map-marker"></i>  Lihat di Google Maps</button>
			 	</div>
			 	<?php endif; ?>	 
			 </div>


		</div>

		<div class="panel box-footer" style="padding-left: 50px;">
			<div class="row">
				<div class="col-sm-1" align="center" style="margin: 7px">
					<a id="btnApprove" class="btn btn-primary btn-block" href="<?php echo base_url('AbsenAtasan/List/approveApproval/'.$dataEmployee[0]['absen_id']); ?>" ><i class="fa fa-check"></i>   Approve</a>
				</div>
				<div class="col-sm-1" align="center" style="margin: 7px">
					<button data-toggle="modal" data-target="#rejectApproval" class="btn btn-danger btn-block"><i class="fa fa-close"></i>    Reject</button>
				</div>
				<div class="col-sm-1" align="center" style="margin: 7px">
					<a id="btnCetak" class="btn btn-info btn-block" href="<?php echo base_url('AbsenAtasan/List/cetakApproval/'.$dataEmployee[0]['absen_id']); ?>" ><i class="fa fa-print"></i>   Cetak</a>
				</div>
			</div>
		</div>

		<div id="rejectApproval" class="modal fade" role="dialog">
			  <div class="modal-dialog">

			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <h4 class="modal-title">Reject Approval</h4>
			      </div>
			      <div class="modal-body">
			      	<div class="row">
			      		<div class="col-md-2">
			      			<h4>Reason</h4>
			      		</div>
			      		<div class="col-md-1">
			      			<h4>:</h4>
			      		</div>
			      		<div class="col-md-8">
			      		<form method="post" id="rejectForm" action="<?php echo base_url('AbsenAtasan/List/rejectApproval/'.$dataEmployee[0]['absen_id']); ?>">
			      			<div class="form-group">
							  <textarea class="form-control" name="reason" rows="5" id="comment" form="rejectForm"></textarea>
							</div>
						
			      		</div>
			      	</div>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-danger" >Reject</button>
			        </form>
			      </div>
			    </div>
			  </div>
		</div>

		<div id="locationModal" class="modal fade" role="dialog">
			  <div class="modal-dialog" style="width: 1000px;">
			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <center><h4 class="modal-title"><strong>Lokasi</strong></h4></center>
			      </div>
			      <div class="modal-body">
			      <center>
			      	<iframe 
					  width="800" 
					  height="400" 
					  frameborder="1" 
					  scrolling="yes" 
					  marginheight="0" 
					  marginwidth="0"
					  <?php if(!strpos(base_url(),"erp.quick.com")): ?>
					  src="https://maps.google.com/maps?q=<?php echo $dataEmployee[0]['latitude'];?>,<?php echo $dataEmployee[0]	['longitude']; ?>&hl=es;z=14&amp;output=embed"
					<?php else: ?>
						src=""
					<?php endif; ?>
					 >
					 </iframe>
					 </center>
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        </form>
			      </div>
			    </div>
			  </div>
		</div>

</section>

<script type="text/javascript">
$(document).ready(function(){
	$("#cover-spin").fadeIn();

	$(window).on('load',function(){
		setTimeout(function(){
			$('#cover-spin').fadeOut();
		},3000)
		
	})
})


	
</script>