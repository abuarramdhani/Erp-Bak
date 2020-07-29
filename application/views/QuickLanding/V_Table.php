<table class="table table-bordered table-hover tblReportQlanding">
    <thead>
        <tr class="bg-primary">
            <th class="bg-primary">No</th>
            <th class="bg-primary">Button Location</th>
            <th class="bg-primary">Browser</th>
            <th class="bg-primary">Click Date</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $no = 0;
            foreach ($report as $key => $rpt) { 
                $no ++;?>
            <tr>
                <td><?php echo $no;?></td>
                <td><?= $rpt['button_location'];?></td>
                <td><?= $rpt['browser'];?></td>
                <td><?= $rpt['creation_date'];?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>
