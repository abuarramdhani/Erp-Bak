<style>
    .dataTables_filter{
        float: right;
    }
    .buttons-excel{
        background-color: green;
        color: white;
    }
    .lblmt label{
        margin-top: 5px;
    }
</style>
<section class="content">
    <div class="inner" >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-11">
                    <div class="text-right">
                        <h1><b><?= $Title ?></b></h1>
                    </div>
                </div>
                <div class="col-lg-1">
                    <div class="text-right hidden-md hidden-sm hidden-xs">

                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11"></div>
                        <div class="col-lg-1 "></div>
                    </div>
                </div>
                <br />
                <div class="">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border"></div>
                            <div class="box-body lblmt">
                                <form method="post" action="<?= base_url('civil-maintenance-order/order/save_order') ?>" enctype="multipart/form-data">
                                    <div class="col-md-12 cmo_pengorderCivil">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Order Dari</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select required class="form-control cmo_slcPkj mco_itcanchange" name="dari" change="1">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-8">
                                                <label class="mco_isiData">Seksi : xxxxxxxxxx</label>
                                            </div>
                                            <input hidden="" name="kodesie" class="mco_inputData">
                                            <input hidden="" name="lokasi" class="mco_inputData">
                                            <div class="col-md-4">
                                                <label class="mco_isiData">Lokasi : xxxxxxxxx</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Tanggal Order</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input required class="form-control mco_tglpick" name="tglorder">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Tanggal Terima</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input required class="form-control mco_tglpick" name="tglterima">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Jenis Pekerjaan</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select required class="form-control cmo_slcJnsPkj" name="jnsPekerjaan">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 setjnsPkjhere" style="padding-left: 0px; padding-top: 5px;">

                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Jenis Order</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select required class="form-control <?= $claz ?>" name="jnsOrder">
                                                    <option value="1" selected="">PEKERJAAN EKSTERNAL DENGAN ORDER</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 setAlertJnsOrder" style="color: red;">

                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-8">
                                            <div class="col-md-3">
                                                <label>Judul Order</label>
                                            </div>
                                            <div class="col-md-9" style="padding-left: 12px;">
                                                <input required oninput="this.value = this.value.toUpperCase()" class="form-control" name="judul" placeholder="Masukkan Judul Order">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <label>Ex : Penambahan wastafel di Area X, Pemangkasan pohon di depan Gedung, Reparasi urinoir mampet</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <label>Keterangan</label>
                                                <br>
                                                <label>Aktivitas Detail Pekerjaan yang dilakukan, misal : bongkar galian, perataan tanah, dan pekerjaan lain yang diminta dalam order tersebut. </label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="col-md-12">
                                                <table class="table table-bordered" id="mco_tblPekerjaan">
                                                    <thead class="bg-info">
                                                        <th>No</th>
                                                        <th>Pekerjaan</th>
                                                        <th width="15%">Qty</th>
                                                        <th width="15%">Satuan</th>
                                                        <th>Keterangan</th>
                                                        <th>Act</th>
                                                    </thead>
                                                    <tbody class="mco_daftarPek_Append">
                                                        <tr class="mco_daftarPek">
                                                            <td class="mco_daftarnoPek">1</td>
                                                            <td>
                                                                <input name="tbl_pekerjaan[]" class="form-control">
                                                            </td>
                                                            <td>
                                                                <input name="tbl_qty[]" type="number" class="form-control">
                                                            </td>
                                                            <td>
                                                                <input name="tbl_satuan[]" class="form-control" oninput="this.value = this.value.toUpperCase()">
                                                            </td>
                                                            <td>
                                                                <textarea name="tbl_ket[]" class="form-control" style="margin: 0px; resize: none;"></textarea>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-xs btn-danger mco_deldaftarnoPek"><i class="fa fa-times"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <button type="button" class="btn btn-sm btn-success pull-right mco_addRowPek">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-12" hidden="" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Nomor Log</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="number" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mco_insertafter" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label class="mco_lampiranno">Lampiran</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input type="file" class="form-control mco_lampiranFile" name="lampiran[]">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Tanggal Dibutuhkan</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input required class="form-control mco_tglpick" name="tglbutuh">
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-top: 30px;" class="col-md-12 text-center">
                                        <button type="submit" class="btn btn-success btn-lg" onclick="return confirm('Anda yakin sudah benar input Ordernya?')">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
