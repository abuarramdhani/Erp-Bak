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
										Perhitungan Utilitas Mesin
									</b>
								</h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="#">
									<i aria-hidden="true" class="fa fa-refresh fa-2x"></i>
								</a>
							</div>
						</div>
					</div>
                </div>
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary">
							<div class="box-header with-border text-center">
								<h3><b>DATA PERHITUNGAN UTILITAS MESIN</b></h3>
								<h4><b><?= $dept?></b></h4>
							</div>
							<div class="box-body">
								<div class="col-md-12">
									<form action="<?php echo base_url('PerhitunganUM/Hitung/exportDataPUM'); ?>" method="post">
									<table id="tbldua" class="table table-striped table-bordered table-hover" style="font-size: 13px;">
										<thead class="bg-info">
											<tr>
												<th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;" width="4%">NO.</th>
												<th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">COST CENTER</th>
												<th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;" class="text-nowrap">RESOURCE CODE</th>
												<th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">DESCRIPTION</th>
												<th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">JENIS MESIN</th>
												<th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">NO MESIN</th>
												<th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">TAG NUMBER</th>
												<th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;" class="text-nowrap">KODE KOMPONEN</th>
												<th rowspan="2" style="text-align: center; vertical-align: middle;background-color: #d9edf7;">DESKRIPSI KOMPONEN</th>
												<th colspan="4" style="text-align: center; vertical-align: middle;">PLAN PRODUKSI (PCS)</th>
												<th rowspan="2" style="text-align: center; vertical-align: middle;">CYCLE TIME (HR)</th>
												<th colspan="4" style="text-align: center; vertical-align: middle;">TOTAL JAM DIBUTUHKAN</th>
												<th rowspan="2" style="text-align: center; vertical-align: middle;">TOTAL JAM DIBUTUHKAN PER BULAN</th>
												<th rowspan="2" style="text-align: center; vertical-align: middle;">UTILITAS MESIN (%)</th>

											</tr>
											<tr>
												<td style="text-align: center; vertical-align: middle;"><?= $bln1?></td>
												<td style="text-align: center; vertical-align: middle;"><?= $bln2?></td>
												<td style="text-align: center; vertical-align: middle;"><?= $bln3?></td>
												<td style="text-align: center; vertical-align: middle;">Rata-rata 1 bulan</td>
												<td style="text-align: center; vertical-align: middle;"><?= $bln1?></td>
												<td style="text-align: center; vertical-align: middle;"><?= $bln2?></td>
												<td style="text-align: center; vertical-align: middle;"><?= $bln3?></td>
												<td style="text-align: center; vertical-align: middle;">Rata-rata 1 bulan</td>
											</tr>
										</thead>
										<tbody>  
											<?php $no=1;foreach($result as $row){ ?> 
												<?php foreach($row['Detail'] as $v){ ?>     
												<tr style="text-align: center; vertical-align: middle;">                        
													<td><?= $no; ?>
														<input type="hidden" name="dept[]" id="dept" value="<?= $dept ?>">
														<input type="hidden" name="periode[]" id="periode" value="<?= $periode ?>">
														<input type="hidden" name="merge[]" id="merge" value="<?= $row['Merge']?>">
														<input type="hidden" name="bln1[]" id="bln1" value="<?= $bln1 ?>">
														<input type="hidden" name="bln2[]" id="bln2" value="<?= $bln2 ?>">
														<input type="hidden" name="bln3[]" id="bln3" value="<?= $bln3 ?>">
														<input type="hidden" name="opr_seq[]" id="opr_seq" value="<?= $v['opr_seq'] ?>">
													</td>              
													<td><input type="hidden" name="cost_center[]" id="cost_center" value="<?= $v['cost_center']?>"><?= $v['cost_center']?></td>               
													<td class="text-nowrap"><input type="hidden" name="resource_code[]" id="resource_code" value="<?= $v['resource_code']?>"><?= $v['resource_code']?></td>               
													<td><input type="hidden" name="deskripsi[]" id="deskripsi" value="<?= $v['deskripsi']?>"><?= $v['deskripsi']?></td>               
													<td><input type="hidden" name="jenis_mesin[]" id="jenis_mesin" value="<?= $v['jenis_mesin']?>"><?= $v['jenis_mesin']?></td>               
													<td style="text-align: left;"><input type="hidden" name="mesin[]" id="mesin" value="<?= $v['mesin']?>"><?= $v['mesin']?></td>               
													<td><input type="hidden" name="tag_number[]" id="tag_number" value="<?= $v['tag_number']?>"><?= $v['tag_number']?></td>                    
													<td  class="text-nowrap" ><input type="hidden" name="item_code[]" id="item_code" value="<?= $v['item']?>"><?= $v['item']?></td>               
													<td style="text-align: left;"><input type="hidden" name="item_desc[]" id="item_desc" value="<?= $v['item_desc']?>"><?= $v['item_desc']?></td>          
													<td><input type="hidden" name="b1[]" id="b1" value="<?= $v['bulan1']?>" /><?= $v['bulan1']?></td> 
													<td><input type="hidden" name="b2[]" id="b2" value="<?= $v['bulan2']?>" /><?= $v['bulan2']?></td>
													<td><input type="hidden" name="b3[]" id="b3" value="<?= $v['bulan3']?>" /><?= $v['bulan3']?></td>
													<td><input type="hidden" name="rata[]" id="rata" value="<?= $v['ratabulan']?>"><?= $v['ratabulan']?></td>  
													<td><input type="hidden" name="cycle_time[]" id="cycle_time" value="<?= $v['cycle_time']?>"/><?= $v['cycle_time']?></td>                        
													<td><input type="hidden" name="jam1[]" id="jam1" value="<?= $v['jam1']?>"><?= $v['jam1']?></td>
													<td><input type="hidden" name="jam2[]" id="jam2" value="<?= $v['jam2']?>"><?= $v['jam2']?></td> 
													<td><input type="hidden" name="jam3[]" id="jam3" value="<?= $v['jam3']?>"><?= $v['jam3']?></td> 
													<td><input type="hidden" name="rata_jam[]" id="rata_jam" value="<?= $v['ratajam']?>"><?= $v['ratajam']?></td>  
													<td><input type="hidden" name="total_jam[]" id="total_jam" value="<?= $row['totaljam']?>"><?= $row['totaljam']?></td>
													<td><input type="hidden" name="utilitas[]" id="utilitas" value="<?= $row['utilitas']?>"><?= $row['utilitas']?>%</td>
												</tr>                    
												<?php $no++; } ?>
											<?php } ?>
										</tbody>
									</table>
									<?php foreach ($insert as $key) {
										foreach ($key['Detail'] as $val) { ?>
											<input type="hidden" name="resource[]" class="resource" value="<?= $val['resource_code'] ?>">
											<input type="hidden" name="nomesin[]" class="nomesin" value="<?= $val['mesin'] ?>">
											<input type="hidden" name="tagnum[]" class="tagnum" value="<?= $val['tag_number']?>">
											<input type="hidden" name="jenis[]" class="jenis" value="<?= $val['jenis_mesin'] ?>">
											<input type="hidden" name="cost[]" class="cost" value="<?= $val['cost_center'] ?>">
											<input type="hidden" name="deptc[]" class="deptc" value="<?= $dept ?>">
											<input type="hidden" name="username[]" class="username" value="<?= $val['username'] ?>">
											<input type="hidden" name="utilitas2[]" class="utilitas" value="<?= $key['utilitas'] ?>">
									<?php } }?>
									<input type="hidden" id="tgl_update" name="tgl_last" value="<?= $tanggal ?>">
									<input type="hidden" id="plan" name="plan" value="<?= $plan ?>">
									<input type="hidden" id="nama_user" name="nama_user" value="<?= $nama_user ?>">
									<div class="row" style="padding-right: 10px">
										<button type="button" class="btn btn-warning" onclick="insertPUM(this)"><i class="fa fa-upload"></i> Upload Oracle</button>
										<button type="submit" title="Export" class="btn btn-success" style="position: absolute; right: 0;"><i class="fa fa-download"></i> Export Excel</button>
									</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
