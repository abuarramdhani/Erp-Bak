<div class="modal-header" style="font-size:25px;background-color:#82E5FA">
    <i class="fa fa-list-alt"></i> Detail Gudang
    <button type="button" class="close" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <div class="panel-body">
        <div class="col-md-2" style="font-weight:bold">Kode</div>
        <div class="col-md-10">: <?= $item?></div>
        <div class="col-md-2" style="font-weight:bold">Deskripsi</div>
        <div class="col-md-10">: <?= $desc?></div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-hovered table-stripped text-center" id="tbl_modal_simulasi" style="width:100%;font-size:12px">
            <thead style="background-color:#82E5FA">
                <tr>
                    <th style="vertical-align:middle">DFG</th>
                    <th style="vertical-align:middle">DMC</th>
                    <th style="vertical-align:middle">FG-TKS</th>
                    <th style="vertical-align:middle">INT-PAINT</th>
                    <th style="vertical-align:middle">INT-WELD</th>
                    <th style="vertical-align:middle">INT-SUB</th>
                    <th style="vertical-align:middle">INT-ASSYGT</th>
                    <th style="vertical-align:middle">INT-ASSY</th>
                    <th style="vertical-align:middle">INT-MACHA</th>
                    <th style="vertical-align:middle">INT-MACHB</th>
                    <th style="vertical-align:middle">INT-MACHC</th>
                    <th style="vertical-align:middle">INT-MACHD</th>
                    <th style="vertical-align:middle">PNL-TKS</th>
                    <th style="vertical-align:middle">SM-TKS</th>
                    <th style="vertical-align:middle">JUMLAH</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $dfg?></td>
                    <td><?= $dmc?></td>
                    <td><?= $fg_tks?></td>
                    <td><?= $int_paint?></td>
                    <td><?= $int_weld?></td>
                    <td><?= $int_sub?></td>
                    <td><?= $int_assygt?></td>
                    <td><?= $int_assy?></td>
                    <td><?= $int_macha?></td>
                    <td><?= $int_machb?></td>
                    <td><?= $int_machc?></td>
                    <td><?= $int_machd?></td>
                    <td><?= $pnl_tks?></td>
                    <td><?= $sm_tks?></td>
                    <td class="bg-info" style="font-weight:bold;"><?= $jumlah?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>