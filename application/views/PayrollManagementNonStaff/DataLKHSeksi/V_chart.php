<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
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
                                <h3 class="box-title"><?= $Title ?></h3>
                            </div>
                            <div class="box-body">
                                <form class="form-horizontal" method="post" action="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/show_chart/');?>" enctype="multipart/form-data">
                                    <div class="form-group">
                                    	<label class="col-lg-4 control-label">
                                            Pilih Periode
                                        </label>
                                        <div class="col-lg-2">
                                            <input type="text" name="txtTahun" class="form-control" placeholder="Tahun">
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="submit" class="btn btn-primary btn-block" style="float: right;">Proses</button>
                                        </div>
                                    </div>
                                </form>

                                <?php if(!empty($data_kasus_ott)){ ?>

                                <hr>
                                <label>1. DATA JUMLAH KASUS PEKERJA OTT (DATA AKUNTANSI)</label>
                                <div class="row">
                                	<div class="col-md-6">
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
		                        	<div class="col-md-6">
		                                <div class="box box-info">
								            <div class="box-body chart-responsive">
								              <div class="chart" id="GJPO" style="height: 200px;"></div>
								            </div>
								    	</div>

								    </div>
								</div><br>

								<label>2. PROSENTASE JUMLAH PEKERJA OTT (DATA AKUNTANSI)</label>
                                <div class="row">
                                	<div class="col-md-6">
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
		                        	<div class="col-md-6">
		                                <div class="box box-info">
								            <div class="box-body chart-responsive">
								              <div class="chart" id="PJKO" style="height: 200px;"></div>
								            </div>
								    	</div>

									</div>
								</div><br>

								<label>3. JUMLAH KASUS OTT PER SEKSI</label>
                                <div class="row">
                                	<div class="col-md-6">
		                                <table class="datatable table table-striped table-bordered table-hover text-left" style="font-size:11px; width: 100%">
		                                	<thead class="bg-primary">
		                                		<tr>
		                                			<th class="text-center text-middle" width="5%" rowspan="2">No.</th>
		                                			<th class="text-center" width="35%" rowspan="2">SEKSI</th>
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

		                        	</div>
		                        	<div class="col-md-6">
		                                <div class="box box-info">
								            <div class="box-body chart-responsive">
								              <div class="chart" id="JKOPS" style="height: 200px;"></div>
								            </div>
								    	</div>
								    	
									</div>
								</div><br>
								<div class="row">
									<div class="col-md-12">
										<div class="box box-info">
								            <div class="box-body chart-responsive">
								              <div class="chart" id="JKOPS2" style="height: 200px;"></div>
								            </div>
								    	</div>

									</div>
								</div>

								<label>4. DATA KASUS OTT</label>
                                <div class="row">
                                	<div class="col-md-6">
		                                <table class="datatable table table-striped table-bordered table-hover text-left" style="font-size:11px; width: 100%">
		                                	<thead class="bg-primary">
		                                		<tr>
		                                			<th class="text-center text-middle" width="5%" rowspan="2">No.</th>
		                                			<th class="text-center" width="35%" rowspan="2">SEKSI</th>
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
		                        	<div class="col-md-6">
		                                <div class="box box-info">
								            <div class="box-body chart-responsive">
								              <div class="chart" id="DKO" style="height: 200px;"></div>
								            </div>
								    	</div>
								    	
									</div>
								</div><br>

								<div class="row">
									<div class="col-md-4"></div>
									<div class="col-md-2">
										<button type="button" id="btn_cek_OTT_pdf" class="btn btn-primary btn-block" style="float: right;">Cek</button>
									</div>
									<div class="col-md-2">
										<form action="<?php echo site_url('PayrollManagementNonStaff/ProsesGaji/DataLKHSeksi/download_pfd/') ?>" method="post" id="frm_ott_pdf" target="blank_">
											<input type="text" name="txtTahun2" value="<?php echo $thn_ott; ?>" hidden>

											<textarea name="GJPO" id="grapic_1" hidden></textarea>
											<textarea name="PJKO" id="grapic_2" hidden></textarea>
											<textarea name="JKOPS" id="grapic_3" hidden></textarea>
											<textarea name="JKOPS2" id="grapic_4" hidden></textarea>
											<textarea name="DKO" id="grapic_5" hidden></textarea>

											<button type="submit" id="btn_prt_OTT_pdf" class="btn btn-primary btn-block" style="float: right;" disabled>Print</button>
										</form>
                                    </div>
                                </div>

								<?php } ?>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>    
        </div>
    </div>
