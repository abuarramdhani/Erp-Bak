<section class="content">
    <div class="row">
        <form  method="POST" action="<?= base_url('PerhitunganBiayaImpor/Laporan/Action/'.$id);?>" id="formLaporanPBI" data-id="<?= $id?>">
            <div class="col-lg-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Program Perhitungan Biaya Impor</h3>
                    </div>
                    <div class="box-body">
                        <table>
                            <tr>
                                <th>Nomor Urut Perhitungan</th>
                                <th>&nbsp;:&nbsp;</th>
                                <td><input type="text" class="form-control" name="nomorUrutPBI" style="width:200px;" value="<?= $header2[0]['NO_URUT_PERHITUNGAN'];?>"></td>
                            </tr>
                            <tr>
                                <th>IO</th>
                                <th>&nbsp;:&nbsp;</th>
                                <td>IDM<input type="hidden" class="form-control" name="IOPBI" style="width:200px;" value="IDM"></td>
                            </tr>
                            <tr>
                                <th>Eksportir</th>
                                <th>&nbsp;:&nbsp;</th>
                                <td><?= $vendor[0]['VENDOR_NAME'];?><input type="hidden" class="form-control" name="vendorPBI" style="width:200px;" value="<?= $vendor[0]['VENDOR_NAME'];?>"></td>
                            </tr>
                            <tr>
                                <th>No. Packing List</th>
                                <th>&nbsp;:&nbsp;</th>
                                <td><input type="text" class="form-control" name="noPackingPBI" style="width:200px;" value="<?= $header2[0]['NO_PACKING_LIST'];?>"></td>
                            </tr>
                            <tr>
                                <th>No. B/L</th>
                                <th>&nbsp;:&nbsp;</th>
                                <td><input type="text" class="form-control" name="noBLPBI" style="width:200px;" value="<?= $header2[0]['NO_BL'];?>"></td>
                            </tr>
                            <tr>
                                <th>No. PO</th>
                                <th>&nbsp;:&nbsp;</th>
                                <td><input type="text" class="form-control" name="noPOPBI" style="width:200px;" value="<?= $nopo[0]['NO_PO'];?>"></td>
                            </tr>
                            <tr>
                                <th>No. Interorg</th>
                                <th>&nbsp;:&nbsp;<input type="hidden" class="form-control" name="noInterorgPBI" style="width:200px;" value=""></th>
                                <td></td>
                            </tr>
                            <tr>
                                <th>No. Receipt</th>
                                <th>&nbsp;:&nbsp;</th>
                                <td><input type="hidden" class="form-control" name="noReceiptPBI" style="width:200px;" value=""></td>
                            </tr>
                        </table>
                        <br>
                        <table>
                            <tr>
                                <td>
                                    <select class="form-control slcCurrencyPBI" name="slcCurrencyPBI" style="width:150px;">
                                        <option></option>
                                        <option>USD</option>
                                        <option>JPY</option>
                                        <option>GBP</option>
                                        <option>SGD</option>
                                    </select>
                                </td>
                                <td>&nbsp;</td>
                                <td><input type="text" class="form-control rateBatchPBI" placeholder="insert rate here!" style="width:150px;" value="<?= $detail_line[0]['RATE']; ?>"></td>
                                <td>&nbsp;</td>
                                <td><button type="button" class="btn btn-warning btnRateBatchPBI">SET</button></td>
                            </tr>
                        </table>
                        <div style="overflow: none;">
                            <table class="table table-hover table-striped table-bordered tblPerhitunganPBI" width="200%">
                                <thead>
                                    <tr class="bg-primary">
                                        <th class="bg-primary text-center" rowspan="3" style="vertical-align:middle;">Action</th>
                                        <th class="bg-primary text-center" rowspan="3" style="vertical-align:middle;">No</th>
                                        <th class="bg-primary text-center" rowspan="3" style="vertical-align:middle;">Kode Barang</th>
                                        <th class="bg-primary text-center" rowspan="3" style="vertical-align:middle; width:200px;">Deskripsi Barang</th>
                                        <th class="text-center" colspan="8"></th>
                                        <th class="text-center" rowspan="2" style="vertical-align:middle;" width="100px;">Bea Masuk</th>
                                        <th class="text-center" >Additional Cost</th>
                                        <th class="text-center" rowspan="2" style="vertical-align:middle;" width="100px;">Total Biaya (Rp)</th>
                                        <th class="text-center" colspan="4">Harga / pcs barang (Rp)</th>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th class="text-center" rowspan="2" style="vertical-align:middle;">PO</th>
                                        <th class="text-center">Qty PO</th>
                                        <th class="text-center" width="100px">Qty krm (PCS)</th>
                                        <th class="text-center">Hrg (<span class="currPBI"></span>)</th>
                                        <th class="text-center" width="100px;">Total (<span class="currPBI"></span>)</th>
                                        <th class="text-center">Rate</th>
                                        <th class="text-center" width="150px;">Nilai Barang (RP)</th>
                                        <th class="text-center" width="100px;">% Pembagian Biaya</th>
                                        <th class="text-center">Nilai (Rp)</th>
                                        <th class="text-center" width="100px;">Hrg PO</th>
                                        <th class="text-center" width="100px;">Tamb</th>
                                        <th class="text-center" width="120px;">Hrg total</th>
                                        <th class="text-center" width="100px;">%</th>
                                    </tr>
                                    <tr class="bg-primary">
                                        <th class="text-center">(PCS)</th>
                                        <th class="text-center">a</th>
                                        <th class="text-center">b</th>
                                        <th class="text-center">c=a*b</th>
                                        <th class="text-center">d</th>
                                        <th class="text-center">e=c*d</th>
                                        <th class="text-center">f=e/ Total e</th>
                                        <th class="text-center">h=f*Total h</th>
                                        <th class="text-center">i=f*z</th>
                                        <th class="text-center">j=h+i</th>
                                        <th class="text-center">k=b*d</th>
                                        <th class="text-center">l=j/a</th>
                                        <th class="text-center">m=k+l</th>
                                        <th class="text-center">n=l/k</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $nos="0"; $totalUSD = 0;  $totalNilaiBarang = 0;
                                        foreach ($detail_line as $key => $line) { 
                                            $nos++;
                                            $totalUSD = $totalUSD + $line['QTY_KIRIM']*$line['HARGA'];
                                            $nilaiBarang = $line['QTY_KIRIM']*$line['HARGA']*$line['RATE'];
                                            $totalNilaiBarang = $totalNilaiBarang + $nilaiBarang;
                                            ?>
                                        <tr data-row="<?= $nos;?>" class="trTblPerhitunganPBI">
                                            <td><button type="button" class="btn btn-danger btnDeleteLinePBI" value="<?= $line['KODE_BARANG'].'+'.$line['NO_PO'].'+'.$line['QTY_PO'].'+'.$line['IO'].'+'.$id; ?>"><i class="fa fa-trash"></i></button></td>
                                            <td><?= $nos; ?></td>
                                            <td><?= $line['KODE_BARANG']; ?><input type="hidden" class="form-control inpKodeBarangPBI" value="<?= $line['KODE_BARANG']; ?>" name="kodebarang[]"></td>
                                            <td><?= $line['DESKRIPSI_BARANG']; ?></td>
                                            <td><?= $line['NO_PO']; ?></td>
                                            <td align="right"><?= number_format($line['QTY_PO']); ?></td>
                                            <td> <input type="text" class="form-control qtyKirimPBI" value="<?= number_format($line['QTY_KIRIM']); ?>" style="width:100px; text-align:right" name="qtyKirim[]"></td>
                                            <td align="right" class="hargaPBI"><?= number_format($line['HARGA'],2); ?></td>
                                            <td align="right" class="totalUSDPBI"><?= number_format($line['QTY_KIRIM'] * number_format($line['HARGA'],2), 2); ?></td>
                                            <td><input type="text" class="form-control txtRatePBI" style="width:100px; text-align:right;" name="rate[]" value="<?= number_format($line['RATE'],2);?>"></td>
                                            <td align="right" class="nilaiBarangPBI"><?= number_format($nilaiBarang,2); ?></td>
                                            <td align="right" class="pembagianBiayaPBI"></td>
                                            <td align="right" class="beaMasukPBI"></td>
                                            <td align="right" class="nilaiAdditionalCostPBI"></td>
                                            <td align="right" class="totalBiayaRPPBI"></td>
                                            <td align="right" class="hargaPOPBI"></td>
                                            <td align="right" class="tambPBI"></td>
                                            <td align="right" class="hrgTotPBI"></td>
                                            <td align="right" class="percentPBI"></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td align="right"><b class="ttotalUSDPBI"><?= number_format($totalUSD,2); ?></b></td>
                                        <td></td>
                                        <td align="right">
                                            <b class="totalNilaiBarangPBI"><?= number_format($totalNilaiBarang,2); ?></b>
                                            <input type="text" style="display: None" id="inptotalNilaiBarangPBI" name="inptotalNilaiBarangPBI" value="<?= number_format($totalNilaiBarang,2); ?>">
                                        </td>
                                        <td></td>
                                        <td align="right"><b class="totalBeaMasukPBI"><?php if (!$bea_masuk) {
                                            // echo '0';
                                            echo '<input type="text" class="form-control inpBeaMasukPBI" style="width:100px; text-align:right;" value="0">';
                                        }else {
                                            // echo number_format($bea_masuk[0]['HARGA'],2);
                                            echo '<input type="text" class="form-control inpBeaMasukPBI" style="width:100px; text-align:right;" value='.number_format($bea_masuk[0]['HARGA'],2).'>';
                                        } ?></b></td>
                                        <td align="right"><b class="totalAdditionalAtasCostPBI"></b></td>
                                        <td align="right"><b class="totalbiayaPBI"></b></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">INFO</h3>
                                </div>
                                <div class="box-body">
                                    <table class="table table-hover table-striped">
                                        <thead>
                                            <tr class="bg-info">
                                                <th></th>
                                                <th class="text-center">Additional Cost</th>
                                                <th class="text-center">in <span class="currPBI"></span></th>
                                                <th class="text-center">in IDR</th>
                                                <th class="text-center">Action</th>
                                                <td><button type="button" class="btn btn-primary tambahAdditionalInfoPBI"><i class="fa fa-plus"></i></button></td>
                                                <th class="text-center">Sort</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                            <?php $total = $local_transport[0]['HARGA']; $no=0;foreach ($additional_cost as $key => $acost) { $no++;   $total += $acost['HARGA'];
                                            ?>
                                                <tr class="trAdditionalInfoAddPBI" data-row="<?= $no;?>">
                                                    <td><?= $no; ?></td>
                                                    <td class="tdAdditionalInfoDescPBI"><?= $acost['DESKRIPSI']; ?></td>
                                                    <td align="right"><?= $acost['HARGA_USD']; ?></td>
                                                    <td align="right" class=""><input type="text" class="form-control hrgLainAdditionalCostPBI" value="<?= number_format($acost['HARGA'],2); ?>" style="text-align:right;" rid="<?= $no;?>" readonly></td>
                                                    <td><button type="button" class="btn btn-danger btndeleteAddCostPBI" value="<?= $id.'-'.$acost['DESKRIPSI']; ?>"><i class="fa fa-trash"></i></button>
                                                    <td>
                                                        <button type="button" class="btn btn-warning editAdditionalCostPBI" rid="<?= $no;?>"><i class="fa fa-pencil"></i></button>
                                                        <button type="button" class="btn btn-success prosesEditAddCostPBI" style="display:none" rid="<?= $no;?>" value="<?= $id.'-'.$acost['DESKRIPSI']; ?>"><i class="fa fa-check"></i></button>
                                                        <img src="<?= base_url('assets/img/gif/spinner.gif');?>" alt="" class="loadingEditAddCostPBI" style="display:none" rid="<?= $no;?>">
                                                    </td>
                                                    <!-- <td></td> -->
                                                    <td class="text-center">
                                                        <input type="text" class="form-control inpSortingRowPBI text-center" style="width: 50px">
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td><b>Z</b></td>
                                                <td colspan="2" class="text-center">Total</td>
                                                <td align="right"><b class="totalAdditionalCostPBI"><?= number_format($total,2);?></b></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <table>
                                <tr>
                                    <th>NOTES </th>
                                    <th>:</th>
                                    <td><textArea class="form-control" name="notesPBI" ><?= $header2[0]['NOTE'];?></textArea></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="pull-right">
                            <button type="button" value="0" class="btn btn-success" id="btnSubPBI" name="btnSubPBI"><i class="fa fa-file-excel-o"></i> Save & Export Data</button>
                            <button type="submit" value="1" class="btn btn-primary" name="btnSubPBI"><i class="fa fa-save"></i> save Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>