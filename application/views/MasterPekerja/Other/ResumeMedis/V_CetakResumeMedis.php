<html>

<head>
  <style>
    td {
      height: 22px;
    }
  </style>
</head>

<body>
  <?php $cetak =  $data[0]; { ?>
    <div style="width: 100%;">
      <table style="width: 100%; font-family: Arial, Helvetica, sans-serif;">
        <tbody>
          <tr>
            <td style="width: 33,3%; text-align: left;"><img style="float: left;" src="<?= base_url('assets/img/resumeMedis/BPJS_Ketenagakerjaan_logo.png') ?>" alt="bpjsk" width="130px"></td>
            <td style="width: 33,3%; text-align: left; text-align: center;">
              <h5>SURAT KETERANGAN DOKTER</h5>
            </td>
            <td style=" width: 33,3%; text-align: right;">
              <img style="width: 50px;" src="<?= base_url('assets/img/resumeMedis/Jamsostek-3b.png') ?>" alt="">
            </td>
          </tr>
        </tbody>
      </table>
      <table border="1" style="width: 100%; border-collapse: collapse; margin-top: 5px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;  table-layout: fixed !important;">
        <tbody>
          <tr>
            <td colspan="6"> Dengan ini saya, dokter</td>
            <td style="border-right: 0px;" colspan="3" rowspan="4"> <img style="width: 90px;" src="<?= base_url('assets/img/resumeMedis/Bentuk_KK4.png') ?>" alt=""></td>
            <td style="border-left: 0px;" colspan="6" rowspan="4"><i>(khusus untuk akibat kecelakaan kerja)</i></td>
          </tr>
          <tr>
            <td colspan="6"> Nama :</td>
          </tr>
          <tr>
            <td colspan=6> Jabatan :</td>
          </tr>
          <tr>
            <td colspan="6"> Menerangkan dengan sesungguhnya :</td>
          </tr>

          <tr>
            <td style="width: 2.5%; border-right: 0px;">1.</td>
            <td colspan="5" style="border-left: 0px;">Nama Tenaga Kerja</td>
            <td colspan="7"><?= $cetak['nama'] ?></td>
            <td style="width: 4%; border-right: 0px;">KPJ :</td>
            <td style="border-left: 0px;"><?php if ($cetak['no_peserta'] == null) echo '-';
                                          else echo $cetak['no_peserta']; ?></td>
          </tr>

          <tr>
            <td style="border-right: 0px;" rowspan="2"></td>
            <td style="border-left: 0px;" rowspan="2" colspan="5">Alamat dan Nomor Telepon</td>
            <td colspan="9"><?= $cetak['alamat'] ?></td>
          </tr>
          <tr>
            <td colspan="2"><?= $cetak['desa'] ?></td>
            <td colspan="2"><?= $cetak['kec'] ?></td>
            <td colspan="3"><?= $cetak['kab'] ?></td>
            <td style="width: 4.2%; border-right: 0px;">Telp :</td>
            <td style="border-left: 0px;"> <?= $cetak['nohp'] ?></td>
          </tr>
          <tr>
            <td style="border-right: 0px;" rowspan="2"></td>
            <td style="border-left: 0px;" colspan="5" rowspan="2"> Tempat dan Tanggl Lahir</td>
            <td colspan="4" rowspan="2"><?= $cetak['templahir'] . ', ' . $lahir ?></td>
            <td style="border-right: 0px; padding-left: 1em;" colspan="2" rowspan="2"> Jenis Kelamin :</td>
            <td style="border-left: 0px; border-bottom: 0px;" colspan="3"><img width="12px" src="<?php if ($cetak['jenkel'] == 'L') echo 'assets/img/resumeMedis/boxCentang.png';
                                                                                                  else echo 'assets/img/resumeMedis/box.png' ?>" alt=""> <span>Laki - Laki</span></td>
          <tr>
            <td style="border-top: 0px; border-left: 0px;" colspan="3"><img width="12px" src="<?php if ($cetak['jenkel'] == 'P') echo 'assets/img/resumeMedis/boxCentang.png';
                                                                                              else echo 'assets/img/resumeMedis/box.png' ?>" alt=""> <span>Perempuan</span></td>
          </tr>
          </tr>

          <tr>
            <td style="border-right: 0px;"></td>
            <td style="border-left: 0px;" colspan="5">Jenis Pekerjaan / Jabatan</td>
            <td colspan="9"><?= $cetak['jabatan'] ?></td>
          </tr>

          <tr>
            <td style="border-right: 0px;"></td>
            <td style="border-left: 0px;" colspan="5">Unit/Bagian Perusahaan</td>
            <td colspan="9"><?= $cetak['seksi'] ?></td>
          </tr>

          <tr>
            <td style="border-right: 0px;">2.</td>
            <td style="border-left: 0px;" colspan="5">Nama Perusahaan</td>
            <td colspan="6"><?= $cetak['nama_perusahaan'] ?></td>
            <td style="width: 4.2%; border-right: 0px;">NPP :</td>
            <td colspan="2" style="border-left: 0px;"><?= $cetak['kd_mitra'] ?></td>
          </tr>

          <tr>
            <td style="border-right: 0px;" rowspan="2"></td>
            <td style="border-left: 0px;" rowspan="2" colspan="5">Alamat dan Nomor Telepon</td>
            <td colspan="9"><?= $cetak['alper'] ?></td>
          <tr>
            <td style="width: 10%;"></td>
            <td colspan="3">Kode pos: </td>
            <td colspan="5">No telepon : <?= $cetak['no_telp'] ?></td>
          </tr>
          </tr>

          <tr>
            <td style="border-right: 0px;"></td>
            <td style="border-left: 0px;" colspan="5"> Nomor Pendaftaran (Bentuk K.K.1)</td>
            <td colspan="9"> 683-WBJ-KD-YK-1999</td>
          </tr>

          <tr>
            <td style="border-right: 0px;"></td>
            <td style="border-left: 0px;" colspan="5"> Nomor Akte Pengawasan</td>
            <td colspan="9"> APS KI / 349</td>
          </tr>

          <tr>
            <td style="border-right: 0px;">3.</td>
            <td style="border-left: 0px;" colspan="5">Kecelakaan pada tanggal</td>
            <td colspan="9"><?= $cetak['tgl_laka'] ?></td>
          </tr>

          <tr>
            <td style="border-right: 0px;">4.</td>
            <td style="border-left: 0px;" colspan="5">Pemeriksaan pada tanggal</td>
            <td colspan="9"><?= $cetak['tgl_periksa'] ?></td>
          </tr>

          <tr>
            <td style="border-right: 0px;">5.</td>
            <td style="border-left: 0px;" colspan="5">Dari hasil pemeriksaan didapatkan :</td>
            <td colspan="9" rowspan="12 "><img width="430px" src="<?= base_url('assets/img/resumeMedis/kondisi.png') ?>" alt=""></td>
          </tr>

          <tr>
            <td style="border-right: 0px;"></td>
            <td style="border-left: 0px;" colspan="5"> a. Keadaan , tempat dan ukuran luka-lukanya</td>
          </tr>

          <tr>
            <td style="border-right: 0px;"></td>
            <td style="border-left: 0px;" colspan="5"> b. Diagnosis</td>
          </tr>

          <tr>
            <td style="border-right: 0px;"></td>
            <td style="border-left: 0px;" colspan="5">
              c. Perlu : <span><img width="12px" src="<?= base_url('assets/img/resumeMedis/box.png') ?>" alt=""> dirawat </span>
              <span> <img width="12px" src="<?= base_url('assets/img/resumeMedis/box.png') ?>" alt=""> berobat jalan sambil bekerja</span>
            </td>
          </tr>

          <tr>
            <td style="border-right: 0px;" colspan="2"></td>
            <td style="border-left: 0px;" colspan="4"> <span><img width="12px" src="<?= base_url('assets/img/resumeMedis/box.png') ?>" alt=""> berobat jalan tidak bekerja </span></td>
          </tr>

          <tr>
            <td style="height: 40px; border-right: 0px;"> 6.</td>
            <td style="height: 40px; border-left: 0px;" colspan="5"> Tindakan medis yang dilakukan</td>
          </tr>

          <tr>
            <td style="border-right: 0px;">7.</td>
            <td style="border-left: 0px;" colspan="5">Setelah hasil pengobatan :</td>
          </tr>

          <tr>
            <td style="border-right: 0px; border-bottom: 0px;"></td>
            <td style="border-left: 0px; border-bottom: 0px;" colspan="5"> <img width="12px" src="<?= base_url('assets/img/resumeMedis/box.png') ?>" alt=""> Sembuh tanpa cacad</td>
          </tr>
          <tr>
            <td style="border-right: 0px; border-bottom: 0px; border-top: 0px;"></td>
            <td style="border-left: 0px; border-bottom: 0px; border-top: 0px;" colspan="5"> <img width="12px" src="<?= base_url('assets/img/resumeMedis/box.png') ?>" alt=""> Cacad anatomis akibat kehilangan anggota badan</td>
          </tr>
          <tr>
            <td style="border-right: 0px; border-bottom: 0px; border-top: 0px;"></td>
            <td style="border-left: 0px; border-bottom: 0px; border-top: 0px; padding-left: 1.6em;" colspan="5"> <img width="12px" alt=""> Jelaskan (Tunjukkan juga pada gambar)</td>
          </tr>




          <tr>
            <td style="border-right: 0px; border-bottom: 0px; border-top: 0px;"></td>
            <td style="border-left: 0px; border-bottom: 0px; border-top: 0px; line-height: 2em;" colspan="5"> <img width="12px" src="<?= base_url('assets/img/resumeMedis/box.png') ?>" alt=""> Apabila terdapat cacad tetapi tidak mengakibatkan <br> kehilangan anggota badan, berapa persen <br> berkurangnya fungsi anggota badan yang cacad tersebut </td>
          </tr>



          <tr>
            <td style="border-right: 0px;"></td>
            <td style="border-left: 0px;" colspan="5">
              <img width="12px" src="<?= base_url('assets/img/resumeMedis/box.png') ?>" alt="">
              ………% terbilang (……….……………………...…)
            </td>
          </tr>

          <tr>
            <td style="border-right: 0px;">8.</td>
            <td style="border-left: 0px;" colspan="5">Setelah sembuh ia dapat melakukan pekerjaan </td>
            <td style="border-right: 0px;" colspan="2"><img width="12px" src="<?= base_url('assets/img/resumeMedis/box.png') ?>" alt=""> Biasa</td>
            <td style="border-left: 0px; border-right: 0px;" colspan="3"><img width="12px" src="<?= base_url('assets/img/resumeMedis/box.png') ?>" alt=""> Ringan</td>
            <td style="border-left: 0px;" colspan="4"><img width="12px" src="<?= base_url('assets/img/resumeMedis/box.png') ?>" alt=""> Tidak dapat bekerja sama sekali</td>
          </tr>

          <tr>
            <td style="border-right: 0px;"></td>
            <td style="height: 30px; border-left: 0px;" colspan="5">Terhitung Tanggal</td>
            <td colspan="9"></td>
          </tr>

          <tr>
            <td style="border-right: 0px;">9.</td>
            <td style="border-left: 0px;" colspan="5">Lama perawatan atau pengobatan</td>
            <td colspan="4" style="padding-left: 1.5em; border-right: 0px;">dari tanggal</td>
            <td colspan="5" style="border-left: 0px;">s/d tanggal</td>
          </tr>

          <tr>
            <td style="border-right: 0px;">10.</td>
            <td style="border-left: 0px;" colspan="5">Diberikan istirahat</td>
            <td colspan="4" style="padding-left: 1.5em; border-right: 0px;">dari tanggal</td>
            <td colspan="5" style="border-left: 0px;">s/d tanggal</td>
          </tr>

          <tr>
            <td style="border-right: 0px;">11.</td>
            <td style="border-left: 0px;" colspan="5">Telah menginggal dunia</td>
            <td colspan="9"></td>
          </tr>

          <tr>
            <td style="border-right: 0px;"></td>
            <td colspan="5" style="border-left: 0px;">Dibuat oleh dokter </td>
            <td style="border-right: 0px;" colspan="2"><img width="12px" src="<?= base_url('assets/img/resumeMedis/box.png') ?>" alt=""> Rumah Sakit</td>
            <td style="border-right: 0px; border-left: 0px;" colspan="2"><img width="12px" src="<?= base_url('assets/img/resumeMedis/box.png') ?>" alt=""> Puskesmas</td>
            <td style="border-right: 0px; border-left: 0px;" colspan="2"><img width="12px" src="<?= base_url('assets/img/resumeMedis/box.png') ?>" alt=""> Poliklinik</td>
            <td style="border-left: 0px;" colspan="3"><img width="12px" src="<?= base_url('assets/img/resumeMedis/box.png') ?>" alt="">Dokter swasta</td>
          </tr>

        </tbody>
      </table>
      <table style="width: 100%;  margin-top: 8px; font-size: 10px; font-family: Arial, Helvetica, sans-serif;  table-layout: fixed;">
        <tbody>
          <tr>
            <td colspan="3" style="text-align: center;">Dibuat dengan sesungguhnya,</td>
          </tr>

          <tr>
            <td style="width: 33.3% ; vertical-align: bottom; padding-right: 20px; padding-left: 20px; height: 60px;">
              <hr>
            </td>
            <td style="width: 33.3% ; vertical-align: bottom; padding-right: 30px; padding-left: 30px; height: 60px;">
              <hr>
            </td>
            <td style="width: 33.3% ; vertical-align: bottom; padding-right: 40px; padding-left: 40px; height: 60px;">
              <hr>
            </td>
          </tr>
          <tr>
            <td style="text-align: center; vertical-align: top;">Nama, tanda tangan dokter pemeriksa dan cap </td>
            <td style="text-align: center; vertical-align: top;">Jabatan</td>
            <td style="text-align: center; vertical-align: top;">Tanggal</td>
          </tr>
        </tbody>
      </table>
    </div>
  <?php }
  ?>
</body>

</html>