<table class="table table-bordered">
    <tr>
        <td style="border-right: 0">
            <img alt="logo" src="<?php echo base_url('assets/img/logopatent.png') ?>" style="width:50px"/>
        </td>
        <td style="border-left: 0">
            <h4>
                CV. KARYA HIDUP SENTOSA
            </h4>
            <p style="font-size:8pt">
                <u>
                    PABRIK MESIN ALAT PERTANIAN.PENGECORAN LOGAM.DEALER UTAMA DIESEL KUBOTA
                </u>
                <br/>
                Kantor Pusat : JL. Magelang No. 144 Jogjakarta 55241 - Indonesia
                <br>
                    Telp.(0274)512095(hunting),563217;Fax(0274)563523;E-mail:operator1@quick.co.id
                </br>
            </p>
        </td>
        <td class="center-hor center-ver">
        	<h1>PACKING LIST</h1>
        </td>
    </tr>
</table>
<table class="table table-bordered">
	<?php foreach ($destination as $value) { ?>
		<tr>
			<td class="top-ver" width="11%" height="80px" style="border-right: 0">
				Kepada YTH :
			</td>
			<td style="border-left: 0" width="39%">
				<?php echo $value['KEPADA_YTH']; ?>
			</td>
			<td class="top-ver" width="14%" style="border-right: 0">
				Dikirim Kepada :
			</td>
			<td style="border-left: 0">
				<?php echo $value['DIKIRIM_KEPADA']; ?>
			</td>
		</tr>
	<?php } ?>
</table>