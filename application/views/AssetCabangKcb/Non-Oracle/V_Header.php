<html>
<?php 
$hima = " ";
$hima_jenis = " ";
$hima_peroleh = " "; ?>
<head>
<link type="image/x-icon" rel="shortcut icon" href="<?= base_url('assets/img/logo.png') ?>">
	<style media="screen">
	</style>
</head>

<body>
	<!-- <br/> -->
	<table style="width:100%; padding: 0; border-collapse: collapse !important;margin-bottom:5px;margin-top: 150px;
	/*border: 1px solid black*/
	">
	<tr>

		<td rowspan="2" valign="top" 
		style="
		text-align: left;
		/*border-top: 1px solid black;*/
		border-left: 1px solid black;
		border-right: 1px solid black; 
		border-top: 1px solid black; 
		/*border-bottom: 1px solid black;*/
		width:74px;
		margin-top: 50px">
		<img style="height: auto; width: 73px;" src="<?php echo base_url('assets/img/logo.png'); ?>" />
	</td>

	<td colspan="5" valign="top" style="
	font-size: 14px;
	font-family: sans-serif;
	text-align: left; 
	border-top: 1px solid black;
	width:50px;
	/*border-right: 1px solid black;*/
	/*border-bottom: 1px solid black;*/
	padding-top: 10px;
	padding-left:20px;
	/*background-color: green;*/
	">
	<b>CV. KARYA HIDUP SENTOSA<br/>
	JOGJAKARTA </b>
</td>

<td style="
width: 20%;
font-size: 12px;
text-align: left;
/*border-left: 1px solid black;*/
border-top: 1px solid black;
border-right: 1px solid black;
font-family: sans-serif;">
<b>NO. : N <?php echo $code[0]?> </td> 

			<!-- <td style="border-top: 1px solid black;"> : </td> 

			<td style="border-top: 1px solid black;border-right: 1px solid black;font-size: 12px;"> <b><?php echo "F.RM.MTN-02-02 (Rev.04)";?> </b><br>
			</td> -->
		</tr>
		<tr>
			<td colspan="6" valign="top" 
			style=" text-align: center;
			/*background-color: pink;*/
			font-family: sans-serif;
			padding-bottom: 20px;
			padding-right: 10px;
			border-right:1px solid black;
			">
			<h1>PROPOSAL PENGADAAN ASSET</h1>
		</td>
	</tr>

	<tr>
		<td colspan="7" valign="top"
		style="
		border-left: 0px solid black;
		border-right: 0px solid black; 
		border-top: 1px solid black; 
		border-bottom: 0px solid black;
		background-color: white;
		padding-top: 10px;
		font-family: sans-serif;
		font-size: 14px">
		<b>I. Asset yang Dibutuhkan :</b>
	</td>
</tr>

<tr>
	<td colspan="7" valign="top" 
	style="	border-top:1px solid black;
	border-left: 1px solid black;
	border-right: 1px solid black;
	font-family: sans-serif;
	font-size: 14px;
	padding-left: 10px;">
	a. Kategori Asset : <i>(Pilih satu dengan tanda √ )</i>
</td>
</tr>

<tr>
	<td colspan="7" valign="top" 
	style="
	border-top:0px solid black;
	border-left:1px solid black;
	border-bottom: 1px solid black;
	border-right: 1px solid black;
	font-family: sans-serif;
	">
	<!-- √ -->
	<table style="padding-left: 20px" >
		<tr>
			<td style="width:18px; font-size: 12px;
			font-style: bold; border: 1px solid black;">
			<center> <?php if($kategori_asset=="1") echo "√"?></center>
		</td>
		<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
			Tanah
		</td>

		<td style="width:18px; font-size: 12px;
		font-style: bold; border: 1px solid black;">
		<center> <?php if($kategori_asset=="4") echo "√"?></center>
		</td>
		<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
			Mobil / Truk
		</td>

	<td style="width:18px; font-size: 12px;
	font-style: bold; border: 1px solid black;">
	<center> <?php if($kategori_asset=="7") echo "√"?></center>
