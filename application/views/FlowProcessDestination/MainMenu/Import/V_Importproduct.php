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
		heightAuto : true,
		showConfirmButton: true
	})
</script>';
} ?>

<style type="text/css">
	.hh {
		text-align: right;
	}
	.btnHoPg{
		height: 40px;
		width: 40px;
		border-radius: 50%;
		margin-top: 20px;
	}
	.loadOSIMG{
		width: 30px;
		height: auto;
	}
	.form-control{
		border-radius: 20px;
	}

	textarea.form-control{
		border-radius: 10px;
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
	.btn {
		border-radius: 20px !important;
	}
</style>

<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b>Import Product</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right">
								<a class="" href="">
									<button class="btnHoPg btn btn-default btn-md">
										<b class="fa fa-file-excel-o"></b>
									</button>
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<button class="btn btn-md btn-primary"><b>Import Product</b></button>
							</div>
							<div class="box-body">
                                <center>
								<br><br>
									<table style="border: none;">
										<tr>
											<form method="post" class="import_excel" id="import_excel" enctype="multipart/form-data" action="<?= base_url(); ?>FlowProcessDestination/Import/importproduk">
											<td>
												<div class="col-md-1"> 
					 								 <input type="file" name="excel_file" id="excel_file" required accept=".xlsx" />
					 							</div>
											</td>
											<td>
												<div class="col-md-1">
													<button type="submit" name="import_excel" class="btn btn-md bg-blue import_excel_btn" id="import_excel_btn1">IMPORT EXCEL</button>
												</div>
											</td>
											<!-- <td>
												<div class="col-md-1">
												OR  
												</div>
											</td>
											</form>
											<td>
												<div>
													<a href="<?php echo site_url('PerhitunganLoadingODM/Input/exportCSV');?>" target="_blank"><button Onclick="" class="btn btn-md">Download Layout CSV</button></a>
												</div>
											</td> -->
										</tr>
									</table>
									<br>
									<div id="loadingimport"></div>
									<br>
								</center>
							</div>
							<!-- <div class="box-footer" >
								<div class="col-lg-12">
								
								</div>
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>