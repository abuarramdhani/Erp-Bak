<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-cloud-upload"></i> Monitoring Job Release</h4>
        </div>

        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;">
                <div class="table-responsive" style="background:rgba(255, 255, 255, 1);padding:5px;border-radius:5px;">
                  <table class="table table-striped table-bordered table-hover text-left tblwiip" style="font-size:12px;">
                    <thead>
                      <tr class="bg-success">
                        <th><center>NO</center></th>
                        <th>NO JOB</th>
                        <th>KODE ITEM</th>
                        <th>NAMA ITEM</th>
                        <th>QTY</th>
                        <th>USAGE RATE</th>
                        <th>ONHAND YSP</th>
                        <th >SCHEDULED START DATE </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; foreach ($get as $key => $g): ?>
                        <?php
                          // if ($g['PRIORITY'] == 1) {
                          //   $style = 'style="background:rgba(35, 224, 150, 0.35)"';
                          // }else {
                          //   $style = '';
                          // }
                          $style = '';
                         ?>
                        <tr row-code-item = "<?php echo $no ?>_<?php echo $g['KODE_ASSY'] ?>" >
                          <td <?php echo $style ?>><?php echo $no ?></td>
                          <td <?php echo $style ?>><?php echo $g['NO_JOB'] ?></td>
                          <td <?php echo $style ?>><?php echo $g['KODE_ASSY'] ?></td>
                          <td <?php echo $style ?>><?php echo $g['DESCRIPTION'] ?></td>
                          <td <?php echo $style ?>><?php echo $g['START_QUANTITY'] ?></center></td>
                          <td <?php echo $style ?>><?php echo abs($g['USAGE_RATE_OR_AMOUNT']) ?></td>
                          <td <?php echo $style ?>><?php echo $g['ONHAND_YSP'] ?></td>
                          <td <?php echo $style ?>><?php echo $g['SCHEDULED_START_DATE'] ?></center></td>
                        </tr>
                      <?php $no++; endforeach; ?>
                    </tbody>
                  </table>
                  <br>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
