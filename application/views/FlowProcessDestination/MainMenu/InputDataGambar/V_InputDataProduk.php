
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
    // print_r($data);
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
								<h1><b>Input Data Komponen</b></h1>
                                <!-- <br><embed src="../../assets/upload_flow_process/Temp/<?php echo $pdfname ?>" type='application/pdf' width='100%' height='500px'/></br> -->
							</div>
                            <!-- <div>
                                <embed src="../../assets/upload_flow_process/Temp/<?php echo $pdfname ?>" type='application/pdf' width='100%' height='700px'/>
                            </div> -->
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
								<button class="btn btn-md btn-primary"><b>Form Input Data Komponen</b></button>
							</div>
							<div class="box-body">
                            	<embed src="<?= base_url('assets/upload_flow_process/Temp/'.$pdfname); ?>" type='application/pdf' width='100%' height='300px'/>
							</div>
							<div class="box-footer" >
								<form method="post" action="<?= base_url('FlowProcess/InputDataGambar/save_data_gambar/'.$current_page.'/'.$jumlah) ?>') ?>" enctype="multipart/form-data">
								<!-- <form method="post" action="<?= base_url('/FlowProcess/InputDataGambar/save_data_gambar/'.$current_page.'/'.$jumlah) ?>" enctype="multipart/form-data"> -->
								<div class="col-lg-12">
									<div class="form-group col-lg-12">
										<div class="col-lg-12 hh">
											<h3 id="header">Page <?= $current_page ?> </h3>
										</div>
										<input name="pdfname" value="<?php echo $pdfname ?>" hidden/>
										<div class="col-lg-12 " style=" margin-top: 20px">
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
											<label >Product:</label>
										</div>
										<div class="col-lg-6">
											<input type="hidden" name="produk_id" id="produk_id" value="<?= $product_id ?>">
											<select name="productId" id="product_ID" class="form-control product_ID" readonly><option value="<?= $product_id ?>"><?= $product_number ?> - <?= $product_description ?></option></select>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
											<label >Drawing Code:</label>
										</div>
										<div class="col-lg-6">
											<select type="text" id="selectDrawingCode2" name="drawing_code" class="form-control "><option></option></select>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
											<label >Drawing Group:</label>
										</div>
										<div class="col-lg-6">
											<input id="drawing_group" placeholder="Input Drawing Group.." type="text" name="drawing_group" class="form-control ">
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
											<label >Drawing Description:</label>
										</div>
										<div class="col-lg-6">
											<input id="drawing_description" placeholder="Input Drawing Description.." type="text" name="drawing_description" class="form-control ">
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
											<label >Revision:</label>
										</div>
										<div class="col-lg-6">
											<input type="text" autocomplete="off" class="dtPicker form-control" id="rev" style="width: 25%" id="" name="txtRev">
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
											<label >Drawing Date:</label>
										</div>
										<div class="col-lg-6">
											<input type="text" id="drawing_date" class="dtPicker form-control" style="width: 25%" id="" name="drawing_date">
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
											<label >Drawing Material:</label>
										</div>
										<div class="col-lg-6">
											<input type="text" id="drawing_material" class="form-control" id="" placeholder="Drawing Material.. " name="drawing_material">
										</div>
									</div>
									<div class="form-group col-lg-12" >
										<div class="col-lg-4 hh">
											<label >Weight:	</label>
										</div>
										<div class="col-lg-6">
											<input type="number" autocomplete="off" class="form-control" id="weight" style="width: 25%"  placeholder="Weight Per Unit.. " name="weightComponent" required>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
											<label >Component Status:</label>
										</div>
										<div class="col-lg-6">
											<input type="radio" value="Y" id="statuscomp1" name="slcStatusComponent">
											<label for="status1" class="label-radio" >Active</label>
											<input type="radio" value="N" id="statuscomp2" name="slcStatusComponent">
											<label for="status2" class="label-radio" >Inactive</label>
										</div>
									</div>
									<div class="form-group col-lg-12 old-code">
										<div class="col-lg-4 hh">
											<label >Changing Ref Document:</label>
										</div>
										<div class="col-lg-6">
											<input type="text" class="form-control" id="ref_document" placeholder="Changing Ref Document.. " name="ref_document">
										</div>
									</div>
									<div class="form-group col-lg-12 old-code">
										<div class="col-lg-4 hh">
											<label >Changing Explanation:</label>
										</div>
										<div class="col-lg-6">
											<input type="text" class="form-control" id="explanation" placeholder="Changing Explanation.. " name="explanation">
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
											<label >Old Drawing Code:</label>
										</div>
										<div class="col-lg-6">
											<input type="text" class="form-control" autocomplete="off" id="old_drw_code" placeholder="Old Drawing Code.. " name="txtOldDrawingCode">
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
											<label >Drawing Status:</label>
										</div>
										<div class="col-lg-6">
											<input type="radio" value="1" id="Drawing_status1" name="slcDrawingStatus">
											<label for="status1" class="label-radio" >Mass Production</label>
											<input type="radio" value="2" id="Drawing_status2" name="slcDrawingStatus">
											<label for="status2" class="label-radio" >Prototype</label>
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
											<label >Drawing Upper Level Code:</label>
										</div>
										<div class="col-lg-6">
											<input type="text" class="form-control" id="drawing_upper_code" placeholder="Drawing Upper Level Code.. " name="drawing_upper_code">
										</div>
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
											<label >Drawing Upper Level Description:</label>
										</div>
										<div class="col-lg-6">
											<input type="text" class="form-control" id="drawing_upper_description" placeholder="Drawing Upper Level Desc.. " name="drawing_upper_description">
										</div>
									</div>
									<div class="form-group col-lg-12 old-code" style="display: none">
										<div class="col-lg-4 hh">
											<label >Changing Due Date:</label>
										</div>
										<div class="col-lg-6">
											<input type="text" class="dtPicker form-control" style="width: 25%" id="duedate" name="duedate">
										</div>
									</div>
									<!-- <div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
											<label >Component Status:</label>
										</div>
										<div class="col-lg-6">
											<input type="radio" value="1" id="statuscomp1" name="slcStatusComponent">
											<label for="status1" class="label-radio" >Baru</label>
											<input type="radio" value="2" id="statuscomp2" name="slcStatusComponent">
											<label for="status2" class="label-radio" >Menggantikan</label>
										</div>
									</div> -->
									<div class="form-group col-lg-12">
	
									<div class="form-group col-lg-12 old-code" style="display: none">
										<div class="col-lg-4 hh">
											<label >Old Drawing Code:</label>
										</div>
										<div class="col-lg-6">
											<input type="text" class="form-control" id="old_drawing_code" placeholder="Old Drawing Code.. " name="old_drawing_code">
										</div>
									</div>
									
									<div class="form-group col-lg-12" >
										<div class="col-lg-4 hh">
											<label >Component Qty Per Unit:</label>
										</div>
										<div class="col-lg-6">
											<input type="number" class="form-control" id="component_qty" style="width: 25%"  placeholder="Qty Per Unit.. " name="component_qty" required>
										</div>
									</div>
									<!-- <div class="form-group col-lg-12" >
										<div class="col-lg-4 hh">
											<label >Gambar Unit</label>
										</div>
										<div class="col-lg-6">
											<input type="file" class="" id="" placeholder="Changing Ref Document.. " name="fileGambarUnit">
										</div>
									</div> -->
									<!-- <input type="hidden" name="productId" value="<?= $product_id ?>"> -->
									<div>
										<input hidden id="current_page" type="text" value="<?= $current_page ?>" />
										<input hidden id="max_page" type="text" value="<?= $jumlah ?>" />
									</div>
									<div class="form-group col-lg-12">
										<div class="col-lg-4 hh">
										    <label >Gambar Unit:</label>
										</div>
										<div class="col-lg-8">
										    <input type="file" placeholder="Upload Gambar Kerja" name="gambarUnit" class="">
										</div>
									</div>
									<div class="form-group col-lg-12" >
										<div class="col-lg-4"></div>
										<div class="col-lg-6" style="text-align: right;">
										<button class="btn btn-default clrFrom" type="button"><B> CLEAR </B></button>
										<button class="btn btn-success" id="btn-submit3" type="button"><B> SAVE </B></button>
										</div>
									</div>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>