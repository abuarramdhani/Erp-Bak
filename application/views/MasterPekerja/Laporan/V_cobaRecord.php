<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3>Rekap Data</h3>
        </div> 
        <div class="panel-body">
          <h3 class="text-center text-primary">Tahap I</h3>
          <div class="form-group" >
            <button class="btn btn-default pull-right text-muted" ><a href="<?php echo base_url('MasterPekerja/KecelakaanKerja/input') ?>">Add</a></button>
          </div>
          <br><br>
          <div class="form-group" style="overflow-x:auto;">
            <table class="table table-bordered table-hover" id="tbl_lkkk_1">
              <thead>
                <tr class="info">
                  <th class="text-center">No</th> 
                  <th class="text-center">Kode Mitra</th>
                  <th class="text-center">No Induk</th>
                  <th class="text-center">Nama</th>                   
                  <th class="text-center">Tanggal Kecelakaan</th>
                  <th class="text-center">Akibat yang Diderita</th>                  
                  <!-- <th class="text-center">Kejadian</th> -->
                  <th class="text-center">Process</th>
                </tr>
              </thead>
              <tbody id="show_data">
                <?php
                  $no=1;
                  foreach ($dataRekap as $row) {
                     $id_lkk_1 = $row['id_lkk_1'];
                ?>
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h3>Menu Tahap II</h3>
                      </div>
                      <div class="modal-body">
                        <h4 style="vertical-align: middle;">Pilih menu yang Anda butuhkan !</h4>
                      </div>
                      <div class="modal-footer">
                        <a id="modal-insertTahap2" class="btn btn-primary">INSERT</a>
                        <a id="modal-editTahap2" class="btn btn-warning">EDIT</a>
                        <a target="_blank" id="modal-printTahap2" class="btn btn-success">PRINT</a>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Modal-End-->
                <tr>
                  <td><?php echo $no ?></td>
                  <td><?php echo $row["kode_mitra"]; ?></td>
                  <td><?php echo $row["noind"]; ?></td>
                  <td><?php echo $row["nama"]; ?></td>
                  <td><?php echo $row["tgl_kk"]; ?></td>
                  <td><?php echo $row["akibat_diderita"]; ?></td>
                  <!-- <td><?php echo $row["desc"] ?></td> -->
                  <td style="text-align:right;">
                  <a target="_blank" href="<?php echo base_url('MasterPekerja/KecelakaanKerja/printKecelakaan'.'/'.$id_lkk_1); ?>" class="btn btn-success btn-xs" data="">Print</a> 
                   <!--  <a href="<?php echo base_url('MasterPekerja/KecelakaanKerja/nextKecelakaan'.'/'.$id_lkk_1); ?>" class="btn btn-info btn-xs" data="">Next</a>  -->
                  <a class="btn btn-warning btn-xs" href="<?php echo base_url('MasterPekerja/KecelakaanKerja/editTahap1'.'/'.$id_lkk_1) ?>">Edit</a>
                  <a class="btn btn-info btn-xs" data-toggle="modal" data-target="#exampleModal" data-next-id="<?php echo $id_lkk_1; ?>">Next</a>  
                  </td>
                </tr>
               
                <?php
                    $no++;
                   } 
                ?>
              </tbody> 
            </table>
          </div>
          
        </div>        
      </div>  
    </div>      
  </section>
  <!-- sementara js e tak dekek kene sek -->


 </body>