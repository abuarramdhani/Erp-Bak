<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> Data Import Excel</b></h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('CetakKanbanToolRoom/CetakKanban');?>">
									<i class="fa fa-refresh fa-2x"></i>
									<span ><br /></span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box">
							<div class="box-header with-border">
								<b>Data Excel</b>
							</div>
							<form target="_blank" action="<?= base_url(); ?>CetakKanbanToolRoom/CetakKanban/InsertnReport" method="post">
								<div class="box-body">
									<div class="panel-body">
										<div class="table-responsive">
											<table class="table table-bordered table-responsive table-hover no-footertable text-left" style="font-size: 13px;">
												<thead>
													<tr class="bg-teal">
														<th width="5%"><center>NO</center></th>
														<th ><center>KODE BARANG</center></th>
														<th ><center>DESKRIPSI</center></th>
														<th ><center>COST CENTER</center></th>
														<th ><center>NOMOR BPPCT</center></th>
														<th ><center>JUMLAH CETAK</center></th>
														<th ><center>ALUR KANBAN</center></th>
													</tr>
												</thead>
												<tbody id="tbodyUserResponsibility">
													<?php 
													$no = 0;
													foreach ($hasilimport as $row):
														$no++;
													?> 		
													<tr>
														<td><center><?php echo $no ?></center></td>
														<td><center><input type="hidden" name="kode_barang[]" id="kode_barang"  value="<?php echo $row['KODE_BARANG']?>"><?php echo $row['KODE_BARANG']?></center></td>
														<td><center><input type="hidden" name="desc[]" id="desc"  value="<?php echo $row['DESC']?>"><?php echo $row['DESC']?></center></td>
														<td><center><input type="hidden" name="cost_center[]" id="cost_center" value="<?php echo $row['COST_CENTER']?>"><?php echo $row['COST_CENTER']?></center></td>
														<td><center><input type="hidden" name="no_bppbgt[]" id="no_bppbgt" value="<?php echo $row['NO_BPPCT']?>"><?php echo $row['NO_BPPCT']?></center></td>
														<td><center><input type="hidden" name="jumlah_cetak[]" id="jumlah_cetak" value="<?php echo $row['JUMLAH_CETAK']?>"><?php echo $row['JUMLAH_CETAK']?></center></td>
														<td><center><input type="hidden" name="alur_kanban[]" id="alur_kanban"  value="<?php echo $row['ALUR_KANBAN']?>"><?php echo $row['ALUR_KANBAN']?></center></td>
														<input type="hidden" name="warna_atas[]" id="warna_atas"  value="#<?php echo $row['WARNA_KEPALA_KANBAN']?>">
														<input type="hidden" name="warna_bawah[]" id="warna_bawah"  value="#<?php echo $row['WARNA_BADAN_KANBAN']?>">
														<input type="hidden" name="warna_header[]" id="warna_header"  value="#<?php echo $row['WARNA_HEADER']?>">
													</tr>
												<?php endforeach ?>
											</tbody>
										</table>
									</div>
									<br>
									<center>
										<button type="submit" title="Generate to Pdf" class="btn btn-danger"><i class="fa fa-print"></i>  &nbsp;Cetak</button>
									</center>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>