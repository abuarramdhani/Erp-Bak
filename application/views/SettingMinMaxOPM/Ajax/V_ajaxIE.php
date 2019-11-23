<table id="tableDataMinMaxIE" class="table table-striped table-bordered table-responsive table-hover">
  <thead style="background:#22aadd; color:#FFFFFF;">
    <th style="text-align:center; width: 5%">NO</th>
    <th class="text-center check-all"><input type="checkbox" id="check-all"/></th>
    <th style="text-align:center; width: 15%">ITEM CODE</th>
    <th style="text-align:center; width: 20%">DESCRIPTION</th>
    <th style="text-align:center; width: 10%">UOM</th>
    <th style="text-align:center; width: 10%">MIN</th>
    <th style="text-align:center; width: 10%">MAX</th>
    <th style="text-align:center; width: 15%">ROP</th>
    <?php
      if ($org == 'ODM') {
        echo '<th style="text-align:center; width: 10%">LIMIT JOB</th>';
      }
    ?>
    <th style="display:none">ACTION</th>
  </thead>
  <tbody>
    <?php $i = 1; foreach ($minmax as $mm) { 	?>
    <tr id="<?php echo $mm['SEGMENT1']; ?>" row-id="">
      <td style="text-align:center" class="no"><?php echo $i++; ?>.</td>
      <td style="text-align:center"></td>
      <td style="text-align:center" class="code"><?php echo $mm['SEGMENT1']; ?></td>
      <td style="text-align:center" class="desc"><?php echo $mm['DESCRIPTION']; ?></td>
      <td style="text-align:center" class="uom"><?php echo $mm['PRIMARY_UOM_CODE']; ?></td>
      <td style="text-align:center" class="min"><?php echo $mm['MIN']; ?></td>
      <td style="text-align:center" class="max"><?php echo $mm['MAX']; ?></td>
      <td style="text-align:center" class="rop"><?php echo $mm['ROP']; ?></td>
      <?php
      if ($org == 'ODM') {
      ?>
      <td style="text-align:center" class="limit"><?php echo $mm['LIMITJOB']; ?></td>
      <?php
      }
       ?>
      <td style="display:none">
        <a class="btn btn-warning btn-xs" title="Edit" href="<?php echo base_url(); ?>SettingMinMax/EditbyRoute<?php echo '/EditItem/'.$org.'/'.$routeaktif.'/'.$mm['SEGMENT1'] ?>"><span class="icon-edit"></span> Edit</a>
      </td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<script type="text/javascript">

//SETTING CURRENT DATE//
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth() + 1; //January is 0!
var yyyy = today.getFullYear();
if (dd < 10) {
  dd = '0' + dd;
}
if (mm < 10) {
  mm = '0' + mm;
}
today = dd + '-' + mm + '-' + yyyy;

          // var today = new Date();
          // var dd = String(today.getDate()).padStart(2, '0');
          // var mm = String(today.getMonth() + 1).padStart(2, '0');
          // var yyyy = today.getFullYear();

          // today = dd + '-' + mm + '-' + yyyy;

  var dtd2 = $('#tableDataMinMaxIE').DataTable({
    dom: '<"dataTable_Button"B><"dataTable_Filter"f>rt<"dataTable_Information"i><"dataTable_Paging"p>',
    columnDefs: [
      {
        orderable: false,
        className: 'select-checkbox',
        targets: 1
      }
    ],
        buttons: [
      {
        extend: 'excelHtml5',
        title: 'Edit Data Min Max'+' : '+today,
        exportOptions: {
          columns: ':visible',
          // rows: ':visible',
          modifier: {
                        selected: true
                    },
          columns: [0, 2, 3, 4, 5, 6, 7, 8],

        }
      }
    ],
        select: {
            style: 'multi',
            selector: 'td:nth-child(2)'
        },
        order: [[0, 'asc']]
  })

  $('#check-all').change(function(){
      if($(this).is(':checked')) {
          // Checkbox is checked..
          console.log('hai');
          dtd2.rows().select();
      } else {
          // Checkbox is not checked..
          console.log('hai hai');
          dtd2.rows().deselect();
      }
  });

  $(".loader").fadeOut("slow");


</script>
