<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CV. Karya Hidup Sentosa | Monitoring Omset Akuntansi</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap/3.3.7/css/bootstrap.css');?>" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/Font-Awesome/4.3.0/css/font-awesome.min.css');?>" type="text/css" />
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/ionicons/css/ionicons.min.css');?>" type="text/css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/theme/css/AdminLTE.min.css');?>" type="text/css" />

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <style>
    th {
      text-align: center;
    }
  </style>
  
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
        <i class="fa fa-globe"></i> QUICK
          <small class="pull-right">Data Monitoring Omset Akuntansi</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- title row -->
</head>


<body onload="window.print();">
<div id="header"></div>
  <section class="invoice">   
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table border="1" >
          <thead>
            <tr>
              <th rowspan="2">No</th>
              <th rowspan="2">ID</th>
              <th rowspan="2">Order Number</th>
              <th rowspan="2">DPP</th>
              <th rowspan="2">Max Amount</th>
              <th rowspan="2">Selisih</th>
              <th colspan="4">Detail</th>
            <tr>
              <th>Nama Item</th>
              <th>Order Item</th>
              <th>Price Unit</th>
              <th>Creation Date</th>
            </tr>    
            </tr>
          </thead>

          <tbody>

          <?php     
            $num=0;
            $selisih='';
            $rowspan="";

            foreach ($order as $key => $grouping) {
              $num++;
              $q = $grouping[0];              

            if($q['MAX_AMOUNT']>$q['DPP'])
            {
              $selisih=$q['MAX_AMOUNT']-$q['DPP'];
            }
            else
            {
              $selisih=$q['DPP']-$q['MAX_AMOUNT'];
            }

            $rowspan="";

          ?>
          <tr>
            <td align="center" rowspan="<?php echo count($grouping) ?>"><?php echo $num ?></td>
            <td align="center" rowspan="<?php echo count($grouping) ?>"><?php echo $q['HEADER_ID'] ?></td>
            <td align="center" rowspan="<?php echo count($grouping) ?>"><?php echo $q['ORDER_NUMBER'] ?></td>
            <td align="center" rowspan="<?php echo count($grouping) ?>"><?php echo $q['DPP'] ?></td>
            <td align="center" rowspan="<?php echo count($grouping) ?>"><?php echo $q['MAX_AMOUNT'] ?></td>
            <td align="center" rowspan="<?php echo count($grouping) ?>"><?php echo $selisih ?></td>
            <?php
              foreach ($grouping as $key => $test) {
            ?>
            <td><?php echo $test['DESCRIPTION']   ?></td>
            <td><?php echo $test['ORDERED_ITEM']   ?></td>
            <td><?php echo $test['PRICE_UNIT']   ?></td>
            <td><?php echo $test['CREATION_DATE']   ?></td>
          </tr>
          <?php } ?>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>
</body>
</html>
