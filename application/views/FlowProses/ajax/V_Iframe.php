<?php if (!empty($link)) {?>
  <iframe oncontextmenu="return false;" type="application/pdf" src="http://192.168.168.221/gambar-kerja/FlowProses/SetWatermarkFlowProses/<?php echo $link ?>/<?php echo $employee ?>#toolbar=0"
    style="
     height: 750px;
     width: 100%;
     left: 0;
     top: 0;
     /* pointer-events: none; */
     ">
   </iframe>
<?php }else {
  echo "<center>Gambar Belum Di Upload !</center>";
} ?>
