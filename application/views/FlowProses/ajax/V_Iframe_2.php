<style media="screen">
/* .fp0012{
  overflow-y: scroll;
  overflow-x:hidden;
   height: 700px;
} */

</style>
<?php if (!empty($link)) {?>
  <iframe oncontextmenu="return false;" type="application/pdf" src="http://192.168.168.221/gambar-kerja/FlowProses/SetWatermarkFlowProses/<?php echo $link ?>/<?php echo $employee ?>#toolbar=0"
    style="
     height: 290px;
     width: 100%;
     left: 0;
     top: 0;
     /* pointer-events: none; */
     ">
   </iframe>
<?php }else {
  echo "<center>Gambar Belum Di Upload !</center>";
} ?>

<script type="text/javascript">
// $(document).ready(function() {
// jQuery(function($) {
  // function fixDiv() {
  //   let cache = $('.fp_area_gambar_kerja_3');
  //   if ($('.fp0012').scrollTop() > 100){
  //     console.log('cek jalan');
  //     cache.css({
  //         'position': 'fixed',
  //         'top': '0px',
  //         'width': '95%',
  //         'height': '350px',
  //         'z-index': '99'
  //       });
  //   }else {
  //     cache.css({
  //       'position': 'relative',
  //       'top': 'auto',
  //       'height': 'auto',
  //       'width': '100%',
  //       'z-index': ''
  //
  //       // 'left': '10px'
  //     });
  //   }
  // }
  // $('.fp0012').scroll(fixDiv);
  // fixDiv()
// })
//
// var wrap = $("#modalfp1");
//
//   wrap.on("scroll", function(e) {
//
//   if (this.scrollTop > 100) {
//
//     $('.fp_area_gambar_kerja_3').css({'position': 'fixed', 'height': '350px', 'top': '0px'})
//     $('iframe').css({'height': '350px'})
//   } else {
//     $('.fp_area_gambar_kerja_3').css({'position': 'relative', 'height': '400px', 'top': 'auto'})
//     $('iframe').css({'height': '400px'})
//   }
//
// });
</script>
