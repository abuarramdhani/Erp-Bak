<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Data Host Down ICT Ping Checker</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-hover table-striped tblMonitoringPingICT">
                        <thead>
                            <tr class="bg-primary">
                                <th>No</th>
                                <th>Create Date</th>
                                <th>IP Address</th>
                                <th>Link</th>
                                <th>Action</th>
                                <th>No Ticket</th>
                                <th>Action By</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=0; foreach ($ip as $key => $list) { $no++;
                                if($list['ip'] == '172.16.100.93' || $list['ip'] == '172.16.100.9') {
                                    $link = 'IconPlus PUSAT-BANJARMASIN';
                                }else if($list['ip'] == '172.16.100.25' || $list['ip'] == '172.16.100.26') {
                                    $link = 'IconPlus PUSAT-JAKARTA';
                                }else if($list['ip'] == '172.16.100.61' || $list['ip'] == '172.16.100.62') {
                                    $link = 'IconPlus PUSAT-LANGKAPURA';
                                }else if($list['ip'] == '172.16.100.29' || $list['ip'] == '172.16.100.30') {
                                    $link = 'IconPlus PUSAT-MAKASSAR';
                                }else if($list['ip'] == '172.16.100.17' || $list['ip'] == '172.16.100.18') {
                                    $link = 'IconPlus PUSAT-MEDAN';
                                }else if($list['ip'] == '172.16.100.21' || $list['ip'] == '172.16.100.22') {
                                    $link = 'IconPlus PUSAT-MLATI';
                                }else if($list['ip'] == '172.16.100.101' || $list['ip'] == '172.16.100.102') {
                                    $link = 'IconPlus PUSAT-PALU';
                                }else if($list['ip'] == '172.16.100.89' || $list['ip'] == '172.16.100.90') {
                                    $link = 'IconPlus PUSAT-PEKANBARU';
                                }else if($list['ip'] == '172.16.100.49' || $list['ip'] == '172.16.100.50') {
                                    $link = 'IconPlus PUSAT-PONTIANAK';
                                }else if($list['ip'] == '172.16.100.9' || $list['ip'] == '172.16.100.10') {
                                    $link = 'IconPlus PUSAT-SURABAYA';
                                }else if($list['ip'] == '172.16.100.5' || $list['ip'] == '172.16.100.6') {
                                    $link = 'IconPlus PUSAT-TUKSONO';
                                }else if($list['ip'] == '172.18.22.1' || $list['ip'] == '172.18.22.2') {
                                    $link = 'LDP PUSAT-TUKSONO';
                                }else if($list['ip'] == '192.168.38.25') {
                                    $link = 'TUKSONO PNP';
                                }else if($list['ip'] == '192.168.38.11') {
                                    $link = 'TUKSONO SHEET METAL';
                                }else if($list['ip'] == '192.168.38.22') {
                                    $link = 'TUKSONO MACH TIMUR';
                                }else if($list['ip'] == '192.168.38.203') {
                                    $link = 'TUKSONO MACH BARAT';
                                }else if($list['ip'] == '192.168.38.14') {
                                    $link = 'TUKSONO FOUNDRY';
                                }else if($list['ip'] == '192.168.38.24') {
                                    $link = 'TUKSONO HTM';
                                }
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td><?= date("d-F-Y <b>H:i</b>",strtotime($list['creation_date']));?></td>
                                    <td><?= $list['ip'];?></td>
                                    <td><?= $link;?></td>
                                    <td><?= $list['action'];?></td>
                                    <td><?= $list['no_ticket'];?></td>
                                    <td><?= $list['action_by'];?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

