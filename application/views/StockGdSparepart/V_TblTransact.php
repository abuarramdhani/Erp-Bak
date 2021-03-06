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
                <th>Alamat</th>
                <th>SubInventory</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1; foreach ($data as $val) { ?>
            <tr>
                <td><?= $i?>
                    <input type="hidden" id="tglAwl<?= $i?>" value="<?= $tglAw?>">
                    <input type="hidden" id="tglAkh<?= $i?>" value="<?= $tglAk?>">
                    <input type="hidden" id="subinv<?= $i?>" value="<?= $subinv?>">
                </td>
                <td class="text-nowrap"><input type="hidden" id="kode_brg<?= $i?>" value="<?= $val['ITEM']?>"><?= $val['ITEM']?></td>
                <td style="text-align:left"><input type="hidden" id="nama_brg<?= $i?>" value="<?= $val['DESCRIPTION']?>"><?= $val['DESCRIPTION']?></td>
                <td><input type="hidden" id="satuan<?= $i?>" value="<?= $val['UOM']?>"><?= $val['UOM']?></td>
                <td><input type="hidden" id="in<?= $i?>" value="<?= $val['SUM_QTY_IN']?>"><?= $val['SUM_QTY_IN']?></td>
                <td><input type="hidden" id="out<?= $i?>" value="<?= $val['QTY_OUT_AKTUAL']?>"><?= $val['SUM_QTY_OUT']?></td>
                <td><input type="hidden" id="onhand<?= $i?>" value="<?= $val['ONHAND']?>"><?= $val['ONHAND']?></td>
                <td><input type="hidden" id="alamat<?= $i?>" value=""></td>
                <td><input type="hidden" id="subinv<?= $i?>" value="<?= $val['SUBINV']?>"><?= $val['SUBINV']?></td>
                <td><button type="button" class="btn btn-md btn-info" onclick="modalHistory(<?= $i?>)"><i class="fa fa-search"></i></button></td>
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