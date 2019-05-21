<?php
	//any
?>

<div style="height:%; background:">
	<table style="border: 1px solid #000; width: 100%" border="1">
		<tr>
			<td rowspan="4"><img src="<?php echo base_url('assets/img/logo.png'); ?>" widht="50px" height="100px"></td>
			<td rowspan="4" style="text-align: center; padding: 5px"><b>LAPORAN PROGRES<br>TIM PENGHAPUSAN OTT DAN PELAKSANAAN TARGET TUNGGAL FUNGSI FABRIKASI <?php echo $thn_ott; ?></b></td>
			<td style="padding-left:5px; font-size:10px; font-weight:bold" width="10%">SEKSI</td>
			<td style="text-align: center; font-size:10px" width="20%">ALL FABRIKASI</td></tr>
		<tr>
			<td style="padding-left:5px; font-size:10px; font-weight:bold">PIC</td>
			<td style="text-align: center; font-size:10px">DAVID SL</td></tr></tr>
		<tr>
			<td style="padding-left:5px; font-size:10px; font-weight:bold">PERIODE</td>
			<td style="text-align: center; font-size:10px">JANUARI - DESEMBER <?php echo $thn_ott; ?></td></tr>
		<tr>
			<td style="padding-left:5px; font-size:10px; font-weight:bold">TGL CETAK</td>
			<td style="text-align: center; font-size:10px"><?php echo date('d-M-Y'); ?></td></tr>
	</table>
