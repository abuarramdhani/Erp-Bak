<br>
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left " id="tblMonitoringDO" style="font-size:12px;">
    <thead>
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
            if ($g['CHECK'] == 'false') {
              $styleSetting = 'style="background:rgba(210, 90, 90, 0.49)"';
            }else {
              $styleSetting = '';
            }
       ?>

       <tr row-id="<?php echo $no ?>" <?php echo $styleSetting ?>>
         <input type="hidden" name="cekdodo" id="checkDODO" value="<?php echo $g['CHECK'] ?>">
         <td><center><?php echo $no ?></center></td>
         <td><center><?php echo $g['DO/SPB'] ?></center></td>
         <td><center><?php echo $g['NO_SO'] ?></center></td>
         <td><center><?php echo $g['TUJUAN'] ?></center></td>
         <td><center><?php echo $g['KOTA'] ?></center></td>
         <td><center><?php echo $g['PLAT_NUMBER'] ?></center></td>
         <td>
           <center>
             <div class="form-group">
               <input class="form-control uppercaseDO" type="text" id="person_id" name="person_id" placeholder="Assign">
             </div>
           </center>
         </td>
         <td><center><button type="button" class="btn btn-info" name="button" style="font-weight:bold;" onclick="detail('<?php echo $g['DO/SPB'] ?>', <?php echo $g['HEADER_ID'] ?>, <?php echo $no ?>, <?php echo $g['NO_SO'] ?>)" data-toggle="modal" data-target="#MyModal2">
           <i class="fa fa-eye"></i></button> </center></td>
       </tr>

     <?php $no++; } }?>
   </tbody>
 </table>
</div>
<script type="text/javascript">
 $('#tblMonitoringDO').DataTable();
</script>
