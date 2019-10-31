<style type="text/css">

.form-control{
	border-radius: 20px;
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

#label-src{
	cursor: help;
	border-radius: 20px;
}

.hh{
	text-align: right;
}

.btn {
		border-radius: 20px !important;
	}
.rs {
	background-color: whitesmoke;
	padding: 20px;
	border-radius: 20px;
	margin-top: 20px !important;
	display: none ;
}

.table-curved {
	   border-collapse: separate;
	   border: solid #ddd 1px;
	   border-radius: 6px;
	   border-left: 0px;
	   border-top: 0px;
	}

	.table-curved th {                                                                                                            
		background-color: #3c8dbc !important;
		color: white;
		text-align: center;
		vertical-align: middle !important;
	}
	.table-curved > thead:first-child > tr:first-child > th {
	    border-bottom: 0px;
	    border-top: solid #ddd 1px;

	}
	.table-curved td, .table-curved th {
	    border-left: 1px solid #ddd;
	    border-top: 1px solid #ddd;
	}
	.table-curved > :first-child > :first-child > :first-child {
	    border-top-left-radius: 6px;
	}
	.table-curved > :first-child > :first-child > :last-child {
	    border-top-right-radius: 6px;
	}
	.table-curved > :last-child > :last-child > :first-child {
	    border-bottom-left-radius: 6px;
	}
	.table-curved > :last-child > :last-child > :last-child {
	    border-bottom-right-radius: 6px;
	}

		.dataTables_scroll
{
    overflow:auto;
}

.btn2 {
		border-bottom-right-radius: 20px !important; 
		border-top-right-radius: 20px !important;
		border-top-left-radius: 0 !important;
		border-bottom-left-radius: 0 !important;
	}
