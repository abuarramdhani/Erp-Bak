<div class="table-responsive" >
    <table class="datatable table table-bordered table-hover table-striped text-center" id="tbl_arsip" style="width: 100%;">
        <thead class="bg-black">
            <tr>
                <th>No</th>
                <th>Tanggal Dibuat</th>
                <th>Tanggal Input</th>
                <th>Jenis Dokumen</th>
                <th>No Dokumen</th>
                <th>Jumlah Item</th>
                <th>Jumlah Pcs</th>
                <th>Mulai Pelayanan</th>
                <th>Selesai Pelayanan</th>
                <th>Waktu Pelayanan</th>
                <th>PIC Pelayanan</th>
                <th>Mulai Packing</th>
                <th>Selesai Packing</th>
                <th>Waktu Packing</th>
                <th>PIC Packing</th>
                <th>Keterangan</th>
                <th>Tanggal Cancel</th>
                <th>Jumlah Coly</th>
                <th>Edit Coly</th>
                <th style="width:50px">Cetak</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1;foreach ($data as $key => $val) {?>
            <tr>
                <td><?= $no?>
                    <input type="hidden" id="jenis<?= $no?>" value="<?= $val['JENIS_DOKUMEN']?>">
                    <input type="hidden" id="nospb<?= $no?>" value="<?= $val['NO_DOKUMEN']?>">
                </td>
                <td><?= $val['TGL_DIBUAT']?></td>
                <td><?= $val['JAM_INPUT']?></td>
                <td><?= $val['JENIS_DOKUMEN']?></td>
                <td><?= $val['NO_DOKUMEN']?></td>
                <td><?= $val['JUMLAH_ITEM']?></td>
                <td><?= $val['JUMLAH_PCS']?></td>
                <td><?= $val['MULAI_PELAYANAN']?></td>
                <td><?= $val['SELESAI_PELAYANAN']?></td>
                <td><?= $val['WAKTU_PELAYANAN']?></td>
                <td><?= $val['PIC_PELAYAN']?></td>
                <td><?= $val['MULAI_PACKING']?></td>
                <td><?= $val['SELESAI_PACKING']?></td>
                <td><?= $val['WAKTU_PACKING']?></td>
                <td><?= $val['PIC_PACKING']?></td>
                <td><?= $val['URGENT'].' '.$val['BON']?></td>
                <td><?= $val['CANCEL']?></td>
                <td><?= $val['COLY']?></td>
                <td><button type="button" class="btn btn-md bg-teal" onclick="editColy(<?= $no?>)">Edit Coly</button></td>
                <td>                <?php echo '<a href="'.base_url().'KapasitasGdSparepart/Pelayanan/cetakPL/'.$val['NO_DOKUMEN'].'" target="_blank" class="btn btn-danger btn-md"><i class="fa fa-file-pdf-o"> PL1</i></a>
                          								<a href="'.base_url().'KapasitasGdSparepart/Pelayanan/cetakPL2/'.$val['NO_DOKUMEN'].'" target="_blank" class="btn btn-danger btn-md mt-2"><i class="fa fa-file-pdf-o"> PL2</i></a>
                          								<a href="'.base_url().'KapasitasGdSparepart/Pelayanan/cetakSM/'.$val['NO_DOKUMEN'].'" target="_blank" class="btn btn-info btn-md mt-2"><i class="fa fa-file-pdf-o"> SM</i></a>' ?></td>

            </tr>
            <?php $no++; }?>
        <tbody>
    </table>
</div>
