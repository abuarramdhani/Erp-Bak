<div style="margin-bottom:15px">
  <b id="atas"></b>
</div>
  <div class="table-responsive">
      <table class="datatable table table-striped table-bordered table-hover text-left" id="tblMoulding2021" style="font-size:12px;">
          <thead class="bg-primary">
              <tr>
                  <th style="text-align:center; width:30px">No</th>
                  <th style="text-align:center; min-width:80px">Action</th>
                  <th style="text-align:center">Component Code</th>
                  <th style="text-align:center">Component Description</th>
                  <th style="text-align:center">Production Date</th>
                  <th style="text-align:center">Kode Cetak</th>
                  <th style="text-align:center">Shift</th>
                  <th style="text-align:center">Komponen (pcs)</th>
                  <th style="text-align:center">Kode</th>
                  <th style="text-align:center">Jumlah Pekerja</th>
                  <th style="text-align:center">Bongkar Qty</th>
                  <th style="text-align:center">Scrap Qty</th>
                  <th style="text-align:center">Hasil Baik</th>
              </tr>
          </thead>
          <tbody>

          </tbody>
      </table>
  </div>
<script type="text/javascript">
  $(document).ready(function () {
    const tblmouldajax = $('#tblMoulding2021').DataTable({
      ajax: {
        data: (d) => $.extend({}, d, {
          bulan: '<?php echo $bulan ?>',
          tanggal: '<?php echo $tanggal ?>',
        }),
        url: baseurl + "ManufacturingOperationUP2L/Moulding/buildMDataTable",
        type: 'POST',
      },
      language:{
        processing: "<div class='overlay custom-loader-background'><i class='fa fa-cog fa-spin custom-loader-color' style='color:#fff'></i></div>"
      },
      ordering: false,
      pageLength: 10,
      pagingType: 'first_last_numbers',
      processing: true,
      serverSide: true,
      preDrawCallback: function(settings) {
           if ($.fn.DataTable.isDataTable('#tblMoulding2021')) {
               var dt = $('#tblMoulding2021').DataTable();

               //Abort previous ajax request if it is still in process.
               var settings = dt.settings();
               if (settings[0].jqXHR) {
                   settings[0].jqXHR.abort();
               }
           }
       }
    });
  });
</script>
