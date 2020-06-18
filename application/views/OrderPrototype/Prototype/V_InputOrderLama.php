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
				<form name="Orderform" action="<?php echo base_url('OrderPro/neworderpro/Insert'); ?>" class="form-horizontal" target="_blank" onsubmit="return validasi();window.location.reload();" method="post">
				<div class="row">
					<div class="col-md-12">
						<div class="box box-warning">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="panel-body">
									<div class="col-md-2" style="text-align: right;">
										<label>Kode Komponen</label>
									</div>
									<div class="col-md-3" style="text-align: left;">
										<input placeholder="Kode Komponen" type="text"class="form-control" name="komp_order">

									</div>
									<div class="col-md-2" style="text-align: right;">
										<label>Proses</label>
									</div>
									<div class="col-md-3" style="text-align: left;">
										<input type="text"class="form-control" name="proses_order" placeholder="Proses">

									</div>
									<div class="col-md-1"><a class="btn btn-default btn-sm"><i class="fa fa-plus"></i></a></div>

										<input type="hidden" name="no_order" value="<?=$noorder?>">
										<input type="hidden" name="tgl_order" value="<?=$tgl_order?>">
                                    
								</div>
								<div class="panel-body">
									<div class="col-md-2" style="text-align: right;">
										<label>Nama Komponen</label>
									</div>
									<div class="col-md-3" style="text-align: left;">
										<input type="text"class="form-control" name="namakomp_order" placeholder="Nama Komponen" readonly="readonly">

									</div>
									<div class="col-md-2" style="text-align: right;">
										<label>Gambar Kerja</label>
									</div>
									<div class="col-md-3" style="text-align: left;">
										<input class="form-control" type="file" name="img_order" id="img_order" accept=".png, .jpeg" />
									</div>
							
									
                                    
								</div>
								<div class="panel-body">
									<div class="col-md-2" style="text-align: right;">
										<label>Due Date</label>
									</div>
									<div class="col-md-3" style="text-align: left;">
										<input type="text" placeholder="Due Date" class="form-control tanggalorder" name="due_order">

									</div>
									
									
                                    
								</div>
								<div class="panel-body">
									<div class="col-md-2" style="text-align: right;">
										<label>Type</label>
									</div>
									<div class="col-md-3" style="text-align: left;">
										<input type="text"class="form-control" name="type_order" placeholder="Type">

									</div>
				
								</div>		
								<div class="panel-body">
									<div class="col-md-2" style="text-align: right;">
										<label>Qty</label>
									</div>
									<div class="col-md-3" style="text-align: left;">
										<input  type="text"class="form-control" name="qty_order" onkeypress="return angkawae(event, false)" placeholder="Qty">

									</div>
                                    
								</div>		
								<div class="panel-body">
									<div class="col-md-2" style="text-align: right;">
										<label>Asal Material</label>
									</div>
									<div class="col-md-3" style="text-align: left;">
										<select class="form-control select2 asmat_order" id="asmat_order" data-placeholder ="Asal Material" name="asmat_order">
											<option></option>
											<option value="Pusat">Pusat</option>
											<option value="Tuksono">Tuksono</option>
										</select>

									</div>
								
								</div>		
									<div class="panel-body">
										<div class="col-md-2" style="text-align: right;">
										<label>Tanggal Kirim Material</label>
									</div>
									<div class="col-md-3" style="text-align: left;">
										<input type="text"class="form-control" name="tglkirim_order" placeholder="Tanggal Kirim Material">

									</div>
									</div>		
									<div class="panel-body">
										<div class="col-md-2" style="text-align: right;">
										<label>Keterangan</label>
									</div>
									<div class="col-md-3" style="text-align: left;">
										<input type="text"class="form-control" name="ket_order" placeholder="Ket">

									</div>
									</div>	
								<div class="panel-body">
									<div  class="col-md-4" ></div>
									<div class="col-md-3" style="text-align: center;">
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