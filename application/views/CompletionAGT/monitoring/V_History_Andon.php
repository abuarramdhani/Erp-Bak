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
    <label for="">Select Date Range</label>
    <input type="text" name="" class="form-control tanggal_agt_history_andon" placeholder="Select Yout Current Date" required="" >
  </div>
  <div class="col-md-2">
    <label for="" style="color:transparent">Ini Filter</label>
    <button type="button" onclick="filter_history_agt()" style="font-size:15px" class="btn btn-primary btn-sm btn-block"> <i class="fa fa-search"></i> <strong>Filter</strong> </button>
  </div>
</div>
<hr>
<p class="label label-success ckmb_data" style="font-size:13px;margin-bottom:15px;"><i class="fa fa-tag"></i> Menampilkan <?php echo count($get) ?> data terbaru</p>
<div style="margin-top:18.5px">
  <table class="table table-bordered agt-history-andon" style="width:100%">
    <thead>
      <tr class="bg-primary">
        <td> No</td>
        <td> Item ID</td>
        <td> Component Code</td>
        <td> Component Name</td>
        <td> No Job</td>
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
          <td><?php echo $value['ITEM_ID'] ?></td>
          <td><?php echo $value['KODE_ITEM'] ?></td>
          <td><?php echo $value['DESCRIPTION'] ?></td>
          <td><b><?php echo $value['NO_JOB'] ?></b></td>
          <td><?php echo $value['STATUS_JOB'] ?></td>
          <td><?php echo $value['TIMER_POS_1'] ?></td>
          <td><?php echo $value['TIMER_POS_2'] ?></td>
          <td><?php echo $value['TIMER_POS_3'] ?></td>
          <td><?php echo $value['TIMER_POS_4'] ?></td>
          <td><?php echo $value['CREATION_DATE'] ?></td>
          <td> <center><button type="button" class="btn btn-success" name="button"> <i class="fa fa-edit"></i> Edit </button></center> </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $('.agt-history-andon').DataTable();
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
    },
  );
  })
</script>
