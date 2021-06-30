<section class="content">
  <div class="panel panel-primary">
    <div class="panel-heading">
      <h1>Export Tahunan</h1>
    </div>
    <div class="panel-body">
      <form action="<?= base_url('SystemIntegration/KaizenPekerjaTks/TeamKaizen/Export/Tahunan/doExport') ?>">
        <div class="form-group form-inline" style="width: 100%;">
          <label>Tahun:</label>
          <div class="input-group date" style="width: 20%;margin-right:10px;">
            <div class="input-group-addon">
              <i class="fa fa-calendar"></i>
            </div>
            <input type="text" class="form-control pull-right js-year-picker" name="year" value="<?= date('Y') ?>">
          </div>
          <button class="btn btn-primary btn-md">Export</button>
        </div>
      </form>
    </div>
  </div>
</section>

<script>
  $(() => {
    $('.js-year-picker').datepicker({
      autoClose: true,
      format: "yyyy",
      viewMode: "years",
      minViewMode: "years",
    })
  })
</script>