<section class="content">
	<div class="inner" >
	  <div class="row">
	    <div class="col-lg-12">
	      <div class="row">
	        <div class="col-lg-12">
	          <div class="col-lg-11">
	            <div class="text-right">
	            <h1><b>Master Gaji Karyawan</b></h1>
	            </div>
	          </div>
	          <div class="col-lg-1">
	            <div class="text-right hidden-md hidden-sm hidden-xs">
	            	<a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagement/');?>">
	            		<i class="icon-wrench icon-2x"></i>
	            		<span><br/></span>
	            	</a>
	            </div>
	          </div>
	        </div>
	      </div>
	      <br/>
	      
	      <div class="row">
	        <div class="col-lg-12">
		        <div class="box box-primary box-solid">
		          <div class="box-header with-border">
					<b>Master Gaji Karyawan</b>
		          </div>
		          <div class="box-body">
					<div class="row">
						<div class="row" style="margin: 10px 0px">
							<form method="post" action="<?php echo base_url('PayrollManagement/Report/MasterGajiKaryawan/search')?>" enctype="multipart/form-data">
								<div class="col-lg-2">
									<input name="txtPeriodeHitung" placeholder="Periode" id="txtPeriodeHitung" type="text" class="form-control">
								</div>

								<div class="col-lg-3">
									<select name="txtDept" class="select2-txtDept">
									<?php 
										if(!empty($departments)){
											foreach($departments as $row) { ?>
												<option value=
													<?php
														echo $row['dept'];
														if ($row['dept'] == $dept_selected)
														{
															echo " selected";
														}
													?>
												>
												<?php echo $row['dept']?>													
												</option>
									<?php 
											}
										}
									?>
									</select>
								</div>
								<div class="col-lg-2">
									<button class="btn btn-warning btn-block">Search</button>
								</div>
							</form>
							<div class="col-lg-3">
							</div>
						</div>
					</div>
					<?php if ($ShowPeriod) 
						{
							echo '<div class="row" style="margin: 10px 0px">
								<table>
									<tr>
										<td width="50px">Periode</td>
										<td> :&nbsp</td>
										<td>'.$year.' - '.$month.'</td>
									</tr>
									<tr>
										<td width="50px">PDF</td>
										<td> :&nbsp</td>
										<td><a class="btn btn-xs btn-primary" href="'.site_url('PayrollManagement/Report/MasterGajiKaryawan/GeneratePDF?year='.$year.'&month='.$month.'&dept='.$dept_selected).'">'.
											'<span class="fa fa-file-pdf-o"></span></a></td>
									</tr>
								</table>
							</div>';
						}
					?>
		            <div class="table-responsive">
		              <table class="table table-striped table-bordered table-hover text-left" id="dataTables-reportMasterGaji" style="font-size:12px;">
		                <thead class="bg-primary">
		                  <tr>
		                    <th style="text-align:center"><div style="width:40px"></div>NO</th>
							<th style="text-align:center"><div style="width:100px"></div>No. Induk</th>
							<th style="text-align:center"><div style="width:100px"></div>Nama</th>
							<th style="text-align:center"><div style="width:100px"></div>PTKP</th>
							<th style="text-align:center"><div style="width:100px"></div>Gaji Pokok</th>
							<th style="text-align:center"><div style="width:100px"></div>IF</th>
							<th style="text-align:center"><div style="width:100px"></div>IP</th>
							<th style="text-align:center"><div style="width:100px"></div>IK</th>
							<th style="text-align:center"><div style="width:100px"></div>UBT</th>
							<th style="text-align:center"><div style="width:100px"></div>UPAMK</th>
							<th style="text-align:center"><div style="width:100px"></div>I Kmhln</th>
							<th style="text-align:center"><div style="width:100px"></div>JHT</th>
							<th style="text-align:center"><div style="width:100px"></div>JKN</th>
							<th style="text-align:center"><div style="width:100px"></div>Pot Duka</th>
							<th style="text-align:center"><div style="width:100px"></div>Pot SPSI</th>
							<th style="text-align:center"><div style="width:100px"></div>Pot IKop</th>
							<th style="text-align:center"><div style="width:100px"></div>THP</th>					
		                  </tr>
		                </thead>
		                <tbody>
							<?php $no = 1; 
							if(!empty($master_gaji)){
								foreach($master_gaji as $row) { ?>
								<tr>
									<td align='center'><?php echo $no++;?></td>
									<td align='center'><?php echo $row['no_induk'] ?></td>
									<td align='center'><?php echo $row['nama'] ?></td>
									<td align='center'><?php echo $row['ptkp'] ?></td>
									<td align='center'><?php echo $row['gaji_pokok'] ?></td>
									<td align='center'><?php echo $row['i_f'] ?></td>
									<td align='center'><?php echo $row['i_p'] ?></td>
									<td align='center'><?php echo $row['i_k'] ?></td>
									<td align='center'><?php echo $row['ubt'] ?></td>
									<td align='center'><?php echo $row['upamk'] ?></td>
									<td align='center'><?php echo $row['i_mahal'] ?></td>
									<td align='center'><?php echo $row['jht'] ?></td>
									<td align='center'><?php echo $row['jkn'] ?></td>
									<td align='center'><?php echo $row['pot_duka'] ?></td>
									<td align='center'><?php echo $row['pot_spsi'] ?></td>
									<td align='center'><?php echo $row['pot_ikop'] ?></td>
									<td align='center'><?php echo $row['thp'] ?></td>
								</tr>
							<?php 
								}
							} 
							?>
		                </tbody>                                      
		              </table>
		            </div>
		          </div>
		        </div>
	        </div>
	      </div>    
	    </div>    
	  </div>
	</div>
</section>