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
                              <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPresensi/Lelayu/TarifPerusahaan');?>">
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
                          <table class="datatable TableTarifPerusahaan table table-bordered text-center" align="center" style="font-size:12px; width: 100%; position: center;">
                            <div class="row"></div>
                              <thead class="bg-primary">
                                <th class="text-center" style="width: 1px;">No</th>
                                <th>Jenis Sumbangan</th>
                                <th>Nominal</th>
                              </thead>
                              <tbody>
                                <tr>
                                  <td>1</td>
                                  <td>Kain Kafan</td>
                                  <td><?php echo "Rp ".number_format($perusahaan[0]['kain_kafan'],2,',','.'); ?></td>
                                </tr>
                                <tr>
                                  <td>2</td>
                                  <td>Uang Duka Perusahaan</td>
                                  <td><?php echo "Rp ".number_format($perusahaan[0]['uang_duka'],2,',','.'); ?></td>
                                </tr>
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
