<section class="content">
	<div class="inner">
	<div class="box box-info">
	<div style="padding-top: 10px">
		<div class="box-header with-border">
			<div class="pull-left">
				<h4><b>Laporan Realisasi Morning Greeting</b></h4>
				<?php foreach($branch as $branch_item){ ?>
					<h5><?php echo $branch_item['org_name']; ?></h5>
				<?php } ?>
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
	    					<form action="<?php echo base_url('MorningGreeting/report/showByBranch/download/pdf'); ?>" method="post">
		    					<?php foreach($branch as $branch_item){ ?>
									<input type="hidden" name="org_id" value="<?php echo $branch_item['org_id']; ?>"></input>
								<?php } ?>
								<input type="hidden" name="range" value="<?php echo $range; ?>"></input>
	  							<button type="submit" class="btn btn-default">Export to PDF</button>
	  						</form>
	  					</li>
	 				   <li>
	 				   	<form action="<?php echo base_url('MorningGreeting/report/showByBranch/download/csv'); ?>" method="post">
	 				   		<?php foreach($branch as $branch_item){ ?>
									<input type="hidden" name="org_id" value="<?php echo $branch_item['org_id']; ?>"></input>
								<?php } ?>
								<input type="hidden" name="range" value="<?php echo $range; ?>"></input>
		  						<button type="submit" class="btn btn-default">Export to CSV</button>
	  						</form>
	 				   </li>
	    				<li>
	    					<form action="<?php echo base_url('MorningGreeting/report/showByBranch/download/xml'); ?>" method="post">
	    						<?php foreach($branch as $branch_item){ ?>
									<input type="hidden" name="org_id" value="<?php echo $branch_item['org_id']; ?>"></input>
								<?php } ?>
								<input type="hidden" name="range" value="<?php echo $range; ?>"></input>
				  				<button type="submit" class="btn btn-default">Export to XML</button>
				  			</form>
	    				</li>
	  				</ul>
				</div>
				</div>
			</div>

		</div>
		<div class="box-body">
				<table id="reportBranchTable" class="table table-striped table-bordered table-responsive table-hover">
					<thead style="background:#22aadd; color:#FFFFFF;">
						<tr>
							<th rowspan="2" style="width:5%; text-align:center;">No</th>
							<th rowspan="2" style="width:35%; text-align:center;">Hari, Tanggal</th>
							<th colspan="2" style="text-align:center;">Tingkat Pelaksanaan (Realisasi / Jadwal)</th>
							<th style="text-align:center;">Prosentase</th>
						</tr>
						<tr>
							<th style="text-align:center;">R</th>
							<th style="text-align:center;">P</th>
							<th style="text-align:center;">%</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=1; foreach($data as $data_item){ ?>
						<tr>
							<td><?php echo $no++; ?></td>
							<td><?php echo $data_item['calldate'];?></td>
							<td><?php echo $data_item['r'];?></td>
							<td><?php echo $data_item['p'];?></td>
							<td><?php echo $prsn=($data_item['r']/$data_item['p'])*100; ?>%</td>
						</tr>
					<?php } ?>
					</tbody>
				<thead style="background:#79BFD9; color:#FFFFFF;">
					<tr>
						<th colspan="3">RATA - RATA PELAKSANAAN</th>
						<th></th>
						<th style="text-align:center;">100%</th>
					</tr>
				</thead>
				</table>
		</div>
		<div class="box box-info"></div>
	</div>
	</div>
	</div>
</section>
