<html>
  <head>
    <style type="text/css">
      *{
        font-family: 'Times New Roman';
        margin:0px;
      }
      .header, .header td{  
        border:1px solid black;
        border-collapse: collapse;
        font-family: 'Times New Roman';
      }
      .cuk{
        padding:2px;
        padding-top: 1%;
      }
      .isi,.isi th, .isi td{
        border:1px solid black;
        margin-top: 3%;
        font-size:11px; 
        text-align: center;
        border-collapse: collapse;  
        font-family: 'Times New Roman'; 
      }
      .footer {
        position: absolute;
        bottom: 0px;
      }
      .footer, .footer td{
        border:1px solid black; 
        font-size:11px;
        text-align: center;
        border-collapse: collapse;
        font-family: 'Times New Roman';
      }
    </style>
  </head>
<body> 
  <table class="header" style="width:100%;">
    <tr>
      <td rowspan="2" style="width:30%;font-size:10px; ">
        <p>
          <b>
            CV. KARYA HIDUP SENTOSA<br>
            JL. MAGELANG<br>
            YOGYAKARTA
          </b>
        </p>
      </td>
      <td rowspan="2" style="width:40%;font-size:13px; text-align: center;">
        <p><b>BUKTI TRANSFER BARANG ANTAR GUDANG (BTAG)</b></p>
        <p style="font-size:11px;">(MOVE ORDER ORDER TRANSFER)</p>
      </td>
      <td >
        Tanggal : <?= $tanggal?>
      </td>
    </tr>	
    <tr>
      <td>
        No. MO : <?= $datalist[0]['NO_BTAG']?>
      </td>
    </tr>
  </table>
<table class="header" style="width:100%;font-size:11px;">
  <tr>
    <td style="width:50%">
      <b>Dari Sub Inv./Locator : <?= $datalist[0]['FROM_SUBINVENTORY_CODE']."/".$datalist[0]['FROM_LOC']?></b>
    </td>
    <td style="width:50%">
      <b>Ke Sub Inv./Locator : <?= $datalist[0]['TO_SUBINVENTORY_CODE']."/".$datalist[0]['TO_LOC']?></b>
    </td>
  </tr>
</table>