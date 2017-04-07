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
						<td class='spcfield1'>No. Induk</td>
						<td class='spcsc'>:</td>
						<td><?php echo $Employee_item['noind'] ?></td>
					</tr>
					<tr>
						<td class='spcfield1'>Nama</td>
						<td class='spcsc'>:</td>
						<td><?php echo strtoupper($Employee_item['nama']) ?></td>
					</tr>
					<tr>
						<td class='spcfield1'>Status Kerja</td>
						<td class='spcsc'>:</td>
						<td><?php echo $Employee_item['kd_status_kerja'] ?></td>
					</tr>
					<tr>
						<td class='spcfield1'>Jabatan</td>
						<td class='spcsc'>:</td>
						<td><?php echo $Employee_item['jabatan'] ?></td>
					</tr>
					<tr>
						<td class='spcfield1'>Seksi</td>
						<td class='spcsc'>:</td>
						<td><?php echo $Employee_item['seksi'] ?></td>
					</tr>				
				</tbody>
			</table>			
			<?php endforeach ?>
			<hr class="full" />
			<h3>DATA PINJAMAN</h3>			
			<?php 
				foreach ($Loan as $Loan_item) :
			?>
			<table>
				<tbody>
					<tr>
						<td class='spcfield1'>No. Pinjaman</td>
						<td class='spcsc'>:</td>
						<td><?php echo $Loan_item['no_hutang'] ?></td>
					</tr>
					<tr>
						<td class='spcfield1'>Tgl. Pengajuan</td>
						<td class='spcsc'>:</td>
						<td><?php echo $Loan_item['tgl_pengajuan'] ?></td>
					</tr>
					<tr>
						<td class='spcfield1'>Total Pinjaman</td>
						<td class='spcsc'>:</td>
						<td><?php echo $Loan_item['total_hutang']; $sisa_angsuran = $Loan_item['total_hutang'] ?></td>
					</tr>
					<tr>
						<td class='spcfield1'>Jumlah Cicilan</td>
						<td class='spcsc'>:</td>
						<td><?php echo $Loan_item['jml_cicilan'] ?></td>
					</tr>
					<tr>
						<td class='spcfield1'>Status Lunas</td>
						<td class='spcsc'>:</td>
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
			<hr class="full" />
			<h3>RINCIAN ANGSURAN</h3>			
			<table class='spct'>
				<thead>
					<tr>
						<th class='spcth'>PERIODE</th>
						<th class='spcth'>TANGGAL PEMBAYARAN</th>
						<th class='spcth'>CICILAN</th>
						<th class='spcth'>STATUS</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$num = 0;
						foreach ($Payment as $Payment_item):
							$num++;
					?>
					<tr>
						<td align='center'><?php echo $num ?></td>
						<td align='center'><?php echo $Payment_item['tgl_transaksi'] ?></td>
						<td align='center'><?php echo 'Rp. '.$Payment_item['jumlah_transaksi'] ?></td>						
						<td align='center' >
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
					<td class='spcfield2'>Angsuran sudah dibayar</td>
					<td class='spcsc'>:</td>
					<td><?php echo $sudah_dibayar ?></td>
				</tr>
				<tr>
					<td class='spcfield2'>Sisa angsuran</td>
					<td class='spcsc'>:</td>
					<td><?php echo $sisa_angsuran ?></td>
				</tr>
			</table>
		</div>
	</div>
</div>