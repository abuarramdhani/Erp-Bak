<section class="content">
	<div class="inner" >
		<div class="row">
			<div class="col-lg-12">
				<div class="row">
					<div class="col-lg-12">
						<div class="col-lg-11">
							<div class="text-right">
							<h1><b> Update Rule</b></h1>
						
							</div>
						</div>
						<div class="col-lg-1 ">
							<div class="text-right hidden-md hidden-sm hidden-xs">
								<a class="btn btn-default btn-lg" href="<?php echo site_url("EmployeeRecruitment/Setting/edit/$id");?>">
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
							<form method="post" action="<?php echo base_url('EmployeeRecruitment/Setting/saveedit/')?>" class="form-horizontal">
							<div class="panel-heading text-left">
							</div>
							
							<div class="panel-body">
								<div class="row">
									<?php if ($msg) { ?>
                                    <div class="row"> <div class="col-md-6 col-md-offset-3 " style="margin-top: 20px">
                                       <div id="eror" class="alert alert-dismissible " role="alert" style="background-color:#00a65a; text-align:center; color:white; "><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> <?php echo $msg;?> </div> 
                                        </div>
                                     </div>
                                    <?php } ?>
									<div class="form-group">
											<label for="norm" class="control-label col-lg-4">Jenis Soal</label>
											<div class="col-lg-4">
												<input required type="text" placeholder="Jenis Soal" name="txtJenis" value="<?= $id ?>" class="form-control " />
											</div>
									</div>
									<div class="form-group">
									<div class="col-lg-1">
									</div>
									<div class="col-lg-10">
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
											<?php $i = 0; foreach ($rule as $rl) { ?>
											<tr class="rowERC">
												<td class="frst">
													<center> <?php echo $rl['nomor']; ?> </center>
												</td>
												<td>
													<select class="form-control " id="id-sub" name="subTest[<?= $i ?>]">
														<option></option>
														<?php 
															$alph ='A'; for($a=0; $a < 26 ; $a++){?>
																<option <?= $rl['sub_test'] == $alph ? 'selected' : '' ?> value="<?= $alph ?>"><?= $alph++; ?></option>
														<?php	}
														 ?>
													</select>
												</td>
												<td>
													<input  type="text" hidden class="id-num" name="nomer[<?= $i ?>]" value="<?php echo $rl['nomor'] ?>">
													<input  type="text" hidden class="id-ruleid" name="idNo[<?= $i ?>]" value="<?php echo $rl['rule_id'] ?>">
													<select required id="slcType" class="form-control" name="slcType[<?= $i ?>]" >
														<option value="s" <?= $rl['type'] == 's' ? 'selected' : '' ?> > S(Single value ) </option>
														<option value="d" <?= $rl['type'] == 'd' ? 'selected' : '' ?> > D(Double value) </option>
													</select>
												</td>
												<td>
													<input required onkeyup="checkSetERC(this)" name="txtKey[<?= $i ?>]" type="text" class="form-control id-key" value="<?= $rl['kunci'] ?>" >
												</td>
												<td>
													<input required type="number" class="form-control id-btl" name="scrBtl[<?= $i ?>]" value="<?= $rl['score_betul'] ?>">
												</td>
												<td >
													<input required type="number" class="form-control id-slh" name="scrSlh[<?= $i ?>]" value="<?= $rl['score_salah'] ?>" >
												</td>

											</tr>
											<?php $i++; } ?>
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
									
							<div class="panel-footer">
								<div class="row">
									<center>
										
									<a href="<?php echo site_url('EmployeeRecruitment/Setting/index');?>" class="btn btn-primary btn-lg btn-rect">Back</a>
									&nbsp;&nbsp;
									<button type="submit" id="btnUser" class="btn btn-primary btn-lg btn-rect">Save Changes</button>
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