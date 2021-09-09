<form action="">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-12 mb-3">
        <a href="<?= base_url('p2k3adm_V2/Admin/Car/Pdf/' . EncryptCar::encode($kecelakaanDetail['id_kecelakaan'])) ?>" target="_blank" class="btn btn-danger">
          <i class="fa fa-file-pdf-o"></i>
          Cetak PDF
        </a>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <div class="row">
            <label for="" class="label-control col-md-4">Kasus</label>
            <div class="col-md-8">
              <input disabled type="text" class="form-control" value="<?= $kecelakaanDetail['kasus']; ?>">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <div class="row">
        <label for="" class="label-control col-md-4">Hari</label>
        <div class="col-md-8">
          <input disabled type="text" value="<?= $kecelakaanDetail['hari'] ?>" class="form-control">
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <label for="" class="label-control col-md-4">Tanggal</label>
        <div class="col-md-8">
          <input disabled type="text" class="form-control" value="<?= date('d-m-Y', strtotime($kecelakaanDetail['waktu_kecelakaan'])) ?>">
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <label for="" class="label-control col-md-4">Jam</label>
        <div class="col-md-8">
          <input disabled type="text" class="form-control" value="<?= date('H:i:s', strtotime($kecelakaanDetail['waktu_kecelakaan'])) ?>">
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <label for="" class="label-control col-md-4">Lokasi</label>
        <div class="col-md-8">
          <input disabled type="text" class="form-control" value="<?= $kecelakaanDetail['lokasi_kerja_kecelakaan'] ?>">
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="form-group">
      <div class="row">
        <label for="" class="label-control col-md-4">Nama</label>
        <div class="col-md-8">
          <input disabled type="text" value="<?= $pekerjaDetail['nama'] ?>" class="form-control">
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <label for="" class="label-control col-md-4">Umur</label>
        <div class="col-md-8">
          <input disabled type="text" value="<?= $pekerjaDetail['age'] ?> Tahun" class="form-control">
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <label for="" class="label-control col-md-4">Lama Bekerja</label>
        <div class="col-md-8">
          <input disabled type="text" value="<?= $kecelakaanDetail['masa_kerja'] ?>" class="form-control">
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <label for="" class="label-control col-md-4">Seksi/Unit</label>
        <div class="col-md-8">
          <input disabled type="text" value="<?= $pekerjaDetail['seksi'] . ' / ' . $pekerjaDetail['unit'] ?>" class="form-control">
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-12">
    <div class="row">
      <div class="form-group">
        <label for="" class="label-control col-md-4">Kronologi</label>
        <div class="col-md-12">
          <textarea disabled class="form-control" name="" id="" style="resize: none;" cols="30" rows="5"><?= $kecelakaanDetail['kronologi'] ?></textarea>
        </div>
      </div>
    </div>
  </div>
</form>