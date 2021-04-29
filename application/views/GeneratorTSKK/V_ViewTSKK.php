<style type="text/css">

#inputElemen {
    border-radius: 25px;
}

#save {
    border-radius: 25px;
}

input[type="text"]::placeholder {
/* Firefox, Chrome, Opera */
text-align: center;
}

</style>

<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                      <div class="text-center"><h1><b>DAFTAR TSKK</b></h1></div>
                    </div>
                </div>
                <br/>

                 <div class="row" style="">
                    <div class="col-lg-12">
                        <div class="box box-primary color-palette-box">
                            <div class="box-header with-border">
                              <div class="row">
                                <div class="col-md-4">
                                  <label for="">Seksi</label>
                                  <select class="select2 seksi_tskk_2021" name="" style="width:100%">
                                    <option value="">Pilih Seksi (Opsional)</option>
                                    <?php foreach ($lihat_seksi as $key => $value): ?>
                                      <option value="<?php echo $value['seksi'] ?>"><?php echo $value['seksi'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <div class="col-md-3">
                                  <label for="">Tipe Produk</label>
                                  <select class="select2 tipe_tskk_2021" name="" style="width:100%">
                                    <option value="">Pilih Tipe Produk (Opsional)</option>
                                    <?php foreach ($lihat_tipe as $key => $value): ?>
                                      <option value="<?php echo $value['tipe'] ?>"><?php echo $value['tipe'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <div class="col-md-3">
                                  <label for="">Proses</label>
                                  <select class="select2 proses_tskk_2021" name="" style="width:100%">
                                    <option value="">Pilih Proses (Opsional)</option>
                                    <?php foreach ($lihat_proses as $key => $value): ?>
                                      <option value="<?php echo $value['proses'] ?>"><?php echo $value['proses'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <div class="col-md-2">
                                  <label for="" style="color:transparent">a</label>
                                  <button type="button" class="btn btn-primary" onclick="filterGenmMonTskk()" name="button" style="width:100%">Filter</button>
                                </div>
                              </div>
                            </div>
                            <div class="panel-body">
                              <div class="tskk_filter_area">
                                <table class="datatable table table-striped table-bordered table-hover tabel_daftarTSKK" id="tabel_daftarTSKK" style="width: 100%">
                                  <thead class="bg-primary">
                                    <tr>
                                      <th width="5%" class="text-center">NO</th>
                                      <th class="text-center" style="display: none;">ID</th>
                                      <th width="15%" class="text-center">ACTION</th>
                                      <th width="20%" class="text-center">JUDUL</th>
                                      <th width="10%" class="text-center">PEMBUAT</th>
                                      <th width="10%" class="text-center">TANGGAL PEMBUATAN</th>
                                      <th width="10%" class="text-center">TYPE</th>
                                      <th width="15%" class="text-center">NAMA PART</th>
                                      <th width="15%" class="text-center">SEKSI</th>
                                      <th width="10%" class="text-center">PROSES</th>
                                      <th style="display:none">ID</th>
                                    </tr>
                                  </thead>
                                  <tbody>

                                    <?php $no = 1; ?>

                                    <?php
                                      if (empty($lihat_header)) {
                                      }else{
                                        $no=1;
                                        foreach ($lihat_header as $key) {
                                          $id = $key['id_tskk'];
                                          $judul_tskk = $key['judul_tskk'];
                                          $tipe = $key['tipe'];
                                          $kode_part = $key['kode_part'];
                                          $nama_part = $key['nama_part'];
                                          // $no_alat_bantu = $key['no_alat_bantu'];
                                          $seksi = $key['seksi'];
                                          $proses = $key['proses'];
                                          $kode_proses = $key['kode_proses'];
                                          $mesin = $key['mesin'];
                                          $proses_ke = $key['proses_ke'];
                                          $proses_dari = $key['proses_dari'];
                                          $tanggal = $key['tanggal_pembuatan'];
                                          $newDate = date("d-M-Y", strtotime($tanggal));
                                          $qty = $key['qty'];
                                          $operator = $key['operator'];
                                          $pembuat = $key['nama_pembuat'];
                                          $status_observasi = $key['status_observasi'];
                                          $pembuat_ = explode(' - ', $pembuat);
                                    ?>

                                      <tr>
                                        <td style="width: 5%; text-align:center;"><?php echo $no; ?></td>
                                        <td style="display: none;"></td>
                                        <td style="text-align:center; width:10%">
                                        <?php if ($pembuat_[0] == $this->session->user): ?>
                                          <!-- <a class="btn btn-warning btn-md" title="Edit TSKK" href="<? // ECHO base_url('GeneratorTSKK/C_GenTSKK/EditTSKK/'.$id)?>"><span class="fa fa-pencil-square-o"></span></a> -->
                                          <a class="btn btn-warning btn-md" title="Edit TSKK" href="<?=base_url('GeneratorTSKK/C_GenTSKK/CreateBegin/'.$id)?>"><span class="fa fa-pencil-square-o"></span></a>
                                        <?php endif; ?>
                                        <?php if ($status_observasi == 'publish'){ ?>
                                          <a class="btn btn-success btn-md" title="Export TSKK" href="<?=base_url('GeneratorTSKK/C_GenTSKK/exportExcel/'.$id)?>"><span class="fa fa-print"></span></a>
                                        <?php } ?>
                                        <!-- <a class="btn btn-danger btn-md" title="Delete TSKK" href="<?=base_url('GeneratorTSKK/C_GenTSKK/deleteData/'.$id)?>"><span class="fa fa-user-times"></span></a>  -->
                                        </td>
                                        <td><?php echo $judul_tskk; ?></td>
                                        <td><?php echo $pembuat; ?></td>
                                        <td style="text-align:center;" data-order="<?php echo date("Ymd", strtotime($newDate)); ?>"><?php echo $newDate; ?></td>
                                        <td><?php echo $tipe; ?></td>
                                        <td><?php echo $nama_part; ?></td>
                                        <td><?php echo $seksi; ?></td>
                                        <td><?php echo $proses; ?></td>
  																	  	<td style="display:none"><input hidden class="form-control idView" value="<?php echo $id ?>"></td>

                                      </tr>
                                      <?php
                                      $no++;
                                    }
                                  }
                                    ?>
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
        </div>
    </div>
</section>
