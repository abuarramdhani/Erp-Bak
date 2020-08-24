<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-hourglass-3"></i> History Running Time Line PnP</h4>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12" style="margin-top:10px">
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left line5wipp detailHistory_rtlp" style="font-size:11px;">
                    <thead>
                      <tr class="bg-info">
                        <th class="text-center">No</th>
                        <th class="text-center">No Job</th>
                        <th class="text-center">Kode Ttem</th>
												<th class="text-center">Nama Barang</th>
												<th class="text-center">Lane</th>
												<th class="text-center">Tanggal</th>
												<th class="text-center">Waktu Mulai</th>
                        <th class="text-center">Waktu Selesai</th>
                        <th class="text-center">Lama Waktu</th>
                        <th class="text-center">Waktu Jeda</th>
                      </tr>
                    </thead>
                    <tbody >
                      <?php foreach ($get as $key => $g): ?>
                      <tr row-pause="<?php echo $key+1 ?>">
                        <td class="text-center"><?php echo $key+1 ?></td>
                        <td class="text-center"><?php echo $g['No_Job'] ?></td>
                        <td class="text-center"><?php echo $g['Komponen'] ?></td>
                        <td class="text-center"><?php echo $g['Nama_Komponen'] ?></td>
                        <td class="text-center"><?php echo $g['Line'] ?></td>
                        <td class="text-center"><?php echo $g['Tanggal'] ?></td>
                        <td class="text-center"><?php echo $g['Start'] ?></td>
                        <td class="text-center"><?php echo $g['Finish'] ?></td>
                        <td class="text-center"><?php echo $g['Time'] ?></td>
                        <td class="text-center">
                          <button type="button" class="btn btn-sm bg-navy" onclick="detail_pause('<?php echo $g['No_Job'] ?>', '<?php echo $g['Line'] ?>', <?php echo $key+1 ?>)" style="border-radius:5px;padding:5px;margin-top:0;" name="button"><i class="fa fa-eye"></i> Detail</button>
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
