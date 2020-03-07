<section class="content">
  <div class="inner" >
  <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="col-lg-11">
              <div class="text-left">
                <h1><b>Laporan Data Asset Oracle</b></h1>
               <select id="slcAsalCabang" name="slcAsalCabang" class="form-control select2 select2-hidden-accessible" style="width:400px;" required="required">
                                      <option value="" > Pilih Asal Cabang </option>
                                      <?php foreach ($cbg as $k) { ?>
                                      <option value="<?php echo $k['branch_code'] ?>"><?php echo $k['nama_cabang'] ?>
                                      </option>
                                      <?php } ?>
                </select>
            
              </div>
            </div>
            <div class="col-lg-1 ">
              <!-- <div class="text-right hidden-md hidden-sm hidden-xs">
                <a class="btn btn-default btn-lg" onclick="window.location.reload()">
                  <i class="icon-refresh icon-2x"></i>
                  <span ><br /></span>
                </a>
                

              </div> -->
            </div>
          </div>
        </div>
        <br />
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div style="padding-top: 20px" class="box-header with-border">
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table table-striped table-bordered table-hover text-left" id="tblACLDAO" style="font-size:12px;">
                    <thead>
                      <tr style="background-color: #3c8dbc;" class="bg-primary">
                        <th width="5%"><center>No</center></th>
                        <th width="10%"><center>Cabang</center></th>
                        <th width="20%"><center>Location</center></th>
                        <th width="10%"><center>Category</center></th>
                        <th width="15%"><center>Description</center></th>
                        <th width="15%"><center>Tag Number</center></th>
                        <th width="10%"><center>Date Placed In Service</center></th>
                        <th width="10%"><center>Invoice Number</center></th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php $no =1; foreach ($oracle as $k) { ?>
                    <tr>
                      <td class="text-center"><?php echo $no;?></td>
                      <td class="text-center"><?php echo $k['BRANCH']?></td>
                      <td class="text-left"><?php echo $k['LOCATION_DESCRIPTION2']?></td>
                      <td class="text-center"><?php echo $k['ATTRIBUTE_CATEGORY_CODE']?></td>
                      <td ><?php echo $k['DESCRIPTION']?></td>
                      <td class="text-center"><?php echo $k['TAG_NUMBER']?></td>
                      <td class="text-center"><?php echo $k['DATE_PLACED_IN_SERVICE']?></td>
                      <td class="text-center"><?php echo $k['INVOICE_NUMBER']?></td>
                    </tr>
                    <?php $no++;} ?>
                    </tbody>
                          </td>
                        </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  $( document ).ready(function() {
  $('#tblACLDAO').DataTable({
    "pageLength": 50
  });
})
</script>
