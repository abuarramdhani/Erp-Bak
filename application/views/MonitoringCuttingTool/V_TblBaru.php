<script>
    $(document).ready(function () {
        $('#tb_cuttingbaru').dataTable({
            "scrollX": true,
            "drawCallback": function() {
                $(".databulan").select2({
                    allowClear: true,
                    placeholder: "bulan",
                    minimumInputLength: 0,
                    ajax: {
                        url: baseurl + "MonitoringCuttingTool/MonitoringTransaksi/getbulan",
                        dataType: 'json',
                        type: "GET",
                        data: function (params) {
                            var queryParameters = {
                                term: params.term,
                            }
                            return queryParameters;
                        },
                        processResults: function (data) {
                            // console.log(data);
                            return {
                                results: $.map(data, function (obj) {
                                    return {id:obj.val, text:obj.bulan};
                                })
                            };
                        }
                    }
                });
            }
        });
    
    });
</script>
<table class="datatable table table-bordered table-hover table-striped text-center text-nowrap" id="tb_cuttingbaru" style="width: 100%;">
    <thead style="background-color:#3DA5FF;color:white">
        <tr>
            <th rowspan="2" style="vertical-align:middle;">No</th>
            <th rowspan="2" style="vertical-align:middle;">Kode Komponen</th>
            <th rowspan="2" style="vertical-align:middle;">Deskripsi Komponen</th>
            <?php 
                for ($i=0; $i < 12 ; $i++) { 
                    echo '<th colspan="2" style="vertical-align:middle;">'.$bulan[$i].'</th>';
                }
            ?>
            <th colspan="2" style="vertical-align:middle;"><?= date('Y');?></th>
            <th rowspan="2" style="vertical-align:middle;">Action</th>
        </tr>
        <tr>
        <?php for ($i=0; $i < 13 ; $i++) { 
            echo "
            <th>IN</th>
            <th>OUT</th>";
        }?>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; foreach ($data as $key => $val) {?>
            <tr>
                <td><?= $no?></td>
                <td><input type="hidden" name="item_baru<?= $no?>" value="<?= $val['ITEM']?>"><?= $val['ITEM']?></td>
                <td><input type="hidden" name="desc_baru<?= $no?>" value="<?= $val['DESCRIPTION']?>"><?= $val['DESCRIPTION']?></td>
                <td><?= $val['01-'.date('Y').'']['IN']?></td>
                <td><?= $val['01-'.date('Y').'']['OUT']?></td>
                <td><?= $val['02-'.date('Y').'']['IN']?></td>
                <td><?= $val['02-'.date('Y').'']['OUT']?></td>
                <td><?= $val['02-'.date('Y').'']['IN']?></td>
                <td><?= $val['02-'.date('Y').'']['OUT']?></td>
                <td><?= $val['04-'.date('Y').'']['IN']?></td>
                <td><?= $val['04-'.date('Y').'']['OUT']?></td>
                <td><?= $val['05-'.date('Y').'']['IN']?></td>
                <td><?= $val['05-'.date('Y').'']['OUT']?></td>
                <td><?= $val['06-'.date('Y').'']['IN']?></td>
                <td><?= $val['06-'.date('Y').'']['OUT']?></td>
                <td><?= $val['07-'.date('Y').'']['IN']?></td>
                <td><?= $val['07-'.date('Y').'']['OUT']?></td>
                <td><?= $val['08-'.date('Y').'']['IN']?></td>
                <td><?= $val['08-'.date('Y').'']['OUT']?></td>
                <td><?= $val['09-'.date('Y').'']['IN']?></td>
                <td><?= $val['09-'.date('Y').'']['OUT']?></td>
                <td><?= $val['10-'.date('Y').'']['IN']?></td>
                <td><?= $val['10-'.date('Y').'']['OUT']?></td>
                <td><?= $val['11-'.date('Y').'']['IN']?></td>
                <td><?= $val['11-'.date('Y').'']['OUT']?></td>
                <td><?= $val['12-'.date('Y').'']['IN']?></td>
                <td><?= $val['12-'.date('Y').'']['OUT']?></td>
                <td><?= $val['TOTAL_IN']?></td>
                <td><?= $val['TOTAL_OUT']?></td>
                <td><select class="form-control select2 databulan" name="bulan_baru<?= $no?>" style="width:120px">
                        <option value="<?= date('M-Y')?>"><?= date('F')?></option>
                    </select>
                    <button style="margin-left:5px" type="submit" class="btn btn-info" formaction="<?php echo base_url("MonitoringCuttingTool/MonitoringTransaksi/DetailTransaksiBaru/".$no."")?>"><i class="fa fa-eye"></i> Detail</button>
                </td>
            </tr>
        <?php $no++; }?>
    </tbody>
</table>