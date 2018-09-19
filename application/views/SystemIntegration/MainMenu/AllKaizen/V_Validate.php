<section class="content">
  <div class="box box-default color-palette-box">
  
  <div class="row">

  
   <!-- left column -->
        <div class="col-md-12">
<form method="POST" action="<?= base_url('SystemIntegration/KaizenGenerator/Validate/findKaizen') ?>">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header ">
              <h3 class="box-title">Validate Kaizen</h3>
            </div>
              <div class="col-lg-12">
                 <div class="form-group" style="margin-top: 10px">
                    <label>Masukkan Nomor Kaizen.. </label>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="box-body">
                    <div class="row">
                      <div class="col-lg-3">
                        <div class="form-group">
                          <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-search"></i></div>
                            <input type="text" class="form-control pull-right" id="" name="txtNoKaizen" placeholder="Nomor Kaizen..">
                          </div>
                        </div>
                      </div>
              
                      <div class="col-lg-3">
                       <button type="submit" class="btn btn-primary" ><i class="fa fa-search" ></i> <b>Find</b></button>
                      </div>
                    </div>
                  </div>
               </div>
          </div>
                 
</form>
<div class="col-md-12" style="margin-top: 20px">
<?php if (isset($find)) { ?>
  <table class="table table-bordered table-striped" id="tblKaizen">
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
            <a class="btn btn-sm btn-danger" href="<?php echo base_url('SystemIntegration/KaizenGenerator/View/'.$list['kaizen_id']); ?>"><i class="fa fa-file-pdf-o"></i></a>
            </center>
          </td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
<?php } ?>
</div>
</div>
  </div>
  </div>
</section>
