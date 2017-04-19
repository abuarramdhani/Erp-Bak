<div class="box-body">
	<h3 align="center">SUMMARY KOMPONEN GAJI STAF PER DEPARTEMEN</h3>
	<p align="center">PERIODE: <?php echo date('F',mktime(0,0,0,$month,10))." - ".$year ?></p>
	<p align="left">Tanggal Cetak: <?php echo date("d/m/Y") ?></p>
	<div class="table-responsive" style="overflow:hidden;">	
		<div id="res">		
			<table class="t_summary_dept">
				<thead>
					<tr>
						<th>KOMPONEN</th>
						<th>KEUANGAN</th>
						<th>PEMASARAN</th>
						<th>PRODUKSI</th>
						<th>PERSONALIA</th>
						<th>TOTAL</th>
					</tr>
				</thead>
				<tbody>
					<?php $no = 1; 
					if(!empty($summary)){
						$num_components = count($summary);
						for ($i = 0; $i < $num_components; $i++)
						{?>
							<tr>
							<?php 
							for ($j = 0; $j < 6; $j++)
							{	
								if ($i < $num_components - 1) 
								{
									if ($j == 0)
									{
										echo "<td align='left'>".$summary[$i][$j]."</td>";
									} else
									{
										echo "<td align='center'>Rp. ".number_format($summary[$i][$j],2,",",".")."</td>";
									}
								} else
								{
									if ($j == 0)
									{
										echo "<td id='total'>".$summary[$i][$j]."</td>";
									} else
									{
										echo "<td id='total' align='center'>Rp. ".number_format($summary[$i][$j],2,",",".")."</td>";
									}
								}								
							}
							?>
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