<section class="content">
  <div class="inner" >
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11">
              <div class="text-right"><h1><b>Approval Atasan</b></h1></div>
            </div>
            <div class="col-lg-1">
              <div class="text-right hidden-md hidden-sm hidden-xs">
                <a class="btn btn-default btn-lg" href="<?php echo site_url('PerizinanPribadi/V_Index');?>">
                  <i class="icon-wrench icon-2x"></i>
                  <br/>
                </a>
              </div>
            </div>
          </div>
        </div>
        <br/>
        <div class="row" style="">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
            <div class="box-header with-border"></div>
              <div class="box-body">
                <div class="nav-tabs-custom">
                  <div class="tab-content">
                    <div id="ikp-all" class="tab-pane fade in active">
                      <table class="table table-responsive-xs table-sm table-bordered tabel_ikp_all table-hover" style="width: 100%">
                        <thead>
                          <tr>
                            <th class="text-center" style="white-space: nowrap">No</th>
                            <th class="text-center" style="white-space: nowrap">Keputusan Anda</th>
                            <th class="text-center" style="white-space: nowrap">ID Izin</th>
                            <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                            <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                            <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                            <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                            <th class="text-center" style="white-space: nowrap">Pekerjaan Diserahkan</th>
                            <th class="text-center" style="white-space: nowrap">Keterangan Pekerja</th>
                            <th class="text-center" style="white-space: nowrap">Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $no = 1;
                          foreach ($izin as $row) {
                            ?>
                            <tr>
                              <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                              <td style="white-space: nowrap; text-align: center;"><?php  
                                if ($row['appr_atasan'] == 't') { ?>
                                <span class="label label-success">Approved</span>
                                <?php }elseif ($row['appr_atasan'] == 'f') { ?>
                                <span class="label label-danger">Rejected</span>
                                <?php }else { ?>
                                <?php if (date('Y-m-d', strtotime($row['created_date'])) != date('Y-m-d')) { ?>
                                <span class="label label-default">Expired</span>
                                <?php }else{ ?>
                                <button class="btn btn-success cm_btn_approve" onclick="getApprovalIKP('1', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)" >
                                  <span style="color: white" class='fa fa-check'></span>
                                </button>
                                <button class="btn btn-danger cm_btn_reject" onclick="getApprovalIKP('0', <?php echo $row['id'] ?>, <?= $row['jenis_ijin'] ?>)">
                                  <span style="color: white" class='fa fa-close'></span>
                                </button>
                                <?php } ?>
                                <?php } ?>
                              </td>
                              <td style="white-space: nowrap; text-align: center;"><?php echo $row['id'] ?></td>
                              <td style="white-space: nowrap"><?php $noind = explode(', ', $row['noind']);
                                foreach ($noind as $na) {
                                  foreach ($nama as $lue) {
                                    if ($na == $lue['noind']) {
                                      echo $lue['noind'].' - '.$lue['nama'].'<br>';
                                    }
                                  }
                                }  ?></td>
                                <td>
                                  <?php 
                                  if ($row['jenis_ijin'] == '1') {
                                    echo "Izin Keluar Pribadi";
                                  }elseif ($row['jenis_ijin'] == '2'){
                                    echo "Izin Sakit Perusahaan";
                                  }elseif ($row['jenis_ijin'] == '3') {
                                    echo "Izin Keluar Perusahaan";
                                  }else{
                                    echo "Izin Apa -_O ?";
                                  }
                                  ?>
                                </td>
                                <td style="white-space: nowrap; text-align: center;"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                <td style="white-space: nowrap; text-align: center;"><?php if ($row['wkt_keluar'] == '' || $row['wkt_keluar'] == null) {
                                  echo '-';
                                }else {
                                  echo date('H:i:s', strtotime($row['wkt_keluar']));
                                } ?></td>
                                <td style="white-space: nowrap"><?php if ($row['diserahkan'] == '' || $row['diserahkan'] == null) {
                                  echo "-";
                                } else {
                                  echo $row['diserahkan'];
                                } ?></td>
                                <td style="white-space: nowrap"><?php echo $row['keperluan'] ?></td>
                                <td style="white-space: nowrap"><?php echo rtrim($row['status']) ?></td>
                              </tr>
                              <?php $no++; } ?>
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

<!-- Modal -->
<div class="modal fade" id="modal-approve-ikp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 600px">
    <div class="modal-content">
      <div class="modal-header text-center">
        <button type="button" class="close hover" data-dismiss="modal">&times;</button>
        <h3>Approval Perizinan Pribadi</h3>
      </div>
      <div class="modal-body" style="width: 100%; text-align: center;">
        <div class="row">
          <div class="col-lg-12">
            <label class="col-lg-3 text-right">ID IKP</label><label class="col-lg-1">:</label>
            <input  class="form-control col-lg-8" name="id_ikp" id="modal-id_ikp" readonly  style="width: 55%">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-lg-12">
            <label class="col-lg-3 text-right">Tanggal</label><label class="col-lg-1">:</label>
            <input  class="form-control col-lg-8" name="tgl_ikp" id="modal-tgl_ikp" readonly  style="width: 55%">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-lg-12">
            <label class="col-lg-3 text-right">Akan Keluar</label><label class="col-lg-1">:</label>
            <input  class="form-control col-lg-8" name="keluar_ikp" id="modal-keluar_ikp" readonly  style="width: 55%">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-lg-12">
            <label class="col-lg-3 text-right">Keperluan</label><label class="col-lg-1">:</label>
            <textarea class="form-control col-lg-8" name="kep_ikp" id="modal-kep_ikp" readonly  style="width: 55%"></textarea>
          </div>
        </div>
        <br>
        <div class="row">
            <table border="1" width="500px" style="margin-left: 50px;">
                <thead>
                    <th style="text-align: center; white-space: nowrap;"><input type="checkbox" id="checkAll_edit_ikp"></th>
                    <th style="text-align: center; white-space: nowrap;">No. Induk</th>
                    <th style="text-align: center; white-space: nowrap;">Nama</th>
                </thead>
                <tbody class="eachPekerjaEditIKP">

                </tbody>
            </table>
        </div>
        <br>
          <div class="modal-footer" style="text-align: center;">
            <div>
              <button type="button" class="btn btn-success" id="app_edit_ikp" value="1">Approve</button>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
</div>

<!-- selesai -->
<script type="text/javascript">
  $(document).ready(function () {
    $('.tabel_ikp_all').DataTable({
        scrollX:        true
    });
  })
</script>
