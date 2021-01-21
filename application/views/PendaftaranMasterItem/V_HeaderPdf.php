<?php 
		// echo "<pre>";print_r($fix);exit();?>
<style>              
</style>
<div class="row" id="page-border" style="padding-top:0px;">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; font-size: 11.5px" >
    <tr>
        <td rowspan="4" style="width: 7%; border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black">
            <img style="width: 50px;height: 70px" src="<?php echo base_url('assets/img/logo.png'); ?>">
        </td>
        <td rowspan="4" style="width: 15%; border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            <p style="font-size: 11px">CV KARYA HIDUP SENTOSA</p>
            <p style="font-size: 11px">YOGYAKARTA</p><br><br>
            <p style="font-size: 11px">DEPARTMENT PRODUKSI</p>
        </td>
        <td rowspan="4" style="width: 50%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold;border: 1px solid black">
            <p style="font-size:19px; ">FORM</p>
            <p style="font-size:19px; ">PENDAFTARAN / REVISI / INACTIVE MASTER ITEM</p>
        </td>
        <td style="width:10%;border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            No. Dokumen
        </td>
        <td style="width:18%;border-bottom :0px; border-collapse: collapse; border: 1px solid black; font-size:11px">
            <?= $header[0]['NO_DOKUMEN']?>
        </td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            Seksi / Unit
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black; font-size:11px">
            <?= $header[0]['SEKSI'] ?>
        </td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            Tanggal
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black; font-size:11px">
        <?= date('d-m-Y', strtotime($header[0]['TGL_REQUEST'])) ?>
        </td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            Halaman
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
        {PAGENO} of {nbpg}
        </td>
    </tr>

</table>