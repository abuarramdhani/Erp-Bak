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
								<a class="btn btn-default btn-lg" href="<?php echo site_url('ReceivePO/History/');?>">
									<i class="fa fa-list fa-2x">
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
						<div class="box box-warning box-solid">
							<div class="box-body">
								<div class="panel-body">
									<table  class="table table-bordered">
										<thead class="bg-teal">
											<tr>
												<th colspan="2"  style="vertical-align: middle; text-align: center;border-right: none; " >LANE 1</th>
												<th class="text-right" style="vertical-align: middle;border-right: none;border-left: none; " >Operator</th>
												<td style="border-left: none;border-right: none;"><input style="width: 70%" type="text" class="form-control" name="opr[]"> </td>
												<th colspan="4" style="border-left: none;border-right: none;"></th>
												<th style="border-left: none;width: 170px"></th>

											</tr>	
										</thead>
										<tbody>
											<tr>
												<th class="text-center">No</th>
												<th class="text-center">No Job</th>
												<th class="text-center">Kode</th>
												<th class="text-center">Nama Barang</th>
												<th class="text-center">Target PPIC</th>
												<th class="text-center">Target PE</th>
												<th class="text-center" > Plan (%)</th>
												<th class="text-center">Ket</th>
												<th class="text-center">Waktu</th>
											</tr>	
										</tbody>
										<tfoot>
											<tr>
												<td class="text-center"></td>
												<td class="text-center"></td>
												<td class="text-center" ></td>
												<td class="text-center"></td>
												<td class="text-center" ></td>
												<td class="text-center"></td>
												<td class="text-center"></td>
												<td class="text-center" style="vertical-align: bottom;"><button  class="btn btn-info btn-xs" style="border-radius: 50px" onclick="lihatdong(this, 1)" >Lihat</button></td>
												<td class="text-center" >
													<p id="timer1" >
                                                                <label id="hours1" >00</label>:<label id="minutes1">00</label>:<label id="seconds1">00</label>
                                                     </p>
													<!-- <button  class="btn bg-orange btn-xs btn-flat" onclick="startstop(1)" id="btnstart1" title="Mulai"> <i class="fa  fa-play "></i></button> -->
													<input style="border-radius: 50px" type="button" id="btnstart1" class="btn bg-orange btn-xs btn-flat" value="Mulai" >
													<input style="border-radius: 50px" type="button" class="btn btn-success btn-xs btn-flat"  id="btnlanjut1" disabled="disabled" value="Jeda" >
													<!-- <input type="button" class="btn bg-primary btn-xs btn-flat"  id="btnrestart1" disabled="disabled" value="Restart"> -->

													<!-- button  class="btn btn-success btn-xs btn-flat"  id="btnlanjut1" disabled="disabled" title="Lanjut"><i class="fa  fa-pause"></i></button> -->

													<button style="border-radius: 50px"  class="btn bg-primary btn-xs btn-flat"  id="btnrestart1" disabled="disabled"> Restart </button>
													<!-- <button  class="btn btn-danger btn-xs btn-flat" onclick="startstop(1)" id="btnstop1" disabled="disabled" title="Stop"><i class="fa  fa-stop"></i></button>-->		
												</td>
											</tr>	
											<tr>
												<td></td>
												<td colspan="6"></td>
												<td colspan="2">
													<div id="lihat1" style="display: none;" >
														<table class="table table-bordered">
															<thead>
																<th class="text-center" style="width: 100px">Pack</th>
																<th class="text-center" style="width: 50px">Isi</th>
															</thead>
															<tbody>
																<td class="text-center">PLASTIK KANTONG 08 SABLON UKURAN 15.5 X 25 CM</td>
																<td class="text-center">5 Pcs</td>
															</tbody>
														</table>
													</div>
												</td>
											</tr>
										</tfoot>
									</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>