</td>
<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
	Peralatan Pabrik ***)
</td>

<td style="width:18px; font-size: 12px;
font-style: bold; border: 1px solid black;">
<center> <?php if($kategori_asset=="10") echo "√"?></center>
</td>
<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
	Asset Tak Berwujud ****)
</td>
</tr>
<tr>
	<td style="width:18px; font-size: 12px;
	font-style: bold; border: 1px solid black;">
	<center> <?php if($kategori_asset=="2") echo "√"?></center>
</td>
<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
	Bangunan
</td>

<td style="width:18px; font-size: 12px;
font-style: bold; border: 1px solid black;">
<center> <?php if($kategori_asset=="5") echo "√"?></center>
</td>
<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
	Kendaraan Roda 2/3
</td>

<td style="width:18px; font-size: 12px;
font-style: bold; border: 1px solid black;">
<center> <?php if($kategori_asset=="8") echo "√"?></center>
</td>
<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
	Jig & Fixtures
</td>

</tr>
<tr>
	<td style="width:18px; font-size: 12px;
	font-style: bold; border: 1px solid black;">
	<center> <?php if($kategori_asset=="3") echo "√"?></center>
</td>
<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
	Mesin
</td>

<td style="width:18px; font-size: 12px;
font-style: bold; border: 1px solid black;">
<center> <?php if($kategori_asset=="6") echo "√"?></center>
</td>
<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
	Perlengkapan Kantor **)
</td>

<td style="width:18px; font-size: 12px;
font-style: bold; border: 1px solid black;">
<center> <?php if($kategori_asset=="9") echo "√"?></center>
</td>
<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
	Dies & Pola (Pattern/Mould)
</td>

</tr>
</table>
</tr>

<tr>
	<td colspan="7" valign="top" 
	style="	border-top:1px solid black;
	border-left: 1px solid black;
	border-right: 1px solid black;
	font-family: sans-serif;
	font-size: 14px;
	padding-left: 10px;">
	b. Jenis Asset : <i>(Pilih satu dengan tanda √ )</i>
</td>
</tr>

<tr>
	<td colspan="7" valign="top" 
	style="
	border-top:0px solid black;
	border-left:1px solid black;
	border-bottom: 1px solid black;
	border-right: 1px solid black;
	">
	<!-- √ -->
	<table style=" padding-left: 20px;" >
		<tr>
			<td style="width:18px; font-size: 12px;
			font-style: bold; border: 1px solid black;">
			<center> <?php if($jenis_asset=="1") echo "√"?> </center>
		</td>
		<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
			Asset yang Dibiayakan (Expansed Asset)
		</td>

		<td style="width:18px; font-size: 12px;
		font-style: bold; border: 1px solid black;">
		<center> <?php if($jenis_asset=="2") echo "√"?> </center>
	</td>
	<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
		Asset Tetap (Capitalized Asset)
	</td>
</tr>
</table>
</tr>


<tr>
	<td colspan="7" valign="top" 
	style="	border-top:0px solid black;
	border-left: 1px solid black;
	border-right: 1px solid black;
	font-family: sans-serif;
	font-size: 14px;
	padding-left: 10px;">
	c. Perolehan Asset : <i>(Pilih satu dengan tanda √ )</i>
</td>
</tr>

<tr>
	<td colspan="7" valign="top" 
	style="
	border-top:0px solid black;
	border-left:1px solid black;
	border-bottom: 1px solid black;
	border-right: 1px solid black;
	">
	<!-- √ -->
	<table style="padding-left: 20px;">
		<tr>
			<td style="width:18px; font-size: 12px;
			font-style: bold; border: 1px solid black;">
			<center> <?php if($perolehan_asset == "1") echo "√"?> </center>
		</td>
		<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
			Dibeli melalui pembelian
		</td>

		<td style="width:18px; font-size: 12px;
		font-style: bold; border: 1px solid black;">
		<center> <?php if($perolehan_asset == "2") echo "√"?> </center>
	</td>
	<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
		Dibuat di KHS
	</td>

	<td style="width:18px; font-size: 12px;
	font-style: bold; border: 1px solid black;">
	<center> <?php if($perolehan_asset == "3") echo "√"?> </center>
