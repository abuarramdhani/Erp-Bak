<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;">Tabel Monitoring</h4>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-left " id="tblMonitoringDOCetak" style="font-size:12px;">
              <thead>
                <tr class="bg-primary">
                  <th><center>NO</center></th>
                  <th><center>NOMOR DO</center></th>
                  <th><center>TO SUBINVENTORY CODE</center></th>
                  <th><center>KOTA</center></th>
                  <th><center>RENCANA KIRIM</center></th>
                  <th><center>ACTION</center></th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($get as $g): ?>
                  <tr>
                    <td><center><?php echo $no; ?></center></td>
                    <td><center><?php echo $g['NO_MO'] ?></center></td>
                    <td><center><?php echo $g['TO_SUBINVENTORY_CODE'] ?></center></td>
                    <td><center><?php echo $g['KOTA'] ?></center></td>
                    <td><center><?php echo $g['RENCANA_KIRIM'] ?></center></td>
                    <td>
                      <center>
                        <a href="<?php echo base_url('MonitoringDO/PDF/'.$g['NO_MO']) ?>" target="_blank" onclick="clickCetak(<?php echo $g['NO_MO'] ?>)" class="btn btn-info">Cetak</a>
                      </center>
                    </td>
                  </tr>
                <?php $no++; endforeach; ?>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
