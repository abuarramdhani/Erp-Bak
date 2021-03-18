<style type="text/css">
  td {
    min-width: 155px;
    /* force table to be oversize */
  }
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-11">
          <div class="text-right">
            <h1><b>Input Kebutuhan APD Seksi</b></h1>
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
                  <div class="col-md-1 text-left" align="right">
                    <label for="lb_periode" class="control-label">Seksi : </label>
                  </div>
                  <form method="post" action="<?php echo site_url('p2k3adm_V2/Admin/inputStandarTIM'); ?>" enctype="multipart/form-data">
                    <div class="col-md-5">
                      <div class="input-group col-md-12">
                        <select required class="form-control k3_admin_standar" name="k3_adm_ks" placeholder="Masukkan Periode">
                          <option></option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <button type="submit" class="btn btn-primary btn-md">Tampilkan</button>
                    </div>
                  </form>
                  <div class="row">
                    <div class="col-lg-12">
                      <div class="row">
                        <?php if ($act == '1') : ?>
                          <form method="post" class="form-horizontal" action="<?php echo site_url('p2k3adm_V2/Admin/saveInputStandar'); ?>" enctype="multipart/form-data">
                            <div class="nav-tabs-custom">
                              <div class="tab-content">
                                <div class="tab-pane active">
                                  <div class="panel panel-default">
                                    <div class="panel-heading" style="height: 55px;">Lines of Input Order
                                      <a href="javascript:void(0);" id="group_add2">
                                        <button tippy-title="Untuk menambah data nama APD" type="button" class="btn btn-success pull-right" style="margin-bottom:10px; margin-right: 10px;"><i class="fa fa-fw fa-plus"></i>Add New</button>
                                      </a>
                                    </div>
                                    <div class="panel-body table-responsive" style="overflow-x: auto;">
                                      <table id="tb_InputKebutuhanAPD" class="table table-striped table-bordered table-hover text-center">
                                        <caption style="color: #000;font-weight: bold;font-size: 18px; padding-left: 0px;"><?php echo $seksi[0]['section_name']; ?>
                                        </caption>
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
                                            <th>Keterangan</th>
                                            <th>Lampiran <b style="color: yellow">(*PDF)</b></th>
                                            <th>Action</th>
                                          </tr>
                                        </thead>
                                        <tbody id="DetailInputKebutuhanAPD">
                                          <tr style="color: #000;" class="multiinput">
                                            <td id="nomor" style="min-width: 10px;">1</td>
                                            <td tippy-title="Diisi dengan nama APD <br> yang akan diinput">
                                              <select required="" class="form-control apd-select2" onchange="JenisAPD(this)" data-id="1">
                                                <option></option>
                                              </select>
                                            </td>
                                            <td>
                                              <input id="txtKodeItem" readonly="" type="text" class="form-control apd-isk-kode p2k3_see_apd" name="txtKodeItem[]" data-id="1">
                                            </td>
                                            <td tippy-title="Jumlah kebutuhan umum ditunjukkan sebagai candangan internal seksi tidak untuk cadangan semua pekerja di seksi terkait">
                                              <input required="" type="number" min="0" class="form-control apd-isk-kode" name="txtkebUmum[]">
                                            </td>
                                            <td tippy-title="Pcs/Bulan">
                                              <input required="" type="number" min="0" class="form-control apd-isk-kode" name="txtkebStaff[]">
                                            </td>
                                            <?php foreach ($daftar_pekerjaan as $key) { ?>
                                              <td tippy-title="Pcs/Bulan">
                                                <input required="" type="number" class="form-control" name="p2k3_isk_standar[]" min="0">
                                              </td>
                                            <?php } ?>
                                            <td tippy-title="Kolom keterangan wajib diisi dengan alasan yang tepat">
                                              <input required="" class="form-control" name="keterangan[]" placeholder="Keterangan" />
                                            </td>
                                            <td tippy-title="Diisi dengan lampiran atau file tambahkan bila ada seperti: foto, analisa, kebutuhan, analisa potensi bahaya">
                                              <input class="form-control" name="lampiran[]" type="file" accept="application/pdf" placeholder="Keterangan" />
                                            </td>
                                            <td tippy-title="Kolom action digunakan untuk menghapus data APD yang sudah diinput bila terjadi kesalahan dalam penginputan data">
                                              <button class="btn btn-default group_rem">
                                                <a href="javascript:void(0);" title="Hapus Baris">
                                                  <span class="glyphicon glyphicon-trash"></span>
                                                </a>
                                              </button>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <input name="p2k3_adm_kodesie" hidden="" type="text" value="<?php echo $kodesie; ?>">
                                      <div class="row text-right" style="margin-right: 12px; margin-top: 20px;">
                                        <?php if ($act == '1') : ?>
                                          <a tippy-title="Untuk kembali ke menu sebelumnya" href="<?php echo site_url('P2K3_V2/Order/inputStandarKebutuhan'); ?>" class="btn btn-primary btn-lg btn-rect">Back</a>
                                          &nbsp;&nbsp;
                                          <button tippy-title="Untuk menyimpan data saat data sudah selesai diinput jika terjadi perubahan standar atau input standar baru" onclick="return confirm('Apa anda yakin ingin Menginput Data Ini?')" type="submit" class="btn btn-primary btn-lg btn-rect">Tambah Data</button>
                                        <?php endif ?>
                                      </div>
                                    </div>
                                  </div>
                                  <i style="color: red;">*) Cek Data Kembali Sebelum Disimpan</i>
                                </div>
                              </div>
                            </div>
                          </form>
                        <?php endif ?>
                      </div>
                    </div>
                  </div>
                  <div class="panel-footer" style="margin-top: 20px;">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
  <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>
<script src="<?= base_url('assets/plugins/@popperjs/core/popper.min.js') ?>"></script>
<script src="<?= base_url('assets/plugins/tippy.js/dist/tippy-bundle.umd.min.js') ?>"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(window).keydown(function(event) {
      if (event.keyCode == 13) {
        event.preventDefault();
        return false;
      }
    });

    /**
     * initialize tippy
     * 
     * @see /assets/js/customAPD.js
     */
    tippyInit();
  });
</script>