</td>
<td style="font-family: sans-serif;font-size: 12px;padding-right:20px;">	
	Diambil dari Stock Gudang
</td>
</tr>
</table>
</tr>

<tr>
	<td colspan="7" valign="top" 
	style="	border-top:0px solid black;
	border-left: 1px solid black;
	border-right: 1px solid black;
	border-bottom: 1px solid black;
	font-size: 14px;
	font-family: sans-serif;
	height: 30px;
	padding-top: 5px;
	padding-left: 10px;">
	d. Seksi Pemakai : <?php echo $pemakai?>
</td>
</tr>
<tr>
	<td colspan="7" valign="top" 
	style="	
	font-size: 14px;
	height: 5px;
	">

</td>
</tr>


<tr style="height: 100px">
	<td colspan="7" valign="top" 
	style="font-size: 12px; background-color: black;">

	<table style="border-collapse: collapse; 
	background-color: white;
	text-align: center;
	width: 100%">

	<tr>
		<td colspan="6" valign="top" 
		style="	text-align: left;
		border-bottom: 1px solid black;
		font-size: 14px;
		height: 30px;
		padding-top: 5px;
		font-family: sans-serif;
		padding-left: 10px;">
		e. Rencana Kebutuhan <i>(dalam satu kategori)</i>
		</td>
	</tr>
<tr>
	<th style=" width: 3%;
	font-weight: normal;
	font-family: sans-serif;
	border-top:1px solid black;
	border-right: 1px solid black;
	border-bottom: 1px solid black;">
No </th>
<th style=" font-family: sans-serif;width: 10%;
font-weight: normal;
border:1px solid black;font-size: 12px;">Kode Barang </th>
<th style="font-family: sans-serif; width: 15%;
font-weight: normal;
border:1px solid black;font-size: 12px;">Nama Asset </th>
<th style="font-family: sans-serif; width: 52%;
font-weight: normal;
border:1px solid black;font-size: 12px;padding-right: 5px;padding-left: 5px">Spesifikasi Asset </th>
<th style="font-family: sans-serif; width: 10%;
font-weight: normal;
border:1px solid black;font-size: 12px;">Jumlah Kebutuhan </th>
<th style="font-family: sans-serif; width: 10%;
font-weight: normal;
border-top:1px solid black;
border-left: 1px solid black;
border-bottom: 1px solid black;font-size: 12px;">
Umur Teknis (Th) </th>
</tr>

<?php $no=1; foreach ($kodebarang as $key => $value) { ?>
	<tr>
		<td style=" font-family: sans-serif;border-top:1px solid black;
		border-right: 1px solid black;font-size: 11px;">
		<?php echo $no?></td>

		<td style=" font-family: sans-serif;border-top:1px solid black;
		border-right: 1px solid black;
		border-left: 1px solid black;font-size: 11px;">
		<?=$value?></td>

		<td style=" font-family: sans-serif; border-top:1px solid black;
		border-right: 1px solid black;
		border-left: 1px solid black;font-size: 11px;">
 		<?=$namaasset[$key]?></td>

		<td align="justify" style=" font-family: sans-serif;border-top:1px solid black;
		border-right: 1px solid black;
		border-left: 1px solid black;font-size: 11px;">
		<?=$spesifikasi_asset[$key]?></td>

		<td style="font-family: sans-serif; border-top:1px solid black;
		border-right: 1px solid black;
		border-left: 1px solid black;font-size: 11px;">
		<?=$jumlah[$key]?></td>

		<td style="font-family: sans-serif; border-top:1px solid black;
		border-left: 1px solid black;font-size: 11px;">
		<?=$umur_teknis[$key]?></td>
</tr>
<?php $no++;} ?>
</table>
</td>
</tr>

	
	<tr>
		<td colspan="5" valign="top" 
		style="
		font-size: 14px;
		height: 5px;
		padding-top: 5px;">
		</td>
	</tr> 
		</td>
	</tr>
	
		
      </table>


  </body>
  </html>

