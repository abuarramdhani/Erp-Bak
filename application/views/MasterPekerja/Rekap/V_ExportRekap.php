<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-12">
                            <div class="text-right"><h1> <b>Export Laporan Kunjungan</b></h1></div>
                        </div>
                    </div>
                </div>
                <br/>

                <div class="panel box-body" style="height: 100px;">
                <center>
                <form target="_blank" method="get" action="<?php echo base_url('MasterPekerja/LaporanKunjungan/cetakExcel'); ?>">
                   <div class="col-lg-12" style="padding-top: 20px;">
                        <div class="col-lg-3">
                          
                        </div>
                        <div align="center" class="col-lg-1 text-center" style="height: 100%;">
                          <b>Periode</b> 
                      </div>
                      <div class="col-lg-3">
                        <input type="text" name="periode" class="form-control" />
                      </div>
                      <div class="col-lg-3" align="left">
                          <button class="btn btn-primary" type="submit">Submit</button>
                      </div>
                   </div>
                  </form> 
                  </center>
                   </div>
            </div>    
        </div>
    </div>
</section> 

<script type="text/javascript">
$(function() {

  $('input[name="periode"]').daterangepicker({
      autoUpdateInput: false,
      locale: {
          cancelLabel: 'Clear'
      }
  });

  $('input[name="periode"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
  });

  $('input[name="periode"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });

});
</script>        