#delFileOldDrawing:hover{
	cursor: pointer;
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
								<h1><b id="titleSrcFPD">Product Search</b></h1>
							</div>
						</div>
						<div class="col-lg-1 " style="height: 70px">
							<div class="text-right ">
								<a class="" href="">
									<button class="btnHoPg btn btn-default btn-md">
										<b class="fa fa-search "></b>
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
								<button class="btn btn-md  btn-primary btnFrmFPDHome"><b>Form Search Product</b></button>
								<button class="btn btn-md  btn-primary btnSub btnFrmFPDsub1" style="display: none"><b class="fa fa-chevron-right "></b> &nbsp;<b id = "subTitleSub1"></b></button>
								<button class="btn btn-md  btn-primary btnSub btnFrmFPDsub2" style="display: none"><b class="fa fa-chevron-right "></b> &nbsp;<b id = "subTitleSub2"></b></button>
								<button class="btn btn-md  btn-primary btnSub btnFrmFPDsub3" style="display: none"><b class="fa fa-chevron-right "></b> &nbsp;<b id = "subTitleSub3"></b></button>
							</div>
							<div class="box-body" style="min-height: 350px">
								<div class="col-lg-12 ndas">
									<div class="col-lg-4" style="text-align: right;"><span id="label-src" class="btn btn-default"><i class="fa fa-search"></i><b> FIND PRODUCT: </b></span></div>
									<div class="col-lg-6">
									<select class="slc2 focus slcProductFPD" style="width: 100%" name="slcProductFPD" data-placeholder="Search By Product Code / Desciption .." >
										
									</select>
									</div>
									<!-- <form action="<?= base_url(); ?>FlowProcess/ProductSearch/bbg" method="post">
										<button class="btn btn-default"><b>aplikasi pak bambang</b></button>
									</form> -->
								</div>
								<div class="col-lg-12 res1 rs" >
									<div class="col-lg-12 text-center" id="loadingPageFPD"> </div>
									<div class="col-lg-12 resFPD" style="display: none">
										<div class="col-lg-6 text-right">
											<label>Product Number :</label>
										</div>
										<div class="col-lg-4 text-left srcRes1">
											
										</div>
										
									</div>
									<div class="col-lg-12 resFPD" style="display: none">
										<div class="col-lg-6 text-right">
											<label>Product Description :</label>
										</div>
										<div class="col-lg-4 text-left srcRes2">
											
										</div>
									</div>
									<div class="col-lg-12 resFPD" style="display: none">
										<div class="col-lg-6 text-right">
											<label>Product Status :</label>
										</div>
										<div class="col-lg-4 text-left srcRes3">
											
										</div>
									</div>
									<div class="col-lg-12 resFPD" style="display: none">
										<div class="col-lg-6 text-right">
											<label>End Date Active :</label>
										</div>
										<div class="col-lg-4 text-left srcRes4">
											
										</div>
									</div>
									<div class="col-lg-12 resFPD" style="display: none">
										<div class="col-lg-6 text-right">
											<label>Gambar Kerja :</label>
										</div>
										<div class="col-lg-4 text-left srcRes5">
											
										</div>
									</div>
									<div class="col-lg-12 resFPD" style="display: none">
										<div class="col-lg-4"></div>
										<div class="col-lg-4  text-center">
												<button id="btnEditProduct" class="btn btn-xs btn-primary"><b class="fa fa-edit"> EDIT </b></button>
												<button id="btnOpenProduct" class="btn btn-xs btn-success"><b class="fa fa-folder"> OPEN </b></button>
										</div>
									</div>
								</div>
								<div class="col-lg-12 res2 rs" >
									<form method="post" action="<?= base_url('FlowProcess/ProductSetup/saveEditProduct') ?>" enctype="multipart/form-data">
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >Product Number:</label>
										</div>
										<div class="col-lg-6">
										    <input placeholder="Input Nomor Produk.." type="text" name="txtProductNumber" class="form-control ">
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >Product Description:</label>
										</div>
										<div class="col-lg-6">
										    <input placeholder="Input Deskripsi Produk.." type="text" name="txtProductDesc" class="form-control ">
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >Status Product:</label>
										</div>
										<div class="col-lg-8">
										    <input type="radio" value="1" id="" name="statusProduct">
											<label for="status1" class="label-checkbox" >Mass Production</label>
										    <input type="radio" value="2" id="" name="statusProduct">
											<label for="status2" class="label-checkbox" >Prototype</label>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >End Date Active:</label>
										</div>
										<div class="col-lg-6">
										    <input type="text" class="dtPicker form-control" id="txtEndDateSI" name="dateEndDateActive">
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >Old Drawing unit:</label>
										</div>
										<div class="col-lg-3" id="fileOldTemp">
										    <a id="linkOldDrawing" target="_blank" href=""> <b id="fileOldDrawing">()</b></a>
										</div>
										<div class="col-lg-4" id="butOldFileTemp">
										    <b class="text-danger" id="delFileOldDrawing" data-id=""> Delete </b>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >New Drawing Unit:</label>
										</div>
										<div class="col-lg-8">
										    <input type="file" placeholder="Upload Gambar Kerja" name="gambarUnit" class="">
											<input type="hidden" name="product_id" id="product_id">
										</div>
									</div>
									<div class="form-group col-lg-12" sty >
										<div class="col-lg-4"></div>
										<div class="col-lg-4" style="text-align: center;">
										<!-- <input type="hidden" name="product_id" id="product_id"> -->
										<button class="btn btn-default clrFrom" type="button"><B> CLEAR </B></button>
										<button class="btn btn-success btnSaveEditProduct" name="product_id" value="" type="submit"><B> UPDATE </B></button>
										</div>
									</form>
									</div>
								</div>
								<div class="col-lg-12 res3 rs"  >
								</div>
								<div class="col-lg-12 res-load text-center rs" id="loadingSaveFPD"> </div>
								<div class="col-lg-12 rs res-resume">
									<table>
										<tr>
											<td> Total Gambar Kerja : <b id="resume_tgk"></b></td>
										</tr>
										<tr>
											<td> Gambar kerja memiliki BOM Produksi : <b id="resume_bomp"></b></td>
										</tr>
										<tr>
											<td> Gambar kerja memiliki BOM Spare Part : <b id="resume_bomsp"></b></td>
										</tr>
										<tr>
											<td> Total Jumlah Operation : <b id="resume_jo"></b></td>
										</tr>
										<tr>
											<td> Status Operation : <b id="resume_so"></b></td>
										</tr>
									</table>
								</div>
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