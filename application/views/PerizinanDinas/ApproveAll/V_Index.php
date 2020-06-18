<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right"><h1><b>Rotasi Atasan Perizinan Dinas</b></h1></div>
                        </div>
                        <div class="col-lg-1">
                            <div class="text-right hidden-md hidden-sm hidden-xs">
                                <a class="btn btn-default btn-lg" href="<?php echo site_url('PerizinanDinas/AtasanApproval/V_Index');?>">
                                    <i class="icon-wrench icon-2x"></i>
                                    <br/>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
<?php  $today = date('Y-m-d'); ?>
                 <div class="row" style="">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <div class="col-lg-12">
                                    <a href="<?php echo site_url('assets/video/rotasi_atasan_dinas.webm');?>" class="btn btn-warning col-lg-1"><span style="color: white" class='fa fa-2x fa-video-camera'></a>
                                    <marquee class="col-lg-11"><label style="font-size: 18px;">Perizinan Dinas yang ditampilkan hanya perizinan hari ini tanggal <?php echo date('d F Y') ?></label></marquee>
                                </div>
                            </div>
                            <div class="box-body">
                            <div class="nav-tabs-custom">
                              <ul class="nav nav-tabs pull-right">
                                <li class="pull-left header"><i class="fa fa-refresh"></i>Rotasi Atasan Perizinan Dinas</li>
                              </ul>
                              <div class="tab-content">
                              <div id="izin-allAll" class="tab-pane fade in active">
                              <table class="table table-responsive-xs table-sm table-bordered tabel_izin_dinas_all" style="width: 100%">
                                <thead>
                                  <tr>
                                    <th class="text-center" style="white-space: nowrap">No</th>
                                    <th class="text-center" style="white-space: nowrap">Action</th>
                                    <th class="text-center" style="white-space: nowrap">ID Izin</th>
                                    <th class="text-center" style="white-space: nowrap">Tanggal Pengajuan</th>
                                    <th class="text-center" style="white-space: nowrap">Akan Keluar</th>
                                    <th class="text-center" style="white-space: nowrap">Nama Pekerja</th>
                                    <th class="text-center" style="white-space: nowrap">Jenis Izin</th>
                                    <th class="text-center" style="white-space: nowrap">Atasan</th>
                                    <th class="text-center" style="white-space: nowrap">Tujuan</th>
                                    <th class="text-center" style="white-space: nowrap">Keterangan</th>
                                    <th class="text-center" style="white-space: nowrap">Status</th>
                                    <th class="text-center" style="white-space: nowrap" hidden>Order</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php $no = 1;
                                  foreach ($izin as $row) {
                                    ?>
                                    <tr>
                                      <td style="white-space: nowrap; text-align: center;"><?php echo $no; ?></td>
                                      <td style="white-space: nowrap; text-align: center;"><?php  if ($row['status'] == 0 && date('Y-m-d', strtotime($row['created_date'])) == $today) { ?>
                                            <button class="btn btn-warning" onclick="edit_pkj_dinas_all(<?php echo $row['izin_id'] ?>)"><span style="color: white" class='fa fa-edit'></button>
                                           <?php }elseif ($row['status'] == 1) { ?>
                                                  <a><span style="color: green" class='fa fa-check fa-2x'></span></a>
                                           <?php }elseif ($row['status'] == 2) { ?>
                                                  <a><span style="color: red" class='fa fa-close fa-2x'></span></a>
                                           <?php }elseif (($row['status'] == 0 && date('Y-m-d', strtotime($row['created_date'])) < date('Y-m-d')) || $row['status'] == 5) {  ?>
                                               <span class="fa fa-2x fa-exclamation-circle" style="color: grey"></span>
                                           <?php } ?>
                                                </td>
                                      <td style="white-space: nowrap; text-align: center;"><?php echo $row['izin_id'] ?></td>
                                      <td style="white-space: nowrap"><?= date("d - M - Y", strtotime($row['created_date'])); ?></td>
                                      <td style="white-space: nowrap; text-align: center;"><?php if ($row['berangkat'] == '' || $row['berangkat'] == null) {
                                          echo '-';
                                      }elseif ($row['berangkat'] < '12:00:00') {
                                          echo date('H:i:s', strtotime($row['berangkat'])).' AM';
                                      }else {
                                          echo date('H:i:s', strtotime($row['berangkat'])).' PM';
                                      } ?></td>
                                      <td style="white-space: nowrap"><?php foreach ($row['pekerja'] as $val) {
                                            if ($val == null || $val == '') {
                                              echo " - <br>";
                                            }else {
                                              echo $val.'<br>';
                                            }
                                      }  ?></td>
                                      <td style="white-space: nowrap; text-align: center;"><?php echo $row['to_dinas'] ?></td>
                                      <td style="white-space: nowrap"><?php echo $row['atasan'];  ?></td>
                                      <td style="white-space: nowrap"><?php foreach ($row['tujuan'] as $key) {
                                            if ($key == null || $key == '') {
                                              echo " - <br>";
                                            }else {
                                              echo $key.'<br>';
                                            }
                                      }  ?></td>
                                      <td style="white-space: nowrap"><?php echo $row['keterangan'] ?></td>
                                      <td style="text-align: center;"><?php
                                            if ($row['status'] == 0 || $row['status'] == 5) { ?>
                                                <span class="label" style="background-color: #E0E0E0; color: black">Unapproved</span>
                                            <?php } elseif ($row['status'] == 1) { ?>
                                                 <span class="label label-success">Approved</span>
                                            <?php } elseif ($row['status'] == 2) { ?>
                                                <span class="label label-danger">Rejected</span>
                                            <?php } ?>
                                      </td>
                                      <td hidden></td>
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
<div class="modal fade" id="modal-approve-dinas-All" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 600px">
    <div class="modal-content">
      <div class="modal-header text-center">
        <button type="button" class="close hover" data-dismiss="modal">&times;</button>
        <h3>Approval Perizinan Dinas</h3>
      </div>
      <div class="modal-body" style="width: 100%; text-align: center;">
        <div class="row">
          <div class="col-lg-12">
            <label class="col-lg-3 text-right">ID Dinas</label><label class="col-lg-1">:</label>
            <input  class="form-control col-lg-8" name="id_dinasAll" id="modal-id_dinasAll" readonly  style="width: 55%">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-lg-12">
            <label class="col-lg-3 text-right">Tanggal</label><label class="col-lg-1">:</label>
            <input  class="form-control col-lg-8" name="tgl_dinasAll" id="modal-tgl_dinasAll" readonly  style="width: 55%">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-lg-12">
            <label class="col-lg-3 text-right">Akan Keluar</label><label class="col-lg-1">:</label>
            <input  class="form-control col-lg-8" name="keluar_dinasAll" id="modal-keluar_dinasAll" readonly  style="width: 55%">
          </div>
        </div>
        <br>
        <div class="row">
          <div class="col-lg-12">
            <label class="col-lg-3 text-right">Keperluan</label><label class="col-lg-1">:</label>
            <textarea class="form-control col-lg-8" name="kep_dinasAll" id="modal-kep_dinasAll" readonly  style="width: 55%"></textarea>
          </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <label class="col-lg-3 text-right">Atasan</label><label class="col-lg-1">:</label>
                <div class="text-left">
                    <select class="form-control select select2" name="modal-Atasan_dinasAll" id="modal-Atasan_dinasAll" style="width: 55%; vertical-align: left !important;">
                        <option></option>
                        <?php foreach ($atasan as $key): ?>
                            <option value="<?php echo $key['employee_code'] ?>"><?php echo $key['employee_code'].' - '.$key['employee_name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <label class="col-lg-3 text-right">Alasan</label><label class="col-lg-1">:</label>
                <textarea class="form-control col-lg-8" name="modal-AlasanAll" id="modal-AlasanAll"  style="width: 55%"></textarea>
            </div>
        </div>
        <br>
        <div class="row">
            <table border="1" width="500px" style="margin-left: 50px;">
                <thead>
                    <th style="text-align: center; white-space: nowrap;">No. Induk</th>
                    <th style="text-align: center; white-space: nowrap;">Nama</th>
                    <th style="text-align: center; white-space: nowrap;">Tujuan</th>
                </thead>
                <tbody class="eachPekerjaEditAll">

                </tbody>
            </table>
        </div>
        <br>
          <div class="modal-footer" style="text-align: center;">
            <div>
              <button type="button" class="btn btn-success" id="app_edit_DinasAll" value="1">Save</button>
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

    $('a[data-toggle="tab"]').on( 'shown.bs.tab', function (e) {
        $.fn.dataTable.tables( { api: true} ).columns.adjust();
        setTimeout(
          function () {
            $('th:contains(Order)').click()
          }, 200
        )
    } );

    $('.tabel_izin_dinas_all').DataTable({
      scrollX: true,
      fixedColumns:   {
        leftColumns: 5,
      }
    });
    $('.tabel_izin_dinas_approve').DataTable({
      scrollX: true,
      fixedColumns:   {
        leftColumns: 5,
      }
    });
    $('.tabel_izin_dinas_check').DataTable();
    $('.tabel_izin_dinas_reject').DataTable({
      scrollX: true,
      fixedColumns:   {
        leftColumns: 5,
      }
    });
  })
</script>
