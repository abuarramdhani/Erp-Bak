<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div style="padding-top: 10px">
		<div class="box-header with-border">
			<div class="pull-left">
				<h4><b>Laporan Realisasi Morning Greeting</b></h4>
				<h5>KSH GROUP</h5>
				<h5><?php echo $range; ?> ( Otomatis Hilangkan Hari Libur )</h5>
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
	    					<form action="<?php echo base_url('MorningGreeting/report/showAll/download/pdf'); ?>" method="post">
		    					<input type="hidden" name="range" value="<?php echo $range; ?>"></input>
								<button type="submit" class="btn btn-default">Export to PDF</button>
	  						</form>
	  					</li>
	 				   <li>
	 				   	<form action="<?php echo base_url('MorningGreeting/report/showAll/download/csv'); ?>" method="post">
								<input type="hidden" name="range" value="<?php echo $range; ?>"></input>
		  						<button type="submit" class="btn btn-default">Export to CSV</button>
	  						</form>
	 				   </li>
	    				<li>
	    					<form action="<?php echo base_url('MorningGreeting/report/showAll/download/xml'); ?>" method="post">
								<input type="hidden" name="range" value="<?php echo $range; ?>"></input>
				  				<button type="submit" class="btn btn-default">Export to XML</button>
				  			</form>
	    				</li>
	  				</ul>
				</div>
				</div>
			</div>
		</div>
		<div class="box-body" style="padding-top:50px;">
			<div style="overflow:auto;">
				<table id="reportShowAllTable" class="table table-striped table-bordered table-responsive table-hover" style="width:auto;">
					<thead style="background:#22aadd; color:#FFFFFF;">
						<tr>
							<th rowspan="3" style="text-align:center;">No</th>
							<th rowspan="3" style="text-align:center;">Hari, Tanggal</th>
						<?php foreach($data_branch as $branch){ ?> 
							<th colspan="3" style="text-align:center;"><?php echo $branch['org_name'] ?></th>
						<?php } ?>
						</tr>
						<tr>
						<?php foreach($data_branch as $branch){ ?>
							<th colspan="2" style="text-align:center;">Tingkat Pelaksanaan (Realisasi / Jadwal)</th>
							<th style="text-align:center;">Prosentase</th>
						<?php } ?>
						</tr>
						<tr>
						<?php foreach($data_branch as $branch){ ?>
							<th style="text-align:center;">R</th>
							<th style="text-align:center;">P</th>
							<th style="text-align:center;">%</th>
						<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach($data as $data_item){ ?>
						<tr>
							<td><?php echo $no++; ?></td>
							<td><?php echo $data_item['calldate'];?></td>
							<?php foreach($data_branch as $branch){ ?>
								<td style="text-align:center;"><?php echo $data_item['r'];?></td>
								<td style="text-align:center;"><?php echo $data_item['p'];?></td>
								<td style="text-align:center;">
									<?php echo $prsn=($data_item['r']/$data_item['p'])*100; ?>%
								</td>
							<?php } ?>
						</tr>
					<?php } ?>
					</tbody>
					<thead>
						<tr>
							<th></th>
							<th>RATA - RATA PELAKSANAAN</th>
							<?php foreach($data_branch as $branch){ ?>
								<th></th>
								<th></th>
								<th style="text-align:center;">80.92%</th>
							<?php } ?>
						</tr>
					</thead>
				</table>
			</div>
		</div>
		<div class="box box-info"></div>
	</div>
	</div>
	</div>
</section>
