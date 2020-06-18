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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('ProductionPlan/Item');?>">
									<i class="fa fa-wrench fa-2x">
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
						<div class="box box-warning">
							<div class="box-header with-border"></div>
							<div class="box-body">
								<div class="panel-body">
									<div class="col-md-4" style="text-align: right;">
										<label>Priority</label>
									</div>
									<div class="col-md-3" style="text-align: center;">
										<input style="text-align: center" type="text" class="form-control" name="priority" placeholder="Priority" onkeypress="return justangka(event, false)" >
									</div>
                                    
								</div>
								<div class="panel-body">
									<div class="col-md-4" style="text-align: right;">
										<label>Kode Komponen</label>
									</div>
									<div class="col-md-3" style="text-align: center;">
										<input style="text-align: center" type="text" class="form-control" id="codekomp" oninput="this.value = this.value.toUpperCase()" name="codekomp" placeholder="Kode Komponen" onkeyup="getName(this)">
									</div>
                                    
								</div>
								<div class="panel-body">
									<div class="col-md-4" style="text-align: right;">
										<label>Nama Komponen</label>
									</div>
									<div class="col-md-3" style="text-align: center;">
										<input style="text-align: center" type="text" class="form-control" id="namekomp" name="namekomp" placeholder="Nama Komponen" readonly="readonly">
									</div>
                                    
								</div>
									<div class="panel-body">
									<div class="col-md-4" style="text-align: right;">
										<label>Jenis</label>
									</div>
									<div class="col-md-3" style="text-align: center;">
										<select class="form-control select2 pilihjenis" data-placeholder="Jenis" name="jeniskomp">
											<option></option>
											<option value="Body">Body</option>
											<option value="Handle Bar">Handle Bar</option>
											<option value="Dos">Dos</option>
										</select>
									</div>
                                    
								</div>
								<div class="panel-body">
									<div  class="col-md-4" ></div>
									<div class="col-md-3" style="text-align: center;">
										<button onclick="InsertItem(this)" class="btn btn-success"><i class="glyphicon glyphicon-floppy-save"></i> Save</button>
									</div>
								</div>
							<div id="hilangkantampilan">
								<div class="panel-body">
									<div class="col-md-12">
										<h3 style="font-weight: bold">Data Body</h3>
									</div>
									<div class="col-md-12">
										<table class="table table-bordered">
											<thead class="bg-teal">
												
												<tr>
													<th class="text-center">No</th>
													<th class="text-center">Kode Komponen</th>
													<th class="text-center">Nama Komponen</th>
													<th class="text-center"></th>
												</tr>
										
											</thead>
											<tbody>
												<?php
												$no=1;
												 foreach ($arraybody as $array) { ?>
												<tr>
													<td class="text-center"><?=$no?></td>
													<td class="text-center"><input type="hidden" value="<?=$array['kode_item']?>" name="codekomp"><?=$array['kode_item']?></td>
													<td class="text-center"><input type="hidden" value="<?=$array['desc_item']?>" name="namakomp"><?=$array['desc_item']?></td>
													<td class="text-center"><input type="hidden" value="" name=""> </td>
												</tr>
												<?php $no++; } ?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="panel-body">
									<div class="col-md-12">
										<h3 style="font-weight: bold">Data Handle Bar</h3>
									</div>
									<div class="col-md-12">
										<table class="table table-bordered">
											<thead class="bg-red">
												<tr>
													<th class="text-center">No</th>
													<th class="text-center">Kode Komponen</th>
													<th class="text-center">Nama Komponen</th>
													<th class="text-center"></th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no=1;
												 foreach ($arrayhandlebar as $array) { ?>
												<tr>
													<td class="text-center"><?=$no?></td>
													<td class="text-center"><input type="hidden" value="<?=$array['kode_item']?>" name="codekomp"><?=$array['kode_item']?></td>
													<td class="text-center"><input type="hidden" value="<?=$array['desc_item']?>" name="namakomp"><?=$array['desc_item']?></td>
													<td class="text-center"><input type="hidden" value="" name=""> </td>
												</tr>
												<?php $no++; } ?>
											</tbody>
										</table>
									</div>
								</div>
								<div class="panel-body">
									<div class="col-md-12">
										<h3 style="font-weight: bold">Data Dos</h3>
									</div>
									<div class="col-md-12">
										<table class="table table-bordered">
											<thead class="bg-primary">
												<tr>
													<th class="text-center">No</th>
													<th class="text-center">Kode Komponen</th>
													<th class="text-center">Nama Komponen</th>
													<th class="text-center"></th>
												</tr>
											</thead>
											<tbody>
												<?php
												$no=1;
												 foreach ($arraydos as $array) { ?>
												<tr>
													<td class="text-center"><?=$no?></td>
													<td class="text-center"><input type="hidden" value="<?=$array['kode_item']?>" name="codekomp"><?=$array['kode_item']?></td>
													<td class="text-center"><input type="hidden" value="<?=$array['desc_item']?>" name="namakomp"><?=$array['desc_item']?></td>
													<td class="text-center"><input type="hidden" value="" name=""> </td>
												</tr>
												<?php $no++; } ?>
											</tbody>
										</table>
									</div>
								</div>

							</div>
							<div class="panel-body">
									<div class="col-md-12" id="tabelitem"></div>
								</div>

							</div>
						</div>
						<div class="row">
							
						</div>
					</div>
				</div>
			</div>
		</section>