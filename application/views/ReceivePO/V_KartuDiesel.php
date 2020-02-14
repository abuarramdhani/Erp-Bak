 <style>
    .main-div {
      width: 60mm;
      float: left;
      margin-left: 6mm;
      margin-bottom: 3.2mm;
    }
    table{
      font-family: arial;
    }
  </style>

  <section>
    <h1 align="center">MASTER COPY DIESEL HORISONTAL</h1>
    <h2 align="center">STANDART WARNA BIRU</h2>
    <br>


    <?php
    $coba=0;
   for ($i=0; $i < sizeof($serial) ; $i++) {  
      ?>

    <div class="main-div" id="kartu">

      <table border="1" width="100%" style="margin: 10px 0px 10px 0px;">
        <tr>
          <th align="center" style="height: 7mm">DIESEL HORISONTAL</th>
        </tr>
        <tr>
          <th align="center" style="height: 7mm"></th>
        </tr>

        <tr>
          <td align="center" style="height:50mm">
            <b><?=$descrecipt?></b>
            <br>
            <br>
            Nomor Seri :
            <br>
            <center><img style="width: 80px;height: 80px;" src="<?= base_url("/img/$serial[$i].png") ;?>"></center>
            <p style="font-style: italic; font-size: 12pt"><?=$serial[$i]?></p>
            <br>
            <h3 style="font-weight:bold; color: red "><?=$ket?></h3>
            <br>
          <?php echo date("d M y") ?>

          </td>
        </tr>
      </table>

    </div>

    <?php
    $coba++;
        if($coba % 9 == 0){
         
            echo "<pagebreak>";
          }

      
    }
    ?>

  </section>
