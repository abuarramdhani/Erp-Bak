<style>
.btnunit {
  background-color: #6AD1FF;
  border: none;
  text-align: center;
  margin: 4px 2px;
  transition: 0.3s;
  width:150px;
  height:70px;
  white-space: normal;
  margin-bottom:15px;
}

.btnunit:hover {
  background-color: #5DB5DE;
}
</style>
<div class="col-md-2">
        <label class="control-label">Kode Unit :</label>
</div>
<?php if ($subinv == 'SP-YSP') { ?>
    <div class="col-md-1">
        <?php for ($i=0; $i < 3; $i++) { 
            echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
            <button type="button" class="btn btn-md btn-info" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
            <span style="color:black;font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
        }?>
    </div>
    <div class="col-md-1">
        <?php for ($i=3; $i < 6; $i++) { 
            echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
            <button type="button" class="btn btn-md btn-info" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
            <span style="color:black;font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
        }?>
    </div>
    <div class="col-md-1">
        <?php for ($i=6; $i < 9; $i++) { 
            echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
            <button type="button" class="btn btn-md btn-info" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
            <span style="color:black;font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
        }?>
    </div>
    <div class="col-md-1">
        <?php for ($i=9; $i < 12; $i++) { 
            echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
            <button type="button" class="btn btn-md btn-info" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
            <span style="color:black;font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
        }?>
    </div>
    <div class="col-md-1">
        <?php for ($i=12; $i < 15; $i++) { 
            echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
            <button type="button" class="btn btn-md btn-info" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
            <span style="color:black;font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
        }?>
    </div>
    <div class="col-md-1">
        <?php for ($i=15; $i < 18; $i++) { 
            echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
            <button type="button" class="btn btn-md btn-info" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
            <span style="color:black;font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
        }?>
    </div>
    <div class="col-md-1">
        <?php for ($i=18; $i < 21; $i++) { 
            $warna = $i == 18 ? 'bg-black' : ($i == 19 ? 'bg-primary' : 'bg-orange');
            $warna2 = $i == 20 ? 'black' : 'white';
            echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
            <button type="button" class="btn btn-md '.$warna.'" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
            <span style="color:'.$warna2.';font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
        }?>
    </div>
    <div class="col-md-1">
        <?php for ($i=21; $i < 24; $i++) { 
            $warna = $i == 21 ? 'bg-black' : ($i == 22 ? 'bg-primary' : 'bg-orange');
            $warna2 = $i == 23 ? 'black' : 'white';
            echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
            <button type="button" class="btn btn-md '.$warna.'" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
            <span style="color:'.$warna2.';font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
        }?>
    </div>
    <div class="col-md-1">
        <?php for ($i=24; $i < 27; $i++) { 
            $warna = $i != 26 ? 'btn-success' : 'btn-danger';
            echo '<input type="hidden" id="unit'.$i.'" value="'.$kode[$i].'">
            <button type="button" class="btn btn-md '.$warna.'" style="width:70px;height:70px;white-space: normal;" onclick="getLihatStock('.$i.', 123)">
            <span style="color:'.$warna2.';font-size:15px;font-weight:bold">'.$kode[$i].'</span></br><span style="color:white;font-size:10px;">'.$nama[$i].'</span></button><br><br>';
        }?>
    </div>
<br><br><br><br><br><br><br><br>
<?php } else{ ?>
    <div class="col-md-10">
        <?php foreach ($kode as $key => $value) {
            echo '<input type="hidden" id="unit'.$key.'" value="'.$value['KATEGORI'].'">
            <button type="button" class="btn btn-md btnunit" onclick="getLihatStockKodeUnit('.$key.')">
            <span style="color:black;font-size:12px;font-weight:bold">'.$value['KATEGORI'].'</span></button>';
        }?>
    </div>
<?php }?>
