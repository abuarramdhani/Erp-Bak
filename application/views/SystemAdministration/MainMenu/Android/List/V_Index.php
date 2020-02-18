	<section class="content">
	<style type="text/css">
		#cover-spin {
	    position:fixed;
	    width:100%;
	    left:0;right:0;top:0;bottom:0;
	    z-index:9999;
	    display: none;
	    background: url(<?php echo base_url('assets/img/gif/loadingquick.gif'); ?>) 
	              50% 50% no-repeat rgba(0,0,0,0.7);
	}
	</style>
	<div id="cover-spin"></div>

	<?php if(!empty($this->session->flashdata('msg'))){ ?>
	<script type="text/javascript">
		$(document).ready(function(){
			Swal.fire(
			'Berhasil Mengubah Data','','success'
			)
		});
	</script>
	<?php } ?>
	<div class="inner" >
			<div class="box box-header"  style="padding-left:20px;padding-right: 20px;">
				<h3 class="pull-left"><strong> Android Entry List </strong> - Android</h3>
				<button style="margin-top: 10px;padding: 10px;" data-toggle="modal" data-target="#tambahData" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Tambah Data</button>
			</div>
	</div>
		<div class="panel box-body">
		<div class="table-responsive">
		<table id="tblLatestVersion" class="table table-striped table-bordered">
			<thead>
				<tr style="background-color:#367FA9; color:white ">
				<th class="text-center">Versi Aplikasi Terbaru</th>
				<th class="text-center">Mandatory Update</th>
				<th class="text-center">Last Update By</th>
				<th class="text-center">Last Update Date</th>
				<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($versi as $key => $value) :
					 ?>
				<tr>

					<td class="text-center">
					<input style="width: 100%;" id="versiTerbaru" disabled class="form-control text-center" type="number" value="<?= $value['versi_terbaru'] ?>"></input></td>
					<td>
					  <select disabled class="form-control" id="mandUpdate" name="frcupdate">
					    <option value="1" <?php if($value['mandatory_update'] == 't') echo "selected"; ?> >True</option>
					    <option value="0" <?php if($value['mandatory_update'] == 'f') echo "selected"; ?> >False</option>
					  </select>
					</td>
					<td class="text-center">
						<input id="lu_by" class="form-control" disabled value="<?= $value['last_update_by'] ?>" ></input>
					</td>
					<td class="text-center">
						<input id="lu_date" class="form-control" disabled value="<?= $value['last_update_date'] ?>" ></input>
					</td>
					<td class="text-center" style="width: 25%;">
						<button class="btn btn-success btn-update">
							Update
						</button>
						<button class="btn btn-primary btn-simpan" style="display: none;">
							Simpan
						</button>
						<button class="btn btn-danger btn-batal" style="display: none;">
							Batal
						</button>

					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		</div>

		</div>

		<div class="panel box-body" >

		<div class="table-responsive">
		<table id="tableAndroidApproval" class="table table-striped table-bordered table-hover">
			<thead>
				<tr style="background-color:#367FA9; color:white ">
						<th class="text-center " style="width:15px">No</th>
						<th data-sortable="false" class="text-center ">Action</th>
						<th class="text-center ">Android ID</th>
						<th class="text-center ">IMEI</th>
						<th class="text-center ">Hardware Serial</th>
						<th class="text-center ">GSF</th>
						<th class="text-center ">Versi Aplikasi</th>
						<th class="text-center ">Employee</th>
						<th class="text-center ">Validation</th>						
					</tr>
			</thead>
			<tbody>
			<?php
			$no = 0;
			foreach ($android as $key => $andro) {
			$no++;

			if ($andro['validation'] ==0) {
							$status = "New Entry";
							$classLabel = "label label-default";
						}
						elseif ($andro['validation'] ==1) {
							$status = "Approved";
							$classLabel = "label label-success";
						}
						elseif($andro['validation'] ==2)
						{
							$status = "Rejected";
							$classLabel = "label label-danger";
						}

			?>
			
					<tr>
					<td><?php echo $no ?></td>
					<td class="text-center">
						<a href="<?php echo base_url('SystemAdministration/Android/edit/'.$andro['gadget_id']) ?>" class="btn btn-success btn-edit"><i class="fa fa-edit"></i> 
						Edit
						</a>
						
<!-- <?php echo base_url('SystemAdministration/Android/delete/'.$andro['gadget_id']) ?> -->
						
						<a class="btn btn-danger btn-hapus" href="<?php echo base_url('SystemAdministration/Android/delete/'.$andro['gadget_id']) ?>"><i class="fa fa-close"></i> Hapus</a>
						</td>

					<td><?php echo $andro['android_id'] ?></td>
					<td><?php echo $andro['imei']?></td>
					<td><?php echo $andro['hardware_serial']?></td>
					<td><?php echo $andro['gsf']?></td>
					<td><?php echo $andro['versi_aplikasi']?></td>
					<td><?php echo $andro['info_1']?></td>
					<td class="text-center" id="tdStatus"><span class="<?=$classLabel ?>"><?php echo $status;?></span></td>
											
					</tr>
					<?php } ?>
			</tbody>
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
<script type="text/javascript">
	$(document).ready(function(){
		$("#tableAndroidApproval").DataTable();

		$('.btn-hapus').click(function(e){
			e.preventDefault();
			var getLink = $(this).attr('href');

			Swal.fire({
			  title: 'Anda yakin ingin menghapus?',
			  text: "You won't be able to revert this!",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Ya, Hapus!',
			  cancelButtonText: 'Tidak'
			}).then((result) => {
			  if (	result.value) {
			  	window.location.href = getLink
			  }
			})
		})

		$('.btn-update').on('click',function(e){
			e.preventDefault();
			$("#versiTerbaru").prop('disabled',false)
			$("#mandUpdate").prop('disabled',false)
			$(".btn-simpan").show()
			$(".btn-batal").show()
			$(this).hide();
		})

		$('.btn-batal').on('click',function(){
			$("#versiTerbaru").prop('disabled',true)
			$("#mandUpdate").prop('disabled',true)
			$(".btn-simpan").hide()
			$(".btn-update").show()
			$(this).hide();
		})

		$('.btn-simpan').on('click',function(){
			let versi_terbaru = $("#versiTerbaru").val();
			let mandUpdate = $("#mandUpdate").val();
			$("#cover-spin").fadeIn()
			//POST JSON
			postData('<?php echo base_urL(''); ?>SystemAdministration/Android/updateVersi', { versiTerbaru: versi_terbaru,mandUpdate:mandUpdate })
			  .then((data) => {
			  	$(".btn-simpan").hide()
				$(".btn-update").show()
				$(".btn-batal").hide();
				$("#versiTerbaru").prop('disabled',true)
				$("#mandUpdate").prop('disabled',true)
				$("#cover-spin").fadeOut()
				$("#lu_by").val(data.last_update_by);
				$("#lu_date").val(data.last_update_date);
			    console.log(data); // JSON data parsed by `response.json()` call
			  })
			  .catch((err)=>{
			  	console.log(err)
			  	$("#cover-spin").fadeOut()
			  	alert('Gagal Mengupdate Data !')
			  });

			 //POST www-form

			// fetch('<?php echo base_urL(''); ?>SystemAdministration/Android/updateVersi',{
			// 		    method: 'POST',
			// 		    headers: {'Content-Type':'application/x-www-form-urlencoded'}, // this line is important, if this content-type is not set it wont work
			// 		    body: 'versiTerbaru='+versi_terbaru+'&mandUpdate='+mandUpdate+''
			// 		})
			// .then((res) =>{
			// 	return res.json()
			// })
			// .then((res) => {
			// 	console.log(res)
			// })
		})

		async function postData(url = '', data = {}) {
			  const response = await fetch(url, {
			    method: 'POST', 
			    mode: 'cors',
			    cache: 'no-cache',
			    credentials: 'same-origin',
			    headers: {
			      'Content-Type': 'application/json'
			    },
			    redirect: 'follow',
			    referrerPolicy: 'no-referrer', 
			    body: JSON.stringify(data) 
			  });
			  return await response.json(); 
			}


	});
</script>

