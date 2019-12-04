

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
										Cetak Kanban
									</b>
								</h1>
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="">
									<i aria-hidden="true" class="fa fa-refresh fa-2x">
									</i>
								</a>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12">
								<div class="box box-default">
									<div class="box-header with-border">
										<center><b style="font-size: 18px">IMPORT DATA KANBAN</b></center>
									</div>
									<br>
									<div class="box-body">
										<center>
											<table style="border: none;">
												<tr>
													<form method="post" class="import_csv" id="import_csv" enctype="multipart/form-data" action="<?= base_url(); ?>CetakKanbanToolRoom/CetakKanban/importexcel">
														<td>
															<div class="col-md-3"> 
																<input class="excell" type="file" name="excel_file" id="excel_file" accept=" .xls,.xlsx" />
															</div>
														</td>
														<td>
															<div class="col-md-3">
																<button  type="submit" title="Import CSV" name="import_csv" class="btn btn-success tomboll " id="import_csv_btn" disabled="disabled" ><i class="fa fa-upload"></i>  IMPORT EXCEL</button>
															</div>
														</td>
														<td>
															<div class="col-md-1">
																<b>OR</b>  
															</div>
														</td>
													</form>
													<td>
														<div class="col-md-3">
															<a href="<?php echo site_url('CetakKanbanToolRoom/CetakKanban/Export');?>">
																<button Onclick="" class="btn btn-danger" title="Download Layout CSV">
																	<i class="fa fa-download"></i> Download Contoh Layout
																</button>
															</a>  
														</div>
													</td>
												</tr>
											</table>
										</center>
									</div>
									<br>
									<div class="box-footer">
							<!-- 	<h4><b>Referensi Warna:</b></h4>
								<p>Berikut adalah beberapa contoh referensi warna yang dapat digunakan,
								<b>nama warna</b> dapat di-<b><i>copy/paste</i></b>-kan ke dalam file .csv untuk mengatur warna kartu kanban.</p>
							<table border="1" id="ooo" style="width: 50%;">

						
							<tr>
								<td style="background-color: Blue; width: 25%; text-align: center; text-align: center "> Blue</td>
								<td style="background-color: SteelBlue; width: 25%; text-align: center" >SteelBlue</td>
								<td style="background-color: Cyan; width: 25%; text-align: center" >Cyan</td>
								<td style="background-color: Aquamarine; width: 25%; text-align: center" >Aquamarine</td>
						

							</tr>
						
							

							<tr>
								<td style="background-color: Red; width: 25%; text-align: center"> Red </td>
								<td style="background-color: Brown; width: 25%; text-align: center" >Brown</td>
								<td style="background-color: Chocolate; width: 25%; text-align: center" >Chocolate</td>
								<td style="background-color: Salmon; width: 25%; text-align: center" >Salmon</td>
						

							</tr>
						

							<tr>
								<td style="background-color: Green; width: 25%; text-align: center"> Green </td>
								<td style="background-color: Olive; width: 25%; text-align: center" >Olive</td>
								<td style="background-color: Lime; width: 25%; text-align: center" >Lime</td>
								<td style="background-color: SpringGreen; width: 25%; text-align: center" >SpringGreen</td>
						

							</tr>
						

							<tr>
								<td style="background-color: OrangeRed; width: 25%; text-align: center"> OrangeRed </td>
								<td style="background-color: Gold; width: 25%; text-align: center" >Gold</td>
								<td style="background-color: Yellow; width: 25%; text-align: center" >Yellow</td>
								<td style="background-color: Khaki; width: 25%; text-align: center" >Khaki</td>
						

							</tr>
						

							<tr>

								<td style="background-color: DarkViolet; width: 25%; text-align: center" >DarkViolet</td>
								<td style="background-color: Magenta; width: 25%; text-align: center" >Magenta</td>
								<td style="background-color: Violet; width: 25%; text-align: center"> Violet </td>
								<td style="background-color: Silver; width: 25%; text-align: center" >Silver</td>
							

							</tr>
						
						
					
					</table> -->
								
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
