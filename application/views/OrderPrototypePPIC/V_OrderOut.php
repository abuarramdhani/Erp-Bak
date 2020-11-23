<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <center><h4 style="font-weight:bold;"><i class="fa fa-hourglass-3"></i> Order Keluar Prototype</h4></center>
        </div>
        <div class="box-body" style="background:#f0f0f0;">
          <div class="row">
            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff; border-radius:7px;margin-bottom:15px;">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left opp_monitoring" style="font-size:11px;">
                    <thead>
                      <tr class="bg-primary">
                        <th class="text-center">NO</th>
                        <th class="text-center">KODE KOMPONEN</th>
                        <th class="text-center">NAMA KOMPONEN</th>
                        <th class="text-center">PROSES</th>
                        <th class="text-center">SEKSI</th>
                        <th class="text-center">QTY</th>
                        <th class="text-center">NO ORDER</th>
                        <th class="text-center">PENERIMA</th>
                        <th class="text-center">AKSI</th>
                      </tr>
                    </thead>
                    <tbody >
                      <?php foreach ($get as $key => $val) {?>
                        <tr>
                          <td><?php echo $key+1 ?></td>
                          <td><?php echo $val['kode_komponen'] ?></td>
                          <td><?php echo $val['nama_komponen'] ?></td>
                          <td><?php echo $val['proses'] ?></td>
                          <td><?php echo $val['seksi'] ?></td>
                          <td><?php echo $val['qty'] ?></td>
                          <td><?php echo $val['no_order'] ?></td>
                          <td>-</td>
                          <td style="text-align:center">
                            -
                            <!-- <button type="button" class="btn btn-sm btn-success" name="button"> <i class="fa fa-pencil"></i> </button> -->
                           </td>
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
  </div>
</div>
