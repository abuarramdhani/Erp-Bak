<html><head></head>
    <body>
        <div style="width: 100%;padding-right: 30px;">
            <p><b><i>Lampiran</i></b></p>
            <table style="font-size: 13px;  width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border: 1px solid;"><i>No</i></th>
                        <th style="border: 1px solid;"><i>Nama</i></th>
                        <th style="border: 1px solid;"><i>No Keb</i></th>
                        <th style="border: 1px solid;"><i>Job Desk</i></th>
                        <th style="border: 1px solid;"><i>Alasan Kebutuhan</i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    for ($i=0; $i < count($lampiran) ; $i++) {
                        $a = $lampiran[$i]['nokeb'];
                        $b = $lampiran[$i]['job_desk'];
                        $c = $lampiran[$i]['alasan_pemenuhan'];
                        echo "<tr>";
                        echo "<td style='border: 1px solid;'>".$no++."</td>";
                        echo "<td style='border: 1px solid;'>".$lampiran[$i]['nama']."</td>";
                        echo "<td style='border: 1px solid;'>".$a."</td>";
                        echo "<td style='border: 1px solid;'>".$b."</td>";
                        echo "<td style='border: 1px solid;'>".$c."</td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </body>
</html>
