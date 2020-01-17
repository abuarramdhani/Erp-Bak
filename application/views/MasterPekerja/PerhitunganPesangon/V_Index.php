<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b><?php echo $Title;?></b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <!-- Ganti yang di dalam site url dengan alamat main menu yang diinginkan -->
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('MasterPekerja/PerhitunganPesangon');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <a href="<?php echo site_url('MasterPekerja/PerhitunganPesangon/create') ?>" style="float:right;margin-right:1%;margin-top:-0.5%;" alt="Add New" title="Add New" >
                                    <button type="button" class="btn btn-default btn-sm"><i class="icon-plus icon-2x"></i></button>
                                </a>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover text-left" id="tbl" .$new_table_name. "" style="font-size:12px;">
                                        <thead class="bg-primary">
                                            <tr>
                                                <th style="text-align:center;">No</th>
                                                <th style="text-align:center;">Action</th>
                                                <th style="text-align:center;">NoInduk</th>
                                                <th style="text-align:center;">Nama</th>
                                                <th style="text-align:center;">Jabatan Terakhir</th>
                                                <th style="text-align:center;">U.Pesangon</th>
                                                <th style="text-align:center;">U.UPMK</th>
                                                <th style="text-align:center;">Sisa Cuti</th>
                                                <th style="text-align:center;">U.Ganti Rugi</th>
                                                <th style="text-align:center;">Htg Koperasi</th>
                                                <th style="text-align:center;">Htg Perusahaan</th>
                                                <th style="text-align:center;">Lain lain</th>
                                         </thead>

                                        <tbody>
                                              <?php
                                                $no = 1;
                                                foreach($data as $pesangon) :
                                                $encrypted_string = $this->encrypt->encode($pesangon['id_pesangon']);
                                                $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);

                                            ?>
                                            <tr>
                                                <td align='center'><?php echo $no++;?></td>
                                                <td align='center' style="white-space: nowrap;">
                                                    <a data-toggle="modal" data-target="#Modal_Hadirin_Perjanjian" value='<?php echo $pesangon['id_pesangon'] ?>' class="nyobaaja" style="margin-right:4px" data-toggle="tooltip" data-placement="bottom" title="Cetak Perjanjian"><span class="fa fa-print fa-2x"></span></a>
                                                    <a style="margin-right:4px" class="prevSangu" value="<?php echo $encrypted_string ?>" data-toggle="tooltip" data-placement="bottom" title="Preview Cetak"><span class="fa fa-file-pdf-o fa-2x"></span></a>
                                                    <a style="margin-right:4px" href="<?php echo base_url('MasterPekerja/PerhitunganPesangon/update/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Edit Data"><span class="fa fa-pencil-square-o fa-2x"></span></a>
                                                    <a href="<?php echo base_url('MasterPekerja/PerhitunganPesangon/delete/'.$encrypted_string.''); ?>" data-toggle="tooltip" data-placement="bottom" title="Hapus Data" onclick="return confirm('Are you sure you want to delete this item?');"><span class="fa fa-trash fa-2x"></span></a>
                                                </td>
                                                <td><?php echo $pesangon['noinduk'];?></td>
                                                <td><?php echo $pesangon['nama'];?></td>
                                                <td><?php echo $pesangon['jabatan_terakhir'];?></td>
                                                <td><?php echo $pesangon['jml_pesangon'];?></td>
                                                <td><?php echo $pesangon['jml_upmk'];?></td>
                                                <td><?php echo $pesangon['jml_cuti'];?></td>
                                                <td><?php echo $pesangon['uang_ganti_kerugian'];?></td>
                                                <td><?php echo $pesangon['hutang_koperasi'];?></td>
                                                <td><?php echo $pesangon['hutang_perusahaan'];?></td>
                                                <td><?php echo $pesangon['lain_lain'];?></td>
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
</section>