</div>
<div style="border: 1px solid #000; border-top:0; height:100%; padding:10px; background: ">

	<label>1. DATA JUMLAH KASUS PEKERJA OTT (DATA AKUNTANSI)</label>
	<div>
		<div style=" border: 1px solid grey; width:49%; float:left">
			<table class="datatable table table-striped table-bordered table-hover text-left" style="font-size:11px; width: 100%">
				<thead class="bg-primary">
					<tr>
				    	<th class="text-center text-middle" width="5%" rowspan="2">No.</th>
				        <th class="text-center" width="35%" rowspan="2">JENIS PEKERJA</th>
				        <th class="text-center" width="60%" colspan="12">BULAN</th>
					</tr>
				    <tr>
				        <th class="text-center" width="5%">JAN</th><th class="text-center" width="5%">FEB</th>
				        <th class="text-center" width="5%">MAR</th><th class="text-center" width="5%">APR</th>
				        <th class="text-center" width="5%">MEI</th><th class="text-center" width="5%">JUN</th>
				        <th class="text-center" width="5%">JUL</th><th class="text-center" width="5%">AGT</th>
				        <th class="text-center" width="5%">SEP</th><th class="text-center" width="5%">OKT</th>
				        <th class="text-center" width="5%">NOV</th><th class="text-center" width="5%">DES</th>
				    </tr>
				</thead>
				<tbody>
				    <?php
				        $no = 0;
				        foreach($ott_per_status as $ops){ 
					    	$no++;
					?>

				        <tr>
				        	<td class="text-center"><?php echo $no; ?></td>
				        	<td class="text-center"><?php echo $ops['status']; ?></td>
				        	<td class="text-center"><?php echo $ops['jan']; ?></td>
				        	<td class="text-center"><?php echo $ops['feb']; ?></td>
				        	<td class="text-center"><?php echo $ops['mar']; ?></td>
				        	<td class="text-center"><?php echo $ops['apr']; ?></td>
				        	<td class="text-center"><?php echo $ops['mei']; ?></td>
				        	<td class="text-center"><?php echo $ops['jun']; ?></td>
				        	<td class="text-center"><?php echo $ops['jul']; ?></td>
				        	<td class="text-center"><?php echo $ops['aug']; ?></td>
				        	<td class="text-center"><?php echo $ops['sep']; ?></td>
				        	<td class="text-center"><?php echo $ops['okt']; ?></td>
				        	<td class="text-center"><?php echo $ops['nov']; ?></td>
				        	<td class="text-center"><?php echo $ops['dec']; ?></td>
				        </tr>

				    <?php 
				        }
				    ?>
				</tbody>
			</table>
		</div>
		<div style="border: 1px solid grey; width:49%; float:right">
			<div style="border: 1px solid grey;">
				<img src="<?php echo $GJPO; ?>" alt="GJPO" width="100%" height="150px">
			</div>
		</div>
	</div><br>

	<label>2. PROSENTASE JUMLAH PEKERJA OTT (DATA AKUNTANSI)</label>
	<div>
		<div style=" border: 1px solid grey; width:49%; float:left">
			<table class="datatable table table-striped table-bordered table-hover text-left" style="font-size:11px; width: 100%">
				<thead class="bg-primary">
					<tr>
				    	<th class="text-center text-middle" width="5%" rowspan="2">No.</th>
				        <th class="text-center" width="35%" rowspan="2">JENIS PEKERJA</th>
				        <th class="text-center" width="60%" colspan="12">BULAN</th>
					</tr>
				    <tr>
				        <th class="text-center" width="5%">JAN</th><th class="text-center" width="5%">FEB</th>
				        <th class="text-center" width="5%">MAR</th><th class="text-center" width="5%">APR</th>
				        <th class="text-center" width="5%">MEI</th><th class="text-center" width="5%">JUN</th>
				        <th class="text-center" width="5%">JUL</th><th class="text-center" width="5%">AGT</th>
				        <th class="text-center" width="5%">SEP</th><th class="text-center" width="5%">OKT</th>
				        <th class="text-center" width="5%">NOV</th><th class="text-center" width="5%">DES</th>
				    </tr>
				</thead>
				<tbody>
				    <?php
				        $no = 0;
				        foreach($ott_per_sentase as $ops){ 
					    	$no++;
					?>

				        <tr>
				        	<td class="text-center"><?php echo $no; ?></td>
				        	<td class="text-center"><?php echo $ops['status']; ?></td>
				        	<td class="text-center"><?php echo $ops['jan']; ?></td>
				        	<td class="text-center"><?php echo $ops['feb']; ?></td>
				        	<td class="text-center"><?php echo $ops['mar']; ?></td>
				        	<td class="text-center"><?php echo $ops['apr']; ?></td>
				        	<td class="text-center"><?php echo $ops['mei']; ?></td>
				        	<td class="text-center"><?php echo $ops['jun']; ?></td>
				        	<td class="text-center"><?php echo $ops['jul']; ?></td>
				        	<td class="text-center"><?php echo $ops['aug']; ?></td>
				        	<td class="text-center"><?php echo $ops['sep']; ?></td>
				        	<td class="text-center"><?php echo $ops['okt']; ?></td>
				        	<td class="text-center"><?php echo $ops['nov']; ?></td>
				        	<td class="text-center"><?php echo $ops['dec']; ?></td>
				        </tr>

				    <?php 
				        }
				    ?>
				</tbody>
			</table>
		</div>
		<div style=" border: 1px solid grey; width:49%; float:right">
			<div style="border: 1px solid grey;">
				<img src="<?php echo $PJKO; ?>" alt="PJKO" width="100%" height="150px">
			</div>
		</div>
	</div><br>

	<label>3. JUMLAH KASUS OTT PER SEKSI</label>
	<table class="datatable table table-striped table-bordered table-hover text-left" style="font-size:11px; width: 100%">
		<thead class="bg-primary">
			<tr>
		    	<th class="text-center text-middle" width="5%" rowspan="2">No.</th>
		        <th class="text-center" width="35%" rowspan="2">JENIS PEKERJA</th>
		        <th class="text-center" width="60%" colspan="12">BULAN</th>
			</tr>
		    <tr>
		        <th class="text-center" width="5%">JAN</th><th class="text-center" width="5%">FEB</th>
		        <th class="text-center" width="5%">MAR</th><th class="text-center" width="5%">APR</th>
		        <th class="text-center" width="5%">MEI</th><th class="text-center" width="5%">JUN</th>
		        <th class="text-center" width="5%">JUL</th><th class="text-center" width="5%">AGT</th>
		        <th class="text-center" width="5%">SEP</th><th class="text-center" width="5%">OKT</th>
		        <th class="text-center" width="5%">NOV</th><th class="text-center" width="5%">DES</th>
		    </tr>
		</thead>
		<tbody>
		    <?php
		        $no = 0;
		        foreach($ott_per_seksi as $ops){ 
			    	$no++;
			?>

		        <tr>
		        	<td class="text-center"><?php echo $no; ?></td>
		        	<td class="text-center"><?php echo $ops['status']; ?></td>
		        	<td class="text-center"><?php echo $ops['jan']; ?></td>
		        	<td class="text-center"><?php echo $ops['feb']; ?></td>
		        	<td class="text-center"><?php echo $ops['mar']; ?></td>
		        	<td class="text-center"><?php echo $ops['apr']; ?></td>
		        	<td class="text-center"><?php echo $ops['mei']; ?></td>
		        	<td class="text-center"><?php echo $ops['jun']; ?></td>
		        	<td class="text-center"><?php echo $ops['jul']; ?></td>
		        	<td class="text-center"><?php echo $ops['aug']; ?></td>
		        	<td class="text-center"><?php echo $ops['sep']; ?></td>
		        	<td class="text-center"><?php echo $ops['okt']; ?></td>
		        	<td class="text-center"><?php echo $ops['nov']; ?></td>
		        	<td class="text-center"><?php echo $ops['dec']; ?></td>
		        </tr>

		    <?php 
		        }
		    ?>
		</tbody>
	</table>
	<div>
		<div style="border: 1px solid grey; width:49%; float:left">
			<img src="<?php echo $JKOPS; ?>" alt="JKOPS" width="100%" height="150px">
		</div>
		<div style="border: 1px solid grey; width:49%; float:right">
			<img src="<?php echo $JKOPS2; ?>" alt="JKOPS2" width="100%" height="150px">
		</div>
	</div><br>

	<label>4. DATA KASUS OTT</label>
	<div>
		<div style=" border: 1px solid grey; width:49%; float:left">
			<table class="datatable table table-striped table-bordered table-hover text-left" style="font-size:11px; width: 100%">
				<thead class="bg-primary">
					<tr>
				    	<th class="text-center text-middle" width="5%" rowspan="2">No.</th>
				        <th class="text-center" width="35%" rowspan="2">JENIS PEKERJA</th>
				        <th class="text-center" width="60%" colspan="12">BULAN</th>
					</tr>
				    <tr>
				        <th class="text-center" width="5%">JAN</th><th class="text-center" width="5%">FEB</th>
				        <th class="text-center" width="5%">MAR</th><th class="text-center" width="5%">APR</th>
				        <th class="text-center" width="5%">MEI</th><th class="text-center" width="5%">JUN</th>
				        <th class="text-center" width="5%">JUL</th><th class="text-center" width="5%">AGT</th>
				        <th class="text-center" width="5%">SEP</th><th class="text-center" width="5%">OKT</th>
				        <th class="text-center" width="5%">NOV</th><th class="text-center" width="5%">DES</th>
				    </tr>
				</thead>
				<tbody>
				    <?php
				        $no = 0;
				        foreach($ott_per_noind as $opn){ 
					    	$no++;
					?>

				        <tr>
				        	<td class="text-center"><?php echo $no; ?></td>
				        	<td class="text-center"><?php echo $opn['status']; ?></td>
				        	<td class="text-center"><?php echo $opn['jan']; ?></td>
				        	<td class="text-center"><?php echo $opn['feb']; ?></td>
				        	<td class="text-center"><?php echo $opn['mar']; ?></td>
				        	<td class="text-center"><?php echo $opn['apr']; ?></td>
				        	<td class="text-center"><?php echo $opn['mei']; ?></td>
				        	<td class="text-center"><?php echo $opn['jun']; ?></td>
				        	<td class="text-center"><?php echo $opn['jul']; ?></td>
				        	<td class="text-center"><?php echo $opn['aug']; ?></td>
				        	<td class="text-center"><?php echo $opn['sep']; ?></td>
				        	<td class="text-center"><?php echo $opn['okt']; ?></td>
				        	<td class="text-center"><?php echo $opn['nov']; ?></td>
				        	<td class="text-center"><?php echo $opn['dec']; ?></td>
				        </tr>

				    <?php 
				        }
				    ?>
				</tbody>
			</table>
		</div>
		<div style=" border: 1px solid grey; width:49%; float:right">
			<div style="border: 1px solid grey;">
				<img src="<?php echo $DKO; ?>" alt="DKO" width="100%" height="150px">
			</div>
		</div>
	</div><br>

</div>