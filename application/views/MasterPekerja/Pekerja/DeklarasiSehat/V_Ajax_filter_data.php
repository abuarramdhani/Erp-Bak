<style media="screen">
  .dt_dsehat td{
    vertical-align: middle !important;
    text-align: center;
  }
</style>
<div class="table-responsive">
  <table class="table table-bordered dt_dsehat" style="width:2300px">
    <thead class="bg-primary">
      <tr>
        <td>No.</td>
        <td style="width:135px !important">Nama Pekerja</td>
        <td style="width:150px !important">Seksi</td>
        <td>No. Induk</td>
        <?php foreach ($pertanyaan as $key => $value): ?>
          <td><?php echo substr($value['aspek'], 0,7) == 'aspek_2' ? 'Tidak ' : '' ?><?php echo $value['pertanyaan'] ?></td>
        <?php endforeach; ?>
      </tr>
    </thead>
    <tbody>
      <?php $no=1;foreach ($master as $key => $value): ?>
        <tr>
          <td><?php echo $no++ ?></td>
          <td><?php echo $value['nama'] ?></td>
          <td><?php echo $value['seksi'] ?></td>
          <td><?php echo $value['noind'] ?></td>
          <?php foreach ($pertanyaan as $key2 => $value2): ?>
            <?php if ($value[$value2['aspek']] == 't'){ ?>
              <td>✔️</td>
            <?php }else{ ?>
              <td style="background:#e9614e"></td>
            <?php } ?>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script type="text/javascript">
let ii = []
for (var i = 0; i < 15; i++) {
  ii.push(i);
}
  $('.dt_dsehat').dataTable({
      // dom: 'Bfrtip',
    // buttons: [
    //     'csv', 'excel', 'pdf'
    // ]
   //  buttons: [
   //  'pageLength',
   //  {
   //    extend: 'excelHtml5',
   //    title: 'Coba dari datatable ',
   //    exportOptions: {
   //      columns: ':visible',
   //      columns: ii,
   //    }
   //  }
   // ],
  });
</script>
