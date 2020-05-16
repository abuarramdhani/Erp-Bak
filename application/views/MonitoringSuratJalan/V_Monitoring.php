<style media="screen">
::-webkit-scrollbar {
    width: 5px;
}
::-webkit-scrollbar-thumb {
    -webkit-border-radius: 7px;
    border-radius: 7px;
    background: rgba(192,192,192,0.3);
    -webkit-box-shadow: inset 0 0 6px rgba(49, 139, 233, 0.7);
}
</style>
<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-newspaper-o"></i> Monitoring Surat Jalan</h4>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover text-left " id="tblpbi" style="font-size:12px;">
              <thead>
                <tr class="bg-info">
                  <th><center>No</center></th>
                  <th><center>No Surat Jalan</center></th>
                  <th><center>Sopir</center></th>
                  <th><center>Plat</center></th>
                  <th><center>Action</center></th>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach ($get as $key => $g): ?>
                  <tr row="<?php echo $no ?>">
                    <td><center><?php echo $no; ?></center></td>
                    <td><center><?php echo $g['NO_SURATJALAN'] ?></center></td>
                    <td id="sopir_up"><center><?php echo $g['NAMA_SUPIR'] ?></center></td>
                    <td id="plat_up"><center><?php echo $g['PLAT_NUMBER'] ?></center></td>
                    <td>
                      <center>
                        <button type="button" class="btn bg-navy" style="border-radius: 8px" name="button" style="font-weight:bold;" onclick="detailSJ('<?php echo $g['NO_SURATJALAN'] ?>')" data-toggle="modal" data-target="#Mmsj">
                          <i class="fa fa-eye"></i> Detail
                        </button>
                        <button type="button" class="btn bg-gray" style="margin-left:5px;border-radius: 8px" name="button" style="font-weight:bold;" onclick="editSJ('<?php echo $g['NO_SURATJALAN'] ?>', <?php echo $no ?>)" data-toggle="modal" data-target="#editmsj">
                           <i class="fa fa-edit"></i> Edit
                        </button>
                        <a href="<?php echo base_url('MonitoringSuratJalan/Cetak/'.$g['NO_SURATJALAN']) ?>" target="_blank" class="btn bg-red" style="border-radius: 8px;margin-left:5px;"><i class="fa fa-file-pdf-o"></i> Cetak</a> 
                      </center>
                    </td>
                  </tr>
                <?php $no++; endforeach; ?>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-md" id="Mmsj" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">DETAIL (<span id="nodoc_msj"></span>) </h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal">Close</button>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <center>
                    <div id="loading-msj" style="display:none;">
                      <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                    </div>
                  </center>
                  <div id="table-msj-area">

                  </div>
                </div>
                <!-- <center><button type="button" class="btn btn-success" name="button" id="rootbutton" onclick="rootsubmit()" style="font-weight:bold;display:none;margin-top:10px">ROOT APPROVE</button> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-md" id="editmsj" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content" style="border-radius: 5px !important; background-color:transparent !important; box-shadow:none;">
      <div class="panel-body">
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <div style="float:left">
                  <h4 style="font-weight:bold;">Edit (<span id="nosj_msj"></span>) </h4>
                </div>
                <button type="button" class="btn btn-danger" style="float:right;font-weight:bold" data-dismiss="modal">Close</button>
              </div>
              <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <center>
                      <div id="loading-msj" style="display:none;">
                        <center><img style="width: 5%" src="<?php echo base_url('assets/img/gif/loading5.gif') ?>"></center>
                      </div>
                    </center>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="box-body">
                          <div class="form-group">
                           <label for="seksi_pengirim">Sopir</label>
                             <div class="row">
                               <div class="col-md-5">
                                 <!-- hanya panggil, ada alasan tertentu -->
                                 <select class="form-control select2MSJ" id="noind_sopir" onchange="nama_msj()" name="noind_sopir" required style="width:100%"></select>
                               </div>
                               <div class="col-md-7">
                                 <input type="text" required class="form-control" id="nama_sopir" name="nama_sopir" readonly placeholder="Nama Sopir" style="text-transform:uppercase;">
                                 <input type="hidden" id="no_induk">
                                 <input type="hidden" id="row">
                               </div>
                             </div>
                           </div>
                           <div class="form-group">
                             <label for="seksi_pengirim">Plat Nomor</label>
                             <div class="row">
                               <div class="col-md-12">
                                 <input type="text" required style="text-transform: uppercase;width:50px;float:left;" maxlength="2" placeholder="AB" class="form-control" id="plat1" name="plat1">
                                 <input required style="width: 90px;float:left;margin-left:11.31px !important" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "5" placeholder="1001" class="form-control" id="plat2" name="plat1">
                                 <input type="text" required style="text-transform: uppercase;width:70px;float:left;margin-left:11.31px !important" maxlength="3" placeholder="EA" class="form-control" id="plat3" name="plat1">
                               </div>
                             </div>
                           </div>
                           <br>
                           <center> <button type="button" class="btn btn-lg btn-primary" name="button" onclick="updateSJ()"><i class="fa fa-edit"></i> Update</button> </center>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- <center><button type="button" class="btn btn-success" name="button" id="rootbutton" onclick="rootsubmit()" style="font-weight:bold;display:none;margin-top:10px">ROOT APPROVE</button> -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
