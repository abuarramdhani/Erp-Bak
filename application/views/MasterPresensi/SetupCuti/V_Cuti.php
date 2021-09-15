<style type="text/css">
   .flex {
      display: flex;
      align-items: center;
   }


   .input-wrapper {
      width: 100%;
      display: flex;
      align-items: center;
      justify-content: start;
   }

   .input-wrapper>input {
      border-radius: .8rem;
   }

   .btn-container>button {
      width: 10rem;
      height: 4rem;
      border-radius: .8rem;
   }

   html {
      scroll-behavior: smooth;
   }

   .cuti-item>td {
      cursor: default;
   }

   .cuti-item>td::selection {
      background: none;
   }

   @keyframes updated {
      from {
         background: none;
         color: '#000';
      }

      to {
         background: '#337ab7';
         color: '#fff';
      }
   }

   .dataTables_info {
      display: none;
   }

   .inserted,
   .updated {
      opacity: 0;
   }
</style>

<section class="content">
   <div class="inner">
      <div class="row">
         <div class="col-lg-12">
            <div class="row">
               <div class="col-lg-12">
                  <div class="col-lg-11">
                     <div class="text-right">
                        <h1>
                           <b>
                              <?= $Title ?>
                           </b>
                        </h1>
                     </div>
                  </div>
                  <div class="col-lg-1">
                     <div class="text-right hidden-md hidden-sm hidden-xs">
                        <a href="" class="btn btn-default btn-lg"><i class="icon-wrench icon-2x"></i></a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-lg-12">
                  <div class="box box-primary box-solid">
                     <div class="box-header with-border" style="height: 4rem;"></div>
                     <div class="box-body">
                        <!-- Input Section -->
                        <section class="input-container" style="width: 100%; display:flex;flex-direction:column;align-items:center">
                           <div class="input-item flex" style="width: 50%; margin:1rem 0rem;">
                              <label for="" style="width: 15rem;">Kode Cuti</label>
                              <div class="input-wrapper">
                                 <input maxLength="3" style="width:10rem" type="text" class="form-control" disabled>
                              </div>
                           </div>
                           <div class="input-item flex" style="width: 50%; margin:1rem 0rem;">
                              <label for="" style="width: 15rem;">Nama Cuti</label>
                              <div class="input-wrapper">
                                 <input maxLength="20" style="width:80%" type="text" class="form-control" disabled>
                              </div>
                           </div>
                           <div class="input-item flex" style="width: 50%; margin:1rem 0rem;">
                              <label for="" style="width: 15rem;">Maksimal Hari</label>
                              <div class="input-wrapper">
                                 <input min="1" style="width:10rem" type="number" class="form-control" disabled>
                              </div>
                           </div>
                        </section>

                        <!-- Button Section -->
                        <section id="btnContainerCuti" class="btn-container flex" style="padding-top:3rem; width: 70%; margin:auto; justify-content:space-around;">
                           <button class="btn btn-primary" data-action="0">Tambah</button>
                           <button class="btn btn-success" disabled>Edit</button>
                           <button class="btn btn-warning" style="padding: 0;"><a class="flex" style="color:white; width:100%; height:100%; justify-content:center" href="<?= base_url('MasterPresensi/SetupCuti/ExportPdf') ?>">Cetak</a></button>
                           <button class="btn btn-danger" data-action="0" disabled>Hapus</button>
                           <!-- <button id="scroll" class="btn btn-default">Scroll</button> -->
                        </section>

                        <!-- Table Section -->
                        <section class="table" style="margin: 3rem auto 0rem auto; width:70%;">
                           <table id="table-cuti" class="table table-bordered table-hover table-striped">
                              <thead>
                                 <tr>
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama Cuti</th>
                                    <th>Max Hari</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php $index = 1; ?>
                                 <?php foreach ($cuti as $cuti) : ?>
                                    <tr id="<?= $index ?>" class="cuti-item <?= str_replace(' ', '', $cuti->kd_cuti . $cuti->nama_cuti) ?>">
                                       <td class="no"><?= $index; ?></td>
                                       <td><?= $cuti->kd_cuti ?></td>
                                       <td><?= $cuti->nama_cuti ?></td>
                                       <td><?= $cuti->hari_maks ?></td>
                                    </tr>
                                    <?php $index++; ?>
                                 <?php endforeach; ?>
                              </tbody>
                           </table>
                           <hr>
                        </section>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>