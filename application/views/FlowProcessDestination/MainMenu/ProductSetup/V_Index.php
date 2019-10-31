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
				height : 400,
				showConfirmButton: true
			})
		</script>';
} ?>


<!-- <section class="notif" style="background-color: #fff; min-height: 30px;
    padding: 15px;
    margin-right: 15px;
    margin-left: 15px;
    padding-left: 15px;
    padding-right: 15px;
    color: limegreen;
    border: 1px solid limegreen;
    border-top: 2px solid limegreen;
    border-bottom: 2px solid limegreen;
    margin-top: 15px;">
    <center>
    <table>
    	<tr>
    	 <td><b>'.$succ.' </b></td>
    	</tr>
    </table>
</center>
</section> -->

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
<!-- <script src="<?php echo base_url("assets/js/custom.js"); ?>"></script> -->
<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11" style="height: 70px">
							<div class="text-right">
								<h1><b>Product Setup</b></h1>
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
				<div class="row">
					<div class="col-lg-12" >
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								<button class="btn btn-md btn-primary"><b>Form Input New Product</b></button>
							</div>
							<div class="box-body">
								<form method="post" action="<?= base_url('FlowProcess/ProductSetup/SaveProduct') ?>" enctype="multipart/form-data">
								<div class="col-lg-12">
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >Product Code:</label>
										</div>
										<div class="col-lg-6">
											<select placeholder="Input Nomor Produk.." id="selectProductCode" name="product_id" class="form-control selectProductCode">
												<option></option>
											</select>
											<input type="hidden" class="product_code" name="txtProductCode" id="product_code">
										</div>
									</div>
									<!-- <div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										</div>
										<div class="col-lg-6">
											<a id="btn-searchKomponen" class="btn btn-searchKomponen btn-default">Search</a>
											 <a id="btn-searchKomponen" class="btn-searchKomponen btn btn-alert btn-md">Cari</a> -->
										<!-- </div>
									</div> --> 
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >Product Description:</label>
										</div>
										<div class="col-lg-6">
										    <input placeholder="Input Deskripsi Produk.." autocomplete="off" type="text" id="product_name" name="txtProductDesc" class="form-control" readonly>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >Status Product:</label>
										</div>
										<div class="col-lg-8">
										    <input type="radio" value="1" id="status1" name="statusProduct" required>
											<label for="status1" class="label-checkbox" >Mass Production</label>
										    <input type="radio" value="2" id="status2" name="statusProduct">
											<label for="status2" class="label-checkbox" >Prototype</label>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >End Date Active:</label>
										</div>
										<div class="col-lg-6">
										    <input placeholder="tanggal aktif terakhir.."  autocomplete="off" type="text"  class="dtPicker form-control" id="txtEndDateSI" name="dateEndDateActive" required>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >Gambar Unit:</label>
										</div>
										<div class="col-lg-8">
										    <input type="file" name="gambarUnit" class="" required>
										</div>
									</div>
									<!-- <input type="hidden" class="product_id" name="product_id" id="product_id"> -->
									<div class="form-group col-lg-12" sty >
										<div class="col-lg-4"></div>
										<div class="col-lg-6" style="text-align: right;">
											<button class="btn btn-default clrFrom" type="button"><B> CLEAR </B></button>
											<button class="btn btn-primary" type="submit"><B> SAVE </B></button>
										</div>
									</div>
								</div>
								</form>
							</div>
							<div class="box-footer">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>