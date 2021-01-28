<div class="table-responsive" style="margin-top:13px;">
  <table class="table table-striped table-bordered table-hover text-left dt-fp-comp-proto" style="font-size:11px;">
    <thead class="bg-primary">
      <tr>
        <th style="text-align:center; width:5%">
            No
        </th>
        <th>
            Product
        </th>
        <th>
            Code
        </th>
        <th style="min-width: 100px">
            Number
        </th>
        <th style="min-width: 170px">
            Description
        </th>
        <th style="max-width: 20px;">
            Rev
        </th>
        <th style="min-width: 70px">
            Revision Date
        </th>
        <th>
            Material Type
        </th>
        <th style="min-width: 100px">
            Oracle Item
        </th>
        <th>
            Weight
        </th>
        <th>
            Status
        </th>
        <th>
            Upper Level
        </th>
        <th>
            Memo Number
        </th>
        <th style="min-width: 170px">
            Explanation
        </th>
        <th style="min-width: 170px">
            Changing Date
        </th>
        <th>
            Changing Status
        </th>
        <th>
            File
        </th>
        <th>
            Qty
        </th>
      </tr>
    </thead>
    <tbody>

    </tbody>
  </table>
</div>
<script type="text/javascript">
const tableflowproseProt = $('.dt-fp-comp-proto').DataTable({
  search: {
  "caseInsensitive": false
  },
  initComplete: function() {},
  processing: true,
  serverSide: true,
  "order": [],
  "ajax": {
    url: baseurl + 'FlowProses/Component/fpssc_proto',
    type: "POST",
  },
  "bSort": false,
  // lengthMenu: [ 10, 25, 50, 75, 100 , 1000],
})
$('#product_fp').change(function() {
  if ($('#fp_tipe_produk').val() == 'product') {
    tableflowproses.search($(this).val()).draw();
  }else {
    tableflowproseProt.search($(this).val()).draw();
  }
})
</script>
