							<table class="table table-bordered table-striped table-condensed" id="wr-rekapbon">
								<thead class="bg-blue">
									<tr>
										<th class="text-center">No</th>
										<th class="text-center">No Induk</th>
										<th class="text-center">Nama</th>
										<th class="text-center">Seksi</th>
										<th class="text-center">Akhir Kontrak</th>
										<th class="text-center">Tanggal Keluar</th>
										<th class="text-center" style="width: 13%">Jumlah Invoice</th>
										<th class="text-center" style="width: 13%">Jumlah Yang Belum Terbayar</th>
										<th class="text-center">Deskripsi</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($bon as $key => $bon_data): ?>
									<tr>
										<td><?php echo $key+1; ?></td>
										<td><?php echo $bon_data['NOIND']; ?></td>
										<td><?php echo $bon_data['NAMA']; ?></td>
										<td><?php echo $bon_data['SEKSI']; ?></td>
										<td><?php echo  date('d-M-Y', strtotime($bon_data['AKHKONTRAK'])); ?></td>
										<td><?php echo  date('d-M-Y', strtotime($bon_data['TGLKELUAR'])); ?></td>
										<td><span class="pull-right"><?php echo number_format($bon_data['AMOUNT_IDR'], 2, ',', '.'); ?></span></td>
										<td style="background-color: #FEF8B5;"><span class="pull-right"><?php echo number_format($bon_data['SALDO_PREPAYMENT'], 2, ',', '.'); ?></span></td>
										<td><?php echo $bon_data['DESCRIPTION']; ?></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>