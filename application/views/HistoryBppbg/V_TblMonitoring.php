<div class="panel-body">
    <div class="row">
        <div class="col-md-3">
            <center>
                <div style="background: #95f576; color: transparent; width: 20%; display: inline; border: 1px solid black;">______</div>
                <span style="display: inline; font-weight: bold;">: TRANSACT BERHASIL</span>
            </center>
        </div>
        <div class="col-md-3">
            <center>
                <div style="background: #f06f4f; color: transparent; width: 20%; display: inline; border: 1px solid black;">______</div>
                <span style="display: inline; font-weight: bold;">: TRANSACT BERMASALAH</span>
            </center>
        </div>
        <div class="col-md-3">
            <center>
                <div style="background: #fae48e; color: transparent; width: 20%; display: inline; border: 1px solid black;">______</div>
                <span style="display: inline; font-weight: bold;">: TRANSACT SEBAGIAN</span>
            </center>
        </div>
        <div class="col-md-3">
            <center>
                <div style="color: transparent; width: 20%; display: inline; border: 1px solid black;">______</div>
                <span style="display: inline; font-weight: bold;">: BON BARU & BELUM DI-TRANSACT</span>
            </center>
        </div>
    </div>
    <br><br>
    <table class="datatable table table-bordered table-hover table-striped text-center" id="tblMon" style="width: 100%;">
        <thead class="bg-primary">
            <tr>
                <th style="width: 5%; vertical-align: middle;">No</th>
                <th style="width: 10%; vertical-align: middle;">No Bon</th>
                <th style="width: 20%; vertical-align: middle;">Seksi Pengebon</th>
                <th style="width: 20%; vertical-align: middle;">Seksi Pemakai</th>
                <th style="width: 10%; vertical-align: middle;">Tanggal Pembuatan Bppbg</th>
                <th style="width: 10%; vertical-align: middle;">Gudang</th>
                <th style="width: 5%; vertical-align: middle;">Detail</th>
            </tr>
        </thead>
        <tbody>
            <?php $no=1; foreach ($mon as $i) { ?>
            <?php
                if ($i['MMT'] == 'Y' && $i['FLAG'] == 'Y') {
                    $color = '#95f576';
                }
                elseif ($i['MMT'] == 'N' && $i['FLAG'] == 'N') {
                    $color = '';
                }
                elseif ($i['MMT'] == 'Y' && $i['FLAG'] == 'N') {
                    $color = '#fae48e';
                }
                else {
                    $color = '#f06f4f';
                }
            ?>
            <tr style="background-color: <?= $color ?>">
                <td style="width: 5%;">
                    <?= $no; ?>
                </td>
                <td style="width: 10%;">
                    <?= $i['NO_BON'] ?>
                </td>
                <td style="width: 20%; text-align: left;">
                    <?= $i['SEKSI_BON'] ?>
                </td>
                <td style="width: 20%; text-align: left;">
                    <?= $i['SEKSI_PEMAKAI'] ?>
                </td>
                <td style="width: 10%;">
                    <?= $i['TANGGAL'] ?>
                </td>
                <td style="width: 10%;">
                    <?= $i['TUJUAN_GUDANG'] ?>
                </td>
                <td style="width: 5%;">
                    <button type="button" class="btn btn-info btn-sm" style="font-weight: bold;" onclick="detailBon('<?= $i['NO_BON'] ?>')" data-toggle="modal" data-target="#detailBon"><i class="fa fa-eye"></i>
                    </button>
                </td>
            </tr>
            <?php $no++;} ?>
        </tbody>
    </table>
</div>



<script type="text/javascript">
  $('#tblMon').DataTable({})
</script>