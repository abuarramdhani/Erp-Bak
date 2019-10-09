<!-- KAS BON PERUSAHAAN -->
<?php $i=1;foreach($kasbon as $key){ ?>
<div class="row" style="margin-top:100px;">
	<table style="width: 100%; margin-top: 40px; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-collapse: collapse;" >
		<tr>
			<td colspan="4" style="width: 40%; border-bottom: 1px solid black; border-right: 1px solid black; padding-left: 10px;"><h3>CV. KARYA HIDUP SENTOSA</h3></td>
      <td style="border-bottom: 1px solid black; border-right: 1px solid black;"><p>No. Kas Bon</p></td>
      <td style="width: 30px; border-bottom: 1px solid black;">&emsp;<?php echo $key['lelayu_id'] ?></td>
    </tr>
    <tr>
      <td colspan="2" style="font-size: 11px; padding-left: 10px;"><p>Jl. Magelang No. 144</p></td>
      <td colspan="2" rowspan="2" style="font-size: 18px; border-bottom: 1px solid black; border-right: 1px solid black; text-align: center;"><p><h2>KAS BON</h2></p></td>
      <td rowspan="2" style="border-right: 1px solid black; border-bottom: 1px solid black;"><p>Tgl.</p></td>
      <td rowspan="2" style="width: 30px; border-bottom: 1px solid black;">&emsp;<?php echo $date; ?></td>
    </tr>
    <tr>
      <td colspan="2" style="border-bottom: 1px solid black; padding-left: 10px;"><p>YOGYAKARTA</p></td>
    </tr>
    <tr>
			<td style="width: 4%; font-size: 12px;border-right: 1px solid black; border-bottom:1px solid black">&nbsp;No&nbsp;</td>
			<td colspan="4" style="text-align: center; font-size: 12px;border-right: 1px solid black; border-bottom:1px solid black;">&nbsp;Pengeluaran &nbsp;</td>
			<td style="width: 20%;font-size: 12px; border-bottom:1px solid black; text-align: center;">&nbsp;Jumlah &nbsp;</td>
		</tr>
		<tr>
      <td style="border-right: 1px solid black;">&nbsp;1.</td>
			<td colspan="4" style="font-size: 12px;border-right: 1px solid black; border-bottom: 1px solid black;">&nbsp;Sumbangan duka untuk <?php echo ucwords(mb_strtolower($key['nama']))."(".$key['noind'].")" ?></td>
      <td style=" border-bottom: 1px solid black;"></td>
		</tr>
		<tr>
      <td rowspan="4" style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
      <td colspan="4" style="font-size: 12px;border-right: 1px solid black; border-bottom: 1px solid black;">&nbsp;<?php  echo ucwords(mb_strtolower($key['keterangan'].' - '))?>Seksi <?php echo ucwords(mb_strtolower($key['seksi'])); ?></td>
      <td style=" border-bottom: 1px solid black;"></td>
		</tr>
		<tr >
      <td colspan="4" style="font-size: 12px;border-right: 1px solid black; border-bottom: 1px solid black; height: 16px;"></td>
      <td style=" border-bottom: 1px solid black;"></td>
		</tr>
    <tr>
      <td colspan="4" style="font-size: 12px;border-right: 1px solid black; border-bottom: 1px solid black;">&nbsp;* Uang Duka </td>
      <td style=" border-bottom: 1px solid black; text-align: right;"><?php echo number_format($key['uang_duka_perusahaan'],2,',','.'); ?>&emsp;</td>
    </tr>
    <tr>
      <td colspan="4" style="font-size: 12px;border-right: 1px solid black; border-bottom: 1px solid black;">&nbsp;* Kain Kafan </td>
      <td style=" border-bottom: 1px solid black; text-align: right;"><p><?php echo number_format($key['kain_kafan_perusahaan'],2,',','.'); ?>&emsp;</p></td>
    </tr>
		<tr>
			<td colspan="5" style="border-right: 1px solid black; text-align: right; font-size: 12px;"><b>Total</b>&emsp;Rp.&ensp;</td>
      <td style="border-bottom: 1px solid black; text-align: right;"><?php $total1 = $key['uang_duka_perusahaan']+$key['kain_kafan_perusahaan']; echo number_format($total1,2,',','.'); ?>&emsp;</td>
		</tr>
	</table>
  <table style="width: 100%; border-right: 1px solid black; border-left: 1px solid black; border-collapse: collapse;">
    <tr>
      <td style="height: 20px;"></td>
    </tr>
    <tr>
      <td colspan="10" style="text-align: center; font-size: 12px;">(&nbsp;<u><?php echo ucwords(mb_strtolower($terbilang_total)) ; ?></u>&nbsp;)</td>
    </tr>
  </table>
	<table style="width: 100%; margin-bottom: 10px ; border-left: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black; text-align: center; font-size: 12px" >
    <tr>
      <td style="height: 20px;"></td>
    </tr>
    <tr>
			<td style="width: 20%;" >Kasir,</td>
			<td style="width: 20%;" >Menyetujui,</td>
			<td style="width: 20%;" >Penerima,</td>
		</tr>
    <tr>
      <td style="height:50px;"></td>
    </tr>
		<tr>
			<td>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
			<td>(&nbsp;<u><?php echo $menyetujui; ?></u>&nbsp;)</td>
			<td>(&nbsp;&nbsp;<u><?php echo $tertanda; ?></u>&nbsp;&nbsp;)</td>
	</table>
</div>


<!-- KAS BON SPSI -->

<div class="row" style="margin-top : 50px;">
	<table style="width: 100%; margin-top: 40px; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; border-collapse: collapse;">
		<tr>
			<td colspan="4" style="width: 40%; border-bottom: 1px solid black; border-right: 1px solid black; padding-left: 10px;"><h3>CV. KARYA HIDUP SENTOSA</h3></td>
      <td style="border-bottom: 1px solid black; border-right: 1px solid black;"><p>No. Kas Bon</p></td>
      <td style="width: 30px; border-bottom: 1px solid black;">&emsp;<?php echo $key['lelayu_id'] ?></td>
    </tr>
    <tr>
      <td colspan="2" style="font-size: 11px; padding-left: 10px;"><p>Jl. Magelang No. 144</p></td>
      <td colspan="2" rowspan="2" style="font-size: 18px; border-bottom: 1px solid black; border-right: 1px solid black; text-align: left; width: 250px;"><p><h2>KAS BON</h2></p></td>
      <td rowspan="2" style="border-right: 1px solid black; border-bottom: 1px solid black;"><p>Tgl.</p></td>
      <td rowspan="2" style="width: 30px; border-bottom: 1px solid black;">&emsp;<?php echo $date; ?></td>
    </tr>
    <tr>
      <td colspan="2" style="border-bottom: 1px solid black; padding-left: 10px;"><p>YOGYAKARTA</p></td>
    </tr>
<!-- BODY -->
    <tr>
			<td style="width: 4%; font-size: 12px;border-right: 1px solid black; border-bottom:1px solid black">&nbsp;No&nbsp;</td>
			<td colspan="4" style="text-align: center; font-size: 12px;border-right: 1px solid black; border-bottom:1px solid black;">&nbsp;Pengeluaran &nbsp;</td>
			<td style="width: 20%;font-size: 12px; border-bottom:1px solid black; text-align: center;">&nbsp;Jumlah &nbsp;</td>
		</tr>
		<tr>
      <td style="border-right: 1px solid black;">&nbsp;1.</td>
			<td colspan="4" style="font-size: 12px;border-right: 1px solid black; border-bottom: 1px solid black;">&nbsp;Sumbangan duka untuk <?php echo ucwords(mb_strtolower($key['nama']))."(".$key['noind'].")" ?></td>
      <td style=" border-bottom: 1px solid black;"></td>
		</tr>
		<tr>
      <td rowspan="6" style="border-right: 1px solid black; border-bottom: 1px solid black;"></td>
      <td colspan="4" style="font-size: 12px;border-right: 1px solid black; border-bottom: 1px solid black;">&nbsp;Seksi <?php echo ucwords(mb_strtolower($key['seksi'])); ?></td>
      <td style=" border-bottom: 1px solid black;"></td>
		</tr>
		<tr >
      <td colspan="4" style="font-size: 12px;border-right: 1px solid black; border-bottom: 1px solid black; height: 16px;"></td>
      <td style=" border-bottom: 1px solid black;"></td>
		</tr>
    <tr>
      <td style="font-size: 12px; border-bottom: 1px solid black;">&nbsp;1. NonStaff dan Staff Non-Managerial </td>
      <td style=" border-bottom: 1px solid black;">:</td>
			<td style=" border-bottom: 1px solid black; text-align: right;"><?php echo $key['spsi_nonmanajerial_ket']; ?></td>
			<td style=" border-right: 1px solid black;  border-bottom: 1px solid black; width: 150px;"></td>
      <td style=" border-bottom: 1px solid black; text-align: right;"><?php echo number_format($key['spsi_nonmanajerial_nominal'],2,',','.'); ?>&emsp;</td>
    </tr>
    <tr>
      <td style="font-size: 12px; border-bottom: 1px solid black;">&nbsp;2. SPV & Kasie Pratama </td>
      <td style=" border-bottom: 1px solid black;">:</td>
			<td style=" border-bottom: 1px solid black; text-align: right;"><?php echo $key['spsi_spv_ket']; ?></td>
			<td style=" border-right: 1px solid black;  border-bottom: 1px solid black; width: 150px;"></td>
      <td style=" border-bottom: 1px solid black; text-align: right;"><?php echo number_format($key['spsi_spv_nominal'],2,',','.'); ?>&emsp;</td>
    </tr>
    <tr>
      <td style="font-size: 12px; border-bottom: 1px solid black;">&nbsp;3. Kasie Madya & Kasie Utama </td>
      <td style=" border-bottom: 1px solid black;">:</td>
			<td style=" border-bottom: 1px solid black; text-align: right;"><?php echo $key['spsi_kasie_ket']; ?></td>
			<td style=" border-right: 1px solid black;  border-bottom: 1px solid black; width: 150px;"></td>
      <td style=" border-bottom: 1px solid black; text-align: right;"><?php echo number_format($key['spsi_kasie_nominal'],2,',','.'); ?>&emsp;</td>
    </tr>
    <tr>
      <td style="font-size: 12px; border-bottom: 1px solid black;">&nbsp;4. Ass Ka-Unit keatas </td>
      <td style=" border-bottom: 1px solid black;">:</td>
			<td style=" border-bottom: 1px solid black; text-align: right;"><?php echo $key['spsi_askanit_ket']; ?></td>
			<td style=" border-right: 1px solid black;  border-bottom: 1px solid black; width: 150px;"></td>
      <td style=" border-bottom: 1px solid black; text-align: right;"><?php echo number_format($key['spsi_askanit_nominal'],2,',','.'); ?>&emsp;</td>
    </tr>
		<tr>
			<td colspan="5" style="border-right: 1px solid black; text-align: right; font-size: 12px;"><b>Total</b>&emsp;Rp.&ensp;</td>
      <td style="border-bottom: 1px solid black; text-align: right;"><?php $total2 = $key['spsi_nonmanajerial_nominal']+$key['spsi_spv_nominal']+$key['spsi_kasie_nominal']+$key['spsi_askanit_nominal']; echo number_format($total2,2,',','.'); ?>&emsp;</td>
		</tr>
	</table>
  <table style="width: 100%; border-right: 1px solid black; border-left: 1px solid black; border-collapse: collapse;">
    <tr>
      <td style="height: 20px;"></td>
    </tr>
    <tr>
			<td colspan="10" style="text-align: center; font-size: 12px;">(&nbsp;<u><?php echo ucwords(mb_strtolower($terbilang_total1)); ?></u>&nbsp;)</td>
    </tr>
  </table>
	<table style="width: 100%; margin-bottom: 10px ; border-left: 1px solid black; border-bottom: 1px solid black; border-right: 1px solid black; text-align: center; font-size: 12px" >
    <tr>
      <td style="height: 20px;"></td>
    </tr>
    <tr>
			<td style="width: 20%;" >Kasir,</td>
			<td style="width: 20%;" >Menyetujui,</td>
			<td style="width: 20%;" >Penerima,</td>
		</tr>
    <tr>
      <td style="height:50px;"></td>
    </tr>
		<tr>
			<td>(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
			<td>(&nbsp;<u><?php echo $menyetujui; ?></u>&nbsp;)</td>
			<td>(&nbsp;&nbsp;<u><?php echo $tertanda; ?></u>&nbsp;&nbsp;)</td>
	</table>
</div>
<?php } ?>
