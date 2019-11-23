<table id="tableDataMinMax" class="table table-striped table-bordered table-responsive table-hover" >
  <thead style="background:#22aadd; color:#FFFFFF;">
    <th style="text-align:center; width: 5%">NO</th>
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
    <th style="text-align:center; width: 5%">ACTION</th>
  </thead>
  <!-- trial data body -->
  <tbody>
    <?php $i=1; $j=0;foreach ($minmax as $mm) { 	?>
    <tr row-id="">
      <td style="text-align:center"><?php echo $i++; ?></td>
      <td style="text-align:center"><?php echo $mm['SEGMENT1']; ?></td>
      <input type="hidden" name="seg1[<?=$j ?>]" value="<?= $mm['SEGMENT1'] ?>">
      <td style="text-align:center"><?php echo $mm['DESCRIPTION']; ?></td>
      <td style="text-align:center"><?php echo $mm['PRIMARY_UOM_CODE']; ?></td>
      <td style="text-align:center"><?php echo $mm['MIN']; ?></td>
      <td style="text-align:center"><?php echo $mm['MAX']; ?></td>
      <td style="text-align:center"><?php echo $mm['ROP']; ?></td>
      <?php
      if ($org == 'ODM') {
      ?>
      <td style="text-align:center">
        <input type="checkbox" name="limitjob[<?=$j ?>]" value="Y" data-code="<?php echo $mm['SEGMENT1']; ?>" data-value="Y" class="cekcekSMM"
      <?php
        // echo $mm['LIMITJOB'];
        if ($mm['LIMITJOB'] == 'Y') {
          echo ' checked="checked"';
         }
      ?>
       >
      </td>
      <?php
        }
      ?>
      <td style="text-align:center">
        <a class="btn btn-warning btn-xs" title="Edit" href="<?php echo base_url(); ?>SettingMinMax/EditbyRoute<?php echo '/EditItem/'.$org.'/'.$routeaktif.'/'.$mm['SEGMENT1'] ?>"><span class="icon-edit"></span> Edit</a>
      </td>
    </tr>
    <?php $j++; } ?>
  </tbody>
</table>

<script type="text/javascript">

$('.cekcekSMM').change(function(){

    if($(this).is(':checked')) {
        // Checkbox is checked..
        const ascode = $(this).attr('data-code')
        const asval = $(this).attr('data-value')

        console.log(ascode+'|'+asval+'aku di cek');

          $.ajax({
            method: 'POST',
            async: false,
            dataType: 'json',
            url: baseurl + 'SettingMinMaxOPM/C_settingMinMaxOPM/updateKilat',
            data: {
              code: ascode,
              data: asval,
            },
            success: function(hasil) {
              console.log(hasil);
              Swal.fire({
                position: 'middle',
                type: 'success',
                title: 'success checked',
                showConfirmButton: false,
                timer: 900
              })
            },
          })
    } else {
        // Checkbox is not checked..
          const ascode = $(this).attr('data-code');
          const asval = null;

          console.log(ascode+'|'+asval+'aku ga di cek');

          $.ajax({
            method: 'POST',
            async: false,
            dataType: 'json',
            url: baseurl + 'SettingMinMaxOPM/C_settingMinMaxOPM/updateKilat',
            data: {
              code: ascode,
              data: asval,
            },
            success: function(hasil) {
              console.log(hasil);
              Swal.fire({
                position: 'middle',
                type: 'success',
                title: 'success Unchecked',
                showConfirmButton: false,
                timer: 900
              })
            },
          })
    }
});
</script>
