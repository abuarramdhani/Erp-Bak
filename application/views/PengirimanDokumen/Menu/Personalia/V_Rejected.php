<style>
    .center{
        text-align: center;
    }
    tbody>tr>td{
        text-align: center;
    }
	thead>tr{
		font-weight: bold;
	}
</style>
<section class="content">
    <div class="panel-body">
        <div class="row">
            <div class="box box-danger box-solid">
                <div class="box-header with-border">
                    <h2><b>Data Rejected - Personalia <?=$lv?></b></h2>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="datatable table table-striped table-bordered table-hover text-left SendDocument" style="font-size: 12px;">
                            <thead class="bg-primary center">
                                <tr>
                                    <td>No</td>
                                    <td>Nomor Induk</td>
                                    <td>Nama</td>
                                    <td>Keterangan</td>
                                    <td>Tanggal</td>
                                    <td>Tanggal Reject</td>
                                    <td>Alasan</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($table as $row): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $row['noind'] ?></td>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= $row['keterangan'] ?></td>
                                        <td><?= $row['tanggal'] ?></td>
                                        <td><?= $row['tgl_update'] ?></td>
                                        <td><?= $row['alasan'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>