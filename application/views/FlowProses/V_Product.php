<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="box box-primary box-solid">
        <div class="box-header with-border">
          <h4 style="font-weight:bold;"><i class="fa fa-car"></i> Product Data</h4>
        </div>
        <div class="box-body" style="background:#f0f0f0 !important;">
          <div class="row">
            <div class="col-md-12" style="margin-top:10px">
              <!-- <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                <div class="row">
                  <div class="col-md-12">
                    <form action="<?php echo base_url('FlowProses/Product/ImportProduct') ?>" method="post" enctype="multipart/form-data">
                      <label for="" style="font-weight:bold;">Import Product</label><br>
                      <div class="row">
                        <div class="col-md-10">
                          <input type="file" class="form-control" name="excel_file" id="excel_file" required accept=".xlsx" />
                        </div>
                        <div class="col-md-2">
                          <button type="submit" class="btn btn-md btn-primary" style="font-weight:bold;width:90%"> <b class="fa fa-file-excel-o"></b> Import Excel</button>
                        </div>
                      </div>
                    </form>
                    <br>
                    <i class="text-danger">*Only support file .xlsx / .xls</i>
                  </div>
                </div>
              </div> -->
              <div class="box-body" style="background:#ffffff !important; border-radius:7px;margin-bottom:15px;">
                  <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover text-left" id="dataTables-example" style="font-size:11px;">
                      <thead class="bg-primary">
                        <tr>
                          <th style="text-align:center; width:5%">
                              No
                          </th>
                          <th>
                              Product Code
                          </th>
                          <th>
                              Product Name
                          </th>
                          <th>
                              Product ID
                          </th>
                      </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($get as $key => $v): ?>
                          <tr>
                            <td style="text-align:center"><?php echo $key+1 ?> </td>
                            <td><?php echo $v['product_code'] ?> </td>
                            <td><?php echo $v['product_name'] ?> </td>
                            <td><?php echo $v['product_id'] ?> </td>
                          </tr>
                        <?php endforeach; ?>
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
</div>
