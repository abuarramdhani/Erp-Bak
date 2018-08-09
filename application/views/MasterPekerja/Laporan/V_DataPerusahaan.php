<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 >Data Perusahaan</h3>
        </div>
        <div class="panel-body">
          <div class="form-group" >
            <button class="btn btn-default pull-right text-muted" ><a href="<?php echo base_url('MasterPekerja/SettingKecelakaanKerja/inputPerusahaan') ?>">Add</a></button>
          </div>
          <br><br>
          <div class="form-group" style="overflow-x:auto;">
            <table class="table table-bordered table-hover" id="tbl_perusahaan">
              <thead>
                <tr class="info">
                  <th class="text-center">No</th>
                  <th class="text-center">Nama Perusahaan</th>
                  <th class="text-center">Kode Mitra</th>
                  <th class="text-center">Alamat</th>
                  <th class="text-center">No Telp</th>
                  <th class="text-center">Contact Person</th> 
                  <th class="text-center">Keterangan</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="show_dataPerusahaan">
                <?php 
                  $no=1; 
                  foreach ($data_Perusahan as $row) {
                    $id_perusahaan  = $this->general->enkripsi($row['id_perusahaan']);
                ?>
                <tr>
                  <td><?php echo $no ?></td>
                  <td><?php echo $row["nama_perusahaan"]; ?></td>
                  <td><?php echo $row["kode_mitra"]; ?></td>
                  <td><?php echo $row["alamat"]; ?>, Desa <?php echo $row["desa"]; ?>, Kecamatan <?php echo $row["kecamatan"]; ?>, Kota <?php echo $row["kota"]; ?></td>
                  <td><?php echo $row["no_telp"]; ?></td>
                  <td><?php echo $row["contact_person"]; ?></td>
                  <td><?php echo $row["keterangan"]; ?></td>
                  <td style="text-align:right;">
                    <a href="<?php echo base_url('MasterPekerja/SettingKecelakaanKerja/editPerusahaan'.'/'.$id_perusahaan); ?>" class="btn btn-info btn-xs" data="">Edit</a> 
                    <a href="<?php echo base_url('MasterPekerja/SettingKecelakaanKerja/deletePerusahaan'.'/'.$id_perusahaan); ?>" class="btn btn-danger btn-xs" data="">Hapus</a>
                  </td>
                </tr>
                <?php $no++;    }?>
              </tbody>
            </table>
          </div>
          
        </div>        
      </div>  
    </div>      
  </section>
 </body>