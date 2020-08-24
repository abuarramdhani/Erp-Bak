<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-hourglass-3"> </i> History</h4>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left " id="dataTables-example" style="font-size:11px;">
                    <thead>
                      <tr class="bg-primary">
                        <th class="text-center">NO</th>
                        <th class="text-center">TIKET NUMBER</th>
                        <th class="text-center">BERAT TIMBANG - 1</th>
                        <th class="text-center">BERAT TIMBANG - 2</th>
                        <th class="text-center">OPERATOR</th>
                        <th class="text-center">TANGGAL CETAK</th>
                        <th class="text-center">BUKTI TIMBANG</th>
                      </tr>
                    </thead>
                    <tbody >
                      <?php foreach ($get as $key => $value): ?>
                        <tr>
                          <td style="text-align:center"><?php echo $key+1 ?></td>
                          <td style="text-align:center"><?php echo $value['ticket_number'] ?></td>
                          <td style="text-align:center"><?php echo $value['weight'] ?></td>
                          <td style="text-align:center"><?php echo $value['weight_2'] ?></td>
                          <td style="text-align:center"><?php echo $value['operator_name'] ?></td>
                          <td style="text-align:center"><?php echo $value['created_at'] ?></td>
                          <td style="text-align:center">
                            <!-- <a href="http://produksi.quick.com/api-jti/out/report/pdf/<?php echo $value['ticket_number'] ?>" target="_blank" type="button" class="btn btn-danger" name="button"> <b class="fa fa-file-pdf-o"></b> </a> -->
                            <a href="http://192.168.168.196/api-jti-master/out/report/pdf/<?php echo $value['ticket_number'] ?>" target="_blank" type="button" class="btn btn-danger" name="button"> <b class="fa fa-file-pdf-o"></b> </a>
                          </td>
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
  </div>
</div>
