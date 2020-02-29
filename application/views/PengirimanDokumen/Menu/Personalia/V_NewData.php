<style>
    .center {
        text-align: center;
    }
    
    tbody>tr>td {
        text-align: center;
    }
    
    thead>tr {
        font-weight: bold;
    }
    .outline{
        border: 2px solid white;
        border-radius: 5px;
        background-color: #f39c12;
        transition: 0.3s;
    }

    .outline:hover {
        background-color: white !important;
        color: #f39c12 !important; 
    }
</style>
<section class="content">
    <div class="panel-body">
        <div class="row">
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <div class="col-lg-6">
                        <h2><b>Data Baru - Personalia <?= $lv ?></b></h2>
                    </div>
                    <div class="col-lg-6 pull-right">
                        <form action="">
                            <label class="label-control col-lg-12 text-right" for="all-seksi-document">Seksi</label>
                            <div class="col-lg-8 pull-right">
                                <select name="seksi" id="all-seksi-document" class="select2 form-control">
                                    <option value="">---pilih semua---</option>
                                    <?php foreach($seksi as $item): ?>
                                        <option <?php echo ($is_get && substr($item->kodesie,0,7) == $selected) ? 'selected'  : '' ?> value="<?= substr($item->kodesie,0,7) ?>"><?=$item->kodesie." - ".$item->nama ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-lg-2 pull-right">
                                <button type="submit" class="btn outline">filter <i class="fa fa-filter"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="datatable table table-striped table-bordered table-hover text-left SendDocument" style="font-size: 12px; width: 100% !important;">
                            <thead class="bg-primary center">
                                <tr>
                                    <td><input type="checkbox" id="checkall"></td>
                                    <td>Nomor Induk</td>
                                    <td>Nama</td>
                                    <td>Keterangan</td>
                                    <td>Seksi</td>
                                    <td>Tanggal</td>
                                    <td>Tanggal Update</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($table as $row): ?>
                                <tr>
                                    <td><input class="check" type="checkbox"></td>
                                    <td class="data-id" data-id="<?= $row['id_data'] ?>">
                                        <?= $row['noind'] ?>
                                    </td>
                                    <td>
                                        <?= $row['nama'] ?>
                                    </td>
                                    <td>
                                        <?= $row['keterangan'] ?>
                                    </td>
                                    <td>
                                        <?= $row['seksi_name'] ?>
                                    </td>
                                    <td>
                                        <?php echo 
                                            ($row['tanggal_start'] == $row['tanggal_end'])? 
                                            date('d/m/Y', strtotime($row['tanggal_start'])) : 
                                            date('d/m/Y', strtotime($row['tanggal_start']))." - ".date('d/m/Y',strtotime($row['tanggal_end'])) 
                                        ?>
                                    </td>
                                    <td>
                                        <?= date('d/m/Y', strtotime($row['tgl_update'])) ?>
                                    </td>
                                    <td>
                                        <button onclick="accData(<?php echo $row['id_data'].','.$lv ?>)" class="btn btn-sm btn-success acc_btn">accept</button>&nbsp
                                        <button onclick="rejData(<?php echo $row['id_data'].','.$lv ?>)" class="btn btn-sm btn-danger rej_btn">reject</button>
                                    </td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- only noob die in redzone -->
<script>
    baseurl = '<?= base_url() ?>'

    const accData = (id, lv) => {
        let checked = $('.check').parent().filter(".checked")

        swal.fire({
            title: `Yakin untuk mengapprove &nbsp;<span style="color: red;">${checked.length ? checked.length : 1}</span>&nbsp; data ?`,
            text: 'cek kevalid-an data',
            type: 'question',
            showCancelButton: true
        }).then(res => {
            if (res.value) {
                let allid = []
                if (checked.length > 0) {
                    checked.each(function() {
                        let newid = $(this).parent().next().data('id')
                        allid.push(newid)
                    })
                } else {
                    allid.push(id)
                }

                $.ajax({
                    method: 'POST',
                    url: baseurl + 'PengirimanDokumen/Personalia/ajax/sendapproval',
                    data: {
                        stat: 'approve',
                        id_data: allid,
                        level: lv
                    },
                    success: () => {
                        swal.fire('Sukses Mengapprove data', '', 'success')
                        allid.forEach(item => {
                            $("td[data-id="+item+"]").parent().css({
                                background: '#2abf4a'
                            }).fadeOut(2000, () => {
                                $(this).remove()
                            })
                        })
                        //loadTableDraft()
                    }
                })
            }
        })
    }

    const rejData = (id, lv) => {
        let checked = $('.check').parent().filter(".checked")

        swal.fire({
            title: `Yakin untuk reject &nbsp<span style="color: red;">${checked.length ? checked.length : 1}</span>&nbsp data ?`,
            text: 'masukkan alasan',
            input: 'textarea',
            type: 'question',
            showCancelButton: true
        }).then(res => {
            if (res.value) {
                let allid = []
                if (checked.length > 0) {
                    checked.each(function() {
                        let newid = $(this).parent().next().data('id')
                        allid.push(newid)
                    })
                } else {
                    allid.push(id)
                }

                let alasan = $('.swal2-textarea').val()

                if(alasan == ''){
                    swal.fire('isi alasan', '', 'warning')
                    return
                }

                $.ajax({
                    method: 'POST',
                    url: baseurl + 'PengirimanDokumen/Personalia/ajax/sendapproval',
                    data: {
                        stat: 'reject',
                        id_data: allid,
                        alasan: alasan,
                        level: lv
                    },
                    success: () => {
                        swal.fire('Sukses Mereject Data', '', 'success')
                        allid.forEach(item => {
                            $("td[data-id="+item+"]").parent().css({
                                background: '#d9232c'
                            }).fadeOut(2000, () => {
                                $(this).remove()
                            })
                        })
                    }
                })
            }
        })
    }

    const loadTableDraft = () => { //maybe will useless
        let lv = '<?=$lv?>'

        $.ajax({
            url: baseurl + 'PengirimanDokumen/Personalia/ajax/newData',
            data: {
                level: lv
            },
            dataType: 'json',
            success: res => {
                let table;

                if (res.length > 0) {
                    res.forEach(item => {
                        table += `<tr>
                                    <td><input class="check" type="checkbox"></td>
                                    <td class="data-id" data-id="${item.id_data}">${item.noind}</td>
                                    <td>${item.nama}</td>
                                    <td>${item.keterangan}</td>
                                    <td>${item.tanggal}</td>
                                    <td>${item.tgl_update}</td>
                                    <td>
                                        <button onclick="accData(${item.id_data},${lv})" class="btn btn-sm btn-success acc_btn">accept</button>&nbsp
                                        <button onclick="rejData(${item.id_data},${lv})" class="btn btn-sm btn-danger rej_btn">reject</button>
                                    </td>
                                </tr>`
                    })
                } else {
                    table += `<tr><td colspan="7"><center>no row</center></td?</tr>`;
                }

                $('table > tbody').html(table)
                setIcheck()
            }
        })
    }
</script>