<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-hourglass-3"></i> MO Terlambat Transact</h4>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left history_mtt" style="font-size:11px;">
                    <thead>
                      <tr class="bg-primary">
                        <th class="text-center" rowspan="2" style="vertical-align:middle">No</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle">No MO</th>
                        <th class="text-center" colspan="2">Creation</th>
												<th class="text-center" colspan="2">Delivery</th>
												<th class="text-center" rowspan="2" style="vertical-align:middle">Lama Keterlambatan</th>
												<th class="text-center" rowspan="2" style="vertical-align:middle">Received By</th>
												<th class="text-center" colspan="2">From</th>
                        <th class="text-center" colspan="2">Item</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle">Qty</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle">Delivered</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle">Status</th>
                        <th class="text-center" rowspan="2" style="vertical-align:middle">Aksi</th>
                        <!-- Alasan terlambat -->
                      </tr>
                      <tr class="bg-primary">
                        <th class="text-center" style="border-top:0px;">Date</th>
                        <th class="text-center" style="border-top:0px;">Time</th>
                        <th class="text-center" style="border-top:0px;">Date</th>
                        <th class="text-center" style="border-top:0px;">Time</th>
                        <th class="text-center" style="border-top:0px;">SubInv</th>
                        <th class="text-center" style="border-top:0px;">Locator</th>
                        <th class="text-center" style="border-top:0px;">Code</th>
                        <th class="text-center" style="border-top:0px;border-right: 1px solid white;">Description</th>
                      </tr>
                    </thead>
                    <tbody >
                      <?php foreach ($get as $key => $g): ?>
                      <tr data-mtt="<?php echo $g['LINE_ID'] ?>">
                        <td class="text-center"><?php echo $key+1 ?></td>
                        <td class="text-center"><?php echo $g['REQUEST_NUMBER'] ?></td>
                        <td class="text-center"><?php echo $g['CREATION_DATE'] ?></td>
                        <td class="text-center"><?php echo $g['WAKTU'] ?></td>
                        <td class="text-center" style="color:#d63737;"><?php echo $g['DELIVERY_DATE'] ?></td>
                        <td class="text-center" style="color:#d63737;"><?php echo $g['DELIVERY_TIME'] ?></td>
                        <td class="text-center" style="color:#d63737;"><?php echo $g['DURASI'] ?></td>
                        <td class="text-center"><?php echo $g['RECEIVED_BY'] ?></td>
                        <td class="text-center"><?php echo $g['FROM_SUBINVENTORY_CODE'] ?></td>
                        <td class="text-center"><?php echo $g['FROM_LOCATOR'] ?></td>
                        <td class="text-center"><?php echo $g['SEGMENT1'] ?></td>
                        <td class="text-center"><?php echo $g['DESCRIPTION'] ?></td>
                        <td class="text-center"><?php echo $g['QUANTITY'] ?></td>
                        <td class="text-center"><?php echo $g['QUANTITY_DELIVERED'] ?></td>
                        <td class="text-center"><?php echo $g['STATUS'] ?></td>
                        <td class="text-center">
                          <button type="button" class="btn btn-sm bg-navy" onclick="detail('<?php echo $g['LINE_ID'] ?>', '<?php echo $g['ALASAN'] ?>')" style="border-radius:5px;padding:5px;margin-top:0;" name="button"><i class="fa fa-cube"></i> Alasan Keterlambatan</button>
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
