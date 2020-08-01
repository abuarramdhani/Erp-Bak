<form name="Orderform" class="form-horizontal" onsubmit="return validasi();window.location.reload();" method="post">

    <table class="table table-bordered" id="reqhandling" style="width: 100%;">
        <thead class="bg-yellow">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Status</th>
                <th class="text-center">Pengorder</th>
                <th class="text-center">Seksi</th>
                <th class="text-center">Nama Dokumen</th>
                <th class="text-center">Produk</th>
                <th class="text-center">Sarana Handling</th>
                <th class="text-center">Action</th>


            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"><button formaction="<?php echo base_url('DbHandling/MonitoringHandling/detailreqhandling/2'); ?>" class="btn btn-success btn-sm">Detail</button></td>


            </tr>
        </tbody>
    </table>
</form>