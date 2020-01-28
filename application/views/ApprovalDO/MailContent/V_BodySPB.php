        <table>
            <tbody>
                <tr>
                    <td> <strong>No SPB</strong> </td>
                    <td>&emsp; : &emsp;&emsp;</td>
                    <td> <?= reset($DetailSPB)['NO_SPB'] ?> </td>
                </tr>
                <tr>
                    <td> <strong>Gudang Asal</strong> </td>
                    <td>&emsp; : &emsp;&emsp;</td>
                    <td> <?= reset($DetailSPB)['FROM_SUBINV'] ?> </td>
                </tr>
                <tr>
                    <td> <strong>Gudang Tujuan</strong> </td>
                    <td>&emsp; : &emsp;&emsp;</td>
                    <td> <?= reset($DetailSPB)['TO_SUBINV'] ?> </td>
                </tr>
            </tbody>
        </table> <br>
        <div style="overflow: auto;">
        <table class="table-hoverable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Qty Request</th>
                    <th>UOM</th>
                    <th>Gudang Asal</th>
                    <th>Gudang Tujuan</th>
                </tr>
            </thead>                        
            <tbody>
                <?php foreach ($DetailSPB as $key => $val) : ?>
                    <tr>
                        <td class="text-right"><?= $key+1 ?></td>
                        <td class="text-left"><?= $val['KODE_BARANG'] ?></td>
                        <td class="text-left"><?= $val['NAMA_BARANG'] ?></td>
                        <td class="text-right"><?= $val['REQ_QTY'] ?></td>
                        <td class="text-left"><?= $val['UOM'] ?></td>
                        <td class="text-left"><?= $val['FROM_SUBINV'] ?></td>
                        <td class="text-left"><?= $val['TO_SUBINV'] ?></td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>