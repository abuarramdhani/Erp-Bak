<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
        </div>
        <br />

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h4 style="text-align:left padding:5px;">Tukar Shift Dan Absen Manual Hari Ini</h4>
              </div>

              <div class="box-body">
                <div class="callout callout-danger">
                  <h4>Catatan :</h4>

                  <p>Hanya menampilkan tukar shift yang di approve pada hari ini dan untuk hari ini,
                    absen manual yang di approve hari ini untuk absen hari ini.
                  </p>
                </div><br>

                <div class="row">
                  <div class="col-md-1">
                    <a href="<?php echo base_url('CateringManagement/Extra/TukarShiftDanAbsenHariIni/export_excel/') ?>" class="btn btn-md btn-success" target="_blank"><i class="fa fa-file-excel-o"></i> Excel</a>
                  </div>
                  <div style="margin-left : 0px; padding-left : 0%;" class="col-md-1">
                    <a href="<?php echo base_url('CateringManagement/Extra/TukarShiftDanAbsenHariIni/export_pdf/') ?>" class="btn btn-md btn-danger" target="_blank"><i class="fa fa-file-pdf-o"></i> PDF</a>
                  </div>
                </div><br>

                <table id="TblTukarShiftdanAbsen" class="table table-striped table-bordered table-hover">

                  <thead class="bg-primary">
                    <tr>
                      <th width="3%" style="text-align : center;">No</th>
                      <th>No. Induk</th>
                      <th>Nama</th>
                      <th>Seksi</th>
                      <th>Tempat Makan</th>
                      <th>Jenis</th>
                      <th>Alasan</th>
                      <th>Approver</th>
                      <th>Waktu Approve</th>


                    </tr>
                  </thead>

                  <tbody>
                    <?php foreach ($DataShiftAbsen as $key => $val) :
                      ?>
                      <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $val['noind'] ?></td>
                        <td><?= $val['nama']; ?></td>
                        <td><?= $val['seksi']; ?></td>
                        <td><?= $val['tempat_makan']; ?></td>
                        <td><?= $val['jenis']; ?></td>
                        <td><?= $val['alasan']; ?></td>
                        <td><?= $val['appr_']; ?></td>
                        <td><?= $val['approve_timestamp']; ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>

                </table>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>