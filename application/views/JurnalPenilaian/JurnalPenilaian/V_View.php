<section class="content">
	<div class="inner" >
	<div class="row">
		<div class="col-lg-12">
			<div class="row">
				<div class="col-lg-12">
					<div class="col-lg-11">
						<div class="text-right">
						<h1><b>Jurnal Penilaian Personalia</b></h1>
						</div>
					</div>
					<div class="col-lg-1">
						<div class="text-right hidden-md hidden-sm hidden-xs">
                            <a class="btn btn-default btn-lg" href="<?php echo site_url('PenilaianKinerja/JurnalPenilaianPersonalia');?>">
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
						
						<b data-toogle="tooltip" title="Halaman untuk membuat template penilaian.">List Penilaian Kinerja</b>
					</div>
					<div class="box-body">
						<div class="col-md-12">
          <!-- Custom Tabs -->
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
            	<?php 
            	$num = 1;
            	foreach($unit_group as $unit_group_item ){ 
            		$active = "";
            		if($num == 1){
            			$active = "class='active'";
            		}
            	?>
	              <li <?php echo $active; ?>><a href="#tab_<?php echo $num; ?>" data-toggle="tab" style="font-size: 18;font-weight: bold;color: #3c8dbc;"><?php echo $unit_group_item['unit_group'] ?></a></li>
              	<?php
              		 $num++;
              	} ?>
              <li class="pull-right num_record" style="display:none;"><?php echo (int)$num; ?></i></a></li>
            </ul>
            <div class="tab-content">
            	<?php
            	$num = 1;
            		foreach($unit_group as $unit_group_item){
            			$active = "";
		            		if($num == 1){
		            			$active = "active";
		            		}
		            		?>
		            			<div class="tab-pane <?php echo $active; ?>" id="tab_<?php echo $num; ?>">
		            				<table class="table table-striped table-bordered table-hover text-left" id="tableAssessment<?php echo $num; ?>" style="font-size:14px;">
								<thead class="bg-primary">
									<tr>
										<th width="5%" class="text-center">No.</th>
										<th width="10%" class="text-center">Noind</th>
										<th width="20%" class="text-center">Nama</th>
										<th width="20%" class="text-center">Kodesie</th>
										<th width="20%" class="text-center">TIM</th>
										<th width="20%" class="text-center">SP</th>
									</tr>
								</thead>
								<tbody>
										<?php $no = 1;
											foreach ($assessment as $assessment_item) {
												if($assessment_item['id_unit_group']==$unit_group_item['id_unit_group']){
											?>
												<tr>
													<td><?php echo $no; ?></td>
													<td><?php echo $assessment_item['noind'] ?></td>
													<td><?php echo $assessment_item['nama'] ?></td>
													<td><?php echo $assessment_item['kodesie'] ?></td>
													<td><?php echo $assessment_item['t_tim'] ?></td>
													<td><?php echo $assessment_item['t_sp'] ?></td>
												</tr>
											<?php
											$no++;
												}
											}
										?>
								</tbody>																			
								</table>
		            			</div>
		            		<?php 
		            	$num++;
            		}
            	 ?> 
              
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->
        </div>
					</div>
					 <div class="panel-footer">
		                <div class="row text-right" style="padding-right: 20px;">
		                    <a href="javascript:history.back(1)" class="btn btn-primary btn-lg btn-rect">Back</a>
		                </div>
		            </div>
				</div>
				</div>
			</div>		
		</div>		
	</div>
	</div>
</section>			
			
				
