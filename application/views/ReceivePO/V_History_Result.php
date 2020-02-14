<?php
      if ($result == null) { ?>
        <div class="col-md-12">
        <h3 style="font-weight: bold;text-align: center;">No Data History</h3>
        </div>
    <?php } else { ?>
    <div class="col-md-4">
     <table id="uwuuwu" class="table table-condensed" style="width: 100%">
      <?php 
      $angka=1; 
       foreach ($result as $list) { 
    ?>
       <thead style="display:none;">
        <tr>	
          <th></th>
          <tr>	
          </thead>
          <tbody >

           <tr>	
            <td><button onclick="Detail(<?=$angka?>)" id="buttonpo<?=$angka?>" class="btn btn-default btn-flat btn-sm" style ="width:100%; " value="<?=$list['PO_NUMBER'] ?>" >Nomor PO : <?=$list['PO_NUMBER'] ?> <br> Surat jalan : <?=$list['SHIPMENT_NUMBER'] ?></button></td>
            <input type="hidden" name="suratjalan" id="suratjalan<?=$angka?>" value = "<?=$list['SHIPMENT_NUMBER'] ?>" >
          </tr>
        </tbody>
      <?php 
        $angka++; } } ?>
    </table>
  </div>
  <div class="col-md-8" id="detail" >

  </div>