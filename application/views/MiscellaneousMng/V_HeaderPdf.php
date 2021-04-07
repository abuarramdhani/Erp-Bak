<?php 
		// echo "<pre>";print_r($fix);exit();?>
<style>              
</style>
<div class="row" id="page-border" style="padding-top:0px;">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse; font-size: 11.5px" >
    <tr>
        <td rowspan="3" style="width: 7%; border-bottom :0px; border-collapse: collapse;text-align:center; border: 1px solid black">
            <img style="width: 50px;height: 70px" src="<?php echo base_url('assets/img/logo.png'); ?>">
        </td>
        <td rowspan="3" style="width: 50%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold;border: 1px solid black">
            <p style="font-size:19px; ">MEMO MISCELLANEOUS TRANSACTION</p>
        </td>
        <td style="width:10%;border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            No. Dokumen
        </td>
        <td style="width:18%;border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            <?= $header['no_dokumen']?>
        </td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            Nama IO
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            <?= $header['io'] ?>
        </td>
    </tr>
    <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            Tanggal
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
        <?= date('d F Y') ?>
        </td>
    </tr>
    <!-- <tr>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
            Halaman
        </td>
        <td style="border-bottom :0px; border-collapse: collapse; border: 1px solid black">
        {PAGENO} of {nbpg}
        </td>
    </tr> -->

</table>