<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11">
              <div class="text-right">
                <h1><b><?php echo $Title; ?></b></h1>
              </div>
            </div>
            <div class="col-lg-1">
              <div class="text-right hidden-md hidden-sm hidden-xs">
                <a class="btn btn-default btn-lg" href="#">
                  <i class="fa fa-recycle fa-2x text-success"></i>
                  <br />
                </a>
              </div>
            </div>
          </div>
        </div>
        <br />

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <!-- <a href="<?php echo site_url('MasterPekerja/Surat/SuratRotasi/create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New">
                  <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                </a> -->
                <h3><?= $title ?></h3>
              </div>
              <div class="box-body">
                <div class="col-md-12">
                  <div class="row">
                    <form action="" method="get">
                      <div class="col-md-6">
                        <label class="label-control col-md-3" for="">Jenis Surat</label>
                        <div class="col-md-7">
                          <select name="surat" class="form-control select2" data-placeholder="Pilih surat" id="" required>
                            <option value=""></option>
                            <?php foreach ($mailList as $val => $name) : ?>
                              <option value="<?= $val ?>" <?= ($selected === $val) ? 'selected' : '' ?>><?= $name ?></option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <!-- <label class="label-control col-md-3">Tanggal</label>
                        <div class="col-md-5">
                          <input type="text" name="month" id="month" class="form-control">
                        </div>
                        <div class="col-md-4"> -->
                        <button type="submit" class="btn btn-primary">
                          <i class="fa fa-search"></i>
                          Cari
                        </button>
                        <!-- </div> -->
                      </div>
                    </form>
                  </div>
                </div>
                <div class="col-md-12" style="padding-top: 2em;">
                  <div class="table-responsive">
                    <?php
                    // FOR DEVELOPMENT
                    // echo "<pre>";
                    // print_r($mail);
                    // echo "</pre>";
                    ?>
                    <?php
                    switch ($selected) {
                      case 'bapsp3':
                        $this->load->view('MasterPekerja/Surat/Recycle/Table/V_BapSp3', ['data' => $mail]);
                        break;
                      case 'demosi':
                        $this->load->view('MasterPekerja/Surat/Recycle/Table/V_Demosi', ['data' => $mail]);
                        break;
                      case 'isolasi':
                        $this->load->view('MasterPekerja/Surat/Recycle/Table/V_Isolasi', ['data' => $mail]);
                        break;
                      case 'mutasi':
                        $this->load->view('MasterPekerja/Surat/Recycle/Table/V_Mutasi', ['data' => $mail]);
                        break;
                      case 'cutoff':
                        $this->load->view('MasterPekerja/Surat/Recycle/Table/V_Cutoff', ['data' => $mail]);
                        break;
                      case 'resign':
                        $this->load->view('MasterPekerja/Surat/Recycle/Table/V_Resign', ['data' => $mail]);
                        break;
                      case 'pengangkatan':
                        $this->load->view('MasterPekerja/Surat/Recycle/Table/V_Pengangkatan', ['data' => $mail]);
                        break;
                      case 'perbantuan':
                        $this->load->view('MasterPekerja/Surat/Recycle/Table/V_Perbantuan', ['data' => $mail]);
                        break;
                      case 'usiaLanjut':
                        $this->load->view('MasterPekerja/Surat/Recycle/Table/V_UsiaLanjut', ['data' => $mail]);
                        break;
                      case 'promosi':
                        $this->load->view('MasterPekerja/Surat/Recycle/Table/V_Promosi', ['data' => $mail]);
                        break;
                      case 'rotasi':
                        $this->load->view('MasterPekerja/Surat/Recycle/Table/V_Rotasi', ['data' => $mail]);
                        break;
                      case 'tugas':
                        $this->load->view('MasterPekerja/Surat/Recycle/Table/V_Tugas', ['data' => $mail]);
                        break;
                      case 'workexp':
                        $this->load->view('MasterPekerja/Surat/Recycle/Table/V_WorkExp', ['data' => $mail]);
                        break;
                      default;
                        break;
                    }
                    ?>
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
<script>
  $(() => {
    $('#month').monthpicker()
    $('.select2').select2()
  })
</script>