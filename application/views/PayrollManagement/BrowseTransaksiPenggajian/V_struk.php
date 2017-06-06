

<?php
    
    foreach ($strukData as $row) {
?>
    <div style="margin-left:5px;margin-right:20px;padding-top:5px;overflow:hidden;">
        <div class="row" style="margin-left:3px;margin-right:3px;padding-top:10px;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 2%;vertical-align:top;" rowspan="3"><img src="<?php echo base_url('assets/img/logo.png')?>" style="width:42px;"></img></td>
                    <td style="width: 20%;vertical-align:top; ">
						<b style="font-size:11px; ">CV. KARYA HIDUP SENTOSA<br>
							YOGYAKARTA</b>
                    </td>
					<td style="width:14%;font-size:12px;vertical-align:top; ">
						<span style="color: #fff; background-color: #000; padding: 10px; ">&nbsp; PRIBADI & RAHASIA &nbsp;</span>
					</td>
					<td style="width:2%;font-size:12px;vertical-align:top; ">
						&nbsp;
					</td>
					<td colspan="3" style="width:60%;">
						&nbsp;
					</td>
                </tr>
				<tr>
					<td colspan="3" style="width:40%;">
						&nbsp;
					</td>
					<td style="width:8%;font-size:12px;vertical-align:top; ">
						Tanggal
					</td>
					<td style="width:1%;font-size:12px;vertical-align:top;text-align:center; ">
						:
					</td>
					<td style="width:20%;font-size:12px;vertical-align:top; ">
						31 Maret 2017
					</td>
				</tr>
				<tr>
					<td colspan="3">
					&nbsp;
					</td>
					<td style="width:1%;font-size:12px;vertical-align:top;text-align:left; ">
						No. Induk
					</td>
					<td style="width:1%;font-size:12px;vertical-align:top;text-align:center; ">
						:
					</td>
					<td style="width:9%;font-size:12px;vertical-align:top; ">
						<?php echo $row->noind; ?>
					</td>
				</tr>
				<tr>
					<td colspan="4" rowspan="2" style="text-align:center;">
					<small style="font-size:8px;">YANG BERHAK MEMBUKA<br>
					HANYA YANG NAMANYA TERCANTUM PADA SLIP INI</small>
					</td>
					<td style="width:1%;font-size:12px;vertical-align:top;text-align:left; ">
						Nama
					</td>
					<td style="width:1%;font-size:12px;vertical-align:top;text-align:center; ">
						:
					</td>
					<td style="width:9%;font-size:12px;vertical-align:top; ">
						<?php echo $row->nama;  ?>
					</td>
				</tr>
				<tr>
					<td style="width:1%;font-size:12px;vertical-align:top;text-align:left; ">
						Seksi/Unit
					</td>
					<td style="width:1%;font-size:12px;vertical-align:top;text-align:center; ">
						:
					</td>
					<td style="width:9%;font-size:12px;vertical-align:top; ">
						<?php echo substr($row->seksi ,0,14); ?> / <?php echo substr($row->unit,0,14); ?>
					</td>
				</tr>
				<tr>
					<td colspan="4">
					&nbsp;
					</td>
					<td style="width:1%;font-size:12px;vertical-align:top;text-align:left; ">
						Cara Pembayaran
					</td>
					<td style="width:1%;font-size:12px;vertical-align:top;text-align:center; ">
						:
					</td>
					<td style="width:9%;font-size:12px;vertical-align:top; ">
						BCA
					</td>
				</tr>
            </table>
        </div>
		<div class="row" style="margin-left:3px;margin-right:3px;padding-top:10px;">
            <table style="width: 100%;font-size:12px;">
                <tr>
                    <td style="width:15%;">
						Gaji Pokok
					</td>
                    <td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:8%;text-align:center;" colspan="2">
						1 Bulan
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->gaji_pokok); ?>
					</td>
					<td style="width:3%;">
						&nbsp;
					</td>
					<td style="width:15%;" colspan="3">
						Lanjutan Sub.Total 1 ...........
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->subtotal1); ?>
					</td>
				</tr>
				<tr>
                    <td style="width:15%;">
						Ins.Kondite
					</td>
                    <td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:8%;text-align:right;">
						<?php echo $row->p_ik; ?>
					</td>
					 <td style="width:8%;text-align:center;">
					  Hari
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->t_ik); ?>
					</td>
					<td style="width:3%;" colspan="5">
						&nbsp;
					</td>
				</tr>
				<tr>
                    <td style="width:15%;">
						Ins.Prestasi
					</td>
                    <td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:8%;text-align:right;">
						<?php echo $row->p_ip ?>
					</td>
					 <td style="width:8%;text-align:center;">
					  Hari
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->t_ip); ?>
					</td>
					<td style="width:3%;">
						&nbsp;
					</td>
					<td style="width:15%;">
						Pajak
					</td>
					<td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:7%;text-align:right;">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->pajak);?>
					</td>
				</tr>
				<tr>
                    <td style="width:15%;">
						Ins.Fungsionil
					</td>
                    <td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:8%;text-align:right;">
						<?php echo $row->p_if ?>
					</td>
					 <td style="width:8%;text-align:center;">
					  Hari
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->t_if); ?>
					</td>
					<td style="width:3%;" colspan="3">
						&nbsp;
					</td>
				</tr>
				<tr>
                    <td style="width:15%;">
						Ins.M.Sore+Malam
					</td>
                    <td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:8%;text-align:right;">
						<?php echo $row->p_ims; ?>/ <?php echo $row->p_imm; ?>
					</td>
					 <td style="width:8%;text-align:center;">
					  Hari
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format(((int)$row->t_ims)+(int)($row->t_imm)) ?>
					</td>
					<td style="width:3%;" colspan="3">
						&nbsp;
					</td>
					<td style="width:7%;text-align:right;">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						( - ) --------------------
					</td>
				</tr>
				<tr>
                    <td style="width:15%;">
						U.Lembur
					</td>
                    <td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:8%;text-align:right;">
						<?php echo $row->p_lembur; ?>
					</td>
					 <td style="width:8%;text-align:center;">
					  Hari
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->t_lembur); ?>
					</td>
					<td style="width:3%;">
						&nbsp;
					</td>
					<td style="width:15%;">
						Sub.Total 2
					</td>
					<td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:7%;text-align:right;">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->subtotal2); ?>
					</td>
				</tr>
				<tr>
                    <td style="width:15%;">
						Uang Makan
					</td>
                    <td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:8%;text-align:right;">
						24.25
					</td>
					 <td style="width:8%;text-align:center;">
					  Hari
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->t_um_puasa); ?>
					</td>
					<td style="width:3%;">
						&nbsp;
					</td>
					<td style="width:15%;">
						Pot. JHT+JKN+JP
					</td>
					<td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:7%;text-align:right;">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->pot_jht + (int)$row->pot_jkn + (int)$row->pot_jpn); ?>
					</td>
				</tr>
				<tr>
                    <td style="width:15%;">
						UBT
					</td>
                    <td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:8%;text-align:right;">
						<?php echo $row->p_ubt; ?>
					</td>
					 <td style="width:8%;text-align:center;">
					  Hari
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->t_ubt); ?>
					</td>
					<td style="width:3%;">
						&nbsp;
					</td>
					<td style="width:15%;">
						Pot. Koperasi
					</td>
					<td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:7%;text-align:right;">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->pikop + (int)$row->putkop); ?>
					</td>
				</tr>
				<tr>
                    <td style="width:15%;">
						UPAMK
					</td>
                    <td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:8%;text-align:right;">
						<?php echo $row->t_upamk; ?>
					</td>
					 <td style="width:8%;text-align:center;">
					  Hari
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->t_upamk); ?>
					</td>
					<td style="width:3%;">
						&nbsp;
					</td>
					<td style="width:15%;">
						Pot. Hutang
					</td>
					<td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:7%;text-align:right;">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->putang); ?>
					</td>
				</tr>
				<tr>
					<?php if($row->thr == 0 and $row->ubthr==0){ ?>
						<td style="width:15%;" colspan="6">
						</td>
					<?php }else{ ?>
						<td style="width:15%;">
							THR + UBTHR
						</td>
						<td style="width:2%;text-align:center;">
							:
						</td>
						<td style="width:8%;text-align:right;">
							&nbsp;
						</td>
						 <td style="width:8%;">
							&nbsp;
						</td>
						<td style="width:20%;text-align:right;">
							<?php echo number_format((int)$row->thr + (int)$row->ubthr); ?>
						</td>
						<td style="width:3%;">
							&nbsp;
						</td>
					<?php } ?>
					<td style="width:15%;">
						Pot. Duka + SPSI
					</td>
					<td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:7%;text-align:right;">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->pduka+(int)$row->pspsi); ?>
					</td>
				</tr>
				<tr>
                    <td style="width:15%;" colspan="6">
					</td>
					<td style="width:15%;">
						Biaya Transfer
					</td>
					<td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:7%;text-align:right;">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->btransfer); ?>
					</td>
				</tr>
				<tr>
					<?php if($row->klaim_dl==0){ ?>
						<td style="width:15%;" colspan="6">
						</td>
					<?php }else{?>
						<td style="width:15%;">
							Koreksi I
						</td>
						<td style="width:2%;text-align:center;">
							:
						</td>
						<td style="width:8%;text-align:right;">
							&nbsp;
						</td>
						 <td style="width:8%;">
							&nbsp;
						</td>
						<td style="width:20%;text-align:right;">
							<?php echo number_format((int)$row->tkena_pajak); ?>
						</td>
						<td style="width:3%;">
							&nbsp;
						</td>
					<?php } ?>
					<td style="width:15%;">
						Pot. Lain-lain
					</td>
					<td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:7%;text-align:right;">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->plain); ?>
					</td>
				</tr>
				<tr>
                    <td style="width:15%;">
						U. Tambahan
					</td>
                    <td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:8%;text-align:right;">
						&nbsp;
					</td>
					 <td style="width:8%;">
					  &nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->pajak); ?>
					</td>
					<td style="width:3%;">
						&nbsp;
					</td>
					<td style="width:15%;">
						Pot. Dn. Pensiun
					</td>
					<td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:7%;text-align:right;">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->pot_pensiun); ?>
					</td>
				</tr>
				<tr>
					<?php if($row->klaim_dl==0){ ?>
						<td style="width:15%;" colspan="8">
						</td>
					<?php }else{?>
						<td style="width:15%;">
							U. Klaim DL
						</td>
						<td style="width:2%;text-align:center;">
							:
						</td>
						<td style="width:8%;text-align:right;">
							&nbsp;
						</td>
						 <td style="width:8%;">
							&nbsp;
						</td>
						<td style="width:20%;text-align:right;">
							<?php echo number_format((int)$row->klaim_dl); ?>
						</td>
						<td style="width:3%;">
							&nbsp;
						</td>
						<td style="width:15%;" colspan="2">
						</td>
					<?php } ?>
					<td style="width:7%;text-align:right;">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						( - ) --------------------
					</td>
				</tr>
				<tr>
                    <?php if($row->klaim_sisa_cuti==0){ ?>
						<td style="width:15%;" colspan="6">
						</td>
					<?php }else{?>
						<td style="width:15%;">
							U. Sisa Cuti
						</td>
						<td style="width:2%;text-align:center;">
							:
						</td>
						<td style="width:8%;text-align:right;">
							&nbsp;
						</td>
						 <td style="width:8%;">
							&nbsp;
						</td>
						<td style="width:20%;text-align:right;">
							<?php echo number_format((int)$row->klaim_sisa_cuti); ?>
						</td>
						<td style="width:3%;">
							&nbsp;
						</td>
					<?php } ?>
					<td style="width:15%;">
						Sub. Total 3
					</td>
					<td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:7%;text-align:right;">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->subtotal3); ?>
					</td>
				</tr>
				<tr>
                    <td style="width:15%;">
						Potongan HTM
					</td>
                    <td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:8%;text-align:right;">
						<?php echo (float)$row->ijin + (int)$row->htm; ?>
					</td>
					 <td style="width:8%;text-align:center;">
					  Hari
					</td>
					<td style="width:20%;text-align:right;">
						- ( <?php echo number_format((int)$row->pot_htm); ?> )
					</td>
					<td style="width:3%;" colspan="5">
						&nbsp;
					</td>
				</tr>
				<tr>
                    <td style="width:15%;" colspan="4">
					</td>
					<td style="width:20%;text-align:right;">
						( + ) -------------------
					</td>
					<td style="width:3%;" colspan="3">
						&nbsp;
					</td>
					<td style="width:7%;text-align:right;">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						( - ) --------------------
					</td>
				</tr>
				<tr>
                    <td style="width:15%;">
						Sub. Total 1
					</td>
                    <td style="width:2%;text-align:center;" colspan="3">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->subtotal1); ?>
					</td>
					<td style="width:3%;">
						&nbsp;
					</td>
					<td style="width:15%;">
						Terima Bersih
					</td>
					<td style="width:2%;text-align:center;">
						:
					</td>
					<td style="width:7%;text-align:right;">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						<?php echo number_format((int)$row->subtotal3); ?>
					</td>
				</tr>
				<tr>
                    <td style="width:15%;" colspan="9">
						&nbsp;
					</td>
					<td style="width:20%;text-align:right;">
						==========
					</td>
				</tr>
            </table>
        </div>
		 <div class="row" style="margin-left:3px;margin-right:3px;padding-top:10px;">
            <table style="width: 100%;">
                <tr>
                    <td>
						GAJIKU BERASAL DARI UANG PARA PELANGGAN
					</td>
                </tr>
				<tr>
                    <td>
						FRM-F&A-04-01 (Rev.01)
					</td>
                </tr>
            </table>
        </div>
    </div>
<?php

    }

?>