<body class="hold-transition login-page">
  <section class="content">
    <div class="panel-group">
      <div class="panel panel-primary">
        <div class="panel-heading">
          <h3 style="text-align: right;">Cetak Tanda Terima BPJS</h3>
        </div>
        <div class="panel-body">
          <div class="form-group" >
            <button class="btn btn-success pull-left"><a style="color: white" href="<?php echo base_url('MasterPekerja/TanTerBPJS/export_excel')?>">Export Excel</a></button>
            <button class="btn btn-default pull-right text-muted" ><a class="text-muted" data-toggle="modal" data-target="#modalCetakBPJS">Tambah Nama</a></button>
          </div>
          <br>
          <div>
            <table id="tbl_datacetak" class="table table-hover table-bordered table-responsive">
              <thead>
                <tr>
                  <th style="text-align: center;">No</th>
                  <th style="text-align: center;">No Induk</th>
                  <th style="text-align: center;">Nama</th>
                  <th style="text-align: center;">Seksi</th>
                  <th style="text-align: center;">No KPJ</th>
                  <th style="text-align: center;">No JP</th>
                  <th style="text-align: center;">Lokasi</th>
                  <th style="text-align: center;">Hapus</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no=1;
                foreach ($data as $key ) {
                  $id = $key['id_cetaktanterbpjs']
                  ?>
                  <tr>
                    <td align="center"><?php echo $no;?></td>
                    <td><?php echo $key['noind']?></td>
                    <td><?php echo $key['nama']?></td>
                    <td align="center"><?php echo $key['seksi']?></td>
                    <td><?php echo $key['no_kpj']?></td>
                    <td><?php echo $key['jp']?></td>
                    <td><?php echo $key['lokasi']?></td>
                    <td align="center"><a href="<?php echo base_url('MasterPekerja/TanTerBPJS/delete'.'/'.$id);?>"><span class="glyphicon glyphicon-trash"></span></a></td>
                  </tr>
                  <?php
                  $no++;
                }

                ?>
              </tbody>
            </table>
          </div>
         <!-- Modal -->
         <div class="modal fade" id="modalCetakBPJS" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog" role="document">
             <div class="modal-content">
               <div class="modal-header">
                 <h3>Masukan Pekerja</h3>
               </div>
               <div class="modal-body">
               <form method="POST" action="<?php echo base_url('MasterPekerja/TanTerBPJS/insert');?>">
                 <select name="tt_noind" id="cetaktanterbpjs-pekerja_bpjs" class="form-control" style="width: 100%" required="required">
                   
                 </select>
                 <br><br>
                 <button type="submit" class="btn btn-default">Tambahkan</button>
                </form>
               </div>
               <div class="modal-footer">
                 
               </div>
             </div>
           </div>
         </div>
         <!-- Modal-End-->          
        </div>        
      </div>  
    </div>      
  </section>
 </body>