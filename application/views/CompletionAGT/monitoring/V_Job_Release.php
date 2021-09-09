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
  <div class="col-md-7">
    <label for="">Filter By Date Range</label>
    <input type="text" name="" class="form-control tanggal_agt_job_andon" placeholder="Select Yout Current Date" required="" >
  </div>
  <div class="col-md-3">
    <label for="">Sudah Cetak Picklist</label>
    <select class="andon_slc_cek_picklist" name="" style="width:100%">
      <option value="Y" selected>Ya</option>
      <option value="N">Tidak</option>
    </select>
  </div>
  <div class="col-md-2">
    <label for="" style="color:transparent">Ini Filter</label>
    <button type="button" onclick="filter_job_agt()" style="font-size:15px" class="btn btn-primary btn-sm btn-block"> <i class="fa fa-search"></i> <strong>Filter</strong> </button>
  </div>
</div>
<hr>
<p class="label label-success label_agt_job" style="font-size:13px;margin-bottom:15px;"><i class="fa fa-tag"></i> Menampilkan data dari <span class="tgl_job_agt_label"></span> </p>
<div style="margin-top:18.5px" class="area_job_filtered">

</div>

<script type="text/javascript">
  $('.andon_slc_cek_picklist').select2();
  $(document).ready(function(){
    setTimeout(function () {
      filter_job_agt();
    }, 50);
    $(".tanggal_agt_job_andon").daterangepicker(
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
    })
});

function filter_job_agt() {
 let val = $('.tanggal_agt_job_andon').val();
 $.ajax({
   url: baseurl + 'CompletionAssemblyGearTrans/action/filter_job_agt',
   type: 'POST',
   // dataType: 'JSON',
   data: {
     range_date: val,
     picklist: $('.andon_slc_cek_picklist').val()
   },
   cache:false,
   beforeSend: function() {
     $('.area_job_filtered').html(`<div style ="width: 70%;margin:auto;height: 30%;background: #fff;overflow: hidden;z-index: 9999;padding:20px 0 30px 0;border-radius:10px;text-align:center">
                                           <img style="width: 8%;" src="${baseurl}assets/img/gif/loading5.gif"><br>
                                           <span style="font-size:14px;font-weight:bold">Sedang memproses data...</span>
                                       </div>`);
     $('.label_agt_job').hide();
   },
   success: function(result) {
    $('.area_job_filtered').html(result);
    $('.tgl_job_agt_label').text(val);
    $('.label_agt_job').show()
   },
   error: function(XMLHttpRequest, textStatus, errorThrown) {
    swalLargeAGT('error', `${XMLHttpRequest.responseText}`);
    $('.area_job_filtered').html('')
    console.error();
   }
 })
}


</script>
