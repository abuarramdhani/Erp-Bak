<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Stiker Cost Center</title>

  <style>
    .main-div {

      float: left;
      /* margin-left :6mm; */

    }

    .gt {
      border: 1px solid black;
      height: 97mm;
      width: 138mm;
    }
  </style>
</head>

<body>
  <section>



    <?php
      $i = 0; //arrayIndex
      $num = sizeof($center);
      foreach($center as $key => $value) {
        ?>

    <div class="main-div gt">


      <table border="1" width="133mm"
        style="margin:10px ;border-collapse: collapse;font-family: calibri, Garamond, Comic Sans MS; ">

        <tr>

          <td rowspan="2" align="left" height="34mm" width="20%"
            style="padding-left: 2px;padding-bottom: 60px; margin-top:10px; background: black ;">
            <img height="20mm" ; width="15mm" src="<?= base_url('assets/img/quick-logo.jpg') ;?>"
              style="display:block;">
          </td>

          <td align="left" colspan="3" style="background: black; padding-left: 18px; line-height: 1px;">
            <b style="font-size: 17pt; color: white; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; COST CENTER:</b>
          </td>
        </tr>
        <tr>
          <td align="left" colspan="3" style="background: black; padding-left: 12px; line-height:40px;">
            <b style="font-size: 70pt; color: white; ">&nbsp;<?= $value?></b>
          </td>

        </tr>


        <tr>
          <td colspan="2" style="padding-left: 10px ; border-right: none;" margin-left="7mm" height="11mm">
            <b style=" font-size: 11pt">SEKSI - NO. MESIN</b>
          </td>

          <td style="padding-left: 10px; border-right: none; border-left: none; width:5%;" margin-left="7mm"
            height="11mm">
            <b style=" font-size: 11pt">:</b>
          </td>

          <td style="border-left: none; width:60%;" margin-left="7mm" height="11mm">
            <b style=" font-size: 11pt"><?= $seksi[$i]?></b>
          </td>

        </tr>

        <tr>
          <td colspan="2" style="padding-left: 10px; border-right: none;" margin-left="7mm" height="11mm">
            <b style=" font-size: 11pt"> TAG NUMBER </b>
          </td>

          <td style="padding-left: 10px; border-right: none; border-left: none; width:5%; " margin-left="7mm"
            height="11mm">
            <b style=" font-size: 11pt">:</b>
          </td>

          <td style="  border-left: none;   width:60%;" margin-left="7mm" height="11mm">
            <b style=" font-size: 11pt"><?= $tag[$i]?></b>
          </td>

        </tr>

        <tr>
          <td colspan="2" style="padding-left: 10px; border-right: none;" margin-left="7mm" height="11mm">
            <b style=" font-size: 11pt"> KODE RESOURCE</b>
          </td>

          <td style="padding-left: 10px; border-right: none; border-left: none; width:5%; " margin-left="7mm"
            height="11mm">
            <b style=" font-size: 11pt">:</b>
          </td>

          <td style="  border-left: none;  width:60%;" margin-left="7mm" height="11mm">
            <b style=" font-size: 11pt"><?= $kode[$i]?></b>
          </td>

        </tr>

        <tr>
          <td colspan="2" style="padding-left: 10px; border-right: none;" margin-left="7mm" height="15mm">
            <b style=" font-size: 11pt"> DESKRIPSI </b>
          </td>

          <td style="padding-left: 10px; border-right: none; border-left: none; width:5%; " margin-left="7mm"
            height="15mm">
            <b style=" font-size: 11pt">:</b>
          </td>

          <td style="  border-left: none; width:60%; " margin-left="7mm" height="15mm">
            <b style=" font-size: 11pt"><?= $desc[$i]?></b>
          </td>

        </tr>

        <tr>
          <td colspan="2" style="padding-left: 10px; border-right: none;" margin-left="7mm" height="11mm">
            <b style=" font-size: 11pt"> TANGGAL UPDATE</b>
          </td>

          <td style="padding-left: 10px;  border-right: none; border-left: none; width:5%; " margin-left="7mm"
            height="11mm">
            <b style=" font-size: 11pt">:</b>
          </td>

          <td style="  border-left: none; width:60%;" margin-left="7mm" height="11mm">
            <b style=" font-size: 11pt"><?= $tgl[$i]?></b>
          </td>

        </tr>

      </table>


    </div>

    <?php
        $i++;
        
        if($i  != $num ){
          if($i%4 == 0){
            echo "<pagebreak>";
          }
        }
        
      }
      
    // echo $i." dan ".$num;exit();
      ?>

  </section>
</body>

</html>