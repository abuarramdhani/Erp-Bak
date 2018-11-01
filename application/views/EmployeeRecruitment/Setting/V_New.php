<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
							<h1><b> Insert New Rule</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url("EmployeeRecruitment/Setting/addnew");?>">
									<i class="icon-edit icon-2x"></i>
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
						Form Edit
						</div>
						<div class="box-body">
							<form method="post" action="<?php echo base_url('EmployeeRecruitment/Setting/saveadd')?>" class="form-horizontal">
							<div class="panel-heading text-left">
							</div>
							
							<div class="panel-body">
								<div class="row">
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Jenis Soal</label>
											<div class="col-lg-4">
												<input required type="text" placeholder="Jenis Soal" name="txtJenis" value="<?= isset($tmp['jenis_soal']) ? $tmp['jenis_soal'] :'' ?>" class="form-control" maxlength="5" />
											</div>
									</div>
									<?php if (isset($tmp['jumlah_soal'])) { ?>
										<div class="form-group">
									<div class="col-lg-1">
									</div>
									<div class="col-lg-10">
									<input type="text" hidden name="insRule" value="1">
									<table class="table table-bordered table-striped" id="tableRule" >
										<thead>
											<tr class="bg-blue ">
												<th> No. </th>
												<th> Sub Test </th>
												<th> Tipe Soal </th>
												<th> Kunci </th>
												<th> Skor Betul </th>
												<th> Skor Salah </th>
												<!-- <th></th> -->
											</tr>
										</thead>
										<tbody>
											<?php for($i = 0 ; $i < $tmp['jumlah_soal'] ; $i++) { ?>
											<tr class="rowERC">
												<td class="frst">
													<center> <?php echo $i+1; ?> </center>
												</td>
												<td>
													<select class="form-control " id="id-sub" name="subTest[<?= $i ?>]">
														<option></option>
														<?php 
															$alph ='A'; for($a=0; $a < 26 ; $a++){?>
																<option value="<?= $alph ?>"><?= $alph++; ?></option>
														<?php	}
														 ?>
													</select>
												</td>
												<td>
													<input  type="text" hidden class="id-num" name="nomer[<?= $i ?>]" value="<?php echo $i+1; ?>">
													<select required id="slcType" class="form-control" name="slcType[<?= $i ?>]" >
														<option value="s"  > S(Single value ) </option>
														<option value="d"  > D(Double value) </option>
													</select>
												</td>
												<td>
													<input required onkeyup="checkSetERC(this)" name="txtKey[<?= $i ?>]" type="text" class="form-control id-key" value="" >
												</td>
												<td>
													<input required type="number" class="form-control id-btl" name="scrBtl[<?= $i ?>]" value="">
												</td>
												<td >
													<input required type="number" class="form-control id-slh" name="scrSlh[<?= $i ?>]" value="" >
												</td>

											</tr>
											<?php } ?>
										</tbody>
									</table>
									</div>
								</div>
								<div class="form-group">
											<label for="norm" class="control-label col-lg-2"></label>
											<div class="col-lg-8 ">
													
												<button type="button" class="btn btn-success " onclick="addRowERC('tableRule')" > + </button>
												<button type="button" class="btn btn-danger " onclick="deleteRowERC('tableRule')" > - </button>
											</div>
									</div>
									<?php }else{ ?>

									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Jumlah Soal</label>
											<div class="col-lg-4">
												<input required type="number" placeholder="Masukkan Jumlah Soal" name="jmlSoal" value="" class="form-control toupper" />
											</div>
									</div>
									<?php } ?>
									
							<div class="panel-footer">
								<div class="row">
									<center>
										
									<a href="<?php echo site_url('EmployeeRecruitment/Setting/index');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
									&nbsp;&nbsp;
									<button type="submit" class="btn btn-primary btn-lg btn-rect">Next</button>
									</center>
								</div>
							</div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</form>
	</div>
</section>