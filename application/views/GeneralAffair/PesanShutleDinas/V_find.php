<p style="text-align: center; font-size: 18px"><b>Rekap <?= $waktu ?></b></p>
<table class="table table-striped table-bordered table-hover" id="GA_Tbl_shutle" width="100%" style="margin-top: 20px">
    <tr>
        <th colspan="2" rowspan="2" width="8%" style="background-color: #94cfff"></th>
        <th class="text-center" colspan="4" style="background-color: #94cfff">DARI PUSAT</th>
    </tr>
    <tr>
        <th class="text-center" width="23%">08:00</th>
        <th class="text-center" width="23%">10:00</th>
        <th class="text-center" width="23%">13:00</th>
        <th class="text-center" width="23%">-</th>
    </tr>
    <tr>
        <th class="text-center" rowspan="4" style="background-color: #94cfff">D<br>A<br>R<br>I<br><br>T<br>U<br>K<br>S<br>O<br>N<br>O</th>
        <th class="text-center">09:00</th>
        <td><?php if (!empty($data89[0]['pekerja'])) {
            foreach ($data89 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
        <td><?php if (!empty($data910[0]['pekerja'])) {
            foreach ($data910 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
        <td><?php if (!empty($data913[0]['pekerja'])) {
            foreach ($data913 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
        <td><?php if (!empty($data900[0]['pekerja'])) {
            foreach ($data900 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
    </tr>
    <tr>
        <th class="text-center">11:00</th>
        <td><?php if (!empty($data811[0]['pekerja'])) {
            foreach ($data811 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
        <td><?php if (!empty($data1011[0]['pekerja'])) {
            foreach ($data1011 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
        <td><?php if (!empty($data1113[0]['pekerja'])) {
            foreach ($data1113 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
        <td><?php if (!empty($data1100[0]['pekerja'])) {
            foreach ($data1100 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
    </tr>
    <tr>
        <th class="text-center">14:00</th>
        <td><?php if (!empty($data814[0]['pekerja'])) {
            foreach ($data814 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
        <td><?php if (!empty($data1014[0]['pekerja'])) {
            foreach ($data1014 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
        <td><?php if (!empty($data1314[0]['pekerja'])) {
            foreach ($data1314 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
        <td><?php if (!empty($data1400[0]['pekerja'])) {
            foreach ($data1400 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
    </tr>
    <tr>
        <th class="text-center">-</th>
        <td><?php if (!empty($data8[0]['pekerja'])) {
            foreach ($data8 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
        <td><?php if (!empty($data10[0]['pekerja'])) {
            foreach ($data10 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
        <td><?php if (!empty($data13[0]['pekerja'])) {
            foreach ($data13 as $key) {
                echo $key['pekerja'];
            }
        }else {
            echo '-';
        } ?></td>
        <td>-</td>
    </tr>
</table>
