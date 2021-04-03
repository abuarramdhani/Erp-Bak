<div>
  <b id="atas"></b>
</div>
<div class="table-responsive">
  <table class="table table-striped table-bordered table-hover text-left dataTable-TCT" style="font-size:12px;">
    <thead>
      <tr class="bg-primary">
        <th><center>NO</center></th>
        <th><center>KODE</center></th>
        <th><center>NAMA</center></th>
        <th><center>SUBINVENTORY</center></th>
        <th><center>LOCATOR</center></th>
        <th><center>TRANSACTION DATE</center></th>
        <th><center>TRANSACTION QUANTITY</center></th>
        <th><center>SOURCE TYPE</center></th>
        <th><center>SOURCE</center></th>
        <th><center>TRANSACTION TYPE</center></th>
        <th><center>NO MESIN</center></th>
        <th><center>COST CENTER</center></th>
        <th><center>DESKRIPSI MESIN</center></th>
        <th><center>SEKSI</center></th>
        <th><center>KOMPONEN YANG DIPROSES</center></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($get_filter as $key => $gf): ?>
      <tr>
        <td style="text-align:center"><?php echo $key+1 ?></td>
        <td style="text-align:center;min-width:120px"><?php echo $gf['KODE']?></td>
        <td style="text-align:center;min-width"><?php echo $gf['NAMA']?></td>
        <td style="text-align:center"><?php echo $gf['SUBINVENTORY_CODE']?></td>
        <td style="text-align:center"><?php echo $gf['LOCATOR']?></td>
        <td style="text-align:center;min-width:135px"><?php echo $gf['TRANSACTION_DATE']?></td>
        <td style="text-align:center;min-width:165px"><?php echo $gf['TRANSACTION_QUANTITY']?></td>
        <td style="text-align:center;min-width:100px"><?php echo $gf['SOURCE_TYPE']?></td>
        <td style="text-align:center"><?php echo $gf['SOURCE']?></td>
        <td style="text-align:center;min-width:130px"><?php echo $gf['TRANSACTION_TYPE']?></td>
        <td style="text-align:center;min-width:80px"><?php echo $gf['NO_MESIN']?></td>
        <td style="text-align:center;min-width:100px"><?php echo $gf['COST_CENTER']?></td>
        <td style="text-align:center;min-width:200px"><?php echo $gf['DESC_MESIN']?></td>
        <td style="text-align:center"><?php echo $gf['SEKSI_PENGEBON']?></td>
        <td style="text-align:center;min-width:200px"><?php echo $gf['KOMPONEN']?></td>
      </tr>
      <?php endforeach;?>
    </tbody>
  </table>
  </div>
  <script type="text/javascript">
  $('.dataTable-TCT').DataTable( {
    // "pagingType": "scrolling";
    paging: false,
    scrollX: true,
    scrollY: "550px"
    // scrollCollapse: true,
    // scroller: true,
    // deferRender: true
  });
  </script>
