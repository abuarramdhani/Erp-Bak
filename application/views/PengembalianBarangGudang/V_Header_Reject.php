<html>
  <head>
    <style type="text/css">
      .header, .header td{  
        font-family: 'Courier New', monospace;
        border:1px solid black;
        border-collapse: collapse;
      }
      .isi,.isi th, .isi td{
        border:1px solid black;
        margin-top: 3%;
        text-align: center;
        border-collapse: collapse;  
        font-family: 'Courier New', monospace; 
      }
      .footer {
        position: absolute;
        bottom: 0px 
      }
      .footer, .footer td{
        border:1px solid black; 
        text-align: center;
        border-collapse: collapse;
        font-family: 'Courier New', monospace;
      }
    </style>
  </head>
<body> 
  <table class="header" style="width:100%;">
    <tr>
      <td rowspan="2" style="width:30%;font-size:9px;">
        <p>
            CV. KARYA HIDUP SENTOSA<br>
            JL. MAGELANG 144<br>
            YOGYAKARTA
        </p>
      </td>
      <td rowspan="2" style="width:40%;font-size:14px; text-align: center;">
        <p><b>BUKTI PENYERAHAN BARANG PRODUKSI<br>(REJECT / REPAIR / LAMA / AFVAL)</b></p>
      </td>
      <td style="width:30%;font-size:10px;">
        Tanggal : <?= $datalist[0]['TANGGAL_BTAG']?>
      </td>
    </tr>	
    <tr>
      <td style="width:30%;font-size:10px;">
        No. Move Order : <?= $datalist[0]['NO_BTAG']?>
      </td>
    </tr>
  </table>
<table class="header" style="width:100%;font-size:10px;">
  <tr>
    <td style="width:50%">
      Dari Gudang : <?= $datalist[0]['FROM_SUBINVENTORY_CODE']?>
    </td>
    <td style="width:50%">
      Locator Pengirim : <?= $datalist[0]['FROM_LOC']?>
    </td>
  </tr>
  <tr>
    <td style="width:50%">
      Ke Gudang : <?= $datalist[0]['TO_SUBINVENTORY_CODE']?>
    </td>
    <td style="width:50%">
      Locator Penerima : <?= $datalist[0]['TO_LOC']?>
    </td>
  </tr>
</table>