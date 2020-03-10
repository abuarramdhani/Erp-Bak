<script src="<?php echo base_url('assets/plugins/dataTables/jquery.dataTables.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/dataTables/dataTables.bootstrap.js');?>"></script>
    <script>
         $(document).ready(function () {
            $('.myTable').dataTable({
                "scrollX": true,
            });
         });
    </script>
<div class="table-responsive">
    <table class="datatable table table-bordered table-hover table-striped myTable text-center" id="myTable" style="width: 100%;">
        <thead class="bg-primary text-nowrap">
            <tr>
                <th>No</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Satuan</th>
                <th>In</th>
                <th>Out</th>
                <th>Onhand</th>
                <th>Min</th>
                <th>Max</th>
                <th>Alamat</th>
                <th>SubInventory</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; foreach ($data as $val) { 
            if ($val['MIN_MINMAX_QUANTITY'] != '' || $val['MAX_MINMAX_QUANTITY'] != '') {
                $avg = ($val['MIN_MINMAX_QUANTITY'] + $val['MAX_MINMAX_QUANTITY']) / 2;
                if ($val['MIN_MINMAX_QUANTITY'] > $val['ONHAND']) {
                    $td = 'bg-danger';
                }elseif ($val['ONHAND'] > $val['MAX_MINMAX_QUANTITY']) {
                    $td = 'bg-success';
                }elseif ($val['ONHAND'] < ($avg / 2)) {
                    $td = 'bg-warning';
                }
            }else {
                $td = '';
            }
        ?>
            <tr>
                <td class="<?= $td?>"><?= $i?>
                    <input type="hidden" id="tglAwl<?= $i?>" value="<?= $tglAw?>">
                    <input type="hidden" id="tglAkh<?= $i?>" value="<?= $tglAk?>">
                    <input type="hidden" id="subinv<?= $i?>" value="<?= $subinv?>">
                </td>
                <td class="text-nowrap <?= $td?>"><input type="hidden" id="kode_brg<?= $i?>" value="<?= $val['ITEM']?>"><?= $val['ITEM']?></td>
                <td class="<?= $td?>" style="text-align:left"><input type="hidden" id="nama_brg<?= $i?>" value="<?= $val['DESCRIPTION']?>"><?= $val['DESCRIPTION']?></td>
                <td class="<?= $td?>"><input type="hidden" id="satuan<?= $i?>" value="<?= $val['UOM']?>"><?= $val['UOM']?></td>
                <td class="<?= $td?>"><input type="hidden" id="in<?= $i?>" value="<?= $val['SUM_QTY_IN']?>"><?= $val['SUM_QTY_IN']?></td>
                <td class="<?= $td?>"><input type="hidden" id="out<?= $i?>" value="<?= $val['SUM_QTY_OUT1']?>"><?= $val['SUM_QTY_OUT']?></td>
                <td class="<?= $td?>"><input type="hidden" id="onhand<?= $i?>" value="<?= $val['ONHAND']?>"><?= $val['ONHAND']?></td>
                <td class="<?= $td?>"><input type="hidden" id="min<?= $i?>" value="<?= $val['MIN_MINMAX_QUANTITY']?>"><?= $val['MIN_MINMAX_QUANTITY']?></td>
                <td class="<?= $td?>"><input type="hidden" id="max<?= $i?>" value="<?= $val['MAX_MINMAX_QUANTITY']?>"><?= $val['MAX_MINMAX_QUANTITY']?></td>
                <td class="<?= $td?>"><input type="hidden" id="alamat<?= $i?>" value=""></td>
                <td class="<?= $td?>"><input type="hidden" id="subinv<?= $i?>" value="<?= $val['SUBINV']?>"><?= $val['SUBINV']?></td>
                <td class="<?= $td?>"><button type="button" class="btn btn-md btn-info" onclick="modalHistory(<?= $i?>)"><i class="fa fa-search"></i></button></td>
            </tr>
        <?php $i++; } ?>
        </tbody>
    </table>
</div>

<div class="modal fade" id="mdlHistory" role="dialog">
    <div class="modal-dialog" style="width:80%">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h3 class="modal-title">Detail Transaksi</h3></center>
        </div>
        <div class="modal-body">
            <div id="dataHistory"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
</div>