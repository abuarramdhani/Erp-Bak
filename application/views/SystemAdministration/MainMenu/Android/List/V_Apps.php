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

	<div class="inner" >
			<div class="box box-header"  style="padding-left:20px;padding-right: 20px;">
				<h3 class="pull-left"><strong> Android Apps Version </strong> - Android</h3>
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
</section>
<script type="text/javascript">
	$(document).ready(function(){	

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

