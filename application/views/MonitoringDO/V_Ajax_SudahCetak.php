<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblMonitoringDOSudahCetak" style="font-size:12px;width:100%">
    <thead>
      <tr class="bg-primary">
        <th style="width:5px"><center>NO</center></th>
        <th style="width:70px"><center>NO.DOK</center></th>
        <th style="width:200px"><center>JENIS KENDARAAN</center></th>
        <th><center>EKSPEDISI</center></th>
        <th style="width:70px"><center>PLAT NOMOR</center></th>
        <th style="width:70px"><center>ASSIGN</center></th>
        <th style="width:50px"><center>TGL PENGIRIMAN</center></th>
        <th style="width:15px"><center>DETAIL</center></th>
        <th style="width:15px"><center>CETAK</center></th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
</div>

<script type="text/javascript">
  // $('#tblMonitoringDOSudahCetak').DataTable();
  const tblmondo = $('#tblMonitoringDOSudahCetak').DataTable({
      // dom: 'rtp',
      ajax: {
        data: (d) => $.extend({}, d, {
          org: null,
          id_plan: null
        }),
        url: baseurl + "MonitoringDO/SettingDO/buildMDDataTable",
        type: 'POST',
      },
      ordering: false,
      pageLength: 10,
      pagingType: 'first_last_numbers',
      processing: true,
      serverSide: true,
      preDrawCallback: function(settings) {
           if ($.fn.DataTable.isDataTable('#tblMonitoringDOSudahCetak')) {
               var dt = $('#tblMonitoringDOSudahCetak').DataTable();

               //Abort previous ajax request if it is still in process.
               var settings = dt.settings();
               if (settings[0].jqXHR) {
                   settings[0].jqXHR.abort();
               }
           }
       }
  });

</script>
