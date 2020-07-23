<section class="content">
	<div class="box box-default color-palette-box">
    	<div class="box-header with-border">
      		<h3 class="box-title"><i class="fa fa-dashboard"></i> <b>Lihat Kaizen</b></h3>
		</div>
		<div class="box-body">
			<div class="row">
				<div class="col-lg-12">
					<table class="table" style="border: 1px solid #000">
						<tbody>
							<tr>
								<td style="border-top: 1px solid #000" width="13%">Pencetus Ide</td>
								<td style="border-top: 1px solid #000" width="2%">:</td>
								<td style="border-top: 1px solid #000;border-right: 1px solid #000" width="35%"><?= $kaizen[0]['pencetus_nama'] ?><span class="pull-right">No. Induk: <?= $kaizen[0]['pencetus_noind'] ?></span></td>
								<td style="border-top: 1px solid #000" width="10%">Nomor</td>
								<td style="border-top: 1px solid #000" width="2%">:</td>
								<td style="border-top: 1px solid #000;border-right: 1px solid #000" width="38%"></td>
							</tr>
							<tr>
								<td style="border-top: 1px solid #000">Seksi</td>
								<td style="border-top: 1px solid #000">:</td>
								<td style="border-top: 1px solid #000; border-right: 1px solid #000"><?= $section_user[0]['section_name'] ?></td>
								<td style="border-right: 1px solid #000" colspan="3"></td>
							</tr>
							<tr>
								<td style="border-top: 1px solid #000">Unit</td>
								<td style="border-top: 1px solid #000">:</td>
								<td style="border-top: 1px solid #000; border-right: 1px solid #000"><?= $section_user[0]['unit_name'] ?></td>
								<td style="border-top: 1px solid #000">tembusan</td>
								<td style="border-top: 1px solid #000">:</td>
								<td style="border-top: 1px solid #000;border-right: 1px solid #000"></td>
							</tr>
							<tr>
								<td style="border-top: 1px solid #000">Departemen</td>
								<td style="border-top: 1px solid #000">:</td>
								<td style="border-top: 1px solid #000; border-right: 1px solid #000"><?= $section_user[0]['department_name'] ?></td>
								<td style="border-top: 1px solid #000;border-right: 1px solid #000" colspan="3">1. Kepala Unit</td>
							</tr>
							<tr>
								<td style="border-top: 1px solid #000">Produk/Jasa</td>
								<td style="border-top: 1px solid #000">:</td>
								<td style="border-top: 1px solid #000; border-right: 1px solid #000"><?= $kaizen[0]['judul'] ?></td>
								<td style="border-top: 1px solid #000;border-right: 1px solid #000" colspan="3">2. Tim Kaizen (Cq. Sekretaris)</td>
							</tr>
							<tr>
								<td style="border-top: 1px solid #000">Nama Komponen</td>
								<td style="border-top: 1px solid #000">:</td>
								<td style="border-top: 1px solid #000; border-right: 1px solid #000">
									<?php if($kaizen[0]['komponen']): foreach ($kaizen[0]['komponen'] as $key => $value) { ?>
										<?= '-'.$value['name'].'<br>'; ?>
									<?php } else: echo '-'; endif; ?>
								</td>
								<td style="border-top: 1px solid #000;border-right: 1px solid #000;border-left: : 1px solid #000" colspan="3">3.</td>
							</tr>
							<tr>
								<td style="border-top: 1px solid #000">Kode Komponen</td>
								<td style="border-top: 1px solid #000">:</td>
								<td style="border-top: 1px solid #000;border-right: 1px solid #000">
									<?php if($kaizen[0]['komponen']): foreach ($kaizen[0]['komponen'] as $key => $value) { ?>
									<?= '-'.$value['code'].'<br>'; ?>
									<?php } else: echo '-'; endif; ?>
								</td>
								<td style="border-top: 1px solid #000;border-right: 1px solid #000" colspan="3">4.</td>
							</tr>
							<tr>
								<td style="border-top: 1px solid #000; border-right: 1px solid #000" colspan="3" class="text-center">
									<b>Kondisi saat ini(Uraian/gambar/Sket/Foto)</b>
								</td>
								<td style="border-top: 1px solid #000;border-right: 1px solid #000" colspan="3" class="text-center">
									<b>Usulan Kaizen(Uraian/gambar/Sket/Foto)</b>
								</td>
							</tr>
							<tr>
								<td style="border-right: 1px solid #000"colspan="3"><?= $kaizen[0]['kondisi_awal'] ?></td>
								<td style="border-right: 1px solid #000;border-right: 1px solid #000"colspan="3"><?= $kaizen[0]['usulan_kaizen'] ?></td>
							</tr>
							<tr>
								<td style="border-top: 1px solid #000; border-right: 1px solid #000" colspan="3" class="text-center">
									<b>Pertimbangan Usulan Kaizen</b>
								</td>
								<td style="border-top: 1px solid #000;border-right: 1px solid #000" colspan="3" class="text-center">
									<b>Tanggal Realisasi</b>
								</td>
							</tr>
							<tr>
								<td style="border-bottom: 1px solid #000; border-right: 1px solid #000" colspan="3"><?= $kaizen[0]['pertimbangan'] ?></td>
								<td style="border-bottom: 1px solid #000; border-right: 1px solid #000" colspan="3" class="text-center">
									<?= date("d M Y", strtotime($kaizen[0]['tanggal_realisasi'])) ?>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="box box-info box-solid">
						<div class="box-header with-border">
							<label>Log Thread</label>
						</div>
						<div class="box-body">
							<div class="row">
								<div class="col-lg-12" style="overflow: auto; height: 120px;">
									<?php
										foreach ($thread as $key => $value) {
											?>
												<em>[ <?= date('d/M/Y H:i:s ', strtotime($value['thread_timestamp'])) ?> ] - <?= $value['detail'] ?> </em><br>
											<?php 
										} ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
    	</div>
    </div>
</section>
