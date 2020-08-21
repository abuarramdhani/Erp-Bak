<table class="table table-bordered text-left" id="mpk_tblRKK" style="font-size:12px;">
    <thead class="bg-primary">
        <tr>
            <th style="text-align:center;">No</th>
            <th style="text-align:center; width: 100px;" data-sortable="false">Action</th>
            <th style="text-align:center;">Noind</th>
            <th style="text-align:center;">Nama</th>
            <th style="text-align:center;">Seksi</th>
            <th style="text-align:center;">Dept</th>
            <th style="text-align:center;">Tanggal</th>
            <th style="text-align:center;">Kondisi</th>
            <th style="text-align:center;">Penyebab</th>
            <th style="text-align:center;">Tindakan</th>
            <th style="text-align:center;">Keterangan</th>
            <th style="text-align:center;">Oleh</th>
        </tr>
    </thead>
    <tbody>
    <?php $i=1; foreach ($list as $key ): ?>
        <?php if (trim($key['keluar']) == 'f'): ?>
            <tr>
        <?php else: ?>
            <tr class="bg-danger">
        <?php endif ?>
            <td><?=$i?></td>
            <td class="text-center">
                <button title="edit data" class="btn btn-primary btn-sm mpk_btnuprk" value="<?=$key['id_rkk']?>">
                    <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-danger btn-sm mpk_btndelrk" value="<?=$key['id_rkk']?>" title="hapus data">
                    <i class="fa fa-trash"></i>
                </button>
            </td>
            <td><?=$key['noind']?></td>
            <td><?=$key['nama']?></td>
            <td><?=$key['seksi']?></td>
            <td><?=$key['dept']?></td>
            <td><?=substr($key['tanggal'], 0,10)?></td>
            <td><?=$key['kondisi']?></td>
            <td><?=$key['penyebab']?></td>
            <td><?=$key['tindakan']?></td>
            <td><?=$key['keterangan']?></td>
            <td><?=$key['user_']?></td>
        </tr>
    <?php $i++; endforeach ?>
    </tbody>
</table>
<div class="col-md-6" style="padding-left: 0px;">
    <div class="col-md-1" style="padding-left: 0px;">
        <div style="width: 30px;height: 30px;" class="bg-danger"></div>
    </div>
    <div class="col-md-6" style="padding-left: 0px;">    
        <label style="margin-top: 3px">pekerja telah keluar</label>
    </div>
</div>