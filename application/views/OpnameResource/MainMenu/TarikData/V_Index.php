<section class="content">
  <div class="box box-primary color-palette-box">
    <div class="box-body">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
          <li class="pull-left header"><i class="fa fa-file"></i> <b>Tarik Data Opname Resource</b></li>
        </ul>
        <form action="<?= base_url('OpnameResource/Export') ?>" method="POST" target="_blank" >
        <div class="tab-content">
          <div class="row">
              <div class="col-md-6 ">
                  <select id="slcNoDocOR" class="form-control" name="slcNoDoc" placeholder="Masukkan Nomor Dokumen .." >
                      <option></option>
                      <?php foreach ($selectDoc as $key => $value) { ?>
                        <option value="<?= $value['NO_DOC']; ?>"><?= $value['NO_DOC']; ?></option>
                      <?php } ?>
                  </select>
              </div>

            <div class="col-md-6">
            <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modalExport" ><i class="fa fa-download "></i> EXPORT </button>
            </div>
          </div>
        </div>
                  <div class="modal fade" id="modalExport" role="dialog" aria-labelledby="modalExport" aria-hidden="true">
                      <div class="modal-dialog" style="min-width:800px;">
                        <div class="modal-content">
                        <!-- <form action="<?= base_url('AccountPayables/CheckPPh/List/action') ?>" method="POST"> -->
                          <input type="hidden" name="txtBatchNum" id="batchNumbDelPPh" value="">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="modalDelete">Pilih Hasil Export</h4>
                          </div>
                          <div class="modal-body" >
                            <center>
                            <button class="btn btn-success" type="submit" name="typeexport" value="excel"><i class="fa fa-file-excel-o"></i> EXPORT EXCEL </button>
                            <button class="btn btn-danger" type="submit" name="typeexport" value="pdf"><i class="fa fa-file-pdf-o"></i> EXPORT PDF </button>
                             
                            </center>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        <!-- </form> -->
                        </div>
                      </div>
                    </div>
      </div>
            </form>
    </div>
  </div>
</section>

