<!-- 	<style>           
	 #page-border{                
		 width: 100%;                
		 height: 100%;                
		 border:4px double black;            
		}       
</style> -->
<div id="page-border">
	<table style="border: 1px solid black; border-collapse: collapse; width: 100%">
		<tr>
			<td rowspan="4" width="5%" style="font-size: 11px; text-align: center; padding-left: 7px;">
           <img width="5%" style="height: 100px; width: 100px"
            src="<?= base_url('assets/img/logo.png') ;?>" style="display:block;">
          </td>
          <td rowspan="4" width="25%" style="font-size: 11px; text-align: left; padding-left: 5px;width: 22%">
          CV KARYA HIDUP SENTOSA<br>
          YOGYAKARTA <br>
          <br>
          Departement Produksi
          </td>
			<td style="border: 1px solid black;border-collapse: collapse; font-weight: bold;font-size: 10pt;text-align: center; background-color: yellow;width: 35%">PRODUCTION ENGINEERING</td>
			<td style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px;width: 7%">Doc. No.</td>
			<td style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px;text-align: left;width: 25%"></td>
		</tr>
		<tr>	
			<td rowspan="3"  style="border: 1px solid black;border-collapse: collapse;font-size: 14pt;padding-left: 5px;font-weight: bold; text-align: center;"> RESOURCE & BoM</td>
			<td  style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px">Print Date </td>
			<td  style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px;text-align: left;"><?= date('d M Y')?></td>

		</tr>

		<tr>
			<td  style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px">By </td>
			<td  style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px;text-align: left;"> <?=$user?> - <?=$name?></td>

		</tr>

		<tr>
			<td style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px">Page </td>
			<td style="border: 1px solid black;border-collapse: collapse;font-size: 12px;padding-left: 7px;text-align: left;"> {PAGENO} from {nbpg}</td>

		</tr>
	</table>
</div>