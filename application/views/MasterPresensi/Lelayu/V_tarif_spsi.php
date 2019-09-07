<section class="content">
  <div class="inner" >
      <div class="row">
          <div class="col-lg-12">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="col-lg-11">
                          <div class="text-right"><h1><b><?= $Title ?></b></h1></div>
                      </div>
                      <div class="col-lg-1">
                          <div class="text-right hidden-md hidden-sm hidden-xs">
                              <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPresensi/Lelayu/TarifSPSI');?>">
                                  <i class="icon-wrench icon-2x"></i>
                                  <br/>
                              </a>
                          </div>
                      </div>
                  </div>
              </div>
              <br/>
              <div class="row">
                  <div class="col-lg-12">
                    <div class="box box-primary box-solid">
                      <div class="box-header with-border"></div>
                        <div class="box-body box-primary">
                            <table class="datatable TableTarifSPSI table table-bordered text-center" align="center" style="font-size:12px; width: 100%; position: center;">
                            <div class="row"></div>
                              <thead class="bg-primary">
                                <th class="text-center" style="width: 1px;">No</th>
                                <th>Status Hubungan Kerja</th>
                                <th>Kode Jabatan</th>
                                <th>Nominal</th>
                              </thead>
                              <tbody>
                                  <?php if (empty($spsi)) {
                                    // code...
                                  }else
                                  $no = 1;
                                  foreach ($spsi as $key){ ?>
                                    <tr>
                                      <td><?php echo $no++; ?></td>
                                      <td><?php echo $key['status_hubungan_kerja']; ?></td>
                                      <td><?php echo $key['jabatan']; ?></td>
                                      <td><?php echo "Rp ".number_format($key['nominal'],2,',','.'); ?></td>
                                    </tr>
                                  <?php } ?>
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
