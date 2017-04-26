

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
						B0689
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
						<?php echo $row->nama; ?>
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
						<?php echo substr($row->seksi,0,14); ?>/<?php echo substr($row->unit,0,14); ?>
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
            <table style="width: 100%;font-size:12px">
				<tr>
					<td style="width:12%">
						THR
					</td>
					<td style="width:2%">
						:
					</td>
					<td style="width:18%">
						<?php
							
						?>
						12 / 12 x <?php echo $row->gaji_pokok?> 
					</td>
					<td style="width:15%;text-align:right;">
						2.222.220
					</td>
					<td style="width:6%;">
						&nbsp;
					</td>
					<td colspan="2">
						Lanjutan Sub.Total 1 ...........
					</td>
					<td style="width:20%;text-align:right;">
						4.498.640
					</td>
				</tr>
				<tr>
					<td>
						UB.THR
					</td>
					<td>
						:
					</td>
					<td>
					<?php
						if(<?php ?>){
						}else{
						}
					?>
						12 / 12 x 2.249.320 
					</td>
					<td style="text-align:right;">
						2.222.220
					</td>
					<td>
						&nbsp;
					</td>
					<td>
						Biaya Transfer
					</td>
					<td>
						:
					</td>
					<td style="text-align:right;">
						4.498.640
					</td>
				</tr>
				<tr>
					<td colspan="3">
					</td>
					<td style="text-align:right;">
						(+) ----------------------
					</td>
					<td colspan="4">
						&nbsp;
					</td>
				</tr>
				<tr>
					<td>
						Sub.Total 1
					</td>
					<td colspan="2">
						&nbsp;
					</td>
					<td style="text-align:right;">
						2.222.220
					</td>
					<td colspan="3">
						&nbsp;
					</td>
					<td style="text-align:right;">
						(-) -------------------
					</td>
				</tr>
				<tr>
					<td colspan="5">
						&nbsp;
					</td>
					<td>
						<b>Terima THR</b>
					</td>
					<td>
						&nbsp;
					</td>
					<td style="text-align:right;">
						4.498.640
					</td>
				</tr>
			</table>
		</div>
		 <div class="row" style="margin-left:3px;margin-right:3px;padding-top:10px;">
            <table style="width: 100%;font-size:12px;">
                <tr>
                    <td style="text-align:center;">
						<b>THR-KU BERASAL DARI UANG PARA PELANGGAN</b>
					</td>
                </tr>
				<tr>
                    <td style="text-align:center;">
						<b>~ SELAMAT IDUL FITRI 1438 H~</b>
					</td>
                </tr>
            </table>
        </div>
    </div>
	<pagebreak>
<?php

    }

?>