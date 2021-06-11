<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary box-solid">
                <div class="box-header">
                    <div class="col-md-6 text-left">
                        <h4>
                            <strong>
                                Detail Group 
                            </strong>
                        </h4>
                    </div>
                </div>
                <div class="box-body">
                    <table id="tbl-group-header-GMI" wdith="100%" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No.</th>
                                <th width="25%" class="text-center">Group Name</th>
                                <th width="30%" class="text-center">Group Description</th>
                                <th width="15%" class="text-center">Creation Date</th>
                                <th width="25%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 0;
                                foreach ($header as $key => $head) {
                                    $no++;
                            ?>
                            <tr class="tr-header-<?= $head['HEADER_ID'] ?>-GMI">
                                <td align="center"><?= $no ?></td> 
                                <td><?= $head['GROUP_NAME'] ?></td> 
                                <td><?= $head['DESCRIPTION'] ?></td> 
                                <td align="center"><?= $head['CREATION_DATE'] ?></td> 
                                <td align="center">
                                    <a class="btn btn-primary btn-sm" href="<?= base_url('grouping-master-item/detail/'.$head['HEADER_ID']) ?>">Detail</a>
                                    <a class="btn btn-warning btn-sm" href="<?= base_url('grouping-master-item/update/'.$head['HEADER_ID']) ?>">Edit</a>
                                    <button class="btn btn-danger btn-sm btn-del-group-GMI" value="<?= $head['HEADER_ID'] ?>">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>