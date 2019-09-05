<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<div style="width: 100%">
		<div style="width: 100%">

		</div>
          <?php
         $p=0;
         // $loop = 1;
         for ($i=0; $i < count($newArr) ; $i++) { ?>

           <table colspan="10" class="table table-bordered" width="100%" border="1" style="border: 1px solid black; border-collapse: collapse;">
            <thead>
              <tr>
                <td style="text-align: center">No</td>
                <td style="text-align: center">No. Induk</td>
                <td style="text-align: center">Nama</td>
                <td style="text-align: center">Nominal</td>
              </tr>
            </thead>
            <tbody>
             <?php $angka=1; for ($j=0; $j < count($newArr[$i]) ; $j++) {  ?>
               <tr>
                 <td style="text-align: center;"><?php echo $angka ?></td>
                 <td style="text-align: center;"><?php echo $newArr[$i][$p]['noind']; ?></td>
                 <td><?php echo $newArr[$i][$p]['nama']; ?></td>
                 <td style="text-align: center;"><?php echo $newArr[$i][$p]['nominal']; ?></td>
               </tr>
             <?php $angka++; $p++; } ?>
           </tbody>
           </table>
					 <?php if ($newArr[$i] != $newArr[count($newArr)-1]){ ?>
						 <br>
					 <?php } ?>
				 <?php } ?>
			 </tbody>
			 <table style="page-break-inside:avoid; position:relative; display:block;">
				 <tr>
					 <td style="height: 20px;"></td>
				 </tr>
				 <tr>
					<td>Yogyakarta, <?php echo $today ?></td>
				 </tr>
				 <tr>
					<td>DEPARTEMEN PERSONALIA</td>
				 </tr>
				 <tr>
					<td style="height: 50px;"></td>
				 </tr>
				 <tr>
					<td><?php echo'<b><u>'.$user_name[0]['nama'].'</u></b>'; ?></td>
				 </tr>
				 <tr>
					<td><?php echo $user_name[0]['jabatan']; ?></td>
				 </tr>
			 </table>
  </div>
</body>
</html>
