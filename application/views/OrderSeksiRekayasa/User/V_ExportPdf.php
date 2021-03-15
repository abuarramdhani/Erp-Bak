<div class="box-body box-report">
    <div class="table-responsive">
        <table class="table" style="border: 1px solid #000; padding-bottom: 6px; margin-bottom: 6px">
            <tbody>
                <tr>
                    <td style="border-top: 1px solid #000; border-right: 1px solid #000" class="text-center" width="10%"><img src="<?php echo base_url('assets/img/logo.png'); ?>" style="max-width: 55px; height: auto; width: 55px" /></td>
                    <td style="border-top: 1px solid #000; border-right: 1px solid #000; font-weight: bold;" class="text-center" width="40%"><h3>ORDER SEKSI REKAYASA</h3></td>
                </tr>
            </tbody>
        </table>
        <table class="table" style="border: 1px solid #000; padding-bottom: 0px; margin-bottom: 0px;">
            <tbody>
                <tr>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Nama Pengorder</td>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="2%">:</td>
                    <td style="border-top: 1px solid #000; font-weight: bold; border-right: 1px solid #000" width="35%"><?= $order[0]['nama'] ?><div class="text-right">No. Induk: <?= $order[0]['no_induk'] ?></div></td>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="13%"><b>No Order</b></td>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="2%">:</td>
                    <td style="border-top: 1px solid #000; font-size: 14px; font-weight: bold; border-right: 1px solid #000" width="35%"><?= $order[0]['id_order'] ?></td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Seksi Pengorder</td>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="2%">:</td>
                    <td style="border-top: 1px solid #000; font-weight: bold; border-right: 1px solid #000" width="35%"><?= $order[0]['seksi'] ?></td>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Tanggal Order</td>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="2%">:</td>
                    <td style="border-top: 1px solid #000; font-weight: bold; border-right: 1px solid #000" width="35%"><?= date("d M Y", strtotime($order[0]['tanggal_order'])) ?></td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Jenis Order</td>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="2%">:</td>
                    <td style="border-top: 1px solid #000; font-weight: bold; border-right: 1px solid #000" width="35%"><?= $order[0]['jenis_order'] ?></td>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="13%"><b>Tanggal Estimasi Selesai</b></td>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="2%">:</td>
                    <td style="border-top: 1px solid #000; font-weight: bold; border-right: 1px solid #000" width="35%"><?= date("d M Y", strtotime($order[0]['tanggal_estimasi_selesai'])) ?></td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Nama Alat/Mesin</td>
                    <td style="border-top: 1px solid #000" width="2%">:</td>
                    <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['nama_alat_mesin'] ?></td>
                </tr>
                <?php if($order[0]['jenis_order'] == 'MEMBUAT ALAT/MESIN' || $order[0]['jenis_order'] == 'OTOMASI'){ ?>
                    <tr>
                        <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Jumlah Alat/Mesin</td>
                        <td style="border-top: 1px solid #000" width="2%">:</td>
                        <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['jumlah_alat_mesin'] ?></td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Spesifikasi Alat/Mesin</td>
                        <td style="border-top: 1px solid #000" width="2%">:</td>
                        <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['spesifikasi_alat_mesin'] ?></td>
                    </tr>
                <?php }else if ($order[0]['jenis_order'] == 'MODIFIKASI ALAT/MESIN' || $order[0]['jenis_order'] == 'REBUILDING MESIN') { ?>
                    <tr>
                        <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Nomor Alat/Mesin</td>
                        <td style="border-top: 1px solid #000" width="2%">:</td>
                        <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['nomor_alat_mesin'] ?></td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Jumlah Alat/Mesin</td>
                        <td style="border-top: 1px solid #000" width="2%">:</td>
                        <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['jumlah_alat_mesin'] ?></td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Tipe Alat/Mesin</td>
                        <td style="border-top: 1px solid #000" width="2%">:</td>
                        <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['tipe_alat_mesin'] ?></td>
                    </tr>
                    <tr>
                        <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Fungsi Alat/Mesin</td>
                        <td style="border-top: 1px solid #000" width="2%">:</td>
                        <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['fungsi_alat_mesin'] ?></td>
                    </tr>
                <?php }else if ($order[0]['jenis_order'] == 'HANDLING MESIN') { ?>
                    <tr>
                        <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Jumlah Alat/Mesin</td>
                        <td style="border-top: 1px solid #000" width="2%">:</td>
                        <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['jumlah_alat_mesin'] ?></td>
                    </tr>
                <?php } ?>
                <tr>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Benefit</td>
                    <td style="border-top: 1px solid #000" width="2%">:</td>
                    <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%"><?= $order[0]['benefit'] ?></td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Target</td>
                    <td style="border-top: 1px solid #000" width="2%">:</td>
                    <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%">
                        <?= $order[0]['target'] ?>
                    </td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Kondisi Sebelum</td>
                    <td style="border-top: 1px solid #000" width="2%">:</td>
                    <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%">
                        <?= $order[0]['kondisi_sebelum'] ?>
                    </td>
                </tr>
                <tr>
                    <td style="border-top: 1px solid #000; font-weight: bold;" width="13%">Kondisi Sesudah</td>
                    <td style="border-top: 1px solid #000" width="2%">:</td>
                    <td colspan="4" style="border-top: 1px solid #000; border-right: 1px solid #000" width="70%">
                        <?= $order[0]['kondisi_sesudah'] ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <br/>
        <table width="100%" class="table" style="border: 1px solid #000; padding-bottom: 0; margin-bottom: 0;">
			<tr>
				<td colspan="3" style="font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;" class="text-center">Pembuat Order</td>
				<td style="font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;" class="text-center">Disetujui</td>
			</tr>
			<tr>
				<td style="font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;" class="text-center">Kepala Seksi</td>
				<td style="font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;" class="text-center">Kepala Unit</td>
				<td style="font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;" class="text-center">Ka. Departemen</td>
				<td style="font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;" class="text-center">Direktur Utama</td>
			</tr>
			<tr>
				<td style="height: 60px; font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;" class="text-center"></td>
				<td style="height: 60px; font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;" class="text-center"></td>
				<td style="height: 60px; font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;" class="text-center"></td>
				<td style="height: 60px; font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;" class="text-center"></td>
			</tr>
			<tr>
				<td style="height: 20px; font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;" class="text-center"></td>
				<td style="height: 20px; font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;" class="text-center"></td>
				<td style="height: 20px; font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;" class="text-center"></td>
				<td style="height: 20px; font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;" class="text-center"></td>
			</tr>
			<tr>
				<td style="font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;">Tgl.</td>
				<td style="font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;">Tgl.</td>
				<td style="font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;">Tgl.</td>
				<td style="font-size: 12px; padding: 2px; border-top: 1px solid #000; border-right: 1px solid #000;">Tgl.</td>
			</tr>
		</table>
		<table width="100%">
			<tr>
				<td style="font-size: 10px ; padding: 2px">Keterangan :</td>
			</tr>
			<tr>
				<td style="font-size: 10px ; padding: 2px">
					1. Apabila order hanya terkait internal seksi, maka approval order hingga level Kepala Seksi terkait.
				</td>
			</tr>
			<tr>
				<td style="font-size: 10px ; padding: 2px">
					2. Apabila order melibatkan beberapa seksi dalam 1 unit, maka approval order hingga level Kepala Unit terkait.
				</td>
			</tr>
			<tr>
				<td style="font-size: 10px ; padding: 2px">
					3. Apabila order melibatkan beberapa unit dalam 1 departemen, maka approval order hingga level Kepala Departemen terkait.
				</td>
			</tr>
			<tr>
				<td style="font-size: 10px ; padding: 2px">
					4. Apabila order lintas departemen, maka approval order hingga level Kepala Departemen - Kepala Departemen terkait.
				</td>
			</tr>
			<tr>
				<td style="font-size: 10px ; padding: 2px">
					5. Apabila order kondisi/kasus khusus(kondisi/kasus tertentu), maka approval order hingga Direktur Utama.
				</td>
			</tr>
		</table>
    </div>
</div>