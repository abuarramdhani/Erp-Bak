<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h3 style="font-weight:bold;float:left;margin:0"><i class="fa fa-edit"></i> <?= $Title?>
                <span class="sr-only"> </span></h3>
              </div>
              <div class="box-body">
                <div class="row">
                <form method="post" enctype="multipart/form-data" action="<?php echo base_url("OrderHandling/InputOrder/save_input_order") ?>">
                <div class="col-md-12">
                  <div class="panel-body" >
                    <div class="col-md-4 text-right"><label>Jenis order :</label></div>
                    <div class="col-md-5">
                        <select id="jenis_order_handling" name="jenis_order" class="form-control select2" style="width:100%" data-placeholder="pilih jenis order" required>
                            <option></option>
                            <option value="1">Pembuatan Sarana Handling</option>
                            <option value="2">Repair Sarana Handling</option>
                            <option value="3">Perusakan Komponen Reject</option>
                        </select>
                    </div>
                  </div>
                  <div class="panel-body">
                    <div class="col-md-4 text-right"><label>Jenis sarana handling :</label></div>
                    <div class="col-md-5">
                        <select id="sarana_handling" name="sarana_handling" class="form-control select2" style="width:100%" data-placeholder="pilih jenis sarana handling" required>
                            <option></option>
                        </select>
                    </div>
                  </div>
                  <div class="panel-body ifsarana" style="display:none">
                    <div class="col-md-4 text-right"><label>Nama Handling :</label></div>
                    <div class="col-md-5" id="nm_handling">
                        <!-- <input id="nama_handling" name="nama_handling" class="form-control" placeholder="nama handling" autocomplete="off"> -->
                    </div>
                  </div>
                  <div class="panel-body ifsaranabaru" style="display:none">
                    <div class="col-md-4 text-right"><label>Gambar :</label></div>
                    <div class="col-md-5">
                        <input type="file" id="file_design" name="file_design" class="form-control" accept=".jpg, .jpeg, .png">
                    </div>
                  </div>
                  <div class="panel-body" >
                    <div class="col-md-4 text-right"><label>Jumlah yang diorder :</label></div>
                    <div class="col-md-5">
                        <input type="number" id="jumlah_order" name="jumlah_order" class="form-control" placeholder="masukkan jumlah order" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="panel-body" >
                    <div class="col-md-4 text-right"><label>Due date :</label></div>
                    <div class="col-md-5">
                        <input id="due_date" name="due_date" class="form-control oth_datepicker" placeholder="masukkan due date order" autocomplete="off" required>
                    </div>
                  </div>
                  <div class="panel-body" >
                    <div class="col-md-4 text-right"><label>Alasan dan tujuan order :</label></div>
                    <div class="col-md-5">
                        <textarea id="alasan_order" name="alasan_order" class="form-control" placeholder="masukkan alasan dan tujuan order" required></textarea>
                    </div>
                  </div>
                  <div class="panel-body text-center">
                    <button class="btn btn-success" style="width:100px">Submit</button>
                  </div>
                </div>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
