<section class="content">
<style type="text/css">
	.margin-top{
		margin-top: 10px;
	}

</style>
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
					<img src="<?php echo $dataEmployee[0]['gambar'];?>" style="width: 200px;height: 200px;margin-bottom: 15px;"/> 
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
					<input type="text" class="form-control" readonly value="<?php echo $bidangUnit[0]['unit_name'];?>" />	
				</div>
			</div>
			<div class="row margin-top">
				<div class="col-md-2">
					<h5>Bidang</h5>
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" readonly value="<?php echo $bidangUnit[0]['field_name'];?>" />	
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
			 	<div class="col-md-2">
			 		<a target="_blank" class="btn btn-success" href="https://maps.google.com/?q=<?php echo $dataEmployee[0]	['latitude']; ?>,<?php echo $dataEmployee[0]['longitude']; ?>"><i class="fa fa-map-marker"></i>  Lihat di Google Maps</a>
			 	</div>			 
			 </div>

		</div>

		<div class="panel box-footer" style="padding-left: 50px;">
			<div class="row">
				<div class="col-md-1">
					<a class="btn btn-primary" href="<?php echo base_url('AbsenAtasan/List/approveApproval/'.$dataEmployee[0]['absen_id']); ?>" ><i class="fa fa-check"></i>   Approve</a>
				</div>
				<div class="col-md-1">
					
				</div>
				<div class="col-md-1">
					<button data-toggle="modal" data-target="#rejectApproval" class="btn btn-danger"><i class="fa fa-close"></i>    Reject</button>
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

</section>