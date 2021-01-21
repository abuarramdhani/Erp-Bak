<script>
$(document).ready(function () {
    $('#tbl<?= $iniket?>').DataTable({
        "scrollX" : true,
        "columnDefs": [{
            "targets": '_all',
        }],
    });
})
</script>
<?php 
$print = $iniket == 'ongoing' || $iniket == 'finished' ? '' : 'display:none'; // print hanya untuk resp. pendaftaran master item tabel ongoing dan finished
if (!empty($data)) {
?>
<table class="datatable table table-bordered table-hover table-striped text-center text-nowrap" id="tbl<?= $iniket?>" style="width: 100%;">
    <thead class="bg-<?= $warna?>">
    <tr>
        <th style="width: 5%">No</th>
        <th>No Dokumen</th>
        <th>Seksi</th>
        <th>Tanggal</th>
        <th>Status</th>
        <th style="width: 15%">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php $no = 1; foreach ($data as $val) {?>
        <tr>
            <td><input type="hidden" id="id_<?= $iniket?><?= $no?>" value="<?= $val['ID_REQUEST']?>"><?= $no?></td>
            <td><input type="hidden" id="no_<?= $iniket?><?= $no?>" value="<?= $val['NO_DOKUMEN']?>"><?= $val['NO_DOKUMEN']?></td>
            <td><input type="hidden" id="seksi_<?= $iniket?><?= $no?>" value="<?= $val['SEKSI']?>"><?= $val['SEKSI']?></td>
            <td><input type="hidden" id="tgl_<?= $iniket?><?= $no?>" value="<?= $val['TGL_REQUEST']?>"><?= date('d-m-Y', strtotime($val['TGL_REQUEST'])) ?></td>
            <td><input type="hidden" id="status_<?= $iniket?><?= $no?>" value="<?= $val['STATUS']?>"><?= $val['STATUS']?></td>
            <td><button type="button" class="btn btn-sm btn-info" onclick="modaldetailreq('<?= $iniket?>', <?= $no?>)"><i class="fa fa-search"></i> Detail</button>
            <button class="btn btn-sm btn-danger" style="<?= $print?>" formtarget="_blank" formaction="<?php echo base_url('PendaftaranMasterItem/Request/PrintRequest/'.$val['ID_REQUEST'].'')?>"><i class="fa fa-print"></i> Print</button></td>
        </tr>
    <?php $no++; }?>
    </tbody>
</table>
<?php
}else {
    echo '<h4 style="text-align:center;font-weight:bold;color:#444444">Data Kosong<h4>';
}
?>