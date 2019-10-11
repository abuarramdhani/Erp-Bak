
<?php $i=1;foreach($data_limbah as $key){ ?>
<div class="row" style="margin-top:100px;">
	<table style="width: 100%; margin-top: 40px; border-bottom: 4px solid black; border-left: 4px solid black; border-top: 4px solid black; border-right: 4px solid black; border-collapse: collapse;" >
		<tr>
			<td colspan="40" style="width: 100%; padding-left: 10px;  padding-right: 10px; padding-top: 10px;padding-bottom: 10px"><img src="<?php echo base_url('assets/img/headlimbah.png') ?>"/></td>
    </tr>
    <tr>
      <td colspan="10" style="font-size: 11px; text-align: left; padding-left: 10px"><p>Seksi Pengirim</p></td>
      <td colspan="2" style="font-size: 11px; text-align: center;"><p>:</p></td>
      <td colspan="28" style="font-size: 11px; text-align: left;"><p><?php echo $key['seksi']; ?></p></td>
    </tr>
    <tr>
      <td colspan="10" style="font-size: 11px; text-align: left; padding-left: 10px"><p>Tanggal dan waktu pengiriman</p></td>
      <td colspan="2" style="font-size: 11px; text-align: center;"><p>:</p></td>
      <td colspan="28" style="font-size: 11px; text-align: left;"><p><?php echo $key['tanggal'].' Pukul '.$key['waktu']; ?></p></td>
    </tr>
    <tr>
      <td colspan="10" style="font-size: 11px; text-align: left; padding-left: 10px"><p>Lokasi Kerja</p></td>
      <td colspan="2" style="font-size: 11px; text-align: center;"><p>:</p></td>
      <td colspan="28" style="font-size: 11px; text-align: left;"><p><?php echo $key['lokasi']; ?></p></td>
    </tr>
    <tr>
      <td colspan="40" style="padding-bottom: 5px; padding-top: 5px"></td>
    </tr>
    <tr>
      <td colspan="10" style="font-size: 11px; text-align: left; padding-left: 10px; padding-bottom: 5px"><p>Jenis limbah yang dibuang</p></td>
      <!-- <td colspan="2" style="font-size: 11px; text-align: center;"><p>:</p></td> -->
      <td colspan="30" style="font-size: 11px; text-align: left; padding-left: 15px; padding-bottom: 5px"><p><i>*isi sesuai jenis limbah yang dikirim ke TPS B3</i></p></td>
    </tr>
     <tr>
      <td colspan="40"></td>
    </tr>
    <tr>
      <td colspan="3" style="font-size: 11px; text-align: center;"></td>
      <td colspan="2" style="font-size: 11px; text-align: center; border: 1px solid black;background-color: yellow"><b>NO.</b></td>
      <td colspan="14" style="font-size: 11px; text-align: center; border: 1px solid black;background-color: yellow"><b>JENIS LIMBAH</b></td>
      <td colspan="6" style="font-size: 11px; text-align: center; border: 1px solid black;background-color: yellow"><b>JUMLAH</b></td>
      <td colspan="6" style="font-size: 11px; text-align: center; border: 1px solid black;background-color: yellow"><b>SATUAN</b></td>
      <td colspan="6" style="font-size: 11px; text-align: center; border: 1px solid black;background-color: yellow"><b>KONDISI</b></td>
      <td colspan="3" style="font-size: 11px; text-align: center;"></td>
    </tr>
    <tr>
      <td colspan="3" style="font-size: 11px; text-align: center;"></td>
      <td colspan="2" style="font-size: 11px; text-align: center; border: 1px solid black; ">1.</td>
      <td colspan="14" style="font-size: 11px; text-align: center; border: 1px solid black; "><?php echo strtoupper($key['jenis_limbah']) ; ?></td>
      <td colspan="6" style="font-size: 11px; text-align: center; border: 1px solid black; "><?php echo $key['jumlah']; ?></td>
      <td colspan="6" style="font-size: 11px; text-align: center; border: 1px solid black; "><?php echo strtoupper($key['satuan']); ?></td>
      <td colspan="6" style="font-size: 11px; text-align: center; border: 1px solid black; "><?php if ($key['bocor'] == '1') {
       echo "BOCOR";
      }else{
        echo "TIDAK BOCOR";
      } ?></td>
      <td colspan="3" style="font-size: 11px; text-align: center;"></td>
    </tr>
     <tr>
      <td colspan="40"></td>
    </tr>
    <tr>
      <td colspan="31" style="font-size: 11px; text-align: center; "></td>
      <td colspan="6" style="font-size: 11px; text-align: center; padding-top: 10px">Mengetahui,</td>
      <td colspan="3" style="font-size: 11px; text-align: center; "></td>
    </tr>
    <tr>
      <td colspan="3" style="font-size: 11px; text-align: center; "></td>
      <td colspan="8" style="font-size: 11px; text-align: center;  ">Penerima</td>
      <td colspan="4" style="font-size: 11px; text-align: center;  "></td>
      <td colspan="8" style="font-size: 11px; text-align: center;  ">Pengirim Limbah</td>
      <td colspan="5" style="font-size: 11px; text-align: center;  "></td>
      <td colspan="12" style="font-size: 11px; text-align: center;  ">Ka. Si <?php $sks = strtolower($key['seksi']); echo ucwords($sks) ?></td>
    </tr>
     <tr>
      <td colspan="40" style="padding-bottom: 30px; padding-top: 30px"></td>
    </tr>
    <tr>
      <td colspan="2" style="font-size: 11px; text-align: center; "></td>
      <td colspan="10" style="font-size: 11px; text-align: center;  ">(Seksi Waste Management)</td>
      <td colspan="2" style="font-size: 11px; text-align: center;  "></td>
      <td colspan="10" style="font-size: 11px; text-align: center;  ">(<?php echo rtrim($key['nama_pengirim']); ?>)</td>
      <td colspan="4" style="font-size: 11px; text-align: center;  "></td>
      <td colspan="12" style="font-size: 11px; text-align: center; ">( _______________________________ )</td>
    </tr>
     <tr>
      <td colspan="40" style="padding-bottom: 10px; padding-top: 10px"></td>
    </tr>
     <tr>
      <td colspan="30" style="font-size: 11px; text-align: center; "></td>
      <td colspan="8" style="font-size: 11px; text-align: center;border: 1px solid black;">FRM-WM-00-06</td>
      <td colspan="2" style="font-size: 11px; text-align: center; "></td>
    </tr>
    <tr>
      <td colspan="30" style="font-size: 11px; text-align: center; "></td>
      <td colspan="8" style="font-size: 11px; text-align: center;border: 1px solid black;">Rev. 00 5/9/2017</td>
      <td colspan="2" style="font-size: 11px; text-align: center; "></td>
    </tr>
    <tr>
      <td colspan="40" style="padding-bottom: 5px; padding-top: 5px"></td>
    </tr>
	</table>
</div>
<?php } ?>