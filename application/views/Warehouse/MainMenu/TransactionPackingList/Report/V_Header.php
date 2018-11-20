<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            body {
                font-size: 12px;
            }

            .table {
                width: 100%;
            }

            .table td {
                padding: 3px 3px;
            }

            .table-bordered, .table-bordered td {
                border: 1px solid #000;
                border-collapse: collapse;
            }

            .table-head-bordered, .table-head-bordered td {
                border: 1px solid #d3d3d3;
                border-collapse: collapse;
            }

            .center-hor, .center-hor td {
                text-align: center;
            }

            .right-hor, .right-hor td {
                text-align: right;
            }

            .center-ver, .center-ver td {
                vertical-align: middle;
            }

            .text-bold , .text-bold td {
                font-weight: bold;
            }

            .top-ver {
                vertical-align: top;
            }
        </style>
    </head>
    <body>
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