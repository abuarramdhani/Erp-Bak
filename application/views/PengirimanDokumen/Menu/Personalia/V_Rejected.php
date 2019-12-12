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
            <div class="box box-danger box-solid">
                <div class="box-header with-border">
                    <h2><b>Data Rejected - Personalia <?=$lv?></b></h2>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="datatable table table-striped table-bordered table-hover text-left SendDocument" style="font-size: 12px;">
                            <thead class="bg-primary center">
                                <tr>
                                    <td>No</td>
                                    <td>Nomor Induk</td>
                                    <td>Nama</td>
                                    <td>Keterangan</td>
                                    <td>Tanggal</td>
                                    <td>Tanggal Reject</td>
                                    <td>Alasan</td>
                                    <td>Edit</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1; foreach($table as $row): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td class="personal" data-seksi="<?= $row['seksi_name'] ?>"><?= $row['noind'] ?></td>
                                        <td class="name"><?= $row['nama'] ?></td>
                                        <td class="ket"><?= $row['keterangan'] ?></td>
                                        <td>
                                        <?php echo 
                                            ($row['tanggal_start'] == $row['tanggal_end'])? 
                                            date('Y/m/d', strtotime($row['tanggal_start'])) : 
                                            date('Y/m/d', strtotime($row['tanggal_start']))." - ".date('Y/m/d',strtotime($row['tanggal_end'])) 
                                        ?>
                                        </td>
                                        <td><?= $row['tgl_update'] ?></td>
                                        <td><?= $row['alasan'] ?></td>
                                        <td><button data-id="<?= $row['id_data'] ?>" data-toggle="modal" data-target="#modalChange" class="btn btn-sm btn-success btn-change"><i class="fa fa-edit"></button></td>
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

<div class="modal fade" id="modalChange" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-detail">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title center"><b>Detail</b></h3>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group col-lg-4">
                        <label for="modalDetail">No Induk</label>
                        <input class="form-control col-lg-4" id="modalNoind" disabled>
                    </div>
                    <div class="form-group col-lg-8">
                        <label for="modalApp1">Nama</label>
                        <input class="form-control" id="modalName" disabled>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="modalApp2">Keterangan</label>
                        <input class="form-control" id="modalKet" disabled>
                    </div>
                    <div class="form-group col-lg-12">
                        <label for="modalApp2">Seksi</label>
                        <input class="form-control" id="modalSection" disabled>
                    </div>
                    <div class="form-group modalHistoryDiv borderHistory">
                        <!-- on js -->
                    </div>
                </form>
            </div>
            <div style="margin: 0 1em 0 1em;" class="modal-footer">
                <!-- <button class="btn btn-danger">Reject</button> -->
                <button class="btn btn-success acc">Approve</button>
            </div>
            <div class="modal-footer">
                <small style="color:red;">*pastikan data valid</small>
            </div>
        </div>
    </div>
</div>

<script>
baseurl = '<?= base_url()?>'
    $(document).ready(function(){
        $('.btn-change').click(function(){
            let id = $(this).data('id')
            $('.rej, .acc').attr('data-id',id)

            let elem    = $(this).closest('tr')
            let noind   = elem.find('.personal').text()
            let name    = elem.find('.name').text()
            let section = elem.find('.personal').data('seksi')
            let ket     = elem.find('.ket').text()

            $('#modalNoind').val(noind)
            $('#modalName').val(name)
            $('#modalSection').val(section)
            $('#modalKet').val(ket)
        })

        $('.acc').click(function(){

            let id = $(this).data('id')
            appDocument(id,!0)
        })

        // $('.rej').click(function(){
        //     let id = $(this).data('id')
        //     appDocument(id,false, 'textarea')
        // })

    })

</script>