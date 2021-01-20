<div class="hold-transition login-panel">
    <section class="content">
        <div class="panel-group">
            <div class="panel panel-primary">
                <div class="panel-heading" style="display: flex; justify-content: space-between;">
                    <a href="<?= base_url('MasterPekerja/ResumeMedis/addResumeMedis') ?>">
                        <button class="btn btn-warning">
                            <span>Add</span>
                            <i class="fa fa-plus"></i>
                        </button>
                    </a>
                    <h3 style="text-align: right;">Resume medis</h3>
                </div>
                <div class="panel-body">
                    <div>
                        <table id="tbl_resume_medis" class="table table-hover table-bordered table-responsive">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Kode Mitra</th>
                                    <th style="text-align: center;">No Induk</th>
                                    <th style="text-align: center;">Nama</th>
                                    <th style="text-align: center;">Tanggal Kecelakaan</th>
                                    <th style="text-align: center;">Tanggal Periksa</th>
                                    <th style="text-align: center;">Proses</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1;
                                foreach ($data as $data) :
                                    $id_rm  = $this->general->enkripsi($data['id_rm']);
                                ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $data['kd_mitra'] ?></td>
                                        <td><?= $data['noind'] ?></td>
                                        <td><?= $data['nama'] ?></td>
                                        <td><?= $data['tgl_laka'] ?></td>
                                        <td><?= $data['tgl_periksa'] ?></td>
                                        <td style="text-align: center;">
                                            <a class="btn btn-success btn-sm" href="<?= base_url('MasterPekerja/ResumeMedis/cetakResumeMedis' . '/'  . $id_rm) ?>">Cetak</a>
                                            <a class="btn btn-warning btn-sm" href="<?= base_url('MasterPekerja/ResumeMedis/editResumeMedis' . '/' . $id_rm); ?>">Edit</a>
                                            <a href="#!" onclick="deleteConfirm('<?= base_url('MasterPekerja/ResumeMedis/deleteResumeMedis' . '/' . $id_rm); ?>')" class="btn btn-danger btn-sm">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Logout Delete Confirmation-->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Are you sure?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Data yang dihapus tidak akan bisa dikembalikan.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <a id="btn-delete" class="btn btn-danger" href="#">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(function() {
        $(window).ready(function() {
            $('#tbl_resume_medis').dataTable();
        })

    })

    function deleteConfirm(url) {
        $('#btn-delete').attr('href', url);
        $('#deleteModal').modal();
    }
</script>