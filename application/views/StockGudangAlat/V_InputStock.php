<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-lg-12">
            <div class="text-right">
              <h1><b>Stock Gudang Alat</b></h1>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="box box-primary box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">Input Stock</h3>
              </div>
              <div class="box-body">
                <div style="width: 100%">
                  <form action="<?=base_url('StockGudangAlat/C_StockGudangAlat/insertData'); ?>" id="formSGA" method="post">
                    <br>
                    <div class="row">
                      <div class="col-lg-2" style="text-align: right;">
                        <label>Nomor PO </label>
                      </div>
                      <div class="col-lg-3">
                        <input class="form-control" placeholder="Nomor PO" id="nopo" name="no_po">
                      </div>
                      <div class="col-lg-2" style="text-align: right;">
                        <label>Quantity </label>
                      </div>
                      <div class="col-lg-3">
                        <input class="form-control" placeholder="Quantity" id="qty" name="qty" type="number">
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-2" style="text-align: right;">
                        <label>Nama </label>
                      </div>
                      <div class="col-lg-3">
                        <input class="form-control toupper" placeholder="Nama" id="nama" name="nama">
                      </div>
                      <div class="col-lg-2" style="text-align: right;">
                        <label>Jenis </label>
                      </div>
                      <div class="col-lg-3">
                        <select class="form-control" id="jenis" name="pilihan" placeholder="">
                          <option disabled selected value="">Pilih jenis Equipment</option>
                          <option value="Arbor">Arbor</option>
                          <option value="Holder">Holder</option>
                          <option value="Collet">Collet</option>
                        </select>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-lg-2" style="text-align: right;">
                        <label>Merk </label>
                      </div>
                      <div class="col-lg-3">
                        <input class="form-control toupper" placeholder="Merk" id="merk" name="merk">
                      </div>
                      <div class="col-lg-2" style="text-align: right;">
                        <label>Sub-inv </label>
                      </div>
                      <div class="col-lg-3">
                        <select class="form-control" id="subinv" name="subinv" placeholder="">
                          <option disabled selected value="">Pilih Sub-Inventory</option>
                          <option value="TR-DM">TR-DM</option>
                          <option value="TR-TKS">TR-TKS</option>
                        </select>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div style="text-align: center;">
                        <button id="clear" type="button" class="btn btn-secondary button3 btn-sm" style="font-size: 13px">
                          <strong>Clear</strong>
                          <span style="padding-left: 5px" class="fa fa-refresh"></span>
                        </button>
                        <button id="nextsga" type="button" class="btn btn-primary btn-sm " style="font-size: 13px" disabled>
                          <strong>Next</strong>
                          <span style="padding-left: 5px" class="fa fa-arrow-right"></span>
                        </button>
                      </div>
                      <div class="box-body">
                        <div class="table" style="margin-bottom: 12px; width: 100%;">
                          <table id="table_input" class="table table-striped table-bordered table-responsive table-hover dataTable no-footer" style="font-size: 11px; display: none">
                            <thead class="bg-primary">
                              <tr>
                                <th width="15%" style="text-align: center; font-size: 13px; vertical-align: middle;">No. PO</th>
                                <th width="20%" style="text-align: center; font-size: 13px; vertical-align: middle;">Nama</th>
                                <th width="20%" style="text-align: center; font-size: 13px; vertical-align: middle;">Merk</th>
                                <th width="10%" style="text-align: center; font-size: 13px; vertical-align: middle;">Jenis</th>
                                <th width="5%" style="text-align: center; font-size: 13px; vertical-align: middle;">Qty</th>
                                <th width="5%" style="text-align: center; font-size: 13px; vertical-align: middle;">Jumlah</th>
                                <th width="5%" style="text-align: center; font-size: 13px; vertical-align: middle;">Subinv</th>
                                <th width="15%" style="text-align: center; font-size: 13px; vertical-align: middle;">Tag Number</th>
                                <!-- <th width="10%" style="text-align: center; font-size: 13px; vertical-align: middle;">Action</th>  -->
                              </tr>
                            </thead>
                            <tbody id="tbody_hasil">
                            </tbody>
                          </table>
                        </div>
                      </div>
                      <div align="center">
                        <button id="SGA_save" type="submit" class="btn btn-primary btn-sm" style="font-size: 12px; display: none">
                          <strong>Save</strong>
                        </button>
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
</section>

