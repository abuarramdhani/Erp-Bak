<style>
    .center{
        text-align: center;
    }
    tbody>tr>td{
        text-align: center;
    }
	thead>tr{
		font-weight: bold;
	}
    thead>tr>td:first-child {
        width: 5%;
    }
    thead>tr>td:first-child + td {
        width: 10%;
    }
	.modal-content{
		top: 7em !important;
		border-radius: 10px !important;
	}
	#modalForm{
		margin: 0 2em 0 2em !important;
	}
	.modal-footer{
		margin: 0 2em 0 2em !important;
	}
	.modalLevelOne, .modalLevelTwo{
		width: 100%;
	}
</style>
<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right"><h1><b>Master Data</b></h1></div>
						</div>
						<div class="col-lg-1">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="#">
									<i class="icon-wrench icon-2x"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<a href="#" id="modalAdd" class="btn btn-default icon-plus icon-2x" data-toggle="modal" data-target="#modalMaster" alt='Add New' title="Add New" style="float: right;"></a>
							</div>
							<div class="box-body">
								<div class="table-responsive">
									<table class="datatable table table-striped table-bordered table-hover text-left SendDocument" style="font-size: 12px;">
										<thead class="bg-primary center">
											<tr>
												<td>No</td>
												<td>Kode</td>
												<td>Keterangan</td>
												<td>Tingkat 1</td>
												<td>Tingkat 2</td>
                                                <td>Action</td>
											</tr>
										</thead>
										<tbody>
											<!-- <tr><td colspan="6"><center><img src="<?= base_url() ?>assets/img/gif/spinner.gif" /></center></td><tr> -->
											<?= $table ?>
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

<!-- Modal Add/Edit Data  -->
<div class="modal fade" id="modalMaster" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h3 class="modal-title center"></h3>
		</div>
		<div class="modal-body">
			<form id="modalForm">
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="modalCode">Kode</label>
					<div class="col-sm-10">
						<input class="form-control" type="number" placeholder="number code" id="modalCode">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="modalInformation">Keterangan</label>
					<div class="col-sm-10">
						<input class="form-control" type="text" placeholder="information of this text" id="modalInformation">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="modalLevelOne">Tingkat 1</label>
					<div class="col-sm-10">
						<select class="form-control" data-placeholder="level 1" id="modalLevelOne">
						<!-- select2 -->
						</select>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="modalLevelTwo">Tingkat 2</label>
					<div class="col-sm-10">
						<select class="form-control" data-placeholder="level 2" id="modalLevelTwo">
							<!-- select2 -->
						</select>
					</div>
				</div>
			</form>
		</div>
		<div class="modal-footer">
			<button type="button" id="modalAction" class="btn btn-success pull-left"></button>
			<button type="button" class="btn btn-warning pull-right" data-dismiss="modal">Cancel</button>
		</div>
		</div>
	</div>
</div>


