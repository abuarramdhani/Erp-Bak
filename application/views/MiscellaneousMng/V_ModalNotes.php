<table class="datatable table table-bordered table-hover table-striped text-center" style="width: 100%;">
    <thead class="bg-primary">
        <tr>
            <th>No</th>
            <th>Jenis Approval</th>
            <th>PIC</th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data as $key => $val) {
			$pic = $this->M_request->getUser($val[1]['pic']);?>
            <tr>
                <td><?= $no?></td>
                <td><?= $val[0]?></td>
                <td><?= $val[1]['pic']?> - <?= $pic[0]['nama']?></td>
                <td><?= stripos($val[0], 'Finish') !== FALSE ? '-' : $val[1]['note']?></td>
            </tr>
        <?php $no++;}?>
    </tbody>
</table>