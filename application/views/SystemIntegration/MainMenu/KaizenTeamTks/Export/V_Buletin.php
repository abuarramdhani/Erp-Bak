<section class="content">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <div style="display: flex; justify-content: flex-end;">
        <h1>Export Buletin</h1>
      </div>
    </div>
    <div class="panel-body col-12">
      <form action="<?= base_url('SystemIntegration/KaizenPekerjaTks/TeamKaizen/Export/Buletin/doExport') ?>">
        <div class="form-group form-inline" style="width: 100%;">
          <label>Tahun:</label>
          <div class="input-group date" style="width: 20%;margin-right:10px;">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right js-month-picker-start" name="month_start" value="<?= date('Y-m')  ?>">
          </div>
          <div class="input-group date" style="width: 20%;margin-right:10px;">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right js-month-picker-end" name="month_end" value="<?= date('Y-m') ?>">
          </div>
          <button id="buletin-submit" type="submit" class="btn btn-primary btn-md">Export</button>
        </div>
        <small class="text-danger" for="">*) Max periode adalah 3 bulan </small>
      </form>
    </div>
  </div>
</section>
<script>
  $(() => {
    const $monthPickerStart = $('.js-month-picker-start')
    const $monthPickerEnd = $('.js-month-picker-end')

    /**
     * Maksimal range bulan adalah 3 bulan
     * "Ini permintaan dari user"
     */
    const MAX_MONTH_DIFF = 2;

    $monthPickerStart.datepicker({
      autoClose: true,
      format: "yyyy-mm",
      viewMode: "months",
      minViewMode: "months",
    })

    $monthPickerEnd.datepicker({
      autoClose: true,
      format: "yyyy-mm",
      viewMode: "months",
      minViewMode: "months",
    })

    /**
     * Event for date start
     * 
     *  
     */
    $monthPickerStart.on('change', function() {
      var month = $(this).datepicker('getDate').getMonth(); //('getMonth');            
      var year = $(this).datepicker('getDate').getFullYear(); //('getFullYear');   

      var minDate = new Date(year, month, 1);
      var maxDate = new Date(year, month + 3, 0);

      $monthPickerEnd.datepicker('setStartDate', minDate)
      $monthPickerEnd.datepicker('setEndDate', maxDate)
      $monthPickerEnd.datepicker('setDate', minDate)

    })

    $('button#buletin-submit').on('click', function(e) {
      e.preventDefault()

      Swal.fire('Chart masih belum sempurna', 'Silahkan untuk mengedit sesuai kebutuhan', 'info').then(() => $('form').submit())
    })

  })
</script>