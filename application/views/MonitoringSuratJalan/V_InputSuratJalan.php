<style media="screen">
  tr.disabled {
    background-color: rgba(161, 161, 161, 0.63) !important;
  }

  tr.disabled:hover {
    background-color: rgba(161, 161, 161, 0.63) !important;
  }
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
          <h4 style="font-weight:bold;"><i class="fa fa-sliders"></i> Monitoring Surat Jalan (Input Surat Jalan)</h4>
        </div>
        <div class="box-body">
          <div class="col-md-2"></div>
          <div class="col-md-8 mt-4">
            <br>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <label for="">Dari</label>
                  <select class="form-control select2" id="dari" required>
                    <option value="">Pilih Lokasi...</option>
                    <option value="PUSAT">PUSAT</option>
                    <option value="MLATI">MLATI</option>
                    <option value="TUKSONO">TUKSONO</option>
                  </select>
                </div>
                <div class="col-md-6">
                  <label for="">Tujuan</label>
                  <select class="form-control select2" id="tujuan_isj" required>
                    <option value="">Pilih Lokasi...</option>
                    <option value="PUSAT">PUSAT</option>
                    <option value="MLATI">MLATI</option>
                    <option value="TUKSONO">TUKSONO</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="seksi_pengirim">Jenis Kendaraan</label>
              <div class="row">
                <div class="col-md-12">
                  <select class="form-control select2" id="jenis_kendaraan" required>
                    <option value="">Pilih ...</option>
                    <option value="HIWING">HIWING</option>
                    <option value="SHUTTLE">SHUTTLE</option>
                    <option value="KENDARAAN LAINNYA">KENDARAAN LAINNYA</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="seksi_pengirim">Sopir</label>
              <div class="row">
                <div class="col-md-4">
                  <select class="form-control select2MSJ" id="noind_sopir" onchange="nama_msj()" name="noind_sopir" required></select>
                </div>
                <div class="col-md-8">
                  <input type="text" class="form-control" id="nama_sopir" readonly placeholder="Nama Sopir">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="seksi_pengirim">Plat Nomor</label>
              <div class="row">
                <div class="col-md-12">
                  <input type="text" autocomplete="off" required style="text-transform: uppercase;width:50px;float:left;" maxlength="2" placeholder="AB" class="form-control" id="plat1" name="plat1">
                  <input required autocomplete="off" style="width: 90px;float:left;margin-left:11.31px !important" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type = "number" maxlength = "5" placeholder="1001" class="form-control" id="plat2" name="plat1">
                  <input type="text" autocomplete="off" required style="text-transform: uppercase;width:70px;float:left;margin-left:11.31px !important" maxlength="3" placeholder="EA" class="form-control" id="plat3" name="plat1">
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-2"></div>
          <div class="col-lg-12">
            <hr>
          </div>
          <div class="col-lg-12">
            <div class="table-responsive">
              <table class="table table-striped table-bordered table-hover text-left " id="tblmsj" style="font-size:12px;">
                <thead>
                  <tr class="bg-info" data="msj_header">
                    <th>
                      <center>No</center>
                    </th>
                    <!-- <th class="checked_msj"><input type="checkbox" id="check-all-msj" onchange="checked_msj()"></th> -->
                    <th class="checked_msj"></th>
                    <th>Dokumen Number</th>
                    <th>
                      <center>Pengirim</center>
                    </th>
                    <th>
                      <center>Seksi Pengirim</center>
                    </th>
                    <th>
                      <center>Tujuan</center>
                    </th>
                    <th>
                      <center>Penerima</center>
                    </th>
                    <th>
                      <center>Tanggal</center>
                    </th>
                    <th>
                      <center>Detail</center>
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no = 1; foreach ($get as $key => $g): ?>
                  <tr row-id="<?php echo $no ?>">
                    <td><?php echo $no; ?></td>
                    <td></td>
                    <td><?php echo $g['DOC_NUMBER'] ?></td>
                    <td>
                      <center><?php echo $g['CREATED_BY'] ?></center>
                    </td>
                    <td>
                      <center><?php echo $g['SEKSI_KIRIM'] ?></center>
                    </td>
                    <td>
                      <center><?php echo $g['TUJUAN'] ?></center>
                    </td>
                    <td>
                      <center><?php echo $g['USER_TUJUAN'] ?></center>
                    </td>
                    <td>
                      <center><?php echo date('d-M-Y H:i:s',strtotime($g['CREATION_DATE'])) ?></center>
                    </td>
                    <td>
                      <center>
                        <button type="button" class="btn bg-navy" style="margin-left:5px;" name="button" style="font-weight:bold;" onclick="detailMSJ('<?php echo $g['DOC_NUMBER'] ?>')" data-toggle="modal" data-target="#Mmsj">
                          <i class="fa fa-eye"></i>
                        </button>
                      </center>
                    </td>
                  </tr>
                  <?php $no++; endforeach; ?>
                  </tr>
                </tbody>
              </table>
            </div>
            <br>
            <center> <button type="button" class="btn btn-lg btn-primary" onclick="setMSJ3()" name="button" id="btnInputMSJ" disabled="disabled"><i class="fa fa-space-shuttle"></i> <b>Create</b></button> </center>
            <br>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade bd-example-modal-xl" id="Mmsj" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
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
