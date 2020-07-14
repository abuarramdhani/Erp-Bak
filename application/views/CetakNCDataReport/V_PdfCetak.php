	<style>           
	 #page-border{                
		 width: 100%;                
		 height: 100%;                
		 border:2px solid black;   
		}       
</style>
<?php //echo "<pre>";print_r($data);exit()?>
<div class="row" id="page-border" style="padding:0px;">
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;" >
    <tr>
        <td style="width: 20%; border-bottom :0px; border-collapse: collapse;text-align:left;font-weight:bold">
            <img style="width: 50px;height: 70px" src="<?php echo base_url('assets/img/logo.png'); ?>">
        </td>
        <td style="width: 50%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold;font-size:20px">
            NC DATA REPORT TOOL MAKING
        </td>
        <td style="width: 30%; border-bottom :0px; border-collapse: collapse;text-align:right;font-weight:bold">
            <img style="width: 45px;height: 60px" src="<?php echo base_url('application/views/CetakNCDataReport/tmk.png'); ?>">
        </td>
    </tr>
    <tr>
        <td colspan="3" style="width: 100%; border-bottom :0px; border-collapse: collapse;text-align:right;font-size:10px;font-style:italic">
            FRM-TMK-04-02 (Rev 03 - 29  Juni 2019)
        </td>
    </tr>
</table>
<table style="width: 100%; border-bottom :0px; border-collapse: collapse;margin-left:5px;margin-right:5px" >
    <tr>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">TOOL NO/ITEM</td>
        <td style="width:20%;border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">: <?= $data[0]['toolno']?></td>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">PROGRAMMER</td>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">: <?= $data[0]['programmer']?></td>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">MACHINE</td>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">: YMC</td>
    </tr>
    <tr>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">PART NAME</td>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">: <?= $data[0]['partname']?></td>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">FILE CAD / CAM</td>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">: CIMATRON</td>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">SHIFT</td>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">: <?= $data[0]['shift']?></td>
    </tr>
    <tr>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">DATE</td>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">: <?= $data[0]['date']?></td>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">FILE NC</td>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">: NC DATA REPORT</td>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">SPV. SIGN</td>
        <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:left;font-size:12px">: </td>
    </tr>
    </table>
    <table style="width: 100%; border-bottom :0px; border-collapse: collapse;margin-left:5px" >
        <tr>
            <td style="width: 100%; border-bottom :0px; border-collapse: collapse;text-align:left;margin-left:5px">
                Sket :
            </td>
        </tr>
        <tr>
            <td style="width: 100%; border-bottom :0px; border-collapse: collapse;text-align:center;font-weight:bold">
                <img style="max-width: 400px;max-height: 400px" src="<?php echo base_url('img/tmk.png'); ?>">
            </td>
        </tr>
    </table>
    <table style="width: 100%; border-bottom :0px; border-collapse: collapse;margin-top:20px;margin-left:5px;margin-right:5px" >
        <thead>
            <tr>
                <td rowspan="2" style="width: 5%;border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px">NO</td>
                <td rowspan="2" style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px">NC PROGRAM</td>
                <td colspan="3" style="width: 24%;border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px">TOOL</td>
                <td rowspan="2" style="width: 8%;border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px">Z (Depth tool)</td>
                <td rowspan="2" style="width: 8%;border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px">CHECK (by op. CNC)</td>
                <td rowspan="2" style="width: 8%;border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px">ALLOW</td>
                <td rowspan="2" style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px">TIME</td>
                <td rowspan="2" style="width: 15%;border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px">REMARK</td>
            </tr>
            <tr>
                <td style="width:5%;border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px;">T</td>
                <td style="width:5%;border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px;">DIA.</td>
                <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px">TOOLNAME</td>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1;foreach ($data as $val) { 
                // echo "<pre>";print_r($val);exit();
                for ($i=0; $i < count($val['title']); $i++) { ?>
                <tr>
                    <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px"><?php if($i==0){echo $no;}?></td>
                    <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px;text-align:left"><?php if($i==0){echo $val['title'][0];}?></td>
                    <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px"><?= $val['T'][$i]?></td>
                    <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px"></td>
                    <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px;text-align:left"><?= $val['toolname'][$i]?></td>
                    <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px"></td>
                    <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px"></td>
                    <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px"></td>
                    <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px"></td>
                    <td style="border:1px solid black; border-bottom :0px; border-collapse: collapse;text-align:center;font-size:12px"></td>
                </tr>
                <?php }
                $no++;}
            ?>
        </tbody>
    </table>
</div>