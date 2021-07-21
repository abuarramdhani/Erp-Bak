<div class="row">
    <?php
        $day = date('d');
        $year = date('Y');
     ?>
  <table style="width: 100%; border-collapse: collapse; font-size: 12px; font-family: times;">
    <tr>
      <td rowspan="2"><img src="assets/img/logo.png" style="height: 45px; width: 35px"></td>
      <td colspan="10" style="vertical-align: bottom">Sie Recruitment & Selection</td>
      <td colspan="2" style="border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; text-align: center; font-weight: bold">FRM-HRM</td>
    </tr>
    <tr>
      <td colspan="10" style="vertical-align: top"><p style="font-weight: bold; font-size:11px">CV. KARYA HIDUP SENTOSA</p><p style="font-size: 8px;">Jl.Magelang No. 144 Yogyakarta</p></td>
      <td colspan="2" style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; text-align: center">Rev. 08 : <?php echo $day.' '.$bulanNow.' '.$year ?></td>
    </tr>
    <tr>
      <td colspan="13" style="height:10px"></td>
    </tr>
    <tr>
      <td colspan="13" align="center" style="font-face: times; font-size:18px;"><b>EVALUASI PEKERJA KONTRAK STAF</b></td>
    </tr>
    <tr>
      <td colspan="13" style="height:10px"></td>
    </tr>
    <tr>
      <td colspan="13">Mohon diisi penilaian pekerja Kontrak Staf di seksi Bapak/Ibu terhadap beberapa aspek dibawah ini dan dikembalikan ke seksi Recruitment & Selection <b>maksimal 7 hari sebelum masa kontrak berakhir.</b></td>
    </tr>
    <tr>
      <td colspan="3"><b>Seksi</b></td>
      <td colspan="5"><b>: <?php echo $data[0]['nama_seksi'] ?></b></td>
    </tr>
    <tr>
      <td colspan="3"><b>Periode Penilaian</b></td>
      <td colspan="3"><b>: <?php echo $day_in[2].' '.$month_in.' '.$day_in[0].' - '.$day_out[2].' '.$month_out.' '.$day_out[0] ?></b></td>
    </tr>
    <tr>
      <td rowspan="2" style="Vertical-align: top; text-align: center; font-weight: bold; border-left: 1px solid black; border-top: 1px solid black">No</td>
      <td rowspan="2" colspan="2" style="Vertical-align: top; text-align: center; font-weight: bold; border-left: 1px solid black; border-top: 1px solid black">Data Pekerja</td>
      <td rowspan="2" style="Vertical-align: top; text-align: center; font-weight: bold; border-left: 1px solid black; border-top: 1px solid black; width: 200px;">Deskripsi Pekerjaan</td>
      <td colspan="5" style="Vertical-align: top; text-align: center; font-weight: bold; border-left: 1px solid black; border-top: 1px solid black">Aspek Penilaian *)</td>
      <td rowspan="2" style="Vertical-align: top; text-align: center; font-weight: bold; border-left: 1px solid black; border-top: 1px solid black">Data Absensi & Surat Peringatan</td>
      <td rowspan="2" style="Vertical-align: top; text-align: center; font-weight: bold; border-left: 1px solid black; border-top: 1px solid black">Kesimpulan Penilaian *)</td>
      <td rowspan="2" style="Vertical-align: top; text-align: center; font-weight: bold; border-left: 1px solid black; border-top: 1px solid black">Penetapan Pekerjaan</td>
      <td rowspan="2" style="Vertical-align: top; text-align: center; font-weight: bold; border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black; width: 120px;">Saran Bagi Pengembangan</td>
    </tr>
    <tr>
      <td style="text-align: center; font-weight: bold; border-left: 1px solid black; border-top: 1px solid black">Prestasi Kerja</td>
      <td style="text-align: center; font-weight: bold; border-left: 1px solid black; border-top: 1px solid black">Keteram pilan Kerja</td>
      <td style="text-align: center; font-weight: bold; border-left: 1px solid black; border-top: 1px solid black">Kerja Tim</td>
      <td style="text-align: center; font-weight: bold; border-left: 1px solid black; border-top: 1px solid black">Kedisi plinan</td>
      <td style="text-align: center; font-weight: bold; border-left: 1px solid black; border-top: 1px solid black">Motivasi Kerja</td>
    </tr>
    <tr>
      <td rowspan="11" valign="top" style="text-align: center; border-left: 1px solid black; border-top: 1px solid black; border-bottom: 1px solid black">1.</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black;" valign="top">Nama</td>
      <td valign="top" style="border-top: 1px solid black">: <?php echo ucwords(mb_strtolower($data[0]['nama'])) ?></td>
      <td style="border-left: 1px solid black; border-top: 1px solid black;"></td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">B</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">B</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">B</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">B</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">B</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black;"></td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">Baik</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black;">1.Ditetapkan</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; border-right: 1px solid black"></td>
    </tr>
    <tr>
      <td style="border-left: 1px solid black" valign="top">No. Induk</td>
      <td valign="top">: <?php echo $data[0]['noind'] ?></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">RR</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">RR</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">RR</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">RR</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">RR</td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; text-align: center">Rata - rata</td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black;  border-right: 1px solid black"></td>
    </tr>
    <tr>
      <td style="border-left: 1px solid black" valign='top'>Tgl. Masuk</td>
      <td valign="top">: <?php echo $day_in[2].' '.$month_in.' '.$day_in[0] ?></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">BRR</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">BRR</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">BRR</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">BRR</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">BRR</td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; text-align: center">Bawah Rata - rata</td>
      <td style="border-left: 1px solid black;">2. Gugur</td>
      <td style="border-left: 1px solid black;  border-right: 1px solid black"></td>
    </tr>
    <tr>
      <td style="border-left: 1px solid black; background-color: orange;" valign="top"><b>Masa Orientasi</b></td>
      <?php $tgl1 = new DateTime($day_in[0].'-'.$day_in[1].'-'.$day_in[2]);
            $tgl2 = new DateTime($day_out[0].'-'.$day_out[1].'-'.$day_out[2]);
            $d = $tgl2->diff($tgl1)->days + 1;?>
      <td style="background-color: orange;" valign="top"><b>: <?= $d?> hari</b></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">K</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">K</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">K</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">K</td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center">K</td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; text-align: center">Kurang</td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black;  border-right: 1px solid black"></td>
    </tr>
    <tr>
      <td colspan="2" style="border-left: 1px solid black">(<?php echo $day_in[2].' '.$month_in.' '.$day_in[0].' - '.$day_out[2].' '.$month_out.' '.$day_out[0] ?>)</td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; border-top: 1px solid black; text-align: center" colspan="5">Aspek-aspek lain yang dianggap penting oleh atasan :</td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; text-align: center"></td>
      <td style="border-left: 1px solid black;">3. Perpanjangan</td>
      <td style="border-left: 1px solid black;  border-right: 1px solid black"></td>
    </tr>
    <tr>
      <td style="border-left: 1px solid black" valign="top">Plotingan Seleksi</td>
      <td valign="top">: <?php echo ucwords(mb_strtolower($data[0]['job_des'])) ?></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black;" colspan="5">1.<hr></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; text-align: center"></td>
      <td style="border-left: 1px solid black;">... bulan.</td>
      <td style="border-left: 1px solid black;  border-right: 1px solid black"></td>
    </tr>
    <tr>
      <td style="border-left: 1px solid black" valign="top">Golongan</td>
      <td valign="top">: <?php echo $data[0]['gol'] ?></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; text-align: center" colspan="5"><hr></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; text-align: center"></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black;  border-right: 1px solid black"></td>
    </tr>
    <tr>
      <td style="border-left: 1px solid black"></td>
      <td></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; text-align: center" colspan="5"><hr></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; text-align: center"></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black;  border-right: 1px solid black"></td>
    </tr>
    <tr>
      <td style="border-left: 1px solid black"></td>
      <td></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black;" colspan="5">2.<hr></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; text-align: center"></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black;  border-right: 1px solid black"></td>
    </tr>
    <tr>
      <td colspan="2" style="border-left: 1px solid black; border-right: 1px solid black;"></td>
      <td></td>
      <td style="border-left: 1px solid black;" colspan="5"><hr></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black; text-align: center"></td>
      <td style="border-left: 1px solid black;"></td>
      <td style="border-left: 1px solid black;  border-right: 1px solid black"></td>
    </tr>
    <tr>
      <td style="border-left: 1px solid black; border-bottom: 1px solid black;"></td>
      <td style="border-bottom: 1px solid black;"></td>
      <td style="border-left: 1px solid black; border-bottom: 1px solid black;"></td>
      <td style="border-left: 1px solid black; border-bottom: 1px solid black; text-align: center" colspan="5"><hr></td>
      <td style="border-left: 1px solid black; border-bottom: 1px solid black;"></td>
      <td style="border-left: 1px solid black; border-bottom: 1px solid black; text-align: center"></td>
      <td style="border-left: 1px solid black; border-bottom: 1px solid black;"></td>
      <td style="border-left: 1px solid black; border-bottom: 1px solid black;  border-right: 1px solid black"></td>
    </tr>
    <tr>
      <td colspan="2">Keterangan:</td>
    </tr>
    <tr>
      <td>*)</td>
      <td colspan="3">Lingkari salah satu</td>
      <td colspan="11" style="text-align: right">Yogyakarta, <?php echo $day.' '.$bulanNow.' '.$year ?></td>
    </tr>
    <tr>
      <td valign="top">-</td>
      <td colspan="5" style="padding-right: 20px;">Jika ada kesalahan penulisan pada data absensi & surat peringatan, mohon seksi dapat melakukan konfirmasi ke Seksi Hubungan Kerja.</td>
      <td colspan="4" style="text-align: center">Mengetahui,</td>
      <td colspan="2" style="text-align: center">Penilai,</td>
      <td style="text-align: center">Menerima,</td>
    </tr>
    <tr>
      <td valign="top">-</td>
      <td colspan="5" style="padding-right: 20px;">Untuk perpanjangan orientasi hanya diperbolehkan maksimal 1 kali dengan kurun waktu perpanjangan maksimal 1 bulan</td>
      <td colspan="4" style="text-align: center; vertical-align: top">Ass./Ka Unit/Ass. Ka. Bidang/Koord. Bidang</td>
      <td colspan="2" style="text-align: center"></td>
      <td style="text-align: center; vertical-align: top">Dept. Personalia</td>
    </tr>
    <tr>
      <td colspan="3" style="height: 50px"></td>
      <td colspan="2" style="height: 50px"><img src="assets/img/master-copy.jpg" style="height: 35px; width: 250px"></td>
      <td colspan="1" style="height: 50px"></td>
      <td colspan="4" style="height: 50px"></td>
      <td colspan="2" style="height: 50px"></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="6"></td>
      <td colspan="4" style="text-align: center">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
      <td colspan="2" style="text-align: center">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
      <td style="text-align: center">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
    </tr>
  </table>
  <pagebreak>
    <table style="width: 100%; border-collapse: collapse; font-size: 12px; font-family: times;">
      <tr>
        <td rowspan="2"><img src="assets/img/logo.png" style="height: 45px; width: 35px"></td>
        <td colspan="10" style="vertical-align: bottom">Sie Recruitment & Selection</td>
        <td colspan="2" style="border-left: 1px solid black; border-right: 1px solid black; border-top: 1px solid black; text-align: center; font-weight: bold">FRM-HRM</td>
      </tr>
      <tr>
        <td colspan="10" style="vertical-align: top"><p style="font-weight: bold; font-size:11px">CV. KARYA HIDUP SENTOSA</p><p style="font-size: 8px;">Jl.Magelang No. 144 Yogyakarta</p></td>
        <td colspan="2" style="border-left: 1px solid black; border-right: 1px solid black; border-bottom: 1px solid black; text-align: center">Rev. 08</td>
      </tr>
      <tr>
        <td colspan="13" style="height:20px"></td>
      </tr>
      <tr>
        <td colspan="13" style="padding-left: 13px">PETUNJUK PENILAIAN CALON PEKERJA KONTRAK STAF</td>
      </tr>
      <tr>
        <td colspan="13" style="height: 15px"></td>
      </tr>
      <tr>
        <td colspan="13" style="padding-left: 13px">Berikut ini keterangan beberapa aspek penilaian:</td>
      </tr>
      <tr>
        <td colspan="13" style="height: 15px"></td>
      </tr>
      <tr>
        <td style="width:5px; text-align: center">1)</td>
        <td colspan="12">Prestasi Kerja</td>
      </tr>
      <tr>
        <td style="width:5px; text-align: center"></td>
        <td colspan="12">Adalah keberhasilan untuk mengerjakan sejumlah pekerjaan dengan kualitas yang baik dan waktu kerja standar yang ditetapkan oleh perusahaan.</td>
      </tr>
      <tr>
        <td style="width:5px; text-align: center">2)</td>
        <td colspan="12">Keterampilan Kerja</td>
      </tr>
      <tr>
        <td style="width:5px; text-align: center"></td>
        <td colspan="12">Adalah kemampuan untuk mengerjakan pekerjaan dnegan tingkat kesulitan yang sesuai dengan pekerjaan - pekerjaan yang ada digolongan pekerjaannya.</td>
      </tr>
      <tr>
        <td style="width:5px; text-align: center">3)</td>
        <td colspan="12">Kerja Tim</td>
      </tr>
      <tr>
        <td style="width:5px; text-align: center"></td>
        <td colspan="12">Adalah kemampuan untuk bekerjasama dengan oranglain, termasuk melakukan usaha untuk mengumpulkan / memberi informasi sehubungan dengan pelaksanaan pekerjaan.</td>
      </tr>
      <tr>
        <td style="width:5px; text-align: center">4)</td>
        <td colspan="12">Kedisiplinan</td>
      </tr>
      <tr>
        <td style="width:5px; text-align: center"></td>
        <td colspan="12">Adalah keberhasilan melaksanakan semua perintah atau ketentuan yang berlaku, ketaatan terhadap perintah atasan, prosedur kerja, tingkah laku yang sesuai dengan etika, serta konsisten dan bertanggungjawab terhadap penyelesaian pekerjaan.</td>
      </tr>
      <tr>
        <td style="width:5px; text-align: center">5)</td>
        <td colspan="12">Motivasi Kerja</td>
      </tr>
      <tr>
        <td style="width:5px; text-align: center"></td>
        <td colspan="12">Adalah dorongan untuk menyelesaikan pekerjaan secara tuntas dan mau mencoba untuk mencapai standar kerja terbaik.</td>
      </tr>
      <tr>
        <td style="width:5px; text-align: center">6)</td>
        <td colspan="12">Bobot TIM dan SP</td>
      </tr>
      <tr>
        <td style="width:5px; text-align: center"></td>
        <td colspan="12">Bobot TIM harus &le; 0,6 dan tidak ada Surat Peringatan selama Masa Orientasi.</td>
      </tr>
      <tr>
        <td colspan="13" style="height: 15px"></td>
      </tr>
      <tr>
        <td colspan="13" style="padding-left: 13px">Demikian petunjuk pengisian lembar evaluasi tenaga kerja kontrak staf. Mohon segera dikembalikan ke Personalia bila telah diisi, maksimal 7 hari sebelum masa orientasi berakhir. Terimakasih.</td>
      </tr>
      <tr>
        <td colspan="13" style="height: 40px"></td>
      </tr>
      <tr>
        <td colspan="4" style="padding-left: 13px">Sie Recuitment & Selection</td>
      </tr>
    </table>
</div>
