<html>

<head>
<style media="screen">
table tr td {
border: 1px solid black !important;
}
</style>
</head>


<body>
	<table style="width:100%; padding: 0; border-collapse: collapse !important;">
		<tr>
			<td style="width: 10%;border: 1px solid black;" rowspan="6">
				<center><img style="height: auto; width: 70px;" src="<?php echo base_url('assets/img/logo.png'); ?>" /></center>
			</td>
			<td style="font-size: 16px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;" rowspan="2" width="40%"><b>FORM PERUBAHAN BOM (ODM/YTH)</b></td>
      <td width="4%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;">No</td>
      <td width="20%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-top: 1px solid black;border-right: 1px solid black;"></td>
			<!-- <td style="font-size: 10px;text-align: left;" height="25px">Yogyakarta, <?php echo date('d M Y'); ?></td> -->
		</tr>
		<tr>
			<td width="4%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">Tanggal</td>
			<td width="20%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-right: 1px solid black;"></td>
		</tr>
		<tr>
      <td style="font-size: 12px;text-align: left;text-align: center;border-bottom: 1px solid black;" width="40%">CV. KARYA HIDUP SENTOSA</td>
      <td width="4%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">Seksi</td>
      <td width="20%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-right: 1px solid black;"></td>
		</tr>
		<tr>
      <td style="font-size: 12px;text-align: left;text-align: center;border-bottom: 1px solid black;" width="40%">Jl. Magelang No. 144, Yogyakarta 55241</td>
      <td width="4%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">Unit</td>
      <td width="20%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-right: 1px solid black;"></td>
		</tr>
	</table>
  <br>
  <table style="width:100%; padding: 0; border-collapse: collapse !important;">
    <tr>
      <td width="12%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;">Kode Item (Parent)</td>
      <td width="1%" style="border-bottom: 1px solid black;border-top: 1px solid black;">:</td>
      <td width="85%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;"></td>
    </tr>
    <tr>
      <td width="10%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;">Deskripsi</td>
      <td width="1%" style="border-bottom: 1px solid black;">:</td>
      <td width="80%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-right: 1px solid black;"></td>
    </tr>
    <tr>
      <td width="10%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;">Tanggal berlaku</td>
      <td width="1%" style="border-bottom: 1px solid black;border-bottom: 1px solid black;">:</td>
      <td width="80%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-right: 1px solid black;"></td>
    </tr>
    <tr>
      <td width="10%" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;">Alasan perubahan</td>
      <td width="1%" style="border-bottom: 1px solid black;">:</td>
      <td width="80%" height="40px" style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-right: 1px solid black;"></td>
    </tr>
  </table>
  <br>
  <table style="width:100%; padding: 0; border-collapse: collapse !important;">
    <tr>
        <td height="30px" colspan="8" style="font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;"><b>KODE KOMPONEN PENYUSUN BOM LAMA</b></td>
    </tr>
    <tr>
      <td width="2.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;padding:5px;"> <b> No</b></td>
      <td width="12.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"> <b> Kode</b></td>
      <td width="30.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"> <b> Deskripsi</b></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"> <b> QTY</b></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"> <b> UOM</b></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"> <b> Supply Type</b></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"> <b> Sub-Inv</b></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;"> <b> Locator</b></td>
    </tr>
    <tr>
      <td width="2.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;">1</td>
      <td width="12.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
      <td width="30.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;"></td>
    </tr>
  </table>
  <br>
  <table style="width:100%; padding: 0; border-collapse: collapse !important;">
    <tr>
        <td height="30px" colspan="8" style="font-size: 12px;text-align: center;border-bottom: 1px solid black;border-top: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;"><b>KODE KOMPONEN PENYUSUN BOM BARU</b></td>
    </tr>
    <tr>
      <td width="2.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;padding:5px;"> <b> No</b></td>
      <td width="12.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"> <b> Kode</b></td>
      <td width="30.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"> <b> Deskripsi</b></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"> <b> QTY</b></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"> <b> UOM</b></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"> <b> Supply Type</b></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"> <b> Sub-Inv</b></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;"> <b> Locator</b></td>
    </tr>
    <tr>
      <td width="2.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;">1</td>
      <td width="12.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
      <td width="30.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;"></td>
      <td width="7.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;"></td>
    </tr>
  </table>
  <br>


  <table style="width:100%; padding: 0; border-collapse: collapse !important;">
    <tr>
      <td width="55%" height="20px" style="font-size: 11px;text-align: left;" colspan="2"></td>
      <td width="10.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;padding:5px;">Dibuat oleh</td>
      <td width="10.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;">Mengetahui</td>
      <td width="10.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-top: 1px solid black;">Menyetujui</td>
      <td width="10.5%" style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;border-top: 1px solid black;">Diupload oleh</td>
    </tr>
    <tr>
      <td height="80px" style="font-size: 11px;text-align: left;" colspan="2">
        Catatan : <br>
        1. Form ini digunakan untuk  mendaftarkan maupun menghapus kode komponen penyusun untuk BOM (ODM/YTH).
        <br>
         Jika baris yang disediakan masih kurang, silakan insert baris untuk menambahkan kode selanjutnya.<br>
        2. Kolom Menyetujui dapat ditandatangani oleh atasan langsung.
      </td>
      <td  style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;">
        <br><br><br><br>
        …...........…..................<br>
        Spv / Kasie Pemohon
      </td>
      <td  style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;">
        <br><br><br><br>
        …...........…..................<br>
        Kasie PPIC
      </td>
      <td  style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;">
        <br><br><br><br>
        …...........…..................<br>
        Ass Ka Unit
      </td>
      <td  style="font-size: 11px;text-align: center;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">
        <br><br><br><br>
        …...........…..................<br>
        Kasie PIEA
      </td>

    </tr>
    <tr>
      <td style="font-size: 11px;text-align: left;" colspan="2">
        No. Form		: FRM-PDE-00-32 <br>
        Rev. 		: 01
      </td>
      <td  style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;">Tgl : </td>
      <td  style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;">Tgl :</td>
      <td  style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;">Tgl :</td>
      <td  style="font-size: 11px;text-align: left;border-bottom: 1px solid black;border-left: 1px solid black;border-right: 1px solid black;">Tgl :</td>
    </tr>

  </table>

</body>
</html>