<div class="modal fade" id="Modal_Hadirin_Perjanjian" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document" style="width: 600px">
     <div class="modal-content">
       <form method="POST" action="<?php echo base_url("MasterPekerja/PerhitunganPesangon/getPDF"); ?>" target="_blank">
       <div class="modal-header text-center">
         <button type="button" class="close hover" data-dismiss="modal">&times;</button>
         <h3>Input Data</h3>
       </div>
       <div class="modal-body" style="width: 100%; text-align: center;">
          <div class="row">
            <div class="col-lg-12">
              <input type="text" name="id_sangu" value="" id="id_sangu" hidden>
              <label class="col-lg-12 text-center">Wakil Personalia</label><br>
              <select  class=" col-lg-8 select select2 text-center" name="Wakil_Personalia" id="Wakil_Personalia"  style="width: 55%">
              <option></option>
              <?php foreach ($tertanda as $key) { ?>
                <option <?php if($key['noind'] == 'B0307'){echo "selected";} ?> value="<?php echo $key['nama'] ?>"><?php echo $key['noind']." - ".$key['nama'] ?></option>
              <?php } ?>
              </select>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-12 text-center">Wakil SPSI</label><br>
              <select  class="form-control col-lg-8 select select2 text-center" name="Wakil_SPSI" id="Wakil_SPSI"  style="width: 55%">
              <option></option>
              <?php foreach ($tertanda as $key) { ?>
                <option <?php if($key['noind'] == 'B0242'){echo "selected";} ?> value="<?php echo $key['nama'] ?>"><?php echo $key['noind']." - ".$key['nama'] ?></option>
              <?php } ?>
              </select>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-12 text-center">Saksi 1</label><br>
              <select  class="form-control col-lg-8 select select2 text-center" name="Saksi_Janji1" id="Saksi_Janji1"  style="width: 55%" required>
              <option></option>
              <?php foreach ($tertanda as $key) { ?>
                <option value="<?php echo $key['nama'] ?>"><?php echo $key['noind']." - ".$key['nama'] ?></option>
              <?php } ?>
              </select>
            </div>
          </div>
          <br>
          <div class="row">
            <div class="col-lg-12">
              <label class="col-lg-12 text-center">Saksi 2</label><br>
              <select  class="form-control col-lg-8 select select2 text-center" name="Saksi_Janji2" id="Saksi_Janji2"  style="width: 55%">
              <option></option>
              <?php foreach ($tertanda as $key) { ?>
                <option value="<?php echo $key['nama'] ?>"><?php echo $key['noind']." - ".$key['nama'] ?></option>
              <?php } ?>
              </select>
            </div>
          </div>
        </div>
       <div class="modal-footer" style="text-align: center;">
         <button type="submit" class="btn btn-success" id="perjanjianPHK">Cetak</button>
       </div>
       </form>
     </div>
   </div>
 </div>
 <input type="hidden" id="id_modal_cetak_sangu" value="<?php echo site_url('MasterPekerja/PerhitunganPesangon/'); ?>">

 <div class="modal fade" id="Modal_Tertanda_Pesangon" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 600px">
      <div class="modal-content">
        <form method="POST" action="<?php echo base_url("MasterPekerja/PerhitunganPesangon/previewcetak"); ?>" target="_blank">
        <div class="modal-header text-center">
          <button type="button" class="close hover" data-dismiss="modal">&times;</button>
          <h3>Input Data</h3>
        </div>
        <div class="modal-body" style="width: 100%; text-align: center;">
           <div class="row">
             <div class="col-lg-12">
                <input type="text" name="id_prev_sangu" id="id_prev_sangu" hidden>
               <label class="col-lg-12 text-center">Approver 1</label><br>
               <select  class=" col-lg-8 select select2 text-center" name="Psg_approver1" id="Psg_approver1"  style="width: 55%">
               <option></option>
               <?php foreach ($tertanda as $key) { ?>
                 <option value="<?= $key['noind'] ?>"><?php echo $key['noind']." - ".$key['nama'] ?></option>
               <?php } ?>
               </select>
             </div>
           </div>
           <br>
           <div class="row">
             <div class="col-lg-12">
               <label class="col-lg-12 text-center">Approver 2</label><br>
               <select  class="form-control col-lg-8 select select2 text-center" name="Psg_approver2" id="Psg_approver2"  style="width: 55%">
               <option></option>
               <?php foreach ($tertanda as $key) { ?>
                 <option <?php if($key['noind'] == 'J1269'){echo "selected";} ?> value="<?php echo $key['noind'] ?>"><?php echo $key['noind']." - ".$key['nama'] ?></option>
               <?php } ?>
           </select>
             </div>
           </div>
           <br>
           <div class="row">
             <div class="col-lg-12">
               <label class="col-lg-12 text-center">Tanggal Cetak</label><br>
               <input class="form-control col-lg-8 text-center" style="margin-left: 23%; width: 55%; text-align: center;" name="psg_tglCetak" id="psg_tglCetak" value="">
             </div>
           </div>
         </div>
        <div class="modal-footer" style="text-align: center;">
          <button type="submit" class="btn btn-success" id="prev_Pesangon">Cetak</button>
        </div>
        </form>
      </div>
    </div>
  </div>