</section>

<script>
  $(function () {
    "use strict";

    $('#GJPO').highcharts({
        title: {
	        text: 'GRAFIK JUMLAH PEKERJA OTT'
	    },
	    yAxis: {
	        title: {
	            text: 'Jumlah Kasus'
	        }
	    },
	    xAxis: {
            categories: ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES'],
            crosshair: true},
	    legend: {
	        layout: 'vertical',
	        align: 'right',
	        verticalAlign: 'middle'
	    },
	    credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true,
					 style:{"fontSize": "12px"},
					format: '{point.y:,.0f}'}}},
        series: <?php echo "[$grp_per_status]"; ?>
    });

    $('#PJKO').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '% PEKERJA OTT'
        },
        xAxis: {
            categories: ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES'],
            crosshair: true
        },
        yAxis: {
	        title: {
	            text: '% Pekerja Ott'
	        }
	    },
        tooltip: {
            valueSuffix: '%'
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0},
			series: {
                groupPadding: 0},
			column: {
                dataLabels: {
                    enabled: true,
					rotation: 270,
                    y: -20,
					 style:{"fontSize": "8px"},
					formatter: function () {
						return Highcharts.numberFormat(this.y,1)+'%';
					}}}},
		credits: {
            enabled: false
        },
        series:  <?php echo"[$grp_per_sentase]"; ?>
    });

    $('#JKOPS').highcharts({
        title: {
	        text: 'OTT PER SEKSI'
	    },
	    yAxis: {
	        title: {
	            text: 'Jumlah Kasus'
	        }
	    },
	    xAxis: {
            categories: ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES'],
            crosshair: true},
	    legend: {
	        layout: 'vertical',
	        align: 'right',
	        verticalAlign: 'middle'
	    },
	    credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true,
					 style:{"fontSize": "12px"},
					format: '{point.y:,.0f}'}}},
        series: <?php echo "[$grp_per_seksi]"; ?>
    });

    $('#JKOPS2').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'GRAFIK JUMLAH KASUS OTT PERBULAN PER SEKSI FABRIKASI'
        },
        xAxis: {
            categories: ['SHEET METAL','MACH A','MACH B','MACH C','MACH D','PERAKITAN A','PERAKITAN B','PERAKITAN C','P & P','FOUNDRY'],
            crosshair: true
        },
        yAxis: {
	        title: {
	            text: 'Jumlah Kasus Ott'
	        }
	    },
        tooltip: {
            valueSuffix: ''
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0},
			series: {
                groupPadding: 0},
			column: {
                dataLabels: {
                    enabled: false
                    }}},
        credits: {
            enabled: false
        },
        legend: {
	        enabled: false
	    },
        series:  <?php echo"[$grp_per_seksi2]"; ?>
    });

    $('#DKO').highcharts({
        title: {
	        text: 'DATA KASUS OTT'
	    },
	    yAxis: {
	        title: {
	            text: 'Jumlah Kasus'
	        }
	    },
	    xAxis: {
            categories: ['JAN','FEB','MAR','APR','MEI','JUN','JUL','AGS','SEP','OKT','NOV','DES'],
            crosshair: true},
	    legend: {
	        layout: 'vertical',
	        align: 'right',
	        verticalAlign: 'middle'
	    },
	    credits: {
            enabled: false
        },
        exporting: {
            enabled: false
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true,
					 style:{"fontSize": "12px"},
					format: '{point.y:,.0f}'}}},
        series: <?php echo "[$grp_per_noind]"; ?>
    });

  });
</script>
