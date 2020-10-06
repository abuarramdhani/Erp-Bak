<?php 
  	$bulan = array(
  		'01' => 'Januari',
		'02' => 'Februari',
		'03' => 'Maret',
		'04' => 'April',
		'05' => 'Mei',
		'06' => 'Juni',
		'07' => 'Juli',
		'08' => 'Agustus',
		'09' => 'September',
		'10' => 'Oktober',
		'11' => 'November',
		'12' => 'Desember' 
	);
?>
<div class="box-body box-report">
  	<div class="table-responsive">
	 	<table class="table" style="border: 1px solid #000; padding-bottom: 6px; margin-bottom: 6px">
			<tbody>
			  	<tr>
				 	<td style="border-top: 1px solid #000; border-right: 1px solid #000" class="text-center" width="10%" rowspan="4"><img src="<?php echo base_url('assets/img/logo.png'); ?>" style="max-width: 55px; height: auto; width: 55px" /></td>
				 	<td style="border-top: 1px solid #000; border-right: 1px solid #000; font-weight: bold;" class="text-center" width="40%" rowspan="4"><h3>LAPORAN KAIZEN</h3></td>
				 	<td style="border-top: 1px solid #000; border-right: 1px solid #000" width="25%">&#9744; Desain</td>
				 	<td style="border-top: 1px solid #000" width="25%">&#9744; Pembelian</td>
			  	</tr>
			  	<tr>
				 	<td style="border-top: 1px solid #000; border-right: 1px solid #000">&#9744; Penurunan Reject</td>
				 	<td style="border-top: 1px solid #000">&#9746; Akuntansi</td>
			  	</tr>
			  	<tr>
				 	<td style="border-top: 1px solid #000; border-right: 1px solid #000">&#9744; Efisiensi Produksi</td>
				 	<td style="border-top: 1px solid #000">&#9744; Pemasaran</td>
			  	</tr>
			  	<tr>
					<td style="border-top: 1px solid #000; border-right: 1px solid #000">&#9744; Dept. Personalia</td>
					<td style="border-top: 1px solid #000">&#9744; Keuangan</td>
			  	</tr>
			</tbody>
	 	</table>
	 	<table class="table" style="border: 1px solid #000; border-bottom: none; padding-bottom: 0; margin-bottom: 0;">
			<tbody>
				<tr>
					<td style="border-top: 1px solid #000; font-weight: bold;" width="15%">Pencetus Ide</td>
					<td style="border-top: 1px solid #000; font-weight: bold;" width="2%">:</td>
					<td style="border-top: 1px solid #000; font-weight: bold;; border-right: 1px solid #000" width="33%"><?= $kaizen[0]['pencetus_nama'] ?><div class="text-right">No. Induk: <?= $kaizen[0]['pencetus_noind'] ?></div></td>
					<td style="border-top: 1px solid #000; font-weight: bold;" width="11%">Nomor</td>
					<td style="border-top: 1px solid #000; font-weight: bold;" width="2%">:</td>
					<td style="border-top: 1px solid #000; font-size: 14px; font-weight: bold;" width="37%" rowspan="2"><center><b><?= $kaizen[0]['no_kaizen'] ?></b></center></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #000; font-weight: bold;">Seksi</td>
					<td style="border-top: 1px solid #000; font-weight: bold;">:</td>
					<td style="border-top: 1px solid #000; font-weight: bold;; border-right: 1px solid #000"><?= $section_user[0]['section_name'] ?></td>
					<td style="border: none" colspan="3"></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #000; font-weight: bold;">Unit</td>
					<td style="border-top: 1px solid #000; font-weight: bold;">:</td>
					<td style="border-top: 1px solid #000; font-weight: bold;; border-right: 1px solid #000"><?= $section_user[0]['unit_name'] ?></td>
					<td style="border-top: 1px solid #000; font-weight: bold;">tembusan</td>
					<td style="border-top: 1px solid #000; font-weight: bold;">:</td>
					<td style="border-top: 1px solid #000; font-weight: bold;"></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #000; font-weight: bold;">Departemen</td>
					<td style="border-top: 1px solid #000; font-weight: bold;">:</td>
					<td style="border-top: 1px solid #000; font-weight: bold;; border-right: 1px solid #000"><?= $section_user[0]['department_name'] ?></td>
					<td style="border-top: 1px solid #000; font-weight: bold;" colspan="3">1. Kepala Unit</td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #000; font-weight: bold;">Produk/Jasa</td>
					<td style="border-top: 1px solid #000; font-weight: bold;">:</td>
					<td style="border-top: 1px solid #000; font-weight: bold;; border-right: 1px solid #000"><?= $kaizen[0]['judul'] ?></td>
					<td style="border-top: 1px solid #000; font-weight: bold;" colspan="3">2. Tim Kaizen (Cq. Sekretaris)</td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #000">Nama Komponen</td>
					<td style="border-top: 1px solid #000">:</td>
					<td style="border-top: 1px solid #000; border-right: 1px solid #000">
					<?php if($kaizen[0]['komponen']): foreach ($kaizen[0]['komponen'] as $key => $value) { ?>
					<?= '-'.$value['name'].'<br>'; ?>
					<?php } else: echo '-'; endif; ?>
					</td>
					<td style="border-top: 1px solid #000" colspan="3">3.</td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #000">Kode Komponen</td>
					<td style="border-top: 1px solid #000">:</td>
					<td style="border-top: 1px solid #000; border-right: 1px solid #000">
					<?php if($kaizen[0]['komponen']): foreach ($kaizen[0]['komponen'] as $key => $value) { ?>
					<?= '-'.$value['code'].'<br>'; ?>
					<?php } else: echo '-'; endif; ?>
					</td>
					<td style="border-top: 1px solid #000" colspan="3">4.</td>
				</tr>
				<tr>
					<td style="max-height: 50px ;border-top: 1px solid #000; font-weight: bold;; border-right: 1px solid #000" colspan="3" class="text-center">Kondisi saat ini(Uraian / Gambar / Sket / Foto)</td>
					<td style="max-height: 50px ;border-top: 1px solid #000; font-weight: bold;" colspan="3" class="text-center">Usulan kaizen(Uraian / Gambar / Sket / Foto)</td>
				</tr>
				<tr>
					<td style="border-right: 1px solid #000; vertical-align: top; text-align: justify ; max-height:200px" colspan="3"  ><?= $kaizen[0]['kondisi_awal'] ?></td>
					<td style="border-right: 1px solid #000; vertical-align: top; text-align: justify ; max-height:200px" colspan="3"  ><?= $kaizen[0]['usulan_kaizen'] ?></td>
				</tr>
			</tbody>
		</table>
		<table class="table" style="border: 1px solid #000; padding-top: 0; margin-top: 0; margin-bottom: 0; border-bottom: 0px">
			<tbody>
				<tr>
					<td style="border-top: none; font-weight: bold;; border-right: 1px solid #000" colspan="4">Pertimbangan Usulan Kaizen</td>
				</tr>
				<tr>
					<td style="border-top: none; border-right: 1px solid #000; vertical-align: top; text-align: justify" colspan="4" rowspan="1"><?= $kaizen[0]['pertimbangan'] ?></td>
				</tr>
				<tr>
					<td style="border-top: 1px solid #000; font-weight: bold; border-right: 1px solid #000" colspan="4" class="text-center">Persetujuan</td>
				</tr>
			</tbody>
		</table>
	  	<table class="table" style="border: 1px solid #000; padding-top: 0; margin-top: 0; margin-bottom: 0; border-bottom: 0px">
			<tbody>
				<tr>
					<td style="font-weight: bold; border-right: 1px solid #000; padding-top: 5px;width: 25%" class="text-center">
						Pembuat
					</td>
					<td style="font-weight: bold; border-right: 1px solid #000; padding-top: 5px;width: 25%" class="text-center">
						Atasan Langsung
					</td>
					<td style="font-weight: bold; border-right: 1px solid #000; padding-top: 5px;width: 25%" class="text-center">
						Atasan dari Atasan Langsung
					</td>
					<td style="font-weight: bold; border-right: 1px solid #000; padding-top: 5px;width: 25%" class="text-center">
						Kepala Departemen Keuangan
					</td>
				</tr>
				<tr>
					<td style="border-top: none; border-right: 1px solid #000; font-weight: bold;" class="text-center">
						<br><br><br><?= $kaizen[0]['pencetus_nama'] ?>
					</td>   
					<td style="border-top: none; border-right: 1px solid #000; font-weight: bold;" class="text-center">
						<br><br><br>.............................
					</td>   
					<td style="border-top: none; border-right: 1px solid #000; font-weight: bold;" class="text-center">
						<br><br><br>.............................
					</td>  
					<td style="border-top: none; border-right: 1px solid #000; font-weight: bold;" class="text-center">
						<br><br><br>Ria Cahyani
					</td>   
				</tr>
			</tbody>
	 	</table>
		<table class="table" style="border: 1px solid #000; padding-top: 0; margin-top: 0; margin-bottom: 0">
			<tbody>
				<tr>
					<td style="border-top: 1px solid #000; font-weight: bold;" width="50%">
						Tanggal Realisasi : <?php 
						$dt4 = strtotime($kaizen[0]['tanggal_realisasi']); 
						$a4 = date('d',$dt4); 
						$b4 = date('m',$dt4); 
						$c4 = date('Y',$dt4); 
						echo $a4.' '.$bulan[$b4].' '.$c4;?>
					</td>
					<td style="border-top: 1px solid #000; font-weight: bold; border-left: 1px solid #000" colspan="3">
						Catatan:
					</td>
				</tr>
			</tbody>
		</table>
		<table>       
			<tr >
				<td style="font-size: 9px ; padding: 2px">No. Form</td>
				<td style="font-size: 9px ; padding: 2px">:</td>
				<td style="font-size: 9px ; padding: 2px">FRM-RNI-06-01</td>
			</tr>
			<tr>
				<td style="font-size: 9px ; padding: 2px">No. Rev</td>
				<td style="font-size: 9px ; padding: 2px">:</td>
				<td style="font-size: 9px ; padding: 2px">01</td>
			</tr>
		</table>
  </div>
</div>