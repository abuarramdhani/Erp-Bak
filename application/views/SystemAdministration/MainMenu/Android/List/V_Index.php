<section class="content">
<style type="text/css">
	.modal-hapus {
  position: absolute;
  top: 100px;
  right: 0px;
  bottom: 0;
  left: 0;
  z-index: 10040;
  overflow: auto;
  overflow-y: auto;
}
</style>
	<div class="inner" >
			<div class="box box-header"  style="padding-left:20px">
				<h3 class="pull-left"><strong> Android Entry List </strong> - Android</h3>
			</div>
		</div>
		<div class="panel box-body" >

		<div class="col-md-12" style="margin-bottom: 10px;" >
			<div class="col-md-10">
				<div class="text-right">
				</div>
			</div>
			<div class="col-md-2">
				<div class="text-right">
					<button data-toggle="modal" data-target="#tambahData" class="btn btn-block btn-primary"><i class="fa fa-plus"></i>   Tambah Data</button>
				</div>
			</div>
		</div>
		<div class="table-responsive">
		<table id="ms_barang" class="table table-striped table-bordered table-hover dataTable no-footer">
			<thead>
				<tr style="background-color:#367FA9; color:white ">
						<th class="text-center " style="width:15px">No</th>
						<th class="text-center ">Action</th>
						<th class="text-center ">Android ID</th>
						<th class="text-center ">IMEI</th>
						<th class="text-center ">Hardware Serial</th>
						<th class="text-center ">GSF</th>
						<th class="text-center ">Employee</th>
						<th class="text-center ">Validation</th>						
					</tr>
			</thead>
			<tbody>
			<?php
			$no = 0;
			foreach ($android as $key => $andro) {
			$no++;

			?>
			
					<tr>
					<td><?php echo $no ?></td>
					<td>
						<a href="<?php echo base_url('SystemAdministration/Android/edit/'.$andro['gadget_id']) ?>" class="btn btn-success">
						Edit
						</a>
						<span>    </span>
<!-- <?php echo base_url('SystemAdministration/Android/delete/'.$andro['gadget_id']) ?> -->
						<span>
						<a class="btn btn-danger" href="<?php echo base_url('SystemAdministration/Android/delete/'.$andro['gadget_id']) ?>">Hapus</a>
						</span>

					</td>

					<td><?php echo $andro['android_id'] ?></td>
					<td><?php echo $andro['imei']?></td>
					<td><?php echo $andro['hardware_serial']?></td>
					<td><?php echo $andro['gsf']?></td>
					<td><?php echo $andro['info_1']?></td>
					<td>
						<?php
						if ($andro['validation'] ==0) {
							echo "New Entry";
						}
						elseif ($andro['validation'] ==1) {
							echo "Approved";
						}
						elseif ($andro['validation'] ==2)
						{
							echo "Rejected";
						}
						?>	
					</td>
											
					</tr>
					
			</tbody>

			<?php } ?>
		</table>
		</div>
		</div>
		<div id="tambahData" class="modal fade" role="dialog">
			  <div class="modal-dialog">
			    <!-- Modal content-->
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal">&times;</button>
			        <center><h4 class="modal-title"><strong>Tambah Data</strong></h4></center>
			      </div>
			      <div class="modal-body">
			     	<form method="post" action="<?php echo base_url('SystemAdministration/Android/tambahData/'); ?>">
			     	<div class="form-group">
			     	<label for="androidID">Android ID</label>
			     		 <input required id="androidID" value="" type="text" name="androidid" class="form-control"/>
			     	</div>
			     	<div class="form-group">
			     		<label for="IMEI">IMEI</label>
			     		<input required id="IMEI" value="" type="text" name="imei" class="form-control"/>
			     	</div>
			     	<div class="form-group">
			     		<label for="HWSerial">Hardware Serial</label>
			     		<input required id="HWSerial" value="" type="text" name="hwserial" class="form-control"/>
			     	</div>
			     	<div class="form-group">
			     		<label for="GSF">GSF</label>
			     		<input required id="GSF" value="" type="text" name="gsf" class="form-control"/>	 	
			     	</div>
			     	<div class="form-group">
			     		<label for="erp-androedit">Nama Karyawan</label>
			     		<div class="row">
				     		<div class="col-md-12">
				     			<select value="" required class="form-control erp-androedit" style="width: 100%;" name="andro-employee" id="erp-androedit">
				     			<option value=""></option>
			     				</select>
			     			</div>	
			     		</div>
			     	</div> 
			     	<div class="form-group">
			     		<label for="datepicker">Valid Until</label>
			     		<div  id="datepicker" class="input-group date" data-provide="datepicker">
						    <input type="text" name="valid_until" value="" class="form-control" value="<?php date('Y/m/d') ?>">
						    <div class="input-group-addon">
						        <span class="glyphicon glyphicon-th"></span>
						    </div>
						</div>
			      </div>
			      <div class="modal-footer">
			      	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			        <button type="submit" class="btn btn-success">Submit</button>
			        </form>
			      </div>
			    </div>
			  </div>
		</div>
</section>

