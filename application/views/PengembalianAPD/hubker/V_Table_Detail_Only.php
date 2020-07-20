<style>
    .select2-search__field{
        text-transform: uppercase;
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
                            <div class="box-header with-border">
                            </div>
                            <div class="box-body">
                                <form method="post" action="<?=base_url('pengembalian-apd/pekerja/save_edit')?>">
                                    <div class="panel-body">
                                        <div class="col-md-1">
                                            <label style="margin-top: 5px;">Pekerja</label>
                                        </div>
                                        <div class="col-md-5">
                                            <select disabled="" class="form-control" id="pad_mdl_getpkj" name="pekerja" style="width: 100%" required="">
                                                <option selected="" value="<?=$pkj[0]['noind']?>"><?=$pkj[0]['noind'].' - '.$pkj[0]['nama']?></option>
                                            </select>
                                        </div>

                                        <div class="col-md-12" style="margin-top: 20px;">
                                            <p><label>List APD</label></p>
                                            <table class="table text-center" id="pad_tbl_AddData">
                                                <thead class="bg-primary">
                                                    <th style="width: 50px;">No</th>
                                                    <th>Nama APD</th>
                                                    <th style="width: 150px;">Status</th>
                                                    <th style="width: 100px;">Jumlah</th>
                                                    <th style="width: 150px;">Jenis</th>
                                                    <th style="width: 150px;">Ukuran</th>
                                                </thead>
                                                <tbody id="pad_rowToAppend">
                                                <?php $x=1; foreach ($barang as $row): ?>
                                                    <tr class="pad_rowAPD">
                                                        <td class="pad_rowNum"><?=$x?></td>
                                                        <td>
                                                            <select class="form-control pad_slcInit" name="apd[]" data-tags="true">
                                                                <?php foreach ($arr as $key): ?>
                                                                    <option <?=($row['nama_apd']==$key) ? 'selected':''?> value="<?=$key?>"><?=$key?></option>    
                                                                <?php endforeach ?>
                                                            </select>
                                                        </td>
                                                        <td style="width: 100px;">
                                                            <select class="form-control pad_slcInit" name="status[]" >
                                                                <option <?=($row['status']==1) ? 'selected':''?> value="1">PINJAM</option>
                                                                <option <?=($row['status']==2) ? 'selected':''?> value="2" selected="">KEMBALI</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input class="form-control" type="number" name="jumlah[]" value="<?=$row['jumlah']?>">
                                                        </td>
                                                        <td>
                                                            <select class="form-control pad_slcInit" name="jenis[]">
                                                                <option <?=($row['jenis']==0) ? 'selected':''?> value="0">Tidak ada Jenis</option>
                                                                <option <?=($row['jenis']==1) ? 'selected':''?> value="1">PENDEK</option>
                                                                <option <?=($row['jenis']==2) ? 'selected':''?> value="2">PANJANG</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control pad_slcInit" type="number" name="ukuran[]" data-tags="true">
                                                                <option value="0">Tidak ada Ukuran</option>
                                                                <?php foreach ($ukuran as $uk): ?>
                                                                    <option <?=($row['ukuran']==$uk) ? 'selected':''?> value="<?=$uk?>"><?=$uk?></option>    
                                                                <?php endforeach ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                <?php $x++; endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <button type="button" class="btn btn-warning" onclick="window.history.go(-1);">
                                                Kembali
                                            </button>
                                        </div>
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
<script>
    window.addEventListener('load', function () {
        $('input').attr('disabled', true);
        $('select').attr('disabled', true);
    });
</script>
<div hidden id="surat-loading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">
    <img src="http://erp.quick.com/assets/img/gif/loadingtwo.gif" style="position: fixed; top: 0;left: 0;right: 0;bottom: 0; margin: auto; width: 40%;">
</div>