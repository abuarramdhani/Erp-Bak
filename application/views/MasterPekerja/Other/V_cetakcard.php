<?php
for($i = 0; $i < count($worker); $i++): ?>
<table style="width:50%; margin-bottom: 5px;" cellspacing="0">
	<?php if(($i+1)%2 == 0): ?>
	<tr>
		<td colspan="2" style="width: 320px;height: 55px;padding: 7px; border: 3px solid black;">
			<img src="<?php echo base_url('/assets/img/id_card.png'); ?>" width="325px" height="55px">
		</td>
		<td style="min-width: 50px;"></td>
		<td colspan="2" style="width: 320px;height: 55px;padding: 7px; border: 3px solid black;">
			<img src="<?php echo base_url('/assets/img/id_card.png'); ?>" width="325px" height="55px">
		</td>
	</tr>
	<tr>
		<td style="width: 75px;height: 100px;padding: 10px; border-left: 3px solid black; border-bottom: 3px solid black;">
			<img src="<?php echo $worker[$i-1][0]['photo'];?>" width="75px" height="100px" style="border: 1px solid black;border-radius: 35px"/>
		</td>
		<td style="width: 245px;height: 100px;text-align: center; border-right: 3px solid black; border-bottom: 3px solid black;line-height: 1.6">
			<h3 style="font-size: 24px;font-family: Times New Roman;" width="245px" height="60px"><b><?php echo $worker[$i-1][0]['nama_panggilan'];?></b></h3>
			<p style="font-size: 10px;color: red;font-family: Times New Roman" width="245px"><b><?php echo $worker[$i-1][0]['jabatan'];?></b></p>
			<p style="font-size: 10px;color: red;font-family: Times New Roman" width="245px"><b><?php echo $worker[$i-1][0]['seksi'];?></b></p>
			<br>
			<img src="<?php echo base_url('assets/plugins/barcode.php?size=60&text=').$worker[$i-1][0]['no_induk'];?>" style="padding-top:-15px;" width="180px" height="34px">
			<p style="font-size: 11px;letter-spacing: 15px;" width="245px"><?php echo $worker[$i-1][0]['no_induk'];?></p>
		</td>
		<td style="min-width: 50px;"></td>
		<td style="width: 75px;height: 100px;padding: 10px; border-left: 3px solid black; border-bottom: 3px solid black;">
			<img src="<?php echo $worker[$i][0]['photo'];?>" width="75px" height="100px" style="border: 1px solid black;border-radius: 35px"/>
		</td>
		<td style="width: 245px;height: 100px;text-align: center; border-right: 3px solid black; border-bottom: 3px solid black;line-height: 1.6">
			<h3 style="font-size: 24px;font-family: Times New Roman" width="245px" height="60px"><b><?php echo $worker[$i][0]['nama_panggilan'];?></b></h3>
			<p style="font-size: 11px;color: red;font-family: Times New Roman" width="245px"><b><?php echo $worker[$i][0]['jabatan'];?></b></p>
			<p style="font-size: 11px;color: red;font-family: Times New Roman" width="245px"><b><?php echo $worker[$i][0]['seksi'];?></b></p>
			<br>
			<img src="<?php echo base_url('assets/plugins/barcode.php?size=60&text=').$worker[$i][0]['no_induk'];?>" width="180px" style="padding-top:-15px;" height="34px">
			<p style="font-size: 11px;letter-spacing: 15px;" width="245px"><?php echo $worker[$i][0]['no_induk'];?></p>
		</td>
	</tr>
	<?php endif; ?>
</table>
<?php endfor; ?>

<!-- ini buat kalo misal jumlah data $worker ganjil -->
<?php if(count($worker)%2 == 1): ?>
<table style="width:23.1%; margin-bottom: 5px;" cellspacing="0">
	<tr>
		<td colspan="2" style="width: 320px;height: 55px;padding: 7px; border: 3px solid black;">
			<img src="<?php echo base_url('/assets/img/id_card.png'); ?>" width="325px" height="55px">
		</td>
	</tr>
	<tr>
		<td style="width: 75px;height: 100px;padding: 10px; border-left: 3px solid black; border-bottom: 3px solid black;">
			<img src="<?php echo $worker[(count($worker)-1)][0]['photo'];?>" width="75px" height="100px" style="border: 1px solid black;border-radius: 35px"/>
		</td>
		<td style="width: 245px;height: 100px;text-align: center; border-right: 3px solid black; border-bottom: 3px solid black;line-height: 1.6">
			<h3 style="font-size: 24px;font-family: Times New Roman" width="245px" height="60px"><b><?php echo $worker[(count($worker)-1)][0]['nama_panggilan'];?></b></h3>
			<p style="font-size: 10px;color: red;font-family: Times New Roman" width="245px"><b><?php echo $worker[(count($worker)-1)][0]['jabatan'];?></b></p>
			<p style="font-size: 10px;color: red;font-family: Times New Roman" width="245px"><b><?php echo $worker[(count($worker)-1)][0]['seksi'];?></b></p>
			<br>
			<img src="<?php echo base_url('assets/plugins/barcode.php?size=60&text=').$worker[(count($worker)-1)][0]['no_induk'];?>" style="padding-top:-15px;" width="180px" height="34px">
			<p style="font-size: 11px;letter-spacing: 15px;" width="325px"><?php echo $worker[(count($worker)-1)][0]['no_induk'];?></p>
		</td>
	</tr>
</table>
<?php endif; ?>
