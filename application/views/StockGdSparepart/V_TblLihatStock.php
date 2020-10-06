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
                <th>ATT</th>
                <th>Min</th>
                <th>Max</th>
                <th>Lokasi Simpan</th>
                <th>SubInventory</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-nowrap">
        <?php $i = 1; foreach ($data as $val) { 
            if ($val['MIN'] != '' || $val['MAX'] != '') {
                $avg = ($val['MIN'] + $val['MAX']) / 2;
                if ($val['MIN'] >= $val['ONHAND']) {
                    $td = 'bg-danger';
                }elseif ($val['ONHAND'] > $val['MAX']) {
                    $td = 'bg-success';
                }elseif ($val['ONHAND'] < ($avg / 2)) {
                    $td = 'bg-warning';
                }else {
                    $td = '';
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
                <td class="<?= $td?>"><input type="hidden" id="kode_brg<?= $i?>" value="<?= $val['ITEM']?>"><?= $val['ITEM']?></td>
                <td class="<?= $td?>" style="text-align:left"><input type="hidden" id="nama_brg<?= $i?>" value="<?= $val['DESCRIPTION']?>"><?= $val['DESCRIPTION']?></td>
                <td class="<?= $td?>"><input type="hidden" id="satuan<?= $i?>" value="<?= $val['UOM']?>"><?= $val['UOM']?></td>
                <td class="<?= $td?>"><input type="hidden" id="in<?= $i?>" value="<?= $val['SUM_QTY_IN']?>"><?= $val['SUM_QTY_IN']?></td>
                <td class="<?= $td?>"><input type="hidden" id="out<?= $i?>" value="<?= $val['SUM_QTY_OUT1']?>"><?= $val['SUM_QTY_OUT']?></td>
                <td class="<?= $td?>" style="font-weight:bold"><input type="hidden" id="onhand<?= $i?>" value="<?= $val['ONHAND']?>"><?= $val['ONHAND']?></td>
                <td class="<?= $td?>"><input type="hidden" id="att<?= $i?>" value="<?= $val['ATT']?>"><?= $val['ATT']?></td>
                <td class="<?= $td?>"><input type="hidden" id="min<?= $i?>" value="<?= $val['MIN']?>"><?= $val['MIN']?></td>
                <td class="<?= $td?>"><input type="hidden" id="max<?= $i?>" value="<?= $val['MAX']?>"><?= $val['MAX']?></td>
                <td class="<?= $td?>"><input type="hidden" id="alamat<?= $i?>" value="<?= $val['LOKASI']?>"><?= $val['LOKASI']?></td>
                <td class="<?= $td?>"><input type="hidden" id="subinv<?= $i?>" value="<?= $val['SUBINV']?>"><?= $val['SUBINV']?></td>
                <td class="<?= $td?>"><button type="button" class="btn btn-md btn-info" onclick="modalHistory(<?= $i?>)"><i class="fa fa-search"></i></button>
                   <button type="button" class="btn btn-md bg-teal" onclick="modalGambarItem(<?= $i?>)"><i class="fa fa-photo"></i></button>
                </td>
            </tr>
        <?php $i++; } ?>
        </tbody>
    </table>
</div>
<div class="col-md-12">
    <table class="table" style="width: 100%;">
        <tr>
            <td colspan="2" style="font-weight:bold">Keterangan :</td>
        </tr>
        <tr>
            <td class="bg-danger"></td>
            <td> Kondisi jika onhand < MIN</td>
            <td class="bg-warning"></td>
            <td> Kondisi jika onhand < average : 2</td>
            <td class="bg-success"></td>
            <td> Kondisi jika onhand > MAX</td>
        </tr>
    </table>
</div>

<div class="modal fade" id="mdlHistory" role="dialog">
    <div class="modal-dialog" style="width:90%">
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

<div class="modal fade" id="mdlGambarItem" role="dialog">
    <div class="modal-dialog" style="padding-right:5px">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h3 class="modal-title">Gambar Item</h3></center>
        </div>
        <div class="modal-body">
            <div id="datagambar"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
</div>