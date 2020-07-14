<style type="text/css">
  td {
    min-width: 155px;
    /* force table to be oversize */
  }
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <form method="post" class="form-horizontal" action="<?php echo site_url('P2K3_V2/Order/saveInputStandar'); ?>" enctype="multipart/form-data">
        <div class="col-lg-12">
          <div class="col-lg-11">
            <div class="text-right">
              <h1><b>Input Kebutuhan APD</b></h1>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12">
              <div class="col-lg-11"></div>
              <div class="col-lg-1 "></div>
            </div>
          </div>
          <br />
          <div class="row">
            <div class="col-lg-12">
              <div class="box box-primary box-solid">
                <div class="box-header with-border">Create Order</div>
                <div class="box-body">
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-lg-12">
                        <div class="row">
                          <div class="nav-tabs-custom">
                            <div class="tab-content">
                              <div class="tab-pane active">
                                <div class="panel panel-default">
                                  <div class="panel-heading" style="height: 55px;">Lines of Input Order
                                    <a href="javascript:void(0);" id="group_add" title="Tambah Baris">
                                      <button type="button" class="btn btn-success pull-right" style="margin-bottom:10px; margin-right: 10px;"><i class="fa fa-fw fa-plus"></i>Add New</button>
                                    </a>
                                  </div>
                                  <div class="panel-body table-responsive" style="overflow-x: auto;">
                                    <table id="tb_InputKebutuhanAPD" class="table table-striped table-bordered table-hover text-center">
                                      <thead>
                                        <tr class="bg-primary">
                                          <th>NO</th>
                                          <th nowrap="">Nama APD</th>
                                          <th>Kode Barang</th>
                                          <th>Kebutuhan Umum</th>
                                          <th>STAFF</th>
                                          <?php foreach ($daftar_pekerjaan as $key) { ?>
                                            <th><?php echo $key['pekerjaan']; ?></th>
                                          <?php } ?>
                                          <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody id="DetailInputKebutuhanAPD">
                                        <tr style="color: #000;" class="multiinput">
                                          <td id="nomor" style="min-width: 10px;">1</td>
                                          <td>
                                            <select required="" class="form-control apd-select2" onchange="JenisAPD(this)" data-id="1">
                                              <option></option>
                                            </select>
                                          </td>
                                          <td>
                                            <input id="txtKodeItem" readonly="" type="text" class="form-control apd-isk-kode p2k3_see_apd" name="txtKodeItem[]" data-id="1">
                                          </td>
                                          <td>
                                            <input required="" type="number" class="form-control apd-isk-kode" name="txtkebUmum[]">
                                          </td>
                                          <td>
                                            <input required="" type="number" class="form-control apd-isk-kode" name="txtkebStaff[]">
                                          </td>
                                          <?php foreach ($daftar_pekerjaan as $key) { ?>
                                            <td>
                                              <input required="" type="number" class="form-control" name="p2k3_isk_standar[]" min="0">
                                            </td>
                                          <?php } ?>
                                          <td>
                                            <button class="btn btn-default group_rem">
                                              <a href="javascript:void(0);" title="Hapus Baris">
                                                <span class="glyphicon glyphicon-trash"></span>
                                              </a>
                                            </button>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                                <i style="color: red;">*) Cek Data Kembali Sebelum Disimpan</i>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="panel-footer">
                      <div class="row text-right" style="margin-right: 12px">
                        <?php
                        $h = date('d');
                        $d = '';
                        if ($h > '40') {
                          $d = 'disabled';
                        }
                        ?>
                        <a href="<?php echo site_url('P2K3_V2/Order/inputStandarKebutuhan'); ?>" class="btn btn-primary btn-lg btn-rect">Back</a>
                        &nbsp;&nbsp;
                        <button <?php echo $d; ?> type="submit" class="btn btn-primary btn-lg btn-rect">
                          Tambah Data
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<div id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
  <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>