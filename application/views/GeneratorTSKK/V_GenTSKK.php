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
                       <div class="text-center"><h1><b>DAFTAR LEMBAR OBSERVASI</b></h1></div>
                    </div>
                </div>
                <br/>

                 <div class="row" style="">
                    <div class="col-lg-12">
                        <div class="box box-primary color-palette-box">
                            <div class="box-header with-border">
                              <div class="row">
                                <div class="col-md-5">
                                  <label for="">Seksi</label>
                                  <select class="select2 seksi_tskk_2021" name="" style="width:100%">
                                    <option value="">Pilih Seksi (Opsional)</option>
                                    <?php foreach ($lihat_seksi as $key => $value): ?>
                                      <option value="<?php echo $value['seksi'] ?>"><?php echo $value['seksi'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <div class="col-md-5">
                                  <label for="">Tipe</label>
                                  <select class="select2 tipe_tskk_2021" name="" style="width:100%">
                                    <option value="">Pilih Tipe (Opsional)</option>
                                    <?php foreach ($lihat_tipe as $key => $value): ?>
                                      <option value="<?php echo $value['tipe'] ?>"><?php echo $value['tipe'] ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                                <div class="col-md-2">
                                  <label for="" style="color:transparent">a</label>
                                  <button type="button" class="btn btn-primary" onclick="filterGenTskk()" name="button" style="width:100%">Filter</button>
                                </div>
                              </div>
                            </div>
                            <div class="panel-body">
                              <table style="width:300px">
                                <tr>
                                  <td style="width:100px;"><div style="width:90%;height:20px;background:#ffcccc"></div> </td>
                                  <td> : Belum siap cetak  </td>
                                </tr>
                              </table>
                              <div class="tskk_filter_area">
                                <div class="table-responsive" style="padding-top:13px;">
                                  <table class="datatable table table-striped table-bordered table-hover tabel_daftarTSKK" id="tabel_daftarTSKK" style="width: 100%;">
                                    <thead class="bg-primary">
                                      <tr>
                                        <th width="5%" class="text-center">NO</th>
                                        <th class="text-center" style="display: none;">ID</th>
                                        <th width="15%" class="text-center">ACTION</th>
                                        <th width="15%" class="text-center">JUDUL</th>
                                        <th width="10%" class="text-center">PEMBUAT</th>
                                        <th width="10%" class="text-center">TANGGAL OBSERVASI</th>
                                        <th width="10%" class="text-center">TYPE</th>
                                        <th width="15%" class="text-center">NAMA PART</th>
                                        <th width="10%" class="text-center">SEKSI</th>
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
                                            $seksi = $key['seksi'];
                                            $proses = $key['proses'];
                                            $kode_proses = $key['kode_proses'];
                                            $mesin = $key['mesin'];
                                            $proses_ke = $key['proses_ke'];
                                            $proses_dari = $key['proses_dari'];
                                            $tanggal = $key['tanggal'];
                                            $newDate = date("d-M-Y", strtotime($tanggal));
                                            $qty = $key['qty'];
                                            $operator = $key['operator'];
                                            $pembuat = $key['nama_pembuat'];
                                            $status_observasi = $key['status_observasi'];
                                            $pembuat_ = explode(' - ', $pembuat);
                                      ?>
                                        <tr <?php echo $status_observasi == 'draft' ? 'style="background:#ffcccc"' : '' ?>>
                                          <td style="width: 5%; text-align:center;"><?php echo $no; ?></td>
                                          <td style="display: none;"></td>
                                          <td style="width: 20%; text-align:center;">
                                            <?php if ($pembuat_[0] == $this->session->user): ?>
                                              <a class="btn btn-warning btn-md" title="Edit Lembar Observasi" href="<?=base_url('GeneratorTSKK/C_GenTSKK/EditObservasi/'.$id)?>"><span class="fa fa-pencil-square-o"></span></a>
                                            <?php endif; ?>
                                          <a class="btn btn-info btn-md" title="Create TSKK" href="<?=base_url('GeneratorTSKK/C_GenTSKK/CreateBegin/'.$id)?>"><span class="fa fa-pencil-square-o"></span> </a>

                                          <?php if ($status_observasi == 'publish'){ ?>
                                            <a class="btn btn-success btn-md" title="Export Lembar Observasi" href="<?=base_url('GeneratorTSKK/C_Observation/exportObservation/'.$id)?>"><span class="fa fa-print"> </span></a>
                                          <?php } ?>

                                          <!-- <a class="btn btn-warning btn-md" title="Export TSKK" href="<?=base_url('GeneratorTSKK/C_Regenerate/exportAgain/'.$id)?>"><span class="fa fa-print"></span></a>                                        -->
                                          <?php if ($pembuat_[0] == $this->session->user): ?>
                                            <a class="btn btn-danger btn-md idViewLembarObservasi" at="<?php echo $id;?>" title="Delete Lembar Observasi" onclick="AreYouSureWantToDelete(<?= $id ?>)"><span class="fa fa-trash"></span></a>
                                          <?php endif; ?>
                                          <!-- href="<?=base_url('GeneratorTSKK/C_GenTSKK/deleteData/'.$id)?>" -->
                                          </td>
                                          <td style="display:none"><input class="form-control idViewLembarObservasi" value="<?php echo $id;?>"></td>
                                          <td><?php echo $judul_tskk; ?></td>
                                          <td><?php echo $pembuat; ?></td>
                                          <td style="text-align:center;"><?php echo $newDate; ?></td>
                                          <td><?php echo $tipe; ?></td>
                                          <td><?php echo $nama_part; ?></td>
                                          <td><?php echo $seksi; ?></td>
                                          <td><?php echo $proses; ?></td>
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
    </div>
</section>
