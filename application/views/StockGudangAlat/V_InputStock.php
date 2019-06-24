<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                    </div>
                </div>
                <br/>
                <div class="text-right"><h1><b>Input Stock Gudang Alat</b></h1></div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                               
                            </div>
                            <div class="box-body">
                               <div style="width: 100%">
                               <form action="<?=base_url('StockGudangAlat/C_StockGudangAlat/insertData'); ?>" method="post">
                                    <div class="row">
                                        <div class="col-lg-4" style="text-align: right;">
                                            <label>TAG</label>
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="form-control" name="tag">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-4" style="text-align: right;">
                                            <label>NAMA </label>
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="form-control" name="nama">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-4" style="text-align: right;">
                                            <label>MERK</label>
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="form-control" name="merk">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-4" style="text-align: right;">
                                            <label>QTY</label>
                                        </div>
                                        <div class="col-lg-3">
                                            <input class="form-control" name="qty" type="number">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-4" style="text-align: right;">
                                            <label>JENIS</label>
                                        </div>
                                        <div class="col-lg-3">
                                            <select class="form-control" id="jenis" name="pilihan" placeholder="">
													<option></option>
                                                    <option value="Arbor">Arbor</option>
                                                    <option value="Holder">Holder</option>
                                                    <option value="Collet">Collet</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="modal-footer" style="text-align: center;">
                                            <button class="btn btn-primary" type="submit" name="slcData">Tambah Data</button>
											<!-- onclick="javascript:addData();" type="button" -->
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

<!-- TABLE RESULT -->
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                               <h3>List of Input</h3>
                            </div>
                            <div class="box-body">
                                <div class="table" style="margin-bottom: 12px; width: 100%;">
									<div>
										<table class="datatable table table-striped table-bordered table-hover text-left" id="tblDataStock" style="width: 100%;">
											<thead class="bg-primary">
												<tr>
													<th style="text-align:center; width:30px">No</th>
													<th>Tag</th>
													<th>Nama</th>
													<th>Merk</th>
													<th>QTY</th>
													<th>Jenis</th>
												</tr>
											</thead>
											<tbody>
											<?php
											
												if (empty($lihat_stok)) {
												}else{
													$no=1;
													foreach ($lihat_stok as $key) {
														$tag = $key['tag'];
														$nama = $key['nama'];
														$merk = $key['merk'];
														$qty = $key['qty'];
														$pilihan = $key['jenis'];
												?>
														<tr>
														<td style="text-align: center;"><?php echo $no; ?></td>
														<td><?php echo $tag; ?></td>
														<td><?php echo $nama; ?></td>
														<td><?php echo $merk; ?></td>
														<td><?php echo $qty; ?></td>
														<td><?php echo $pilihan; ?></td>
														</tr>
														<?php
														$no++;
													}
												}
												?>
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
</section>
<div>
<!-- <div style="text-align: center;">
	<form method="POST" action="<?php echo site_url('StockGudangAlat/C_StockGudangAlat/insertData'); ?>">
		<button type="submit" class="btn btn-primary" type="submit">Kirim</button>
	</form>
</div> -->
                </div>    
            </div>    
        </div>
    </div>
</section>