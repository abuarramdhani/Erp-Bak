<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div style="padding-top: 10px">
		<div class="box-header with-border">
			<div class="pull-left">
				<h4><b>Laporan Realisasi Morning Greeting</b></h4>
				<?php foreach($branch as $branch_item){ ?>
					<h5>Relasi <?php echo $branch_item['org_name']; ?></h5>
				<?php } ?>
				<h5>
					<?php if($month == 'JANUARI'){
								echo '01 - 31';
							}
							else if($month == 'FEBRUARI'){
								echo '01 - 28';
							}
							else if($month == 'MARET'){
								echo '01 - 31';
							}
							else if($month== 'APRIL'){
								echo '01 - 30';
							}
							else if($month == 'MEI'){
								echo '01 - 31';
							}
							else if($month == 'JUNI'){
								echo '01 - 30';
							}
							else if($month == 'JULI'){
								echo '01 - 31';
							}
							else if($month == 'AGUSTUS'){
								echo '01 - 31';
							}
							else if($month == 'SEPTEMBER'){
								echo '01 - 30';
							}
							else if($month == 'OKTOBER'){
								echo '01 - 31';
							}
							else if($month == 'NOVEMBER'){
								echo '01 - 30';
							}
							else echo '01 - 31';?> <?php echo $month;?> <?php $now=date('Y'); echo $now; ?>
					</h5>
			</div>
			
			<div class="input-group">
				<div class="input-group-btn">
					<div class="btn-group pull-right">
	  						<button type="button" class="btn btn-default">Export to ..</button>
	  						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	    						<span class="caret"></span>
	    						<span class="sr-only">Toggle Dropdown</span>
	  						</button>
	  				<ul class="dropdown-menu">
	    				<li>
	    					<form action="<?php echo base_url('MorningGreeting/report/showByRelation/download/pdf'); ?>" method="post">
		    					<?php foreach($branch as $branch_item){ ?>
									<input type="hidden" name="org_id" value="<?php echo $branch_item['org_id']; ?>"></input>
								<?php } ?>
	  							<button type="submit" class="btn btn-default">Export to PDF</button>
	  						</form>
	  					</li>
	 				   <li>
	 				   	<form action="<?php echo base_url('MorningGreeting/report/showByRelation/download/csv'); ?>" method="post">
	 				   		<?php foreach($branch as $branch_item){ ?>
									<input type="hidden" name="org_id" value="<?php echo $branch_item['org_id']; ?>"></input>
								<?php } ?>
		  						<button type="submit" class="btn btn-default">Export to CSV</button>
	  						</form>
	 				   </li>
	    				<li>
	    					<form action="<?php echo base_url('MorningGreeting/report/showByRelation/download/xml'); ?>" method="post">
	    						<?php foreach($branch as $branch_item){ ?>
									<input type="hidden" name="org_id" value="<?php echo $branch_item['org_id']; ?>"></input>
								<?php } ?>
				  				<button type="submit" class="btn btn-default">Export to XML</button>
				  			</form>
	    				</li>
	  				</ul>
				</div>
				</div>
			</div>
		</div>
		<div class="box-body" style="padding-top:50px;">
				<table id="reportRelationTable" style="width:100%;" class="table table-striped table-bordered table-responsive table-hover ">
					<thead style="background:#22aadd; color:#FFFFFF;">
						<tr>
							<th rowspan="2" style="width:5%;text-align:center;">No</th>
							<th rowspan="2" style="width:10%;text-align:center;">Cust. ID</th>
							<th rowspan="2" style="width:30%;text-align:center;">Relasi</th>
							<th rowspan="2" style="width:20%;text-align:center;">Kota</th>
							<th colspan="5" style="text-align:center;">Minggu</th>
							<th rowspan="2" style="text-align:center;">Presentase ( 100% jika 4x )</th>
						</tr>
						<tr>
							<th style="width:3%;">1</th>
							<th style="width:3%;">2</th>
							<th style="width:3%;">3</th>
							<th style="width:3%;">4</th>
							<th style="width:3%;">5</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach($data as $data_item){ ?>
						<tr>
							<td style="text-align:center;"><?php echo $no++; ?></td>
							<td style="text-align:center;"><?php echo $data_item['oracle_cust_id'];?></td>
							<td><?php echo $data_item['relation_name'];?></td>
							<td style="text-align:center;"><?php echo $data_item['regency_name'];?></td>
							<td>1</td>
							<td>1</td>
							<td>1</td>
							<td>1</td>
							<td>1</td>
							<td>100%</td>
						</tr>
					<?php } ?>
					</tbody>
				<thead style="background:#79BFD9; color:#FFFFFF;">
					<tr>
						<th colspan="9">RATA - RATA PELAKSANAAN</th>
						<th>100%</th>
					</tr>
				</thead>
				</table>
		</div>
		<div class="box box-info"></div>
	</div>
	</div>
	</div>
</section>