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
								<h1><b>View Data</b></h1>
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
								<button class="btn btn-md btn-primary"><b>View Data</b></button>
							</div>
							<div class="box-body">
							</div>
							<div class="box-footer" >
								<div class="col-lg-12">
									<div class="form-group col-lg-12">
										<div class="col-lg-12 hh">
										</div>
										<div class="col-lg-4 hh">
										    <label >Jumlah OP available:</label>
										</div>
										<div class="col-lg-6">
                                            <input type="text" name="available_op" class="form-control" placeholder="Masukkan jumlah Operator" required/>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-12 hh">
										</div>
										<div class="col-lg-4 hh">
										    <label >Jumlah Hari Kerja:</label>
										</div>
										<div class="col-lg-6">
                                            <input type="text" name="hari_kerja" class="form-control" placeholder="Masukkan jumlah Hari Kerja" required/>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-12 hh">
										</div>
										<div class="col-lg-4 hh">
										    <label >Parameter:</label>
										</div>
										<div class="col-lg-6">
                                            <input type="text" name="input_parameter" class="form-control" placeholder="Masukkan Parameter" required/>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-12 hh">
										</div>
										<div class="col-lg-4 hh">
										    <label >Department Class:</label>
										</div>
										<div class="col-lg-6">
                                            <select id="searchDeptClass" name="deptclass" class="searchDeptClass form-control bg-warning select2" data-placeholder="Pilih Department Class">
							                	<option></option>
											</select>
										</div>
									</div>
                                    <div class="form-group col-lg-12">
										<div class="col-lg-12 hh">
										</div>
										<div class="col-lg-4 hh">
										    <label >Resource:</label>
										</div>
										<div class="col-lg-6">
                                            <select id="searchDeptCode" name="deptcode" class="searchDeptCode  form-control bg-warning select2" data-placeholder="Pilih Resource">
							                	<option></option>
											</select>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >Periode:</label>
										</div>
										<div class="col-lg-6">
											<span id="monthPeriode">
										    <input type="month" class="form-control" id="txt_monthPeriode" name="monthPeriode" placeholder="Bulan Tahun" required/>
										</div>
									</div>
								</div>
								<div class="row" style="padding:10px">
									<div id="sub-div" align="center" style="padding-right:15px; padding-bottom: 10px" >
                                        <button id="next" type="button" class="btn btn-success btn-sm" style="font-size: 13px"><strong>Next</strong><span style="padding-left: 5px" class="fa fa-arrow-right"></span></button>
										</div>
									</div>
								</div>
								</div>
								<div class="row" style="padding:10px">
									<div id="sub-div" align="center" style="padding-right:15px; padding-bottom: 10px" >
                                    	<div id="loading" style="display: none;text-align: center;width:100%;margin-top: 0px;margin-bottom: 20px">
										<img style="width:50px" src="<?php echo base_url().'assets/img/gif/loading11.gif' ?>"/>
									</div>
								</div>
								</div>
								<div id="result">
								</div>
								<!-- <div class="box box-primary box-solid">
								</div> -->
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>