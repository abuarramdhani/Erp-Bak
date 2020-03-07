<style type="text/css">
  #filter tr td{padding: 5px}
  .text-left span {
    font-size: 36px
  }
  .zoom {
  transition: transform .2s;
}

.zoom:hover {
  -ms-transform: scale(1.3); /* IE 9 */
  -webkit-transform: scale(1.3); /* Safari 3-8 */
  transform: scale(1.3); 
  box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}
</style>
<section class="content">
  <div class="inner" >
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="text-left ">
              <span style="font-family: 'Source Sans Pro',sans-serif;font-size: 28px"><b>Setup Rencana Kebutuhan </b></span>
              <!-- <a href="<?php echo base_url('MonitoringLPPB/ListBatch/newLppbNumber');?>"> -->
              <!-- <button type="button"  class="btn btn-lg btn-primary pull-right zoom"><i class="glyphicon glyphicon-plus"></i></button>
              </a> -->
            </div>
          </div>
          
          <div class="col-md-4" style="margin-bottom: 20px">
            <br/>
              <select id="id_setup" name="id_setup" onchange="getOptionSetup($(this))" class="form-control select2 select2-hidden-accessible" style="width:100%;">
                <option> - Pilih Halaman Setup - </option>
                <option value="1"> Jenis Asset </option>
                <option value="2"> Kategori Asset </option>
                <option value="3"> Perolehan Asset </option>
                <option value="4"> Seksi Pemakai </option>
            </select>
          </div>
        <div id="showOptionSetup">
        </div>
        <input type="hidden" name="hdn" id="hdnText" class="hdnClass" value="">
        <br />
          
        </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
</script>