<!-- TABLE RESULT -->
<section class="content">
  <div class="inner">
    <div class="row">
      <div class="col-lg-12">
        <div class="box box-primary box-solid">
          <div class="box-header with-border">
            <h3 class="box-title">List of Input</h3>
          </div>
          <div class="box-body">
            <div class="table" style="margin-bottom: 12px;  width: 100%;">
              <div>
                <table class="table table-striped table-bordered table-hover text-left" id="tblDataStockBaru" style="width: 100%;font-size: 13px; ">
                  <thead class="bg-primary">
                    <tr>
                      <th style="text-align:center;font-size: 13px; width:30px">No</th>
                      <th style="text-align:center;font-size: 13px;  width:30px">Nomor PO</th>
                      <th style="text-align:center;font-size: 13px;  width:30px">Nama</th>
                      <th style="text-align:center;font-size: 13px;  width:30px">Merk</th>
                      <th style="text-align:center;font-size: 13px;  width:30px">QTY</th>
                      <th style="text-align:center;font-size: 13px;  width:30px">Jumlah</th>
                      <th style="text-align:center;font-size: 13px;  width:30px">Sub-Inv</th>
                      <th style="text-align:center;font-size: 13px;  width:30px">Tag</th>
                      <th style="text-align:center;font-size: 13px;  width:30px">Jenis</th>
                      <th style="text-align:center;font-size: 13px;  width:30px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
												if (empty($lihat_stok)) {
												}else{
													$no=1;
													foreach ($lihat_stok as $key) {
                                                        $no_po = $key['no_po'];
                                                        $nama = $key['nama'];
                                                        $merk = $key['merk'];
                                                        $qty = $key['qty'];
                                                        $jml = $key['jml'];
                                                        $subinv = $key['subinv'];
                                                        $tag = $key['tag'];
                                                        $pilihan = $key['jenis'];
                                                        $id = $key['id'];
												?>
                    <tr>
                      <td style="text-align: center;"><?php echo $no; ?></td>
                      <td><?php echo $no_po; ?></td>
                      <td><?php echo $nama; ?></td>
                      <td><?php echo $merk; ?></td>
                      <td align="center"><?php echo $qty; ?></td>
                      <td align="center"><?php echo $jml; ?></td>
                      <td align="center"><?php echo $subinv; ?></td>
                      <td><?php echo $tag; ?></td>
                      <td><?php echo $pilihan; ?></td>
                      <td class="text-center">
                        <a data-toggle="modal" data-target="#Modalku<?php echo $no; ?>" onclick="editSkrtt(<?php echo $id ?>)" class="btn btn-success fa fa-pencil-square-o"></a>
                        <a href="<?=base_url('StockGudangAlat/C_StockGudangAlat/deleteData/'. $id); ?>" onclick="alert('Are You Sure To Delete ?')" class="btn btn-danger fa fa-trash"></a>
                      </td>
                    </tr>
                    <?php
														$no++;
													}
												}
												?>
                  </tbody>
                </table>
              </div>
              <!-- </div>
                            </div> -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- Modal -->
<?php $nomor = 1; foreach($lihat_stok as $key) {?>
<div class="modal fade" id="Modalku<?php echo $nomor; ?>" tabindex="1" role="dialog" aria-labelledby="judulModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="box-header with border" id="formModalLabel" style="text-align:center;">Ubah Data</h3>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?=base_url('StockGudangAlat/C_StockGudangAlat/updateData/')?>" method="post">
        <div class="modal-body">
          <input hidden name="nama" value="<?= $key['nama']?>" />
          <div class="form-group">
            <label for="nama">Nomor PO</label>
            <input type="text" class="form-control noPoSaitama" id="noPo" name="noPo">
          </div>
          <div class="form-group">
            <label for="tag">Tag</label>
            <input type="text" class="form-control tagSaitama" id="tag" name="tag">
          </div>
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control nama" id="sel1" name="noMobil">
          </div>
          <div class="form-group">
            <label for="qtyKirim">Merk</label>
            <input class="form-control merek" type="text" name="merk" id="merk">
          </div>
          <div class="form-group">
            <label for="qty">Qty</label>
            <input class="form-control qtySaitama" id="qty" name="qty" type="number" id="number">
          </div>
          <div class="form-group">
            <label for="jenis">Jenis</label>
            <div class="form-group">
              <select class="form-control" id="jenis" name="pilihan" placeholder="">
                <option class="jenisaitama" selected></option>
                <option value="Arbor">Arbor</option>
                <option value="Holder">Holder</option>
                <option value="Collet">Collet</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="BtnSubmit" onclick="updateData(this)">Ubah Data</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $nomor++; } ?>
