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

    .fixed_header tbody{
        overflow:auto;
        height:400px;
        width:100%;
    }

    ::-webkit-scrollbar {
        display: none;
    }
</style>
<section class="content">
    <div class="panel-body">
        <div class="row">
            <div class="box box-warning box-solid">
                <div class="box-header with-border">
                    <h2><b>Data Baru - Personalia <?= $lv ?></b></h2>
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
                                            date('Y/m/d', strtotime($row['tanggal_start'])) : 
                                            date('Y/m/d', strtotime($row['tanggal_start']))." - ".date('Y/m/d',strtotime($row['tanggal_end'])) 
                                        ?>
                                    </td>
                                    <td>
                                        <?= date('Y/m/d', strtotime($row['tgl_update'])) ?>
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
        swal.fire({
            title: 'Yakin untuk mengapprove ?',
            text: 'cek kevalid-an data',
            type: 'question',
            showCancelButton: true
        }).then(res => {
            if (res.value) {
                let checked = $('.check').parent().filter(".checked")
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
        swal.fire({
            title: 'Yakin untuk reject ?',
            text: 'masukkan alasan',
            input: 'textarea',
            type: 'question',
            showCancelButton: true
        }).then(res => {
            if (res.value) {
                let checked = $('.check').parent().filter(".checked")
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

    const loadTableDraft = () => {
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