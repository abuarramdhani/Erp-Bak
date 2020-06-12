<style type="text/css">
#kiri
	{
	width:50%;
	float:left;
	}
#kanan
	{
	width:50%;
	float:right;
	}
#bawah
	{
	width:100%;
	float:center;
	}
</style>
<section class="content">
	<div class="inner">
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1>
									<b>
										<?= $Title ?>
									</b>
								</h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('OrderPro/neworderpro');?>">
									<i class="fa fa-pencil fa-2x">
									</i>
									<span>
										<br />
									</span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<form name="Orderform" enctype="multipart/form-data" action="<?php echo base_url('OrderPro/neworderpro/InsertOrder'); ?>" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-warning">
							<div class="box-header with-border"></div>
							<div class="box-body">
							<div id="kiri">
								<div class="panel-body">
									<div class="col-md-5" style="text-align: right;">
										<label>Kode Komponen</label>
									</div>
									<div class="col-md-6" style="text-align: left;">
										<input required="required" autocomplete="off" placeholder="Kode Komponen" type="text"class="form-control" name="komp_order">
									</div>
								</div>	
								<div class="panel-body">
									<div class="col-md-5" style="text-align: right;">
										<label>Nama Komponen</label>
									</div>
									<div class="col-md-6" style="text-align: left;">
										<input required="required" autocomplete="off" type="text"class="form-control" name="namakomp_order" placeholder="Nama Komponen" >
									</div>
								</div>
									<div class="panel-body">
									<div class="col-md-5" style="text-align: right;">
										<label>Asal Material</label>
									</div>
									<div class="col-md-6" style="text-align: left;">
										<select class="form-control select2 asmat_order" id="asmat_order" data-placeholder ="Asal Material" name="asmat_order">
											<option></option>
											<option value="Pusat">Pusat</option>
											<option value="Tuksono">Tuksono</option>
										</select>
									</div>								
								</div>		
								<div class="panel-body">
									<div class="col-md-5" style="text-align: right;">
										<label>Tanggal Kirim Material</label>
									</div>
									<div class="col-md-6" style="text-align: left;">
										<input required="required" autocomplete="off" type="text"class="form-control" name="tglkirim_order" id="tglkirim_order" placeholder="Tanggal Kirim Material" readonly="readonly">
										<input required="required" autocomplete="off" type="text"class="form-control" name="tglkirim_order" id="tglkirim_order2" placeholder="Tanggal Kirim Material" style="display: none;">
									</div>
								</div>	
								<div class="panel-body">
									<div class="col-md-5" style="text-align: right;">
										<label>Due Date</label>
									</div>
									<div class="col-md-6" style="text-align: left;">
										<input required="required" autocomplete="off" type="text" placeholder="Due Date"  class="form-control tanggalorder" name="due_order">
									</div>
								</div>
								<div class="panel-body">
									<div class="col-md-5" style="text-align: right;">
										<label>Type</label>
									</div>
									<div class="col-md-6" style="text-align: left;">
										<input required="required" autocomplete="off" type="text"class="form-control" name="type_order" placeholder="Type">
									</div>
								</div>		
								<div class="panel-body">
									<div class="col-md-5" style="text-align: right;">
										<label>Qty</label>
									</div>
									<div class="col-md-6" style="text-align: left;">
										<input required="required" autocomplete="off"  type="text"class="form-control" name="qty_order" onkeypress="return angkawae(event, false)" placeholder="Qty">
									</div>
								</div>			
								<div class="panel-body">
									<div class="col-md-5" style="text-align: right;">
										<label>Keterangan</label>
									</div>
									<div class="col-md-6" style="text-align: left;">
										<input required="required" autocomplete="off" type="text"class="form-control" name="ket_order" placeholder="Ket">
									</div>
								</div>	
							</div> 
							<div id="kanan">
								<div class="panel-body">
									<div class="col-md-3" style="text-align: left;">
										<label>Proses</label>
									</div>
									<div class="col-md-2" style="text-align: left;">
										<input required="required" autocomplete="off" type="text" class="form-control" name="urutanproses[]" id="upros1" value="1" readonly="readonly">
									</div>
									<div class="col-md-6" style="text-align: left;">
										<select class="form-control select2" id="proses_order" name="proses_order[]" data-placeholder="Proses">
											<option></option>
											<?php foreach ($proses as $ses) {?>
												<option value="<?=$ses['id_proses']?>"><?=$ses['nama_proses']?></option>
											<?php }?>
										</select>
									</div>
									<div class="col-md-1"><a class="btn btn-default btn-sm" onclick="tambahproses()"><i class="fa fa-plus"></i></a></div>

										<!-- <input required="required" autocomplete="off" type="hidden" name="no_order" value="<?=$noorder?>"> -->
										<input required="required" autocomplete="off" type="hidden" name="tgl_order" value="<?=$tgl_order?>">
                        
								</div>
								<div id="tambah_proses"></div>
								<div class="panel-body">
									<div class="col-md-3" style="text-align: left;">
										<label>Gambar Kerja</label>
									</div>
									<div class="col-md-6" style="text-align: left;">
										<input required="required" autocomplete="off" class="form-control" type="file" name="img_order" id="img_order" accept=".png, .jpeg, .jpg" />
									</div>
								</div>
								</div>
									<div  class="col-md-4" ></div>
									<div id="bawah" class="col-md-6" style="text-align: center;">
										<button class="btn bg-teal">Insert</button>
									</div>
							</div>

							</div>
						</div>
						<div class="row">
							
						</div>
					</div>
				</div>
			</form>
			</div>
		</section>