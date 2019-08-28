<?php 
$succ =  $this->session->flashdata('response');
if ($succ != null) {
	echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
		<script type="text/javascript">
			Swal.fire({
				type: \'success\',
				title: \''.$succ.'\',
				width: 600,
				height : 500,
				showConfirmButton: false,
				timer: 2200
			})
		</script>';
} ?>

<style type="text/css">
	.form-control{
		border-radius: 20px;
	}

	.hh {
		text-align: right;
	}

	textarea.form-control{
		border-radius: 10px;
	}
	.btnHoPg{
		height: 40px;
		width: 40px;
		border-radius: 50%;
		margin-top: 20px;
	}
	.select2-selection{
		border-radius: 20px !important;
	}

	ul.select2-results__options:last-child{
		border-bottom-right-radius: 20px !important;
		border-bottom-left-radius: 20px !important;
	}

	input.select2-search__field{
		border-radius: 20px !important;
	}

	span.select2-dropdown{
		border-radius: 20px !important;
	}

	.loadOSIMG{
		width: 30px;
		height: auto;
	}
	.btn {
		border-radius: 20px !important;
	}
	
</style>

<?php 
    // echo '<pre>';
    // echo FCPATH;
    // exit();
?>

<section class="content">
	<div class="inner" >
	<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b>Input Data</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right ">
								<a class="" href="">
									<button class="btnHoPg btn btn-default btn-md">
										<b class="fa fa-cog "></b>
									</button>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row" >
					<div class="col-lg-12" >
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<button class="btn btn-md btn-primary"><b>Input Data</b></button>
							</div>
							<div class="box-body">
							</div>
							<div class="box-footer" >
								<div class="col-lg-12">
								<form method="post" action="<?= base_url('PerhitunganLoadingODM/Input/saveData')?>">
									<div class="form-group col-lg-12">
										<div class="col-lg-12 hh">
										</div>
										<div class="col-lg-4 hh">
										    <label >Organization Code:</label>
										</div>
										<div class="col-lg-6">
											<select id="searchOrgCode" name="txt_org_code" class="searchOrgCode form-control select2" data-placeholder="Pilih Organization Code" required>
							                <option></option>
											</select>
											
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-12 hh">
										</div>
										<div class="col-lg-4 hh">
										    <label >Item Code:</label>
										</div>
										<div class="col-lg-6">
											<select id="searchItemCode" name="txt_item_id" class="searchItemCode form-control select2" data-placeholder="Pilih Item Code" required>
							                <option></option>
											</select>
											
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >Periode:</label>
										</div>
										<div class="col-lg-6">
											<input type="month" class="form-control" id="" name="txt_periodebulan" placeholder="Periode" required>
										</div>
									</div>
                                    
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >Needs:</label>
										</div>
										<div class="col-lg-6">
										    <input placeholder="Needs" type="integer" id="needs" name="txt_needs" class="form-control" autocomplete=”off” required></select>
										</div>
									</div>
									<div class="form-group col-lg-12" >
										<div class="col-lg-4"></div>
											<div class="col-lg-6" style="text-align: right;">
												<button class="btn btn-default clrFrom" type="button"><B> CLEAR </B></button>
												<button class="btn btn-success " type="submit"><B> SAVE </B></button>
											</div>
											OR
											<a onclick="location.href = 'Input/viewimport';" class="btn bg-blue btn-md">IMPORT CSV</a>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- <div class="col-md-10 import"> -->
		<div class="box box-primary box-solid">
			<div class="box-header with-border">
				Tabel Data
			</div>
			<div class="box-body">
				<!-- <div class="table-responsive"> -->
					<table class="table table-striped dataTable table-bordered table-hover text-left " id="tblHistoryInput" style="font-size:12px;">
						<thead>
							<tr class="bg-primary">
								<th width="%"><center>No</center></th>
								<th width="%"><center>ITEM CODE</center></th>
								<th width="%"><center>DESCRIPTION</center></th>
								<th width="%"><center>PERIODE</center></th>
								<th width="%"><center>NEEDS</center></th>
								<th width="%"><center>SATUAN</center></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$no = 0;
							foreach ($Input as $row):
							$no++;
							?>
							<tr row-id="1">	
								<td><center><?php echo $no ?></center></td>
								<td><center><?php echo $row['ITEM_CODE']?></center></td>
								<td><center><?php echo $row['DESCRIPT']?></center></td>
								<td><center><?php echo $row['PERIODE']?></center></td>
								<td><center><?php echo $row['NEEDS']?></center></td>
								<td><center><?php echo $row['SATUAN']?></center></td>															
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>
				<!-- </div> -->
			</div>
		</div>
</section>