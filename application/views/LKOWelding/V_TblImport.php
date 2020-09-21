<div class="col-md-1">
    <label>Tanggal</label>
</div>
<div class="col-md-3">
    <input type="text" class="form-control" />
</div>
<div class="col-md-1">
    <label>File</label>
</div>
<div class="col-md-3">
    <input type="file" class="form-control" />
</div>
<div class="col-md-2">
    <button formaction="<?php echo base_url('LaporanKerjaOperator/Input/ImportFile'); ?>"></button>
</div>
<div class="col-md-2">
    <button formaction="<?php echo base_url('LaporanKerjaOperator/Input/DownLoadLayout'); ?>"></button>
</div>
<div class="col-md-12" style="margin-top: 10px;">
    <table class="table table-bordered" id="tbl_hasil_lko">
        <thead class="bg-green">
            <tr>
                <th class="text-center bg-green" rowspan="2" style="vertical-align: middle;font-size:8pt">NO</th>
                <th class="text-center bg-green" rowspan="2" style="vertical-align: middle;font-size:8pt">NO INDUK</th>
                <th class="text-center bg-green" rowspan="2" style="vertical-align: middle;font-size:8pt">NAMA PEKERJA</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;font-size:8pt">URAIAN PEKERJAAN</th>
                <th class="text-center" colspan="3">PENCAPAIAN</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;font-size:8pt">SHIFT</th>
                <th class="text-center" rowspan="2" style="vertical-align: middle;font-size:8pt">KET</th>
                <th class="text-center" colspan="8" style="vertical-align: middle;font-size:8pt">KONDITE</th>
                <th class="text-center" style="font-size: 8pt;" style="vertical-align: middle;font-size:8pt" rowspan="2">ACTION</th>
            </tr>
            <tr>
                <th class="text-center">TGT</th>
                <th class="text-center">ACT</th>
                <th class="text-center">%</th>
                <th class="text-center">MK</th>
                <th class="text-center">I</th>
                <th class="text-center">BK</th>
                <th class="text-center">TKP</th>
                <th class="text-center">KP</th>
                <th class="text-center">KS</th>
                <th class="text-center">KK</th>
                <th class="text-center">PK</th>
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
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td class="text-center"><a class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-pencil"></i></a> <a class="btn btn-danger btn-xs" title="Delete"><i class="fa fa-remove"></td>
            </tr>
        </tbody>
    </table>
</div>