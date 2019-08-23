<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <div class="row">
      <div class="container" style="border:1px solid black;">
        <section style="text-align:center">
          <h4><strong>SURAT PERNYATAAN <br/> KESANGGUPAN UNTUK TETAP BEKERJA</strong></h4>
        </section>
        <br />
        <br />
        <section>
          <div style="width:1200px;">
            <div style="width:50px;float:left;">
              <p style="line-height: 1.7;">
                No <br />
                Lamp <br />
                Hal <br />
              </p>
            </div>
            <div style="width:400px;float:left;">
              <p style="line-height: 1.7;">
                : -<br />
                : Surat Keterangan Dokter tentang HPL <br />
                : Kesanggupan Untuk Bekerja Selama Waktu Tertentu<br />
              </p>
            </div>
          </div>
        </section>
        <br />
        <br />
        <p>Dengan Hormat,</p>
        <br />
        <div style="width:1200px;">
          Saya yang beridentitas di bawah ini : <br />
        <div style="width:100px;float:left;">
          <p style="line-height: 1.7;">
            Nama      <br />
            No. Induk <br />
            Seksi     <br />
            Alamat    <br />
          </p>
        </div>
        <div style="width:540px;float:right;">
          <p style="line-height: 1.7;">
          : <strong><?=$data['nama'] ?></strong> <br />
          : <strong><?=$data['noind']?></strong> <br />
          : <strong><?=$data['seksi']?></strong> <br />
          : <strong><?=$data['alamat']?></strong> <br />
          </p>
        </div>
      </div>
        <br />
        <p align="justify" style="line-height: 1.7;">
          Dikarenakan adanya kebutuhan serah terima pekerjaan dengan pekerja yang baru, maka bersama surat ini saya menyatakan bahwa saya bersedia untuk tetap masuk dan bekerja sampai tanggal <u><strong><?php echo $data['tgl']?></strong></u> walaupun saya sedang dalam masa
          tunggu kelahiran (HPL) yang diperkirakan jatuh pada tanggal <strong><b><u><?php echo $data['tgl_hpl'] ?></u></b></strong>.
          Untuk itu saya siap untuk menanggung segala resiko yang terjadi sampai jangka waktu tersebut di atas dan tidak menuntut Perusahaan atas hal tersebut.
        </p>
        <br />
        <p align="justify" style="line-height: 1.7;">
          Demikian surat pernyataan ini saya buat dan saya tandatangani dengan sadar dan tanpa ada paksaan dari pihak manapun, untuk dapat digunakan sebagaimana mestinya.
        </p>
        <br />
        <br />
        <div style="width:1200px;">
          <div style="width:200px;float:left;">
              <p style="line-height: 1.7;">
                Yogyakarta, <?php echo $data['now'] ?> <br>
                Hormat Saya,
                <br/>
                <br/>
                <br/>
                <br/>
                <u><b><?=$data['nama']?><b></u><br>
                Pekerja
              </p>
          </div>
          <div style="width:220px;float:right;">
            <p style="line-height: 1.7;">
              Mengetahui,
              <br/>
              <br/>
              <br/>
              <br/>
              <br>
              <u><b><?=$data['atasan']?></b></u><br>
              Atasan Langsung
            </p>
          </div>
        </div>
        <br/>
        <br/>
        <br>
        <br/>
        <br/>
        </div>
      </div>
    </div>
  </body>
</html>
