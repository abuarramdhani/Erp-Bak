<style media="screen">
.btn-group{
margin-bottom: -40px !important;
}
</style>
<br>
<div class="row">
  <div class="col-md-12">
    <div class="alert bg-primary alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">
          <i class="fa fa-close"></i>
        </span>
      </button>
      <strong>Sekilas Info! </strong> Klik 2 kali jika hanya memilih 1 tanggal</strong>
    </div>
  </div>
  <div class="col-md-10">
    <label for="">Filter By Date Range</label>
    <input type="text" name="" class="form-control tanggal_agt_history_andon" placeholder="Select Yout Current Date" required="" >
  </div>
  <div class="col-md-2">
    <label for="" style="color:transparent">Ini Filter</label>
    <button type="button" onclick="filter_history_agt()" style="font-size:15px" class="btn btn-primary btn-sm btn-block"> <i class="fa fa-search"></i> <strong>Filter</strong> </button>
  </div>
</div>
<hr>
<p class="label label-success agt_label_history" style="font-size:13px;margin-bottom:15px;"><i class="fa fa-tag"></i> Menampilkan <?php echo count($get) ?> data terbaru</p>

<div style="margin-top:18.5px" class="area_history_filtered">
  <table class="table table-bordered agt-history-andon" style="width:100%">
    <thead>
      <tr class="bg-primary">
        <td> No</td>
        <td > Item ID</td>
        <td> Component Code</td>
        <td> Component Name</td>
        <td> No Job</td>
        <td> Serial</td>
        <td> Running Pos</td>
        <td> Time Post 1</td>
        <td> Time Post 2</td>
        <td> Time Post 3</td>
        <td> Time Post 4</td>
        <td> Creation Date</td>
        <td> Action</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get as $key => $value): ?>
        <tr>
          <td><?php echo $key+1 ?></td>
          <td ><?php echo $value['ITEM_ID'] ?></td>
          <td><?php echo $value['KODE_ITEM'] ?></td>
          <td><?php echo $value['DESCRIPTION'] ?></td>
          <td><b><?php echo $value['NO_JOB'] ?></b></td>
          <td><b><?php echo $value['SERIAL'] ?></b></td>
          <td><center><button type="button" class="btn btn-sm" name="button" style="font-weight:bold"><?php echo $value['STATUS_JOB'] ?></button><center> </td>
          <td><?php echo $value['TIMER_POS_1'] ?></td>
          <td><?php echo $value['TIMER_POS_2'] ?></td>
          <td><?php echo $value['TIMER_POS_3'] ?></td>
          <td><?php echo $value['TIMER_POS_4'] ?></td>
          <td><?php echo $value['DATE_TIME'] ?></td>
          <td>
            <center>
              <button type="button" class="btn btn-sm btn-danger" <?php echo $value['STATUS_JOB'] != 'POS_5' ? 'disabled' : '' ?> name="button" style="width:40px;" onclick="del_agt_andon_pos('<?php echo $value['ITEM_ID'] ?>', 2, '<?php echo $value['DATE_TIME'] ?>')"> <i class="fa fa-trash"></i> </button>
            </center>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script type="text/javascript">
let j90 = 0;
let h87 = [];
  for (var i = 0; i < 12; i++) {
    h87.push(i)
  }
  $('.agt-history-andon').DataTable({
    columnDefs: [
      {orderable: false, targets: [12]},
    ],
    select: {
        style: 'multi',
        selector: 'tr'
    },
    dom: 'Bfrtip',
    buttons: [
      'pageLength',
      {
        extend: 'excelHtml5',
        title: 'History Andon ~ Exported At <?php echo date('d-m-y') ?>',
        exportOptions: {
          columns: ':visible',
          columns: h87,
        }
      }
     ],
  });

  $(document).ready(function () {
    $(".tanggal_agt_history_andon").daterangepicker(
    {
      showDropdowns: true,
      autoApply: true,
      locale: {
        format: "YYYY-MM-DD",
        separator: " - ",
        applyLabel: "OK",
        cancelLabel: "Batal",
        fromLabel: "Dari",
        toLabel: "Hingga",
        customRangeLabel: "Custom",
        weekLabel: "W",
        daysOfWeek: ["Mg", "Sn", "Sl", "Rb", "Km", "Jm", "Sa"],
        monthNames: [
          "Januari",
          "Februari",
          "Maret",
          "April",
          "Mei",
          "Juni",
          "Juli",
          "Agustus ",
          "September",
          "Oktober",
          "November",
          "Desember",
        ],
        firstDay: 1,
      },
    });
});

function filter_history_agt() {
 j90 = 1;
 let val = $('.tanggal_agt_history_andon').val();
 $.ajax({
   url: baseurl + 'CompletionAssemblyGearTrans/action/filter_history_agt',
   type: 'POST',
   // dataType: 'JSON',
   data: {
     range_date: val,
   },
   cache:false,
   beforeSend: function() {
     $('.area_history_filtered').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                           <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                           <span style="font-size:14px;font-weight:bold">Sedang memproses data...</span>
                                       </div>`);
   },
   success: function(result) {
    $('.area_history_filtered').html(result);
    $('.agt_label_history').hide();
   },
   error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalAGT('error', 'Terdapat Kesalahan...');
    $('.area_history_filtered').html('')
    console.error();
   }
 })
}


</script>
