<!-- <br> -->
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblMonitoringDO" style="font-size:12px;">
    <thead>
      <!-- <tr class="bg-primary">
        <th><center>NO</center></th>
        <th><center>NOMOR</center></th>
        <th><center>TUJUAN</center></th>
        <th><center>KOTA</center></th>
        <th><center>USER</center></th>
        <th><center>STATUS</center></th>
        <th><center>NEXT PROCESS</center></th>
        <th><center>DETAIL</center></th>
      </tr> -->
      <tr class="bg-primary">
        <th><center>NO</center></th>
        <th><center>NO.DOK</center></th>
        <th><center>NOMOR SO</center></th>
        <th><center>TUJUAN</center></th>
        <th><center>KOTA</center></th>
        <th><center>PLAT NOMOR</center></th>
        <th><center>ASSIGN</center></th>
        <th><center>DETAIL</center></th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (!empty($get[0]['DO/SPB'])) {
          $no = 1;
          foreach ($get as $g){
            // if ($g['CHECK'] == 'false') {
            //   $styleSetting = 'style="background:rgba(210, 90, 90, 0.49)"';
            // }else {
              $styleSetting = '';
            // }
       ?>

       <tr row-id="<?php echo $no ?>" <?php echo $styleSetting ?>>
         <!-- <input type="hidden" name="cekdodo" id="checkDODO" value="<?php echo $g['CHECK'] ?>"> -->
         <input type="hidden" id="cekSudahAssign">
         <td><center><?php echo $no ?></center></td>
         <td><center><?php echo $g['DO/SPB'] ?></center></td>
         <td><center><?php echo $g['NO_SO'] ?></center></td>
         <td><center><?php echo $g['TUJUAN'] ?></center></td>
         <td><center><?php echo $g['KOTA'] ?></center></td>
         <td><center><?php echo $g['PLAT_NUMBER'] ?></center></td>
         <td>
           <center>
             <div class="form-group">
                 <select class="form-control uppercaseDO select2MonitoringDO" id="person_id" name="person_id"></select>
               <!-- <input class="form-control uppercaseDO select2MonitoringDO" type="text" id="person_id" name="person_id" placeholder="Assign"> -->
             </div>
           </center>
         </td>
         <td><center><button type="button" class="btn btn-info" name="buttondetail" style="font-weight:bold;" onclick="detail('<?php echo $g['DO/SPB'] ?>', <?php echo $g['HEADER_ID'] ?>, <?php echo $no ?>, '<?php echo $g['NO_SO'] ?>', '<?php echo $g['PLAT_NUMBER'] ?>')" data-toggle="modal" data-target="#MyModal2">
           <i class="fa fa-eye"></i></button> </center></td>
       </tr>

     <?php $no++; } }?>
   </tbody>
 </table>
</div>
<script type="text/javascript">
 $('#tblMonitoringDO').DataTable({
   drawCallback: function(dt) {

  $('.select2MonitoringDO').select2({
    minimumInputLength: 2,
    placeholder: "Pilih Petugas",
    ajax: {
      url: baseurl + "MonitoringDO/SettingDO/petugas",
      dataType: "JSON",
      type: "POST",
      data: function (params) {
        return {
          term: params.term
        };
      },
      processResults: function (data) {
        return {
          results: $.map(data, function (obj) {
            return {
              id: obj.employee_code,
              text: obj.employee_code + ' - ' + obj.employee_name
            }
          })
        }
      }
    }
  })
 }
 });

//
// $(document).ready(function() {
// $('#tblMonitoringDO').dataTable({
//   drawCallback: function(dt) {
//
//  $('.select2MonitoringDO').select2({
//    minimumInputLength: 2,
//    placeholder: "Pilih Petugas",
//    ajax: {
//      url: baseurl + "MonitoringDO/SettingDO/petugas",
//      dataType: "JSON",
//      type: "POST",
//      data: function (params) {
//        return {
//          term: params.term
//        };
//      },
//      processResults: function (data) {
//        return {
//          results: $.map(data, function (obj) {
//            return {
//              id: obj.employee_code,
//              text: obj.employee_code + ' - ' + obj.employee_name
//            }
//          })
//        }
//      }
//    }
//  })
// }
// })

</script>
