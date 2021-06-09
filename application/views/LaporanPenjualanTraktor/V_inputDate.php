<style>
.button-date {
    width: 4.5ch;
    height: 4.5ch;
    border-radius: 50%;
    background-color: transparent;
    border: 0;
    color: #486581;
}

.button-date:hover,
.button-date:focus {
    outline: none;
    background-color: #3C8DBC;
    color: white;
}
</style>
<section class="content">
    <div class="inner">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="col-lg-11">
                            <div class="text-right">
                                <h1>INPUT <b>TANGGAL LIBUR</b></h1>
                            </div>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-primary box-solid">
                            <div class="box-header with-border">
                                <i class="fa fa-calendar" style="margin:0 10px;"></i>Input Tanggal Libur
                            </div>
                            <div class="box-body">
                                <div class="col-lg-12" style="padding:20px;display:flex;justify-content:center;">
                                    <div style="width:40%;padding-top:10px;padding-right:30px;">
                                        <span style="display:block;width:100%;margin-bottom:20px;">
                                            <h4><b>Tabel</b> Tanggal Libur Bulan <b><?= date('M') ?>
                                                    <?= date('Y') ?></b></h4>
                                        </span>
                                        <table class="table table-bordered table-striped table-hovered"
                                            style="width:100%;">
                                            <thead class="bg-primary">
                                                <th>
                                                    <center>Tanggal</center>
                                                </th>
                                                <th>Keterangan</th>
                                                <th>
                                                    <center>Action</center>
                                                </th>
                                            </thead>
                                            <tbody id="tbody-skipdate-lpt">
                                                <?php foreach ($skipDateMonth as $value) { ?>
                                                <tr>
                                                    <td width=20%>
                                                        <center><b><?= $value['TANGGAL'] ?></b></center>
                                                    </td>
                                                    <td><?= $value['NOTES'] ?></td>
                                                    <td>
                                                        <center>
                                                            <button class="btn btn-danger button-delete-date-lpt"
                                                                data-id="<?= $value['DATE_ID'] ?>"
                                                                data-date="<?= $value['TANGGAL'] ?>"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </center>
                                                    </td>
                                                </tr>
                                                <?php }; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div style="width:35%;padding-top:10px;padding-left:30px;">
                                        <span style="display:block;width:100%;margin-bottom:20px;">
                                            <h4><b>Form Input</b> Tanggal Libur</h4>
                                        </span>
                                        <span class="bg-primary"
                                            style="width:100%;display:block;padding:4px 20px;">Input
                                            Tanggal</span>
                                        <input id="input-date-lpt" type="text" class="form-control"></input>
                                        <span class="bg-primary"
                                            style="width:100%;display:block;padding:4px 20px;margin-top:20px;">Keterangan</span>
                                        <textarea id="input-notes-lpt" class="form-control"></textarea>
                                        <button id="button-input-skipDate" class="btn btn-primary"
                                            style="margin-top:25px;width:100%"><b>Submit</b></button>
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