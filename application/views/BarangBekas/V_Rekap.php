<style media="screen">
  td{
    padding-bottom: 20px !important;
  }
</style>
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">

        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                 <h4 style="font-weight:bold"><i aria-hidden="true" class="fa fa-database"></i> Rekap Data Pengiriman Barang Bekas</h4>
              </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="table-responsive">
                      <table class="table table-bordered rekap_pbb" style="width:100%">
                        <thead class="bg-primary">
                          <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Dokumen Number</th>
                            <th class="text-center">Type Document</th>
                            <th class="text-center">Seksi</th>
                            <th class="text-center">Cost Center</th>
                            <th class="text-center">Sub.Inv</th>
                            <th class="text-center">Locator</th>
                            <th class="text-center">Item</th>
                            <th class="text-center">Sub.Inv Tujuan</th>
                            <th class="text-center">Locator Tujuan</th>
                            <th class="text-center">Item Tujuan</th>
                            <th class="text-center">Onhand</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Berat Timbang</th>
                            <th class="text-center">Status</th>
                          </tr>
                        </thead>
                        <tbody id="">
                          <?php foreach ($get as $key => $value): ?>
                            <tr>
                              <td><?php echo $key+1 ?></td>
                              <td><?php echo $value['DOCUMENT_NUMBER'] ?></td>
                              <td><?php echo $value['TYPE_DOCUMENT'] ?></td>
                              <td><?php echo $value['SEKSI'] ?></td>
                              <td><?php echo $value['COST_CENTER'] ?></td>
                              <td><?php echo $value['SUB_INVENTORY'] ?></td>
                              <td><?php echo $value['ID_LOCATOR'] ?></td>
                              <td><?php echo $value['ITEM'] ?></td>
                              <td><?php echo $value['SUBINV_TUJUAN'] ?></td>
                              <td><?php echo $value['LOCATOR_TUJUAN'] ?></td>
                              <td><?php echo $value['ITEM_TUJUAN'] ?></td>
                              <td><?php echo $value['ONHAND'] ?></td>
                              <td><?php echo $value['JUMLAH'] ?> <?php echo $value['UOM'] ?></td>
                              <td><?php echo $value['BERAT_TIMBANG'] ?> Kg</td>
                              <td><?php echo $value['STATUS'] ?></td>
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
  </div>
</section>
