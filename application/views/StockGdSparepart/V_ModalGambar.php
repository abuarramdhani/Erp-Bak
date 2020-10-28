<?php
$filename = './assets/upload/wipp/setelah/'.$kode.'.png';
if (file_exists($filename)) {
			$image = '<img style="max-width: 1000px;max-height: 1000px" src="'. base_url("".$filename."").'">';
			$ket = '';
		}else {
			$image = '<img style="max-width: 100px;max-height: 100px" src="'. base_url("./assets/img/delete2.png").'">';
			$ket = 'Gambar tidak ditemukan...';
        }
?>

<div class="panel-body">
    <div class="col-md-12 text-center">
        <span><?= $image?></span>
        <p><?= $ket?></p>
    </div>
</div>
<div class="panel-body">
    <div class="col-md-12">
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <label>Kode Barang</label>
        </div>
        <div class="col-md-9">: <?= $kode?></div>
    </div>
    <div class="col-md-12">
        <div class="col-md-1"></div>
        <div class="col-md-2">
            <label>Deskripsi Barang</label>
        </div>
        <div class="col-md-9">: <?= $nama?></div>
    </div>
</div>