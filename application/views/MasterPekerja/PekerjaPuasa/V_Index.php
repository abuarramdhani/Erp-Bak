<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11">
            </div>
            <div class="col-lg-1">
            </div>
          </div>
        </div>
        <br>

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h1 style="text-align:left padding:5px;">Cetak Pekerja Puasa</h1>
              </div><br>

              <div class="box-body">
                <div class="nav-tabs-custom" style="position: relative;">

                  <ul class="nav nav-tabs">
                    <li class="active">
                      <a href="#shift" data-toggle="tab">NON SHIFT</a>
                    </li>
                    <li class="">
                      <a href="#nonshift" data-toggle="tab">SHIFT</a>
                    </li>
                  </ul>

                  <div class="tab-content">
                    <div class="tab-pane active" id="shift">
                      <hr>
                      <table id="puasak" class="table table-striped table-bordered table-hover">
                        <thead class="bg-primary">
                          <tr>
                            <th width="5%">No</th>
                            <th>No Induk</th>
                            <th>Nama</th>
                            <th>Seksi</th>
                            <th>Agama</th>
                            <th>Shift</th>

                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($Pekerja as $key => $val) :
                            ?>
                            <tr>
                              <td><?= $key + 1 ?></td>
                              <td><?= $val['noind']; ?></td>
                              <td><?= $val['nama']; ?></td>
                              <td><?= $val['seksi']; ?></td>
                              <td><?= $val['agama']; ?></td>
                              <td><?= $val['shift']; ?></td>

                            </tr>
                          <?php endforeach; ?>
                      </table>
                    </div>

                    <div class="tab-pane" id="nonshift">
                      <hr>
                      <table id="puasakk" class="table table-striped table-bordered table-hover">
                        <thead class="bg-primary">
                          <tr>
                            <th width="5%">No</th>
                            <th>No Induk</th>
                            <th>Nama</th>
                            <th>Seksi</th>
                            <th>Agama</th>

                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($Pekerjanonshift as $key => $val) :
                            ?>
                            <tr>
                              <td><?= $key + 1 ?></td>
                              <td><?= $val['noind']; ?></td>
                              <td><?= $val['nama']; ?></td>
                              <td><?= $val['seksi']; ?></td>
                              <td><?= $val['agama']; ?></td>

                            </tr>
                          <?php endforeach; ?>
                      </table>
                    </div>

                  </div>


                </div>


              </div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>