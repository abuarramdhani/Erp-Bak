<script>
$(document).ready(function () {
    $('.tbl_detail_hsl_psikotes').dataTable({
        scrollX: true,
    });
});
</script>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
        </div>
          <div class="col-ld-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <span style="font-size:20px">Detail Hasil Tes</span>
              </div>
              <div class="box-body">
              <?php foreach ($data as $key => $value) {
                foreach ($value as $key2 => $val2) {?>
                <div class="row"> 
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="col-md-2 text-left">
                            <label>Kode Tes </label>
                        </div>
                        <div class="col-md-10"> 
                            : <?= $val2[0]['kode_test'] ?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-2 text-left">
                            <label>Tanggal </label>
                        </div>
                        <div class="col-md-10">
                            : <?=  DateTime::createFromFormat('Y-m-d', $val2[0]['tgl_test'])->format('d-m-Y')?>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-md-2 text-left">
                            <label>Nama Peserta </label>
                        </div>
                        <div class="col-md-10">
                            : <?= $val2[0]['nama_peserta'] ?>
                        </div>
                    </div>
                    <div class="col-md-12 text-left">
                        <div class="col-md-2 text-left">
                            <label>Nama Tes </label>
                        </div>
                        <div class="col-md-10">
                            : <?= $val2[0]['nama_tes'] ?>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="margin-top:-20px">
                <table class="table table-bordered table-hover table-striped tbl_detail_hsl_psikotes" style="width: 100%;">
                    <thead>
                        <tr style="background-color: #3c8dbc; color:white;" class="text-nowrap">
                            <th class="text-center" style="width:7%">No</th>
                            <th class="text-center">Jawaban</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($val2 as $key3 => $val3) {?>
                            <tr>
                                <td class="text-center"><?= $no?></td>
                                <td class="text-nowrap"><?= $val3['cek']?></td>
                            </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
                <hr>
                </div>
                </div>
                <?php } }?>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
