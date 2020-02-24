        <table>
            <tbody>
                <tr>
                    <td> <strong>No DOSP</strong> </td>
                    <td>&emsp; : &emsp;&emsp;</td>
                    <td> <?= reset($DetailDO)['NO_DO'] ?> </td>
                </tr>
                <tr>
                    <td> <strong>No SO</strong> </td>
                    <td>&emsp; : &emsp;&emsp;</td>
                    <td> <?= reset($DetailDO)['NO_SO'] ?> </td>
                </tr>
                <tr>
                    <td> <strong>Relasi</strong> </td>
                    <td>&emsp; : &emsp;&emsp;</td>
                    <td> <?= reset($DetailDO)['NAMA_CUST'] ?> </td>
                </tr>            
                <tr>
                    <td> <strong>Alamat</strong> </td>
                    <td>&emsp; : &emsp;&emsp;</td>
                    <td> <?= reset($DetailDO)['ALAMAT'] ?> </td>
                </tr>
            </tbody>
        </table> <br>
        <div style="overflow: auto;">
        <table class="table-hoverable">
            <thead>
                <tr>
                    <th >No</th>
                    <th >Kode Barang</th>
                    <th >Nama Barang</th>
                    <th >Qty Request</th>
                    <th >QTY ATR</th>
                    <th >UOM</th>
                    <th >Lokasi Gudang</th>
                </tr>
            </thead>                        
            <tbody>
                <?php foreach ($DetailDO as $key => $val) : ?>
                    <tr>
                        <td class="text-right"><?= $key+1 ?></td>
                        <td class="text-left"><?= $val['KODE_BARANG'] ?></td>
                        <td class="text-left"><?= $val['NAMA_BARANG'] ?></td>
                        <td class="text-right"><?= $val['REQ_QTY'] ?></td>
                        <td class="text-right"><?= $val['QTY_ATR'] ?></td>
                        <td class="text-left"><?= $val['UOM'] ?></td>
                        <td class="text-left"><?= $val['LOKASI_GUDANG']->load() ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>