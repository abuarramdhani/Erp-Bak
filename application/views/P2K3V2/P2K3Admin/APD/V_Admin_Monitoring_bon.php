<style>
  .table-sm td,
  .table-sm th {
    padding: .1rem
  }

  td.details-control {
    background: url('../../assets/img/icon/details_open.png') no-repeat center center;
    cursor: pointer;
  }

  tr.shown td.details-control {
    background: url('../../assets/img/icon/details_close.png') no-repeat center center;
  }

  div.slider {
    display: none;
  }

  table.dataTable tbody td.no-padding {
    padding: 0;
  }

  #p2k3_img {
    transition: transform 0.8s;
  }

  #p2k3_img:hover {
    transform: rotate(180deg);
  }
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="col-lg-11">
          <div class="text-right">
            <h1><b>Monitoring Bon</b></h1>
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
              <div class="box-header with-border text-center">
                <h4>
                  <?php echo $kodesie; ?>
                </h4>
              </div>
              <div class="box-body">
                <div class="panel-body">
                  <form method="get" class="form-horizontal" action="<?php echo site_url('p2k3adm_V2/Admin/monitoringBon'); ?>" enctype="multipart/form-data">
                    <div class="col-md-1 text-left" align="right">
                      <label for="lb_periode" class="control-label">Seksi : </label>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group col-md-12">
                        <select required class="form-control k3_admin_monitorbon" name="k3_adm_ks">
                          <option value="semua">SEMUA SEKSI</option>
                          <!-- <option value="semua">SEMUA SEKSI</option> -->
                        </select>
                      </div>
                    </div>
                    <div class="col-md-1 text-left" align="right">
                      <label for="lb_periode" class="control-label">Periode : </label>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group col-md-12">
                        <input required="" class="form-control p2k3_tanggal_periodeUnlimited" autocomplete="off" type="text" name="k3_periode" id="yangPentingtdkKosong" value="<?php echo $pr; ?>" />
                      </div>
                    </div>
                    <div class="col-md-2">
                      <button type="submit" class="btn btn-primary">Lihat</button>
                    </div>
                  </form>
                  <div style="margin-top: 50px;"></div>
                  <script>
                    var kodes = '<?php echo $kodesie; ?>';
                    var period = '<?php echo $period; ?>';
                  </script>
                  <table style="margin-top: 50px; width: 100%; position: relative;" class="table table-striped table-bordered table-hover text-center p2k3_monitoringbon">
                    <caption style="color: #000; font-weight: bold;">BON APD</caption>
                    <thead class="bg-primary">
                      <tr>
                        <th></th>
                        <!-- <th>No</th> -->
                        <th>Nomor Bon</th>
                        <th>Tanggal Bon</th>
                        <th>Seksi pengebon</th>
                        <th>Gudang</th>
                        <th>Keterangan</th>
                        <th>Cetak Bon</th>
                      </tr>
                    </thead>
                    <tbody id="DetailInputKebutuhanAPD">
                      <?php $a = 1;
                      foreach ($monitorbon as $key) : ?>
                        <tr style="color: #000;" class="multiinput">
                          <td>
                            <div style="cursor: pointer;" class="p2k3_row_swow" href="#"><img class="1" id="p2k3_img" src="../../assets/img/icon/details_open.png"></div>
                            <input hidden="" value="<?php echo $a; ?>">
                          </td>
                          <!-- <td id="nomor"><?php echo $a; ?></td> -->
                          <td>
                            <?php echo $key['no_bon']; ?>
                          </td>
                          <td>
                            <?php echo $key['tgl_bon']; ?>
                          </td>
                          <td>
                            <?php echo $key['seksi_pengebon']; ?>
                          </td>
                          <td>
                            <?php echo $key['tujuan_gudang']; ?>
                          </td>
                          <td>
                            <?php echo $key['keterangan']; ?>
                          </td>
                          <td>
                            <a target="_blank" data-toggle="tooltip" data-placement="top" title="Cetak Bon" href="<?php echo site_url('p2k3adm_V2/Admin/CetakBon/' . $key['no_bon']); ?>" class="btn btn-danger">
                              <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            </a>
                          </td>
                        </tr>
                        <?php $clas = 'p2k3_row' . $a; ?>
                        <tr>
                          <td style="padding: 0px; position: relative;" colspan="7">
                            <div style="overflow: hidden; display: none; position: relative; width: 100%;" class="<?php echo $clas; ?>">
                              <table class="table table-xs table-bordered" style="margin: 0; padding: 0; position: relative;">
                                <thead class="bg-info">
                                  <tr>
                                    <td width="5%"><b>No</b></td>
                                    <td width="15%"><b>Kode Item</b></td>
                                    <td><b>Nama Item</b></td>
                                    <td width="10%"><b>Jumlah Bon</b></td>
                                    <td width="10%"><b>Transact</b></td>
                                    <td width="10%"><b>Qty Transact</b></td>
                                    <td width="8%"><b>Satuan</b></td>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $kode = explode(';', $key['kode_barang']);
                                  $apd = explode(';', $key['nama_apd']);
                                  $jml = explode(';', $key['jml_bon']);
                                  $satuan = explode(';', $key['satuan']);
                                  $qty = explode(';', $key['qty_transact']);
                                  $trans = explode(';', $key['transact']);
                                  $lim = count($kode); ?>
                                  <?php for ($i = 0; $i < $lim; $i++) { ?>
                                    <tr>
                                      <td><?php echo ($i + 1); ?></td>
                                      <td>
                                        <a style="cursor:pointer;" class="p2k3_see_apd_text"><?php echo $kode[$i]; ?></a>
                                      </td>
                                      <td>
                                        <a style="cursor:pointer;" class="p2k3_to_input"><?php echo $apd[$i]; ?></a>
                                        <input hidden="" value="<?php echo $apd[$i]; ?>" class="p2k3_see_apd">
                                      </td>
                                      <td><?php echo $jml[$i]; ?></td>
                                      <td><?php echo ($trans[$i] == 'N') ? '<i style="color:red" class="fa fa-times" aria-hidden="true"></i>
                                                                        ' : '<i style="color:green" class="fa fa-check" aria-hidden="true"></i>'; ?></td>
                                      <td><?php echo ($qty[$i] < $jml[$i]) ? "<span style='font-weight: bold; color: #ff6b61'>" . $qty[$i] . "</span>" : $qty[$i]; ?></td>
                                      <td><?php echo $satuan[$i]; ?></td>
                                    </tr>
                                  <?php } ?>
                                </tbody>
                              </table>
                            </div>
                          </td>
                        </tr>
                      <?php $a++;
                      endforeach ?>
                    </tbody>
                  </table>
                  <table style="width: 100%; position: relative;" class="table table-striped table-bordered table-hover text-center p2k3_monitoringbon">
                    <caption style="color: #000; font-weight: bold;">BON SEPATU</caption>
                    <thead class="bg-primary">
                      <tr>
                        <th></th>
                        <!-- <th>No</th> -->
                        <th>Nomor Bon</th>
                        <th>Tanggal Bon</th>
                        <th>Seksi pengebon</th>
                        <th>Gudang</th>
                        <th width="300px">Keterangan</th>
                        <th>Cetak Bon</th>
                      </tr>
                    </thead>
                    <tbody id="DetailInputKebutuhanAPD">
                      <?php
                      foreach ($monitorBonSafetyShoes as $item) : ?>
                        <tr style="color: #000;" class="multiinput">
                          <td>
                            <div style="cursor: pointer;" class="p2k3_row_swow" href="#"><img class="1" id="p2k3_img" src="../../assets/img/icon/details_open.png"></div>
                            <input hidden="" value="<?php echo $a; ?>">
                          </td>
                          <!-- <td id="nomor"><?php echo $a; ?></td> -->
                          <td>
                            <?php echo $item['0']['no_bon']; ?>
                          </td>
                          <td>
                            <?php echo $item['0']['tgl_bon']; ?>
                          </td>
                          <td>
                            <?php echo $item['0']['seksi_pengebon']; ?>
                          </td>
                          <td>
                            <?php echo $item['0']['tujuan_gudang']; ?>
                          </td>
                          <td>
                            <span><?php echo count($item); ?> Pekerja</span>
                          </td>
                          <td>
                            <a target="_blank" data-toggle="tooltip" data-placement="top" title="Cetak Bon" href="<?php echo site_url('p2k3adm_V2/Admin/CetakBon/' . $item['0']['no_bon']); ?>" class="btn btn-danger">
                              <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            </a>
                          </td>
                        </tr>
                        <?php $clas = 'p2k3_row' . $a; ?>
                        <tr>
                          <td style="padding: 0px; position: relative;" colspan="7">
                            <div style="overflow: hidden; display: none; position: relative; width: 100%;" class="<?php echo $clas; ?>">
                              <table class="table table-xs table-bordered" style="margin: 0; padding: 0; position: relative;">
                                <thead class="bg-info">
                                  <tr>
                                    <td width="5%"><b>No</b></td>
                                    <td width="15%"><b>No Induk</b></td>
                                    <td width="10%"><b>Kode Item</b></td>
                                    <td><b>Nama Item</b></td>
                                    <td width="10%"><b>Jumlah Bon</b></td>
                                    <td width="10%"><b>Transact</b></td>
                                    <td width="10%"><b>Qty Transact</b></td>
                                    <td width="8%"><b>Satuan</b></td>
                                    <td width="5%"><b>Action</b></td>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 1;
                                  foreach ($item as $key) : ?>
                                    <tr>
                                      <td><?= $i++; ?></td>
                                      <td><?= $key['keterangan']; ?></td>
                                      <td>
                                        <a style="cursor:pointer;" class="p2k3_to_input"><?= $key['kode_barang']; ?></a>
                                        <input hidden="" value="<?= $key['nama_apd']; ?>" class="p2k3_see_apd">
                                      </td>
                                      <td>
                                        <a style="cursor:pointer;" class="p2k3_see_apd_text"><?php echo $key['nama_apd']; ?></a>
                                      </td>
                                      <td><?php echo $key['jml_bon']; ?></td>
                                      <td><?php echo ($key['transact'] == 'N') ? '<i style="color:red" class="fa fa-times" aria-hidden="true"></i>
                                                                        ' : '<i style="color:green" class="fa fa-check" aria-hidden="true"></i>'; ?></td>
                                      <td><?php echo ($key['qty_transact'] < $key['jml_bon']) ? "<span style='font-weight: bold; color: #ff6b61'>" . $key['qty_transact'] . "</span>" : $key['qty_transact']; ?></td>
                                      <td><?= $key['satuan'] ?></td>
                                      <td>
                                        <?php if ($key['transact'] == 'N'): ?>
                                          <button class="btn btn-danger apd_delbonspt" value="<?=$key['no_id']?>">
                                            <i class="fa fa-trash"></i>
                                          </button>
                                        <?php else: ?>
                                          -
                                        <?php endif ?>
                                      </td>
                                    </tr>
                                  <?php endforeach ?>
                                </tbody>
                              </table>
                            </div>
                          </td>
                        </tr>
                      <?php $a++;
                      endforeach ?>
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
<div id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;" hidden="hidden">
  <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>

<div class="modal fade" id="apd_mdldelspt" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="post" action="<?=base_url('P2K3_V2/Order/HapusBon')?>">
        <div class="modal-header">
          <label class="modal-title" id="exampleModalLabel">Alasan Menghapus Bon</label>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        <input class="form-control" minlength="5" required="" name="alasan" placeholder="Masukan Alasan" />
        <input hidden="" name="seksi" value="<?=$kodesie?>">
        <input hidden="" name="periode" value="<?=$pr?>">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-danger" id="apd_btnsubdelspt" name="id">Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#surat-loading').attr('hidden', false);
    $.ajax({
      type: 'POST',
      data: {
        lokasi_id: 'value'
      },
      url: baseurl + 'p2k3adm_V2/Admin/getSeksiAprove3',
      success: function(result) {
        var vall = '<?=$kodesie?>';
        $(".k3_admin_monitorbon").prop("disabled", false).html(result);
        $('.k3_admin_monitorbon').val(vall).trigger('change');
        $('#surat-loading').attr('hidden', true);
      }
    });
  });
</script>