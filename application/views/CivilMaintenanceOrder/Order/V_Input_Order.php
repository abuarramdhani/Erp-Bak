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
                                                <select required class="form-control cmo_slcPkj mco_itcanchange" name="dari" change="1" style="width: 100%">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="col-md-12">
                                                <label class="mco_isiData">Seksi Pekerja : xxxxxxxxxx</label>
                                            </div>
                                            <input hidden="" name="kodesie" class="mco_inputData">
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Lokasi Order</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="select2 mco_lokasi" style="width: 100%" name="lokasi" data-placeholder="Lokasi Order">
                                                    <option></option>
                                                    <option value="01">Jogja</option>
                                                    <option value="02">Tuksono</option>
                                                    <option value="03">Mlati</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Voip</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input required class="form-control" name="voipOrder" placeholder="Voip Yang Bisa Dihubungi">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Tanggal Order</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input required class="form-control" value="<?php echo date('Y-m-d') ?>" name="tglorder" readonly>
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
                                                <label>Detail Pekerjaan</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select required class="form-control cmo_slcJnsPkjDetail" name="detailPekerjaan" disabled>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 setjnsPkjhereDetail" style="padding-left: 0px; padding-top: 5px;">

                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Jenis Order</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select required class="form-control <?= $claz ?>" name="jnsOrder">
                                                    <option value="1" selected="">Pekerjaan Eksternal Dengan Order</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 setAlertJnsOrder" style="color: red;">

                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 10px;">
                                        <div class="col-md-12">
                                            <div class="col-md-12">
                                                <style type="text/css">
                                                    
                                                </style>
                                                <table class="table table-bordered" id="mco_tblPekerjaan">
                                                    <thead class="bg-info">
                                                        <th>No</th>
                                                        <th>Pekerjaan</th>
                                                        <th width="10%">Qty</th>
                                                        <th width="10%">Satuan</th>
                                                        <th>Keterangan</th>
                                                        <th width="20%">Lampiran</th>
                                                        <th>Act</th>
                                                    </thead>
                                                    <tbody class="mco_daftarPek_Append">
                                                        <tr class="mco_daftarPek">
                                                            <td class="mco_daftarnoPek">1</td>
                                                            <td>
                                                                <input name="tbl_pekerjaan[0]" nomor='0' class="form-control tbl_pekerjaan">
                                                            </td>
                                                            <td>
                                                                <input name="tbl_qty[0]" type="number" class="form-control tbl_qty">
                                                            </td>
                                                            <td>
                                                                <input name="tbl_satuan[0]" class="form-control tbl_satuan" oninput="this.value = this.value.toUpperCase()">
                                                            </td>
                                                            <td>
                                                                <textarea name="tbl_ket[0]" class="form-control tbl_ket" style="margin: 0px; resize: none;"></textarea>
                                                            </td>
                                                            <td class='td_lampiran'>
                                                                <div>
                                                                    <input type="file" nomor='1' class="form-control mco_lampiranFilePekerjaan tbl_lampiran" name="tbl_lampiran[0][]" style="display: none;">
                                                                </div>
                                                                <button nomor='1' type='button' class="btn btn-primary add_lamp">Choose File 1</button>
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
                                            <div class="col-md-4">
                                                <label>Status</label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="select2 mco_status" style="width: 100%" name="status" required data-placeholder="Status Order">
                                                    <option></option>
                                                    <option>Biasa</option>
                                                    <option>Urgent</option>
                                                </select>
                                            </div>
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
                                    <div class="col-md-12 mco_tglbutuh" style="margin-top: 10px;display: none">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Tanggal Dibutuhkan</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input required class="form-control mco_tglpick" name="tglbutuh">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mco_alasan" style="margin-top: 10px;display: none">
                                        <div class="col-md-6">
                                            <div class="col-md-4">
                                                <label>Alasan</label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea class="form-control" name="alasan"></textarea>
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
<div class="modal fade" id="inputOrder" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 90%">
        <div class="modal-content">
            <div class="modal-header">
                <label class="modal-title" id="exampleModalLongTitle">Lihat Lampiran</label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <iframe src="" style="width: 100%;height: 500px;"></iframe>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>