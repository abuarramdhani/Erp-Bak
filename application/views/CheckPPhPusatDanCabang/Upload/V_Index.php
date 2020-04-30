<section class="content">
      <div class="row">
        <div class="col-lg-12">
          <div class="box box-deafault">
            <div class="box-header with-border" style="background:#FFF; height: 459px">
              <div style="padding-top: 80px; " class="col-lg-6 col-lg-offset-3" >
              </div>
              <div  style="padding-top: 20px;" class="col-lg-6 col-lg-offset-3">
                <center>
                <h2> <i style="vertical-align: middle;" class="fa fa-cloud-upload "> </i><strong>   File </strong> Uploader</h2>
                </center>
              </div>
              <div class="row">
                <form id="form_pph_pusat_dan_cabang" class="form-inline" method="post" enctype="multipart/form-data" accept-charset="utf-8" action="<?= base_url('AccountPayables/CheckPPhPusatDanCabang/Upload/proccess') ?>">
                    <div class="col-lg-4 col-lg-offset-3">
                      <input type="file" class="form-control" name="file_pph" style="width:400px"  >
                    </div>
                    <div class="col-md-2" style="text-align: right ;">
                      <button type="submit" class="btn btn-primary "><span class="fa fa-upload"></span> Upload</button>
                    </div>
              </div>
              <div style="padding-top: 20px;" class="col-lg-6 col-lg-offset-3">
                </form>
                    <div class="progress" style="display:none">
                      <div id="progressBar" class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        <span class="sr-only">0%</span>
                      </div>
                    </div>
                    <div class="msg alert alert-info text-left" style="display:none"></div>
              </div>
              <?php if ($errorupd)  { ?>
                               
                                <div class="modal fade" id="infoErrorPPhCabang" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
                                  <div class="modal-dialog" style="min-width:800px;">
                                    <div class="modal-content">
                                      <input type="hidden" name="txtBatchNum" id="batchNumbDelPPhCabang" value="">
                                      <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title text-danger " id="modalDelete">Upload Telah Berhasil, Namun ada <?= count($errorupd); ?> kesalahan data</h4>
                                      </div>
                                      <div class="modal-body" >
                                        <center>
                                          <b> Ada Vendor yang mempunyai Nomor Invoice Sama , yaitu:</b>
                                          <table class="table table-striped table-bordered tblListErrorPPHCabang">
                                            <thead>
                                              <tr class="bg-info">
                                                <th>No.</th>
                                                <th>Vendor</th>
                                                <th>No. Invoice</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php $no=1; foreach ($errorupd as $key => $value) { ?>
                                                <tr>
                                                  <td><?= $no++; ?></td>
                                                  <td><?= $value['nama_vendor'] ?></td>
                                                  <td><?= $value['no_invoice'] ?></td>
                                                </tr>
                                              <?php } ?>
                                            </tbody>
                                          </table>
                                        </center>
                                      </div>
                                      <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                 <?php } ?>
            </div>
          </div>
        </div>
      </div> 
</section>