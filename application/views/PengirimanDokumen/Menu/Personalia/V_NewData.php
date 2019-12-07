<style>
    .center{
        text-align: center;
    }
    tbody>tr>td{
        text-align: center;
    }
	thead>tr{
		font-weight: bold;
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
                        <table class="datatable table table-striped table-bordered table-hover text-left SendDocument" style="font-size: 12px;">
                            <thead class="bg-primary center">
                                <tr>
                                    <td><input type="checkbox" id="checkall"></td>
                                    <td>Nomor Induk</td>
                                    <td>Nama</td>
                                    <td>Keterangan</td>
                                    <td>Tanggal</td>
                                    <td>Tanggal Update</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($table as $row): ?>
                                    <tr>
                                        <td><input class="check" type="checkbox"></td>
                                        <td class="data-id" data-id="<?= $row['id_data'] ?>"><?= $row['noind'] ?></td>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= $row['keterangan'] ?></td>
                                        <td><?= $row['tanggal'] ?></td>
                                        <td><?= $row['tgl_update'] ?></td>
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
        }).then(res=>{
            if(res.value){
                let checked = $('.check').parent().filter(".checked")
                let allid = []
                if(checked.length > 0){
                    checked.each(function() {
                        let newid = $(this).parent().next().data('id')
                        allid.push(newid)
                    })
                }else{
                    allid.push(id)
                }

                $.ajax({
                    method: 'POST',
                    url: baseurl+'PengirimanDokumen/Personalia/ajax/sendapproval',
                    data: {
                        stat: 'approve',
                        id_data: allid,
                        level: lv
                    },success: () => {
                        swal.fire('Sukses Mengapprove data', '', 'success')
                        loadTableDraft()
                    }
                })
            }
        })
    }

    const rejData = (id,lv) => {
        swal.fire({
            title: 'Yakin untuk reject ?',
            text: 'masukkan alasan',
            input: 'textarea',
            type: 'question',
            showCancelButton: true
        }).then(res=>{
            if(res.value){
                let checked = $('.check').parent().filter(".checked")
                let allid = []
                if(checked.length > 0){
                    checked.each(function() {
                        let newid = $(this).parent().next().data('id')
                        allid.push(newid)
                    })
                }else{
                    allid.push(id)
                }

                let alasan = $('.swal2-textarea').val()
                $.ajax({
                    method: 'POST',
                    url: baseurl+'PengirimanDokumen/Personalia/ajax/sendapproval',
                    data: {
                        stat: 'reject',
                        id_data: allid,
                        alasan: alasan,
                        level: lv
                    },success: () => {
                        swal.fire('Sukses Mereject Data', '', 'success')
                        loadTableDraft()
                    }
                })
            }
        })
    }

    const loadTableDraft = () => {
        let lv = '<?=$lv?>'

        $.ajax({
            url: baseurl+'PengirimanDokumen/Personalia/ajax/newData',
            data: {
                level: lv
            },
            dataType: 'json',
            success: res => {
                let table;
                console.log(res.length)

                if (res.length > 0){
                    res.forEach(item=>{
                            table +=    `<tr>
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
                }else{
                    table += `<tr><td colspan="7"><center>no row</center></td?</tr>`;
                }
                
                $('table > tbody').html(table)
            }
        })
    }

    $(document).ready(function(){
        // setTimeout(function(){
        //     $('.icheckbox_flat-blue').first().click(function(){
        //         if($(this).hasClass('checked')){
        //             $('.icheckbox_flat-blue').removeClass('checked');
        //         }else{
        //             $('.icheckbox_flat-blue').addClass('checked');
        //         }
        //     })
        // }, 3000)

        // $(".acc_btn").each((i, obj)=>{

        //     let data = $(obj).parent().html()
        //     console.log(data);

        //     $(this).on('click', function(){
        //         console.log("asa");
        //     })
        // })

        // let elementsArray = document.querySelectorAll(".acc_btn");

        // elementsArray.forEach(function(elem) {
        //     let id_data = $(this).parent().parent().find('.data-id').data('id')
        //     console.log(id_data);
            
        //     elem.addEventListener("click", function() {
        //         swal.fire({
        //             title: 'Yakin untuk mengapprove ?',
        //             text: 'cek kevalid-an data',
        //             type: 'question',
        //             showCancelButton: true
        //         }).then(res=>{
        //             if(res.value){
        //                 console.log(id_data);
                        
        //             }
        //         })
                
        //     });
        // });
        
    })
</script>