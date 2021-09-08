<b style="font-size:10px;"><?php echo "Menampilkan Data Deklarasi Sehat Berdasarkan Tanggal: $tanggal_awal sampai $tanggal_akhir, Seksi: $seksi, Pekerja: $noind" ?></b>
  <table style="width:100%;border: 1px solid black; border-collapse: collapse;">
    <thead>
      <tr>
        <td style="padding:5px;font-weight: bold;text-align: center;border-bottom:1px solid black;border-left:1px solid black;">No.</td>
        <td style="padding:5px;font-weight: bold;text-align: center;width:135px !important;border-bottom:1px solid black;border-left:1px solid black;">Nama Pekerja</td>
        <td style="padding:5px;font-weight: bold;text-align: center;width:150px !important;border-bottom:1px solid black;border-left:1px solid black;">Seksi</td>
        <td style="padding:5px;font-weight: bold;text-align: center;border-bottom:1px solid black;border-left:1px solid black;">No. Induk</td>
        <?php foreach ($pertanyaan as $key => $value): ?>
          <td style="padding:5px;font-weight: bold;text-align: center;border-bottom:1px solid black;border-left:1px solid black;"><?php echo substr($value['aspek'], 0,7) == 'aspek_2' ? 'Tidak ' : '' ?><?php echo $value['pertanyaan'] ?></td>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php $no=1;foreach ($get as $key => $value): ?>
        <tr>
          <td style="padding: 5px;;text-align: center;border-bottom:1px solid black;border-left:1px solid black;"><?php echo $no++ ?></td>
          <td style="padding: 5px;;text-align: center;border-bottom:1px solid black;border-left:1px solid black;"><?php echo $value['nama'] ?></td>
          <td style="padding: 5px;;text-align: center;border-bottom:1px solid black;border-left:1px solid black;"><?php echo $value['seksi'] ?></td>
          <td style="padding: 5px;;text-align: center;border-bottom:1px solid black;border-left:1px solid black;"><?php echo $value['noind'] ?></td>
          <?php foreach ($pertanyaan as $key2 => $value2): ?>
            <?php if ($value[$value2['aspek']] == 't'){ ?>
              <td style="padding: 5px;text-align: center;border-bottom:1px solid black;border-left:1px solid black;"> <b>√</b> </td>
            <?php }else{ ?>
              <td style="padding: 5px;background:#e9614e;border-bottom:1px solid black;border-left:1px solid black;"></td>
            <?php } ?>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
