<?php
	$sudah_dibayar = 0;
	$sisa_angsuran = 0;
?>

<div class="box-body">
	<h2 align="center">DATA PINJAMAN PEKERJA</h2>
	<div class="table-responsive" style="overflow:hidden;">	
		<div id="res">
			<h3>DATA PEKERJA</h3>			
			<?php
				foreach ($Employee as $Employee_item):
			?>
			<table>
				<tbody>					
					<tr>
						<td class='c_rincian_hutang_a'>No. Induk</td>
						<td class='c_rincian_hutang_space'>:</td>
						<td><?php echo $Employee_item['noind'] ?></td>
					</tr>
					<tr>
						<td class='c_rincian_hutang_a'>Nama</td>
						<td class='c_rincian_hutang_space'>:</td>
						<td><?php echo strtoupper($Employee_item['nama']) ?></td>
					</tr>
					<tr>
						<td class='c_rincian_hutang_a'>Status Kerja</td>
						<td class='c_rincian_hutang_space'>:</td>
						<td><?php echo $Employee_item['kd_status_kerja'] ?></td>
					</tr>
					<tr>
						<td class='c_rincian_hutang_a'>Jabatan</td>
						<td class='c_rincian_hutang_space'>:</td>
						<td><?php echo $Employee_item['jabatan'] ?></td>
					</tr>
					<tr>
						<td class='c_rincian_hutang_a'>Seksi</td>
						<td class='c_rincian_hutang_space'>:</td>
						<td><?php echo $Employee_item['seksi'] ?></td>
					</tr>				
				</tbody>
			</table>			
			<?php endforeach ?>
			<hr class="hl_rincian_hutang" />
			<h3>DATA PINJAMAN</h3>			
			<?php 
				foreach ($Loan as $Loan_item) :
			?>
			<table>
				<tbody>
					<tr>
						<td class='c_rincian_hutang_a'>No. Pinjaman</td>
						<td class='c_rincian_hutang_space'>:</td>
						<td><?php echo $Loan_item['no_hutang'] ?></td>
					</tr>
					<tr>
						<td class='c_rincian_hutang_a'>Tgl. Pengajuan</td>
						<td class='c_rincian_hutang_space'>:</td>
						<td><?php echo $Loan_item['tgl_pengajuan'] ?></td>
					</tr>
					<tr>
						<td class='c_rincian_hutang_a'>Total Pinjaman</td>
						<td class='c_rincian_hutang_space'>:</td>
						<td><?php echo 'Rp. '.number_format($Loan_item['total_hutang'],0,",","."); $sisa_angsuran = $Loan_item['total_hutang'] ?></td>
					</tr>
					<tr>
						<td class='c_rincian_hutang_a'>Jumlah Cicilan</td>
						<td class='c_rincian_hutang_space'>:</td>
						<td><?php echo $Loan_item['jml_cicilan'] ?></td>
					</tr>
					<tr>
						<td class='c_rincian_hutang_a'>Status Lunas</td>
						<td class='c_rincian_hutang_space'>:</td>
						<td>
							<?php if ($Loan_item['status_lunas'] == '1')
								{
									echo "Lunas";
								}
								else
								{
									echo "Belum Lunas";
								}
							?>
						</td>
					</tr>
				</tbody>
			</table>
		<?php endforeach ?>
			<hr class="hl_rincian_hutang" />
			<h3>RINCIAN ANGSURAN</h3>			
			<table class='t_rincian_hutang'>
				<thead>
					<tr>
						<th>PERIODE</th>
						<th>TGL. PEMBAYARAN</th>
						<th id='cicilan'>CICILAN</th>
						<th>STATUS</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$num = 0;
						foreach ($Payment as $Payment_item):
							$num++;
					?>
					<tr>
						<td><?php echo $num ?></td>
						<td><?php echo $Payment_item['tgl_transaksi'] ?></td>
						<td><?php echo 'Rp. '.number_format($Payment_item['jumlah_transaksi'],0,",",".") ?></td>						
						<td>
							<?php if ($Payment_item['lunas'] == '1')
								{
									$sudah_dibayar += $Payment_item['jumlah_transaksi'];
									$sisa_angsuran -= $Payment_item['jumlah_transaksi'];
									echo 'Sudah dibayar';
								}
								else
								{
									echo 'Belum dibayar';
								}
							?>
						</td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			<table>
				<p></p>
				<tr>
					<td class='c_rincian_hutang_b'>Angsuran sudah dibayar</td>
					<td class='c_rincian_hutang_space'>:</td>
					<td><?php echo 'Rp. '.number_format($sudah_dibayar,0,",",".") ?></td>
				</tr>
				<tr>
					<td class='c_rincian_hutang_b'>Sisa angsuran</td>
					<td class='c_rincian_hutang_space'>:</td>
					<td><?php echo 'Rp. '.number_format($sisa_angsuran,0,",",".") ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>