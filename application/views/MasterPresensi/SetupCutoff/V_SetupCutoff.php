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

   .cutoff-item>td {
      cursor: default;
   }

   .cutoff-item>td::selection {
      background: none;
   }

   .disable {
      pointer-events: none;
      cursor: not-allowed;
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
                           <input type="hidden" class="id_cutoff">
                           <div class="input-item-Co flex" style="width: 50%; margin:1rem 0rem;">
                              <label for="" style="width: 15rem;">Periode</label>
                              <div class="input-wrapper">
                                 <input id="inputPeriode" style="width:14rem" type="text" class="form-control" disabled autocomplete="off">
                              </div>
                           </div>
                           <div class="input-item-Co flex" style="width: 50%; margin:1rem 0rem;">
                              <label for="" style="width: 15rem;">Tanggal</label>
                              <div class="input-wrapper">
                                 <input id="inputTanggal" style="width:80%" type="text" class="form-control" disabled autocomplete="off">
                              </div>
                           </div>
                           <div class="input-item-Co flex" style="width: 50%; margin:1rem 0rem;">
                              <label for="" style="width: 15rem;">OS</label>
                              <div class="input-wrapper">
                                 <label class="radio-inline" style="padding-left:0;">
                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1"> Ya
                                 </label>
                                 <label class="radio-inline">
                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="0"> Tidak
                                 </label>
                              </div>
                           </div>
                        </section>

                        <!-- Button Section -->
                        <section id="btnContainer" class="btn-container flex" style="padding-top:3rem; width: 70%; margin:auto; justify-content:space-around;">
                           <button class="btn btn-primary" data-action="0">Tambah</button>
                           <button class="btn btn-success" disabled>Edit</button>
                           <button class="btn btn-warning" style="padding: 0;"><a class="flex" style="color:white; width:100%; height:100%; justify-content:center" href="<?= base_url('MasterPresensi/SetupCutoff/ExportPdf') ?>">Cetak</a></button>
                           <button class="btn btn-danger" data-action="0" disabled>Hapus</button>
                           <!-- <button id="scroll" class="btn btn-default">Scroll</button> -->
                        </section>

                        <!-- Table Section -->
                        <section class="table" style="margin: 3rem auto 0rem auto; width:70%;">
                           <table id="tableCutoff" class="table table-bordered table-hover table-striped">
                              <thead>
                                 <tr>
                                    <th>NO</th>
                                    <th>ID</th>
                                    <th>OS</th>
                                    <th>PERIODE</th>
                                    <th>TANGGAL AWAL</th>
                                    <th>TANGGAL AKHIR</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php $index = 1; ?>
                                 <?php foreach ($cutoff as $cutoff) : ?>
                                    <tr class="cutoff-item" data-id="<?= $cutoff->id_cutoff ?>" id="<?= $cutoff->id_cutoff ?>">
                                       <td class="no"><?= $index ?></td>
                                       <td><?= $cutoff->id_cutoff ?></td>
                                       <td><?= $cutoff->os == 0 ? 'Tidak' : 'Ya' ?></td>
                                       <td class="periode" data-periode="<?= $cutoff->periode ?>"><?= HelperFunction::convertTodate($cutoff->periode) ?></td>
                                       <td><?= explode(' ', $cutoff->tanggal_awal)[0] ?></td>
                                       <td><?= explode(' ', $cutoff->tanggal_akhir)[0] ?></td>
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