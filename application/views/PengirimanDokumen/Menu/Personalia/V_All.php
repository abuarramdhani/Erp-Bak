<style>
    .center{
        text-align: center;
    }
    tbody>tr>td{
        text-align: center;
    }
    tbody>tr>td:first-child{
        width: 5%;
    }
	thead>tr{
		font-weight: bold;
	}
    .mt-5{
        margin-top: 10px;
    }
    .ml-10{
        margin-left: 14px;
    }
    .text-divider{margin: 2em 0; line-height: 0; text-align: center;}
    .text-divider span{background-color: #f5f5f5; padding: 1em; border-radius: 5px;}
    .text-divider:before{ content: " "; display: block; border-top: 1px solid #e3e3e3; border-bottom: 1px solid #f7f7f7;}
</style>
<section class="content">
    <div class="panel-body">
        <div class="row">
            <div class="box box-primary box-solid">
                <div class="box-header with-border">
                    <h2><b>Rekap Semua Dokumen</b></h2>
                </div>
                <div class="box-body">
                <form method="GET" action="">
                    <div class="form-group row">
                        <div class="col-lg-4">
                            <label class="col-sm-2 mt-5">Periode</label>
                            <div class="col-sm-10">
                                <input type="text" name="periode" class="form-control" value="<?php  echo (isset($_GET['periode']))? $_GET['periode'] : "" ?>" autocomplete="off" id="periode" placeholder="Periode">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-sm-4 mt-5">Dokumen</label>
                            <div class="col-sm-8">
                                <select class="form-control select2" name="doc" id="">
                                    <option value="all" <?php echo (isset($_GET['doc']) && $_GET['doc'] == 'all')? "selected":""; ?>>semua</option>
                                    <?php foreach($listDocument as $item): ?>
                                        <option value="<?= $item['id'] ?>" <?php echo (isset($_GET['doc']) && $_GET['doc'] == $item['id'])? "selected":""; ?>><?= $item['keterangan'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <label class="col-sm-2 mt-5">Seksi</label>
                            <div class="col-sm-10">
                                <select class="form-control select2" name="section" id="">
                                    <option value="all">semua</option>
                                    <?php foreach($listSeksi as $item): ?>
                                        <option value="<?= $item['kodesie'] ?>" <?php echo (isset($_GET['section']) && $_GET['section'] == $item['kodesie'])? "selected":""; ?>><?= $item['kodesie'].' - '.$item['seksi'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 text-left mt-5 ml-10">
                            <button class="btn btn-info" type="submit">Search <i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form >
                <h5 class="text-divider"><span><b><?= $info_periode ?></b></span></h5>
                    <div class="table-responsive">
                        <table class="datatable table table-striped table-bordered table-hover text-left RekapAll" style="font-size: 12px;">
                            <thead class="bg-primary center">
                                <tr>
                                    <td>No</td>
                                    <td>Tanggal</td>
                                    <td>Nomor Induk</td>
                                    <td>Nama</td>
                                    <td>Seksi</td>
                                    <td>Keterangan</td>
                                    <td>Status</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($table as $row): ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $row['tanggal'] ?></td>
                                    <td><?= $row['noind'] ?></td>
                                    <td><?= $row['nama'] ?></td>
                                    <td><?= $row['kodesie'] ?></td>
                                    <td><?= $row['keterangan'] ?></td>
                                    <td><?= $row['status'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>