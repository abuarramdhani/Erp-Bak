<div class="table-responsive">
  <table class="table table-bordered table-striped table-hover text-left tb-poinpenyimpangan" style="font-size:14px;width:100%">
    <thead>
      <tr class="bg-primary">
        <th style="text-align:center;width:4%">No</th>
        <th style="text-align:center;width:56%">Poin Penyimpangan</th>
        <th style="text-align:center;width:16%">Last Update</th>
        <th style="text-align:center;width:14%">Last Update By</th>
        <th style="text-align:center;width:10%">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $no=1; foreach ($getPoinPenyimpangan as $key => $value): ?>
      <tr>
        <td style="text-align:center"><?php echo $no ?></td>
        <td><?php echo $value['poin'] ?></td>
        <td style="text-align:center"><?php echo $value['last_update_date'] ?></td>
        <td style="text-align:center"><?php echo $value['last_update_by'] ?></td>
        <td style="text-align:center">
          <a class="btn btn-primary" href="#" title="Update Poin Penyimpangan" data-id="<?php echo $value['id'] ?>" data-toggle="modal" data-target="#editpp" style="width:37px;margin-right:4px">
            <i class="fa fa-edit"></i>
          </a>
          <a class="btn btn-danger" title="Delete Poin Penyimpangan" data-id="<?php echo $value['id'] ?>" onclick="deletePP(<?php echo $value['id'] ?>)">
            <i class="fa fa-trash"></i>
          </a>
        </td>
      </tr>
      <?php $no++; endforeach; ?>
    </tbody>
  </table>
</div>
<!-- Modal Edit -->
<div class="modal fade" id="editpp" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>Update Poin Penyimpangan</b></h4>
      </div>
      <div class="modal-body">
        <div class="modal-editPP"></div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function () {
  $('.tb-poinpenyimpangan').dataTable({
    ordering: false,
  })
})
$('#editpp').on('show.bs.modal', function(e) {
  var getPP = $(e.relatedTarget).data('id');
  $.ajax({
    url: baseurl + 'MenjawabTemuanAudite/Handling/getPP',
    type: 'POST',
    data: {
      id: getPP,
    },
    cache: false,
    beforeSend: function () {
      $('.modal-editPP').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                  <span style="font-size:15px;font-weight:bold;margin-top:5px">Data sedang dimuat...</span>
                              </div>`);
    },
    success: function(data) {
      $('.modal-editPP').html(data);
    }
    });
  });
</script>
