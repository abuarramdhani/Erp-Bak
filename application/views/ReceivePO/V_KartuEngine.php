<style type="text/css">
  table{
    font-family: arial;
    font-size: 10pt;
    text-align: center;
  }

</style>
<?php
$coba = 0;
 for ($i=0; $i < sizeof($serial) ; $i++) {  ?>
<div class="div1"  width= "49,5%"  style="float: left;  margin-bottom: 60px">
    <table border="1" width="100%" style="margin-bottom: 5px; border-collapse: collapse; margin-right: 10px">
      <tbody>
          <tr>
            <td width="5px" style="border-right: none;padding-left: 5px"><center><img style="width: 30px;height: 40px;" src="<?= base_url('assets/img/logo.png') ;?>"></center></td>
            <td colspan="3" style="padding-left: 10px; border-left: none;text-align: left;">Gudang Produksi & Ekspedisi <br>  CV. Karya Hidup Sentosa</td>
            <td rowspan="2"><center><img style="width: 60px;height: 60px;" src="<?= base_url("/img/$serial[$i].png") ;?>"></center></td>
             <td  rowspan="2"  style="font-size: 8pt" >Tgl Lppb<br><br>&nbsp;<?php echo date("d M y") ?>&nbsp;</td>
          </tr>

          <tr>
            <td style="text-align: center; font-size: 14pt" colspan="4" ><b>KIB MOTOR BENSIN</b></td>
          </tr>

          <tr>
            <td width="5px"  >1</td>
            <td >Kode Brg</td>
            <td colspan="3" > <?=$itemrecipt?></td>
            <td rowspan="3"  style="color: white">blabla</td>
          </tr>

          <tr>
            <td></td>
            <td>Nama Brg</td>
            <td colspan="3" style="color: red" ><b><?=$descrecipt?></b></td>
            
            
          </tr>

           <tr>
            <td></td>
            <td>Type</td>
            <td colspan="3" style="font-size: 16pt;color: red"><b>........</b></td>
          </tr>

            <tr>
           <td style="text-align: center;" colspan="5" >Untuk Produk ....... </td>
            <td style="color: white">blabla</td>
          </tr>
      </tbody>
    </table>
      <table border="1" width="100%" style="margin-bottom: 10px;border-collapse: collapse;margin-right: 10px">
        <tbody>
            <tr>
                <td style="text-align: center" colspan="3">CV. KHS melengkapi</td>
            </tr>
            <tr>
                <td>No Seri</td>
                <td colspan="2" style="font-size: 16pt;text-align: center"><b><?=$serial[$i]?></b></td>
            </tr>
        </tbody>
      </table>
      <table  style="margin-bottom: 10px;margin-right: 10px" width="100%" >
        <tr>
          <td style="border: none; color: red"  align="center">
          <p > ------------------------------ POTONG DISINI ------------------------------ </p>
        </td style="border: none;" >
        </tr>
      </table>
      

      <table border="1" style="border-collapse: collapse;margin-right: 10px" width="100%">
        <tbody>
            <tr>
                <td style="text-align: center;font-size: 16pt" colspan="2"><b>UNTUK WOLC</b></td>
            </tr>
            <tr>
                <td>Kode Brg</td>
                <td><?=$itemrecipt?></td>
            </tr>
              <tr>
                <td>Nama Brg</td>
                <td><b> <?=$descrecipt?></b></td>
            </tr>
              <tr>
                <td>Type</td>
                <td style="text-align: center; background-color: orange;font-size: 16pt" ><b>........</b></td>
            </tr>
             <tr>
                <td>No Seri</td>
                <td style="font-size: 16pt;text-align: center"><b><?=$serial[$i]?></b></td>
            </tr>
        </tbody>
      </table>
    </div>
  <?php 
  $coba++;
  if($coba%4 == 0){
                echo "<pagebreak>";
          } 
      }

      ?>

