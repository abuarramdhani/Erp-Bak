<table class="table table-bordered table-hover table-striped text-center" id="tb_peserta_psikotest" style="width: 100%;">
    <thead style="background-color:#63E1EB">
        <tr class="text-nowrap">
            <!-- <th style="width:7%;">No</th> -->
            <th>Nama Peserta</th>
            <th>No. Handphone</th>
            <th>Kode Akses</th>
            <th style="width:15%">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data as $key => $value) {?>
        <tr id="tr_peserta<?= $no?>">
            <!-- <td><?= $no?></td> -->
            <td><?= $value['nama']?>
                <input type="hidden" name="nama_peserta[]" id="nama_peserta<?= $no?>" value="<?= $value['nama']?>">
                <input type="hidden" name="pendidikan[]" id="pendidikan<?= $no?>" value="<?= $value['pendidikan']?>">
                <input type="hidden" name="nik[]" id="nik<?= $no?>" value="<?= $value['nik']?>"></td>
            <td><input type="hidden" name="no_hp[]" id="no_hp<?= $no?>" value="<?= $value['nohp']?>"><?= $value['nohp']?></td>
            <td><input type="hidden" name="kode_akses[]" id="kode_akses<?= $no?>" value="<?= $value['kode_akses']?>"><?= $value['kode_akses']?></td>
            <td><button type="button" class="btn btn-xs btn-danger" onclick="delete_peserta_psikotest(<?= $no?>)"><i class="fa fa-trash"></i> Delete</button>
                <button type="button" class="btn btn-xs btn-info" style="margin-left:10px" onclick="preview_chat_psikotest(<?= $no?>)"><i class="fa fa-eye"></i> Preview</button>
            </td>
        </tr>
        <?php $no++; }?>
    </tbody>
</table>