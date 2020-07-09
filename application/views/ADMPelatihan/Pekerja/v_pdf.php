<html>
<head>
</head>
<body>
<?php
		set_time_limit(0);
		ini_set("memory_limit", "2048M");

	?>
<div style="width: 100%;padding-right: 30px;">
<h3>Data Pribadi</h3>

<center><img style="margin-top: 5px" name="img_pekerja" width="117" height="151" src="<?php echo $data['photo'] ?>"></center>


<br>
<br>
<table style="width:100%;font-size: 16px;padding-left: 20px;">
<tbody>
<tr>
	<td>Noinduk</td>
	<td>:</td>
	<td><?php echo $data['noind'] ?></td> 
</tr>
<tr>
	<td>Nama</td>
	<td>:</td>
	<td> <?php echo ucwords(strtolower($data['nama'])) ?></td>
</tr>
<tr>
	<td>Jabatan</td>
	<td>:</td>
	<td><?php echo ucwords(strtolower($data['jabatan']))?> </td>
</tr>
<tr>
	<td>Seksi</td>
	<td>:</td>
	<td><?php echo ucwords(strtolower($data['seksi']))?> </td>
</tr>
<tr>
	<td>Pekerjaan</td>
	<td>:</td>
	<td><?php echo ucwords(strtolower($data['kerja']))?> </td>
</tr>
<tr>
	<td>Unit</td>
	<td>:</td>
	<td><?php echo ucwords(strtolower($data['unit']))?> </td>
</tr>
<tr>
	<td>Bidang</td>
	<td>:</td>
	<td><?php echo ucwords(strtolower($data['bidang']))?> </td>
</tr>
<tr>
	<td>Departemen</td>
	<td>:</td>
	<td><?php echo ucwords(strtolower($data['dept']))?> </td>
</tr>
</tbody>
</table>
<br>
<br>
<?php if (isset($training) && !empty($training)) { ?>
<table  border="1" style="width:100%;font-size: 14px;padding-left: 20px;">
											<thead >
												<tr>
													<th style="text-align: center; width: 5%">No</th>
                                                    <th style="text-align: center;width: 30%">Pelatihan Yang Sudah Diikuti</th>
                                                    <th style="text-align: center;width: 15%">Tanggal</th>
                                                    <th style="text-align: center;width: 22%">Waktu</th>
                                                    <th style="text-align: center;width: 13%">Ruangan</th>
                                                    <th style="text-align: center;width: 15%">Trainer</th>
												</tr>
											</thead>
											<tbody>
                                            <?php
                                                    $no=1;
                                                    foreach ($training as $key) {
                                                        ?>
                                                                <tr>
                                                                    <td style="text-align: center;"><?php echo $no; ?></td>
                                                                     <td style="padding-left: 5px;"><?php echo ucwords(strtolower($key['training_name'])); ?></td>
                                                                     <td style="padding-left: 5px;"><?php echo date('d-m-Y', strtotime($key['date'])) ?></td>
                                                                     <td style="padding-left: 5px;"><?php echo $key['waktu']; ?></td>
                                                                     <td style="padding-left: 5px;"><?php echo ucwords(strtolower($key['room'])); ?></td>
                                                                     <td style="padding-left: 5px;"><?php echo ucwords(strtolower($key['trainer_name'])); ?></td>
           

                                                                </tr>
                                                                <?php
                                                                $no++;

                                                        }
                                                        ?>

                                                        <?php
                                                    
                                            ?>
                                            </tbody>
										</table>
										 <?php } ?>
</div>
</body>
</html>
