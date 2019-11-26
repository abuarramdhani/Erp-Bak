<?php if(!empty($this->session->flashdata('pesan'))): ?>
  <script type="text/javascript">
    $(document).ready(function(){
      Swal.fire('Error','Tidak Ada Data','error');
    })
  </script>
<?php endif; ?>
<style type="text/css">
  .modal1 {
  position: fixed;
  left: 0px;
  top: 0px;
  width: 100%;
  height: 100%;
  z-index: 9999;
  opacity: 0.8;
  display: none;
  background: url(<?php echo base_url('assets/img/gif/loadingtwo.gif'); ?>) 
              50% 50% no-repeat rgba(1,1,1,1);
}
</style>
<section class="content">
  <div class="modal1"></div>
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <div class="text-right"><h1> <b>Export Data Pekerja Masuk</b></h1></div>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="panel box-body">
                <form method="post" id="formExport">
                <div class="row">
                   <div class="col-lg-12" style="padding-top: 20px;">
                        <div class="col-lg-3">
                          
                        </div>
                        <div align="center" class="col-lg-1 text-center" style="height: 100%;">
                          <b>Petugas</b> 
                        </div>
                        <div class="form-group col-lg-4">
                          <select class="form-control slc-petugas-hubker" name="petugas">
                          <option selected="true" value="<?php if(!empty($petugas)){echo $petugas;} ?>"><?php if(!empty($petugas)){echo $petugas;} ?></option>
                          </select>
                        </div>                    
                   </div>
                </div>
                <div class="row">
                   <div class="col-lg-12" style="padding-top: 20px;">
                        <div class="col-lg-3">
                          
                        </div>
                        <div align="center" class="col-lg-1 text-center" style="height: 100%;">
                          <b>Lokasi Kerja</b> 
                        </div>
                        <div class="form-group col-lg-4">
                          <select class="form-control slc-lokasi-kerja-mp" name="lokasi">
                          <option selected="true" value="<?php if(!empty($slclokasi)){echo $slclokasi;} ?>"><?php if(!empty($slclokasi)){echo $slclokasi;} ?></option>
                          </select>
                        </div>                    
                   </div>
                </div>
                <div class="row">
                   <div class="col-lg-12" style="padding-top: 20px;">
                        <div class="col-lg-3">
                          
                        </div>
                        <div align="center" class="col-lg-1 text-center" style="height: 100%;">
                          <b>Periode</b> 
                      </div>
                      <div class="col-lg-4">
                        <input placeholder="Periode" type="text" name="periode" class="form-control" value="<?php if(!empty($periode)){echo $periode;} ?>" />
                      </div>
                      
                   </div>
                </div>

                <div class="row">
                   <div class="col-lg-12" style="padding-top: 20px;">
                      <div class="col-lg-8" align="right">
                          <button class="btn btn-primary btn-previewMasuk" type="submit"><i class="fa fa-eye"></i>&nbsp;Preview</button>
                          <button class="btn btn-success btn-excel" type="submit"><i class="fa fa-file-excel-o"></i>&nbsp;Excel</button>
                      </div>
                      
                   </div>
                </div>

                  
                  </form> 
                   </div>
            </div>    
        </div>

      <?php if(!empty($dataPekerja)): ?>
        <div class="row">
          <div class="col-lg-12">
            <div class="panel box-body">
              <div class="row">
                <div class="col-lg-12">
                  <h4><b>Data Pekerja Masuk CV. Karya Hidup Sentosa</b></h4>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <h4 style="font-weight: bold">Bulan <?= $bulan; ?></h4>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-12">
                  <h4  style="font-weight: bold">Lokasi Kerja <?= ucwords(strtolower($lokasi)); ?></h4>
                </div>
              </div>
              
              
                <div class="table-responsive">
                  <table id="tbl_datapkjmasuk" class="table table-striped table-bordered table-hover">
                    <thead style="background-color:  #85c1e9;">
                      <tr>
                        <th>No</th>
                        <th>No Induk</th>
                        <th>Nama</th>
                        <th>Tgl.Masuk</th>
                        <th>Alamat</th>
                        <th>Desa</th>
                        <th>Kecamatan</th>
                        <th>Kabupaten</th>
                        <th>Propinsi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no=0;foreach($dataPekerja as $data): $no++; ?>
                      <tr>
                        <td><?= $no ?></td>
                        <td><?= $data->noind ?></td>
                        <td><?= rtrim($data->nama) ?></td>
                        <td><?= date('Y-m-d',strtotime($data->masukkerja)) ?></td>
                        <td><?= rtrim($data->alamat) ?></td>
                        <td><?= rtrim($data->desa) ?></td>
                        <td><?= rtrim($data->kec) ?></td>
                        <td><?= rtrim($data->kab) ?></td>
                        <td><?= rtrim($data->prop) ?></td>
                      </tr>
                    <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
      <?php endif; ?>  
    </div>
</section> 

<script type="text/javascript">
$(document).ready(function(){

  $('input[name="periode"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });

  $('input[name="periode"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
  });

  $('input[name="periode"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

  $(".btn-excel").on('click',function(){
    $("#formExport").attr('action','<?php echo base_url('MasterPekerja/CetakPekerjaMasuk/exportExcel'); ?>');
    $("#formExport").submit()
  });

  $(".btn-previewMasuk").on('click',function(){
    $('.modal1').show();    
    setTimeout(function(){
      $('.modal1').hide();
    },3000);
    $("#formExport").attr('action','<?php echo base_url('MasterPekerja/CetakPekerjaMasuk/preview'); ?>');
    $("#formExport").submit();
  });
    
      
});
</script>        