<!-- only noob :) -->
<script>
	baseurl = '<?= base_url() ?>'
	tbody= $('table>tbody')

    $(document).ready(function(){
		//listener plus button / show modal
		let title, action
		$('#modalAdd').click(()=>{

			$("#modalForm")[0].reset()
			$('#modalCode').prop('disabled', false)


			$('#modalLevelOne, #modalLevelTwo').select2('val', '')

			$("#modalAction").attr('onclick', 'modalSave()').html('<i class="fa fa-plus"></i> Add')

			title = "<b>Add Data</b>"
			action = "Add"

			$('.modal-title').html(title)
			$('.modal-footer #action').html(action)
		})

		//load select seksi
		$.ajax({
			type: 'GET',
            url: baseurl+'PengirimanDokumen/ajax/seksi',
			dataType: 'json',
			success: (res) => {
				let seksiHTML
				res.forEach((item, id)=>{
					seksiHTML += `<option value="${item.kodesie}">${item.kodesie} - ${item.seksi}</option>`
				})
				seksiHTML += '<option value="kosong">---none---</option>'
				$('#modalLevelOne, #modalLevelTwo').html(seksiHTML)
			}
		})


    })

	const modalSave = () => {
		let code 	= $('#modalCode').val(),
			inform 	= $('#modalInformation').val(),
			lv1 	= $('#modalLevelOne').val()
			lv2 	= $('#modalLevelTwo').val()
		
		if(code == '' || inform == '' || lv1 == '' || lv2 == ''){
			alert('isi semua data')
			return
		}else{
			$('#modalMaster').modal('toggle')
		}
		
		let dataMaster = {
			kode: code,
			ket: inform,
			level1: lv1,
			level2: lv2
		}

		let apiSaveMaster = '<?= base_url()?>'+'PengirimanDokumen/ajax/insertMaster'

		$.ajax({
			method: 'POST',
			data : dataMaster,
			url: apiSaveMaster,
			success: res => {
				loadTable()
			}
		})
	}

	const editMaster = (id, elem) => {
		$("#modalForm")[0].reset()

		let tr = elem.parent().parent()
		let code = tr.find('.code').text()
		let ket = tr.find('.ket').text()
		let lv1 = tr.find('.level1').data('kodesie')
		let lv2 = tr.find('.level2').data('kodesie')

		$('#modalCode').val(code).prop('disabled', true)
		$('#modalInformation').val(ket)
		$('#modalLevelOne').val(lv1).trigger('change')
		$('#modalLevelTwo').val(lv2).trigger('change')
		

		$("#modalAction").attr('onclick', 'modalUpdate('+id+')').html('<i class="fa fa-save"></i> Save Changes')

		title = "<b>Edit Data</b>"
		action = "Update"

		$('.modal-title').html(title)
		$('.modal-footer #action').html(action)
	}

	const modalUpdate = id => {
		let code 	= $('#modalCode').val(),
			inform 	= $('#modalInformation').val(),
			lv1 	= $('#modalLevelOne').val()
			lv2 	= $('#modalLevelTwo').val()
		
		if(code == '' || inform == '' || lv1 == '' || lv2 == ''){
			alert('isi semua data')
			return
		}else{
			$('#modalMaster').modal('toggle')
		}
		
		let dataMaster = {
			id: id,
			kode: code,
			ket: inform,
			level1: lv1,
			level2: lv2
		}

		let apiSaveMaster = '<?= base_url()?>'+'PengirimanDokumen/ajax/updateMaster'

		$.ajax({
			method: 'POST',
			data : dataMaster,
			url: apiSaveMaster,
			success: res => {
				loadTable()
			}
		})
	}

	const loadTable = () => {
		$.ajax({
			url: baseurl+'PengirimanDokumen/ajax/showMaster',
			dataType: 'json',
			beforeSend: () => {
				let loading = `<tr><td colspan="6"><center><img src="${baseurl + 'assets/img/gif/spinner.gif'}" /></center></td></tr>`
				tbody.html(loading)
			},
			success: res => {
				let row
				let i = 1
				res.forEach(res=>{
					row += `<tr>
								<td class="id">${i++}</td>
								<td class="code" data-id="${res.id}">${res.id_master}</td>
								<td class="ket">${res.keterangan}</td>
								<td class="level1" data-kodesie="${res.kodesie1}">${res.seksi1}</td>
								<td class="level2" data-kodesie="${res.kodesie2}">${res.seksi2}</td>
								<td><button onclick="editMaster(${res.id}, $(this))" data-toggle="modal" data-target="#modalMaster" class="btn btn-sm btn-success"><i class="fa fa-edit"></i> edit</button>&nbsp<button onclick="deleteMaster(${res.id})" class="btn btn-sm btn-danger" ><i class="fa fa-trash"></i>delete</button></td>
							</tr>`
				})
				tbody.html(row)
			}
		})
	}
</script>
