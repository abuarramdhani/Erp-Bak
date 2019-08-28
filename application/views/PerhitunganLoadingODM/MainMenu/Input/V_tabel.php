<section class="content">
	<div class="inner" >
	<div class="row">
		<!------------Preloader-------------->
			<div class="preloader">
					<div class="loading">
						<p>Please Wait Loading Data Table...</p>
					</div>
			</div>
		<!------------Preloader End---------->
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
								<h1><b> DATA IMPORT CSV</b></h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url('PerhitunganLoadingODM/Input');?>">
									<i class="icon-desktop icon-2x"></i>
									<span ><br /></span>
								</a>
							</div>
						</div>
					</div>
				</div>
				<br />
				<div class="row">
					<div class="col-lg-12">
						<div class="box box-primary box-solid">
							<div class="box-header with-border">
								Tabel Input Csv
							</div>
							<form action="<?= base_url(); ?>PerhitunganLoadingODM/Input/saveDatacsv" method="post">
							<div class="box-body">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-responsive table-hover no-footertable text-left" style="font-size: 13px;">
										<thead>
											<tr class="bg-primary">
												<th width="10%"><center>NO</center></th>
												<th width="30%"><center>ITEM CODE</center></th>
												<th width="20%"><center>PERIODE</center></th>
												<th width="20%"><center>NEEDS</center></th>
												<th width="20%"><center>ORGANIZATION CODE</center></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$no = 0;
											foreach ($data_input as $row):
											// echo'<pre>';
											// print_r($row);
											// exit();
												$no++;
											?> 		
													<tr>
														<td><center><?php echo $no ?></center></td>
														<td><center><input type="hidden" name="itemcode[]" id="itemcode" value="<?php echo $row['ITEM_CODE']?>"><?php echo $row['ITEM_CODE']?></center></td>
														<td><center><input type="hidden" name="period[]" id="period" value="<?php echo $row['PERIOD']?>"><?php echo $row['PERIOD']?></center></td>
														<td><center><input type="hidden" name="needs[]" id="needs" value="<?php echo $row['NEEDS']?>"><?php echo $row['NEEDS']?></center></td>
														<td><center><input type="hidden" name="orgcode[]" id="orgcode" value="<?php echo $row['ORG_CODE']?>"><?php echo $row['ORG_CODE']?></center></td>
													</tr>
											<?php endforeach ?>
										</tbody>
									</table>
								</div>
								<center><button id="submitimport" type="submit" name="submit" class="submit btn btn-md bg-blue">SAVE ALL</button></center>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-2">
							<!-- <center><button id="submitimport" type="submit" name="submit" class="submit btn btn-md bg-blue">SAVE ALL</button></center> -->
							</form>
						</div>
					</div>
				</div>
			</div>
	</div>
	</div>
</section>