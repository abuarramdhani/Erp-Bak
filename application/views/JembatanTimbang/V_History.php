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
                        <th class="text-center">NO DOKUMEN</th>
                        <th class="text-center">TIKET NUMBER</th>
                        <th class="text-center">BERAT TIMBANG - 1</th>
                        <th class="text-center">BERAT TIMBANG - 2</th>
                        <th class="text-center">SELISIH</th>
                        <th class="text-center">OPERATOR</th>
                        <th class="text-center">TANGGAL CETAK</th>
                        <th class="text-center">BUKTI TIMBANG</th>
                      </tr>
                    </thead>
                    <tbody >
                      <?php foreach ($get as $key => $g): ?>
                        <tr>
                          <td style="text-align:center"><?php echo $key+1 ?></td>
                          <td style="text-align:center"><?php echo $g['document_number'] ?></td>
                          <td style="text-align:center"><?php echo $g['ticket_number'] ?></td>
                          <td style="text-align:center">
                            <?php if (!empty($g['weight']) && empty($g['weight_2'])) { ?>
                              <?php echo empty($g['weight']) ? '-' : $g['weight'].' Kg' ?>
                            <?php }else { ?>
                              <?php echo empty($g['weight_2']) ? '-' : $g['weight_2'].' Kg' ?>
                            <?php } ?>
                          </td>
                          <td style="text-align:center">
                            <?php if (!empty($g['weight']) && empty($g['weight_2'])) { ?>
                              <?php echo empty($g['weight_2']) ? '-' : $g['weight_2'].' Kg' ?>
                            <?php }else { ?>
                              <?php echo empty($g['weight']) ? '-' : $g['weight'].' Kg' ?>
                            <?php } ?>
                          </td>
                          <td style="text-align:center">
                            <?php
                            if (!empty($g['ticket_number'])) {
                              $cek = explode('-', $g['ticket_number']);
                              if ($cek[1] == 'O') {
                                $selisih = $g['weight'] - $g['weight_2'];
                              }else {
                                $selisih = $g['weight_2'] - $g['weight'];
                              }
                            }else {
                              $selisih = '-';
                            }
                            ?>
                            <?php echo $selisih == '-' ? '-' : $selisih.' Kg' ?>
                          </td>
                          <td style="text-align:center"><?php echo $g['operator_name'] ?></td>
                          <td style="text-align:center"><?php echo $g['created_at'] ?></td>
                          <td style="text-align:center">
                             <a href="http://produksi.quick.com/api-jti/out/report/pdf/<?php echo $g['ticket_number'] ?>" target="_blank" type="button" class="btn btn-danger" name="button"> <b class="fa fa-file-pdf-o"></b> </a>
                            <!--<a href="http://192.168.168.196/api-jti-master/out/report/pdf/<?php echo $g['ticket_number'] ?>" target="_blank" type="button" class="btn btn-danger" name="button"> <b class="fa fa-file-pdf-o"></b> </a>-->
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
