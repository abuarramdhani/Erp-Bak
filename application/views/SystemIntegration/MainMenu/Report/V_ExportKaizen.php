<section class="content">
  <div class="box box-default color-palette-box">
  
  <div class="row">

  
   <!-- left column -->
        <div class="col-md-12">
<form method="POST" action="<?= base_url('SystemIntegration/KaizenGenerator/Report/findexport') ?>">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header ">
              <h3 class="box-title">Export Kaizen</h3>
            </div>
              <div class="col-lg-12">
                 <div class="form-group" style="margin-top: 10px">
                    <label>Pilih Rentang Waktu Pelaporan</label>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="box-body">
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Tanggal Awal</label>
                          <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" <?= isset($start) ? "value='".date('m/d/Y', strtotime($start))."'" : '' ?> class="form-control pull-right" id="txtStartDateSI" name="txtStartDate" placeholder="Start Date..">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                        <div class="form-group">
                          <label>Tanggal Akhir</label>
                          <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" <?= isset($end) ? "value='".date('m/d/Y', strtotime($end))."'" : '' ?> class="form-control pull-right" id="txtEndDateSI" name="txtEndDate" placeholder="End Date..">
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-3">
                       <button type="submit" class="btn btn-primary" style="margin-top: 25px" ><i class="fa fa-search" ></i> <b>Find</b></button>
                      </div>
                    </div>
                  </div>
               </div>
          </div>
                 
</form>
<div class="col-md-12" style="margin-top: 20px">
<?php if (isset($find)) { ?>
  <table class="table table-bordered table-striped dataTable-pekerja" id="tblKaizen">
    <thead>
      <tr class="bg-blue">
        <th width="5%">No.</th>
        <th width="10%">Nomor Kaizen</th>
        <th width="30%">Judul</th>
        <th width="20%">Creator</th>
        <th width="17%">Departemen</th>
        <!-- <th width="12%">Tanggal Lapor</th> -->
        <th width="6%"></th>
      </tr>
    </thead>
    <tbody>
      <?php $no= 1; foreach ($find as $list) {?>
        <tr>
          <td><?php echo $no++; ?></td>
          <td><?php echo $list['no_kaizen']; ?></td>
          <td><?php echo $list['judul']; ?></td>
          <td><?php echo $list['pencetus']; ?></td>
          <td><?php echo $list['department_name']; ?></td>
          <!-- <td><?php echo date('Y-m-d',strtotime($list['lapor_date'])); ?></td> -->
          <td>
            <center>
            <a class="btn btn-sm btn-danger" target="_blank" href="<?php echo base_url('SystemIntegration/KaizenGenerator/Pdf/'.$list['kaizen_id']); ?>"><i class="fa fa-file-pdf-o"></i></a>
            </center>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
<form method="POST" action="<?= base_url('SystemIntegration/KaizenGenerator/Report/exportExcelKaizen') ?>">
  <input type="hidden" name="txtStartDate" value="<?= $start ?>">
  <input type="hidden" name="txtEndDate" value="<?= $end ?>">
  <button style="margin-bottom: 20px" class="btn btn-success "> <i class="fa fa-file-excel-o"></i> Export</button>
</form>
<?php } ?>
</div>
</div>
  </div>
  </div>
</section>
