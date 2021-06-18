<div style="margin-bottom:15px">
  <b id="top"></b>
</div>
<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover text-left datatable-handling" style="font-size:13px">
    <thead>
      <tr class="bg-primary">
        <th class="bg-primary" style="text-align:center;width:5%;">No</th>
        <th class="bg-primary" style="text-align:center;width:10%;">Tanggal Audit</th>
        <th style="text-align:center;width:15%;">Poin Penyimpangan</th>
        <th style="text-align:center;width:10%;">Foto Before</th>
        <th style="text-align:center;width:20%;">Action Plan</th>
        <th style="text-align:center;width:10%;">Foto After</th>
        <th style="text-align:center;width:20%;">Alasan Verifikasi Masih Open</th>
        <th style="text-align:center;width:10%">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; foreach ($getDataAudite as $key => $value):
        $encrypted_string = $this->encrypt->encode($value['id_temuan']);
		    $encrypted_string = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string);
        $encrypted_string2 = $this->encrypt->encode($value['id']);
        $encrypted_string2 = str_replace(array('+', '/', '='), array('-', '_', '~'), $encrypted_string2);?>
        <?php
          if (!empty($getDataAudite[$key+1]['alasan_masih_open']) && $value['id'] == $getDataAudite[$key+1]['id']){
            $alasan_masih_open = $getDataAudite[$key+1]['alasan_masih_open'];
          }else {
            $alasan_masih_open = '';
          }
         ?>
        <?php if ($key >= 1):
          $keyq = $key-1;?>
          <?php if ($value['id'] == $getDataAudite[$keyq]['id'])  {
            continue;
          }?>
      <tr style="<?php echo $value['status'] != 'CLOSE' ? '' : 'background-color:rgb(48 222 134);color:black'?>">
        <td style="text-align:center;min-width:30px;font-weight:bold"><?php echo $no ?></td>
        <td style="text-align:center;min-width:120px;font-weight:bold"><?php echo $value['tanggal_audit'] ?></td>
        <td style="min-width:280px;font-weight:bold"><?php echo $value['poin_penyimpangan'] ?></td>
        <td style="min-width:140px">
          <a href="#" data-toggle="modal" data-target="#showbefore" data-backdrop="static" data-id="<?php echo $value['id_temuan'] ?>" style="<?php echo $value['status'] != 'CLOSE' ? '' : 'color:black'?>">
            <i><?php echo $value['foto_before'] ?></i>
          </a>
        </td>
        <td style="min-width:280px;font-weight:bold"><?php echo $value['action_plan'] ?></td>
        <td style="min-width:140px">
          <a href="#" data-toggle="modal" data-target="#showafter" data-backdrop="static" data-id="<?php echo $value['id_jawaban'] ?>" style="<?php echo $value['status'] != 'CLOSE' ? '' : 'color:black'?>">
            <i><?php echo $value['foto_after'] ?></i>
          </a>
        </td>
        <td style="min-width:280px;font-weight:bold"><?php echo $alasan_masih_open ?></td>
        <td style="text-align:center;min-width:120px;vertical-align:middle">
            <a class="btn btn-danger"
              href="<?php echo base_url('RekapTemuanAudite/Handling/pdfHandling/'.$encrypted_string2.' '.$encrypted_string.'') ?>" target="_blank" title="Export Data to PDF">
              <i class="fa fa-file-pdf-o"></i>
            </a>
        </td>
      </tr>
      <?php else: ?>
        <tr style="<?php echo $value['status'] != 'CLOSE' ? '' : 'background-color:rgb(48 222 134);color:black'?>">
          <td style="text-align:center;min-width:30px;font-weight:bold"><?php echo $no ?></td>
          <td style="text-align:center;min-width:120px;font-weight:bold"><?php echo $value['tanggal_audit'] ?></td>
          <td style="min-width:280px;font-weight:bold"><?php echo $value['poin_penyimpangan'] ?></td>
          <td style="min-width:140px">
            <a href="#" data-toggle="modal" data-target="#showbefore" data-backdrop="static" data-id="<?php echo $value['id_temuan'] ?>" style="<?php echo $value['status'] != 'CLOSE' ? '' : 'color:black'?>">
              <i><?php echo $value['foto_before'] ?></i>
            </a>
          </td>
          <td style="min-width:280px;font-weight:bold"><?php echo $value['action_plan'] ?></td>
          <td style="min-width:140px">
            <a href="#" data-toggle="modal" data-target="#showafter" data-backdrop="static" data-id="<?php echo $value['id_jawaban'] ?>" style="<?php echo $value['status'] != 'CLOSE' ? '' : 'color:black'?>">
              <i><?php echo $value['foto_after'] ?></i>
            </a>
          </td>
          <td style="min-width:280px;font-weight:bold"><?php echo $alasan_masih_open ?></td>
          <td style="text-align:center;min-width:120px;vertical-align:middle">
              <a class="btn btn-danger"
                href="<?php echo base_url('RekapTemuanAudite/Handling/pdfHandling/'.$encrypted_string2.' '.$encrypted_string.'') ?>" target="_blank" title="Export Data to PDF">
                <i class="fa fa-file-pdf-o"></i>
              </a>
          </td>
        </tr>
      <?php endif; ?>
      <?php $no++; endforeach; ?>
    </tbody>
  </table>
</div>
<?php //echo "<pre>";print_r($getDataAudite);die; ?>
<!-- Modal Before -->
<div class="modal fade" id="showbefore" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>Foto Before</b></h4>
      </div>
      <div class="modal-body">
        <div class="modal-data-before"></div>
      </div>
    </div>
  </div>
</div>
<!-- Modal After -->
<div class="modal fade" id="showafter" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>Foto After</b></h4>
      </div>
      <div class="modal-body">
        <div class="modal-data-after"></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function () {
    $('.datatable-handling').dataTable({
      scrollX: true,
      scrollY: 400,
      ordering: true,
      filterInput: 120,
      fixedColumns: {
        leftColumns: 2,
      },
      columnDefs: [
        {orderable: false, targets: [2,3,4,5,6,7]}
      ],
    });
    })
    // $('.dataTables_filter input[type=search]').removeClass('form-control');
    $('.dataTables_filter input[type="search"]').css(
      {'width':'400px','display':'inline-block'}
    );
  $('#showbefore').on('show.bs.modal', function(e) {
    var getGambar = $(e.relatedTarget).data('id');
    $.ajax({
      url: baseurl + 'RekapTemuanAudite/Handling/getGambarBefore',
      type: 'POST',
      data: {
        id: getGambar,
      },
      cache: false,
      beforeSend: function() {
        $('.modal-data-before').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                    <img style="width: 25%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                    <span style="font-size:13px;font-weight:bold;margin-top:5px">Gambar sedang dimuat...</span>
                                </div>`);
      },
      success: function(data) {
        $('.modal-data-before').html(data);
      }
      });
    });
  $('#showafter').on('show.bs.modal', function(e) {
    var getGambar = $(e.relatedTarget).data('id');
    $.ajax({
      url: baseurl + 'RekapTemuanAudite/Handling/getGambarAfter',
      type: 'POST',
      data: {
        id: getGambar,
      },
      cache: false,
      beforeSend: function() {
        $('.modal-data-after').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                    <img style="width: 25%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                    <span style="font-size:13px;font-weight:bold;margin-top:5px">Gambar sedang dimuat...</span>
                                </div>`);
      },
      success: function(data) {
        $('.modal-data-after').html(data);
      }
      });
    });
</script>
