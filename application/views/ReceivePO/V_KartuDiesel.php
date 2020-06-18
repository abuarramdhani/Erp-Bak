 <style>
    .main-div {
      width: 60mm;
      float: left;
      margin-left: 7mm;
      margin-bottom: 4mm;
    }
    table{
      font-family: arial;
    }
  </style>

  <section>
    <?php
    $coba=0;
   for ($i=0; $i < sizeof($serial) ; $i++) {  
      ?>

    <div class="main-div" id="kartu">

      <table border="1" width="100%">
        <tr>
          <th align="center" style="height: 7mm">DIESEL HORISONTAL</th>
        </tr>
        <tr>
          <th align="center" style="height: 5mm;"></th>
        </tr>

        <tr>
          <td align="center">
            <b><?=$descrecipt?></b>
            <br>
            Nomor Seri :
            <br>
            <center><img style="width: 80px;height: 80px;" src="<?= base_url("/img/$serial[$i].png") ;?>"></center>
            <p style="font-size: 14pt; color: #0d47a1;font-weight: bold;"><?=$serial[$i]?></p>
            <br>
            <p style="font-weight:bold; color: red;font-size: 11pt "><?=$ket?></p>
            <br>
          <?php echo date("d M y") ?>

          </td>
        </tr>
      </table>

    </div>

    <?php
    $coba++;
        if($coba % 12 == 0){
         
            echo "<pagebreak>";
          }

      
    }
    ?>

  </section>
