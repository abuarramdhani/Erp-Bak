<?php   
foreach($show as $a){ 

 ?>

<table class="table1" style="width:100%;border: 1px solid black; padding: 0px; border-collapse: collapse;">
    <tr>
          <td rowspan="2" width="5%" style="font-size: 12px; text-align: center;">
           <img width="5%" style="height: 100px; width: 100px"
            src="<?= base_url('assets/img/logo.png') ;?>" style="display:block;">
          </td>
          <td rowspan="2" width="20%" style="font-size: 12px; text-align: left;">
          CV KARYA HIDUP SENTOSA<br>
          JL. MAGELANG 144 YOGYAKARTA
          </td>
          <td rowspan="2" width="40%" style="border-left: 1px solid black;font-size: 18px;
          text-align: center;border-right: 1px solid black; font-weight: bold;">
          KARTU ORDER RESHARPENING
          </td>
          <td height="30px" width="9%" style="font-size: 12px;padding-left: 10px">Tanggal Order</td>
          <td height="30px" width="3%" style="font-size: 12px;text-align: left;">:</td>
          <td height="30px" width="8%" style="font-size: 12px"><?php echo $a['tgl_order']; ?></td>
    </tr>
      <tr style="height: 10%;">
            <td height="30px" width="9%" style="font-size: 12px;padding-left: 10px; 
            border-top: 1px solid black">Nomor Order</td>
            <td height="30px" width="3%" style="font-size: 12px;border-top: 1px solid black;text-align: left;">:</td>
            <td height="30px" width="8%" style="font-size: 12px;border-top: 1px solid black"><?= $a['REQUEST_NUMBER']; ?></td>
      </tr>
  </table>
  <table class="table2" style="margin-top: 5px;width:100%;border: 1px solid black; padding: 0px;border-collapse: collapse;">
    <tr style="border: 1px solid black">
      <td colspan="2" rowspan="3" width="10%" style="font-size: 12px;text-align: center;border: 1px solid black;">
          <center>
              <img style="height: 100px; width: 100px" src="<?php echo base_url('/assets/img/'.$a['no_order'].'.png'); ?>" />
          </center>
      </td>
      <td rowspan="2" colspan="2" width="10%" style="font-size: 12px;text-align: center;padding: 0;border: 1px solid black;">
        <?php echo $a['kode_barang']; ?>
      </td>
      <!-- <td rowspan="2" width="5%" style="font-size: 4px; 
      text-align: center;"> </td> -->
      <td rowspan="2" width="10%" style="font-size: 12px; 
      text-align: center; font-weight: bold;border: 1px solid black;">SATUAN</td>
      <td colspan="2" width="20%" style="font-size: 12px; font-weight: bold;
      text-align: center;border: 1px solid black;">QTY KIRIM</td>
      <td colspan="2" width="20%" style="font-size: 12px; font-weight: bold;
      text-align: center;border: 1px solid black;">QTY KEMBALI</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td width="8%" style="font-size: 12px;font-weight: bold; 
        text-align: center;border: 1px solid black;">SERAH</td>
        <td  width="8%" style="font-size: 12px;font-weight: bold;; 
        text-align: center;font-weight: bold;border: 1px solid black;">TERIMA</td>
        <td width="8%" style="font-size: 12px; 
        text-align: center;font-weight: bold;border: 1px solid black;">OK</td>
        <td width="8%" style="font-size: 12px; 
        text-align: center;font-weight: bold;border: 1px solid black;">REJECT</td>
       
    </tr>
    <tr style="border: 1px solid black;">
      <td colspan="2" width="10%" style="font-size: 12px;  
      text-align: center; padding-top: 15px; padding-bottom: 15px;border: 1px solid black;"><?php echo $a['deskripsi_barang']; ?>
      </td>
      <td width="10%" style="font-size: 12px; text-align: center;border: 1px solid black;">PCS</td>
      <td style="font-size: 12px; text-align: center;border: 1px solid black;"><?php echo $a['qty']; ?></td>
      <td style="font-size: 12px;border: 1px solid black;"> </td>
      <td style="font-size: 12px;border: 1px solid black;"> </td>
      <td style="font-size: 12px;border: 1px solid black;"> </td>
    </tr>
    <tr style="border: 1px solid black;">
      <td colspan="3" rowspan="2" style="font-size: 12px;border: 1px solid black;
      padding-top: 10;vertical-align: top; text-align: left;">CATATAN:</td>
      <td colspan="2" width="3%" style="font-size: 12px;  padding: 10px;  
      text-align: center;border: 1px solid black;">
      Nama & Paraf<br>Operator</td>
      <td style="font-size: 12px; 
      text-align: center;border: 1px solid black;"> </td>
      <td style="font-size: 12px; 
      text-align: center;border: 1px solid black;"> </td>
      <td style="font-size: 12px; 
      text-align: center;border: 1px solid black;"> </td>
      <td style="font-size: 12px; 
      text-align: center;border: 1px solid black;"> </td>
    </tr>
    <tr style="border: 1px solid black;">
      <td colspan="2" width="3%" style="font-size: 12px; padding: 10px; 
      text-align: center;border: 1px solid black;">Nama & Paraf<br>Pengawas</td>
      <td  style="font-size: 12px; 
      text-align: center;border: 1px solid black;"> </td>
      <td style="font-size: 12px; 
      text-align: center;border: 1px solid black;"> </td>
      <td style="font-size: 12px; 
      text-align: center;border: 1px solid black;"> </td>
      <td style="font-size: 12px; 
      text-align: center;border: 1px solid black;"> </td>
    </tr>
</table>
<table style="margin-top: 1px;width:100%;">    
    <tr style="border: 1px solid black;">
    <tr>
      <td style="font-size: 8px"><?php echo $a['idunix']; ?></td>
    </tr>
</table>
<?php }?>