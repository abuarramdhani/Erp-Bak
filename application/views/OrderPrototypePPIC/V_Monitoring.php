<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-cube"></i> Monitoring Order</h4>
        </div>
        <div class="box-body" style="background:#f0f0f0;">
          <div class="row">
            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff; border-radius:7px;margin-bottom:15px;">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left opp_monitoring" style="font-size:11px;width:100%">
                    <thead>
                      <tr class="bg-primary">
                        <th class="text-center" rowspan="2" style="vertical-align:middle">NO</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle">KODE KOMPONEN</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle">NAMA KOMPONEN</th>
												<th class="text-center" rowspan="2" style="vertical-align:middle">TANGGAL INPUT</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle">NO ORDER</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle">QTY /UNIT</th>
												<th class="text-center" colspan="2">PROSES SAAT INI</th>
                        <th class="text-center" colspan="2">NEXT PROSES</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle">PROSES</th>
                        <!-- Alasan terlambat -->
                      </tr>
                      <tr class="bg-primary">
                        <th class="text-center" style="border-top:0px;">PROSES</th>
                        <th class="text-center" style="border-top:0px;">SEKSI</th>
                        <th class="text-center" style="border-top:0px;">PROSES</th>
                        <th class="text-center" style="border-top:0px;border-right: 1px solid white;">SEKSI</th>
                      </tr>
                    </thead>
                    <tbody >

                      <?php $no=1; foreach ($get as $key => $val){ ?>
                        <tr row="<?php echo $val['id'] ?>" style="text-align:center">
                          <td><?php echo $no ?></td>
                          <td><?php echo $val['kode_komponen'] ?></td>
                          <td><?php echo $val['nama_komponen'] ?></td>
                          <td><?php echo substr($val['created_date'], 0,10) ?></td>
                          <td><?php echo $val['no_order'] ?></td>
                          <td><?php echo $val['qty'] ?></td>

                            <?php if (!empty($val['proses'][0]['id'])){ ?>

                              <td><?php echo $val['proses'][0]['proses'] ?></td>
                              <td><?php echo $val['proses'][0]['seksi'] ?></td>

                              <?php if (!empty($val['proses'][1]['id'])){ ?>
                                <td><?php echo $val['proses'][1]['proses'] ?></td>
                                <td><?php echo $val['proses'][1]['seksi'] ?></td>
                              <?php }else { ?>
                                <td> - </td>
                                <td> - </td>
                              <?php } ?>

                            <?php }else { ?>
                              <td> - </td>
                              <td> - </td>
                              <td> - </td>
                              <td> - </td>
                            <?php } ?>

                          <td><button type="button" class="btn btn-primary" name="button" onclick="opp_detail_proses_mon(<?php echo $val['id'] ?>)"> <b class="fa fa-cube"></b> Detail</button> </td>

                        </tr>
                      <?php $no++;} ?>

                    </tbody>
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
