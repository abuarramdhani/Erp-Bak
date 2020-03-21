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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlan/Projection');?>">
									<i class="fa fa-bar-chart fa-2x">
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
				<div class="row">
					<div class="col-md-12">
						<div class="box box-danger">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="panel-body">
									<h3 style="text-align: center;"><label>-------------------- BODY --------------------</label></h3>
									<div class="col-md-12">
										<h5><label>PROJECTION</label></h5>
									</div>
									<div class="col-md-12">
										<table class="table table-bordered">
											<thead class="bg-red">
												<tr>
													<th style="width: 100px">	</th>
													<?php 
													$hedbulan = date("F");
													$date=date("j");
													$btas = $date + 7;
													for ($i= $date; $i < $btas ; $i++) { 
													  ?>
													<th colspan="2" class="text-center"><?=$i?> <?=$hedbulan?></th>
													<?php } ?>

												</tr>
											</thead>
											<tbody>
												
												<tr>
													<th class="text-center">Nama Komponen</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>

												</tr>
											</tbody>
											<tfoot>
												<?php foreach ($body as $bod) {
												 ?>
												<tr>
													<td class="text-center"><input type="hidden" name="kompbody[]" value="<?=$bod['komponen']?>"><?=$bod['komponen']?></td>
													<td class="text-center"><input type="hidden" name="planbody1[]" value="<?=$bod['qty_plan1']?>"><?=$bod['qty_plan1']?></td>
													<td class="text-center"><input type="hidden" name="proyekbody1[]" value="<?=$bod['proyeksi1']?>"><?=$bod['proyeksi1']?></td>
													<td class="text-center"><input type="hidden" name="planbody1[]" value="<?=$bod['qty_plan2']?>"><?=$bod['qty_plan2']?></td>
													<td class="text-center"><input type="hidden" name="proyekbody1[]" value="<?=$bod['proyeksi2']?>"><?=$bod['proyeksi2']?></td>
													<td class="text-center"><input type="hidden" name="planbody3[]" value="<?=$bod['qty_plan3']?>"><?=$bod['qty_plan3']?></td>
													<td class="text-center"><input type="hidden" name="proyekbody3[]" value="<?=$bod['proyeksi3']?>"><?=$bod['proyeksi3']?></td>
													<td class="text-center"><input type="hidden" name="planbody4[]" value="<?=$bod['qty_plan4']?>"><?=$bod['qty_plan4']?></td>
													<td class="text-center"><input type="hidden" name="proyekbody4[]" value="<?=$bod['proyeksi4']?>"><?=$bod['proyeksi4']?></td>
													<td class="text-center"><input type="hidden" name="planbody5" value="<?=$bod['qty_plan5']?>"><?=$bod['qty_plan5']?></td>
													<td class="text-center"><input type="hidden" name="proyekbody5" value="<?=$bod['proyeksi5']?>"><?=$bod['proyeksi5']?></td>
													<td class="text-center"><input type="hidden" name="planbody6" value="<?=$bod['qty_plan6']?>"><?=$bod['qty_plan6']?></td>
													<td class="text-center"><input type="hidden" name="proyekbody6" value="<?=$bod['proyeksi6']?>"><?=$bod['proyeksi6']?></td>
													<td class="text-center"><input type="hidden" name="planbody7" value="<?=$bod['qty_plan7']?>"><?=$bod['qty_plan7']?></td>
													<td class="text-center"><input type="hidden" name="proyekbody7" value="<?=$bod['proyeksi7']?>"><?=$bod['proyeksi7']?></td>

												</tr>
												<?php } ?>
											</tfoot>
										</table>
									</div>
								</div>
								<div class="panel-body">
									<div class="col-md-12">
										<h5><label>POTENSI SHORTAGE</label></h5>
									</div>
									<div class="col-md-12">
											<table class="table table-bordered">
											<thead class="bg-red">
												<tr>
													<th class="text-center">Type</th>
													<th class="text-center">Kode</th>
													<th class="text-center">Deskripsi</th>
													<th class="text-center">Qty</th>
													<th class="text-center">Progress</th>

												</tr>
											</thead>
											<tbody>
													<?php foreach ($shortagebody as $shortbody) { ?>
												<tr>
													<td class="text-center"></td>
													<td class="text-center"><?=$shortbody['komponen']?></td>
													<td class="text-center"><?=$shortbody['desc']?></td>
													<td class="text-center"><?=$shortbody['qty']?></td>
													<td class="text-center"></td>
										
												</tr>
												<?php } ?>
											</tbody>
										
										</table>
									</div>
								</div>
							</div>
							<div class="box-footer">
								<div class="panel-body">
									<h3 style="text-align: center;"><label>-------------------- HANDLE BAR --------------------</label></h3>
									<div class="col-md-12">
										<h5><label>PROJECTION</label></h5>
									</div>
									<div class="col-md-12">
										<table class="table table-bordered">
											<thead class="bg-teal">
												<tr>
													<th style="width: 100px">	</th>
													<?php 
													$hedbulan = date("F");
													$date=date("j");
													$btas = $date + 7;
													for ($i= $date; $i < $btas ; $i++) { 
													  ?>
													<th colspan="2" class="text-center"><?=$i?> <?=$hedbulan?></th>
													<?php } ?>

												</tr>
											</thead>
											<tbody>
												<tr>
													<th class="text-center">Nama Komponen</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>

												</tr>
											</tbody>
											<tfoot>
												<?php foreach ($handle_bar as $hand) {
												 ?>
												<tr>
													<td class="text-center"><input type="hidden" name="komphand[]" value="<?=$hand['komponen']?>"><?=$hand['komponen']?></td>
													<td class="text-center"><input type="hidden" name="planhand1[]" value="<?=$hand['qty_plan1']?>"><?=$hand['qty_plan1']?></td>
													<td class="text-center"><input type="hidden" name="proyekhand1[]" value="<?=$hand['proyeksi1']?>"><?=$hand['proyeksi1']?></td>
													<td class="text-center"><input type="hidden" name="planhand1[]" value="<?=$hand['qty_plan2']?>"><?=$hand['qty_plan2']?></td>
													<td class="text-center"><input type="hidden" name="proyekhand1[]" value="<?=$hand['proyeksi2']?>"><?=$hand['proyeksi2']?></td>
													<td class="text-center"><input type="hidden" name="planhand3[]" value="<?=$hand['qty_plan3']?>"><?=$hand['qty_plan3']?></td>
													<td class="text-center"><input type="hidden" name="proyekhand3[]" value="<?=$hand['proyeksi3']?>"><?=$hand['proyeksi3']?></td>
													<td class="text-center"><input type="hidden" name="planhand4[]" value="<?=$hand['qty_plan4']?>"><?=$hand['qty_plan4']?></td>
													<td class="text-center"><input type="hidden" name="proyekhand4[]" value="<?=$hand['proyeksi4']?>"><?=$hand['proyeksi4']?></td>
													<td class="text-center"><input type="hidden" name="planhand5" value="<?=$hand['qty_plan5']?>"><?=$hand['qty_plan5']?></td>
													<td class="text-center"><input type="hidden" name="proyekhand5" value="<?=$hand['proyeksi5']?>"><?=$hand['proyeksi5']?></td>
													<td class="text-center"><input type="hidden" name="planhand6" value="<?=$hand['qty_plan6']?>"><?=$hand['qty_plan6']?></td>
													<td class="text-center"><input type="hidden" name="proyekhand6" value="<?=$hand['proyeksi6']?>"><?=$hand['proyeksi6']?></td>
													<td class="text-center"><input type="hidden" name="planhand7" value="<?=$hand['qty_plan7']?>"><?=$hand['qty_plan7']?></td>
													<td class="text-center"><input type="hidden" name="proyekhand7" value="<?=$hand['proyeksi7']?>"><?=$hand['proyeksi7']?></td>

												</tr>
												<?php } ?>
											</tfoot>
										</table>
									</div>
								</div>
								<div class="panel-body">
									<div class="col-md-12">
										<h5><label>POTENSI SHORTAGE</label></h5>
									</div>
									<div class="col-md-12">
											<table class="table table-bordered">
											<thead class="bg-teal">
												<tr>
													<th class="text-center">Type</th>
													<th class="text-center">Kode</th>
													<th class="text-center">Deskripsi</th>
													<th class="text-center">Qty</th>
													<th class="text-center">Progress</th>

												</tr>
											</thead>
											<tbody>
												<?php foreach ($shortagehand as $shorthand) { ?>
												<tr>
													<td class="text-center"></td>
													<td class="text-center"><?=$shorthand['komponen']?></td>
													<td class="text-center"><?=$shorthand['desc']?></td>
													<td class="text-center"><?=$shorthand['qty']?></td>
													<td class="text-center"></td>
										
												</tr>
												<?php } ?>
											</tbody>
										
										</table>
									</div>
								</div>
								
							</div>
							<div class="box-footer">
								<div class="panel-body">
									<h3 style="text-align: center;"><label>-------------------- DOS --------------------</label></h3>
									<div class="col-md-12">
										<h5><label>PROJECTION</label></h5>
									</div>
									<div class="col-md-12">
										<table class="table table-bordered">
											<thead class="bg-yellow">
												<tr>
													<th style="width: 100px">	</th>
													<?php 
													$hedbulan = date("F");
													$date=date("j");
													$btas = $date + 7;
													for ($i= $date; $i < $btas ; $i++) { 
													  ?>
													<th colspan="2" class="text-center"><?=$i?> <?=$hedbulan?></th>
													<?php } ?>

												</tr>
											</thead>
											<tbody>
												<tr>
													<th class="text-center">Nama Komponen</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>
													<th class="text-center">Plan</th>
													<th class="text-center">Proyeksi</th>

												</tr>
											</tbody>
											<tfoot>
												<?php foreach ($dos as $do) {
												 ?>
												<tr>
													<td class="text-center"><input type="hidden" name="kompdo[]" value="<?=$do['komponen']?>"><?=$do['komponen']?></td>
													<td class="text-center"><input type="hidden" name="plando1[]" value="<?=$do['qty_plan1']?>"><?=$do['qty_plan1']?></td>
													<td class="text-center"><input type="hidden" name="proyekdo1[]" value="<?=$do['proyeksi1']?>"><?=$do['proyeksi1']?></td>
													<td class="text-center"><input type="hidden" name="plando1[]" value="<?=$do['qty_plan2']?>"><?=$do['qty_plan2']?></td>
													<td class="text-center"><input type="hidden" name="proyekdo1[]" value="<?=$do['proyeksi2']?>"><?=$do['proyeksi2']?></td>
													<td class="text-center"><input type="hidden" name="plando3[]" value="<?=$do['qty_plan3']?>"><?=$do['qty_plan3']?></td>
													<td class="text-center"><input type="hidden" name="proyekdo3[]" value="<?=$do['proyeksi3']?>"><?=$do['proyeksi3']?></td>
													<td class="text-center"><input type="hidden" name="plando4[]" value="<?=$do['qty_plan4']?>"><?=$do['qty_plan4']?></td>
													<td class="text-center"><input type="hidden" name="proyekdo4[]" value="<?=$do['proyeksi4']?>"><?=$do['proyeksi4']?></td>
													<td class="text-center"><input type="hidden" name="plando5" value="<?=$do['qty_plan5']?>"><?=$do['qty_plan5']?></td>
													<td class="text-center"><input type="hidden" name="proyekdo5" value="<?=$do['proyeksi5']?>"><?=$do['proyeksi5']?></td>
													<td class="text-center"><input type="hidden" name="plando6" value="<?=$do['qty_plan6']?>"><?=$do['qty_plan6']?></td>
													<td class="text-center"><input type="hidden" name="proyekdo6" value="<?=$do['proyeksi6']?>"><?=$do['proyeksi6']?></td>
													<td class="text-center"><input type="hidden" name="plando7" value="<?=$do['qty_plan7']?>"><?=$do['qty_plan7']?></td>
													<td class="text-center"><input type="hidden" name="proyekdo7" value="<?=$do['proyeksi7']?>"><?=$do['proyeksi7']?></td>

												</tr>
												<?php } ?>
											</tfoot>
										</table>
									</div>
								</div>
								<div class="panel-body">
									<div class="col-md-12">
										<h5><label>POTENSI SHORTAGE</label></h5>
									</div>
									<div class="col-md-12">
											<table class="table table-bordered">
											<thead class="bg-yellow">
												<tr>
													<th class="text-center">Type</th>
													<th class="text-center">Kode</th>
													<th class="text-center">Deskripsi</th>
													<th class="text-center">Qty</th>
													<th class="text-center">Progress</th>

												</tr>
											</thead>
											<tbody>
												<?php foreach ($shortagedos as $shortdos) { ?>
												<tr>
													<td class="text-center"></td>
													<td class="text-center"><?=$shortdos['komponen']?></td>
													<td class="text-center"><?=$shortdos['desc']?></td>
													<td class="text-center"><?=$shortdos['qty']?></td>
													<td class="text-center"></td>
										
												</tr>
												<?php } ?>
											</tbody>
										
										</table>
									</div>
								</div>
								
							</div>
					</div>
				</div>
			</div>
		</section>