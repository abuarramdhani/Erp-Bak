<style type="text/css">html, body { scroll-behavior: smooth; } td { height: 60px; } thead tr th { height: auto; } .fixed-column { position: absolute; background: white; width: 100px; left: 16px; margin-bottom: 2px; }</style>
<?php if(count($title) > 1): ?>
<div class="row" id="frame-total-khs-data">
    <div class="box box-primary box-solid">
        <div class="box-header with-border"><h3 style="margin-top: 0; margin-bottom: 0;">Total KHS</h3></div>
            <div id="box-body-data" class="box-body" style="padding: 16px; overflow-y: auto; background-color: white;">
                <table class="table table-bordered table-hover text-center" style="overflow-x: scroll; width: 100%; display: block;">
                    <thead>
                        <tr>
                            <?php $i = 1; foreach($monthList as $key => $value): ?>
                            <th class="<?= ($i++ % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>" colspan="<?= $value ?>"><?= $key ?></th>
                            <?php endforeach ?>
                        </tr>
                        <tr>
                            <?php $i = 1; foreach($monthListFormatted as $month): ?>
                            <?php if($i == 1): ?>
                                <th class="bg-orange"><?= $month ?></th>
                            <?php else: ?>
                                <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>" colspan="3"><?= $month ?></th>
                                <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>"><?= $currentMonthFormatted ?></th>
                            <?php endif ?>
                            <?php $i++; endforeach ?>
                        </tr>
                        <tr>
                            <?php $i = 1; foreach($monthList as $key => $value): ?>
                            <?php if($i == 1): ?>
                                <th class="bg-orange">Data Awal</th>
                            <?php else: ?>
                                <th style="width: 60px;" class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Target Turun</th>
                                <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Target Sisa</th>
                                <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Aktual Turun</th>
                                <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Aktual Sisa</th>
                            <?php endif ?>
                            <?php $i++; endforeach ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="font-weight: bold;">
                            <td id="total-khs-data-awal"></td>
                            <?php for($i = 1; $i < count($monthList); $i++): ?>
                            <td class="total-khs-target-turun"></td>
                            <td class="total-khs-target-sisa"></td>
                            <td class="total-khs-aktual-turun"></td>
                            <td class="total-khs-aktual-sisa"></td>
                            <?php endfor; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php endif; foreach($title as $department): ?>
<div class="row">
    <div class="box box-primary box-solid">
        <div class="box-header with-border"><h3 style="margin-top: 0; margin-bottom: 0;"><?= $department ?></h3></div>
            <div id="box-body-data" class="box-body" style="padding: 16px; padding-bottom: 0; overflow-y: auto; background-color: white;">
                <?php switch($department): case 'Keuangan': case 'Produksi': ?>
                <div style="margin-left: 98px;">
                    <table class="table table-bordered table-hover text-center" style="overflow-x: scroll; width: 100%; display: block;">
                        <thead>
                            <th class="fixed-column" style="background-color: #00a65a; color: white; min-width: 100px; padding-top: 56px; padding-bottom: 56px; margin-top: 1px;">Keterangan</th>
                            <tr>
                                <?php $i = 1; foreach($monthList as $key => $value): ?>
                                <th class="<?= ($i++ % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>" colspan="<?= $value ?>"><?= $key ?></th>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <?php $i = 1; foreach($monthListFormatted as $month): ?>
                                <?php if($i == 1): ?>
                                    <th class="bg-orange"><?= $month ?></th>
                                <?php else: ?>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>" colspan="3"><?= $month ?></th>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>"><?= $currentMonthFormatted ?></th>
                                <?php endif ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <tr>
                                <?php $i = 1; foreach($monthList as $key => $value): ?>
                                <?php if($i == 1): ?>
                                    <th class="bg-orange">Data Awal</th>
                                <?php else: ?>
                                    <th style="width: 60px;" class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Target Turun</th>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Target Sisa</th>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Aktual Turun</th>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Aktual Sisa</th>
                                <?php endif ?>
                                <?php $i++; endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <td class="fixed-column" style="height: auto; padding-bottom: 11px;">Kasie Utama ke atas</td>
                            <tr>
                                <?php $totalDataAwal = 0; $targetTurun = array(); $targetSisa = array(); $aktualTurun = array(); $aktualSisa = array(); ?>
                                <?php $i = 0; foreach($tableData[$department] as $item) { $targetTurun[0][$i] = 0; $targetSisa[0][$i] = 0; $aktualTurun[0][$i] = 0; $aktualSisa[0][$i] = 0; $i++; } ?>
                                <?php $target = 0; $aktual = 0; $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): $target = $item[0]['aktual'] ?>
                                <td class="row-1-target-sisa-<?= $department ?> row-1-aktual-sisa-<?= $department ?>"><?= $aktual = $item[0]['aktual']; $totalDataAwal += $aktual ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="row-1-target-turun-<?= $department ?>"><?= $item[0]['target']; $targetTurun[0][$i] += $item[0]['target'] ?></td>
                                <td class="row-1-target-sisa-<?= $department ?>"><?= $target = (($target - $item[0]['target']) < 0) ? 0 : ($target - $item[0]['target']); $targetSisa[0][$i] += $target; ?></td>
                                <td class="row-1-aktual-turun-<?= $department ?>"><?= $aktual = (($aktual - $item[0]['aktual']) < 0) ? 0 : ($aktual - $item[0]['aktual']); $aktualTurun[0][$i] += $aktual; ?></td>
                                <td class="row-1-aktual-sisa-<?= $department ?>"><?= $item[0]['aktual']; $aktualSisa[0][$i] += $item[0]['aktual'] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <td class="fixed-column" style="height: auto; padding-bottom: 11px;">Staff s/d Kasie Madya</td>
                            <tr>
                                <?php $i = 0; foreach($tableData[$department] as $item) { $targetTurun[1][$i] = 0; $targetSisa[1][$i] = 0; $aktualTurun[1][$i] = 0; $aktualSisa[1][$i] = 0; $i++; } ?>
                                <?php $target = 0; $aktual = 0; $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): $target = $item[1]['aktual'] ?>
                                <td class="row-2-target-sisa-<?= $department ?> row-2-aktual-sisa-<?= $department ?>"><?= $aktual = $item[1]['aktual']; $totalDataAwal += $aktual ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="row-2-target-turun-<?= $department ?>"><?= $item[1]['target']; $targetTurun[1][$i] += $item[1]['target'] ?></td>
                                <td class="row-2-target-sisa-<?= $department ?>"><?= $target = (($target - $item[1]['target']) < 0) ? 0 : ($target - $item[1]['target']); $targetSisa[1][$i] += $target; ?></td>
                                <td class="row-2-aktual-turun-<?= $department ?>"><?= $aktual = (($aktual - $item[1]['aktual']) < 0) ? 0 : ($aktual - $item[1]['aktual']); $aktualTurun[1][$i] += $aktual; ?></td>
                                <td class="row-2-aktual-sisa-<?= $department ?>"><?= $item[1]['aktual']; $aktualSisa[1][$i] += $item[1]['aktual'] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <td class="fixed-column" style="height: auto; padding-bottom: 20px; padding-top: 19px;">Non Staff</td>
                            <tr>
                                <?php $i = 0; foreach($tableData[$department] as $item) { $targetTurun[2][$i] = 0; $targetSisa[2][$i] = 0; $aktualTurun[2][$i] = 0; $aktualSisa[2][$i] = 0; $i++; } ?>
                                <?php $target = 0; $aktual = 0; $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): $target = $item[2]['aktual'] ?>
                                <td class="row-3-target-sisa-<?= $department ?> row-3-aktual-sisa-<?= $department ?>"><?= $aktual = $item[2]['aktual']; $totalDataAwal += $aktual ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="row-3-target-turun-<?= $department ?>"><?= $item[2]['target']; $targetTurun[2][$i] += $item[2]['target'] ?></td>
                                <td class="row-3-target-sisa-<?= $department ?>"><?= $target = (($target - $item[2]['target']) < 0) ? 0 : ($target - $item[2]['target']); $targetSisa[2][$i] += $target; ?></td>
                                <td class="row-3-aktual-turun-<?= $department ?>"><?= $aktual = (($aktual - $item[2]['aktual']) < 0) ? 0 : ($aktual - $item[2]['aktual']); $aktualTurun[2][$i] += $aktual; ?></td>
                                <td class="row-3-aktual-sisa-<?= $department ?>"><?= $item[2]['aktual']; $aktualSisa[2][$i] += $item[2]['aktual'] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <td class="fixed-column" style="height: auto; padding-bottom: 20px; padding-top: 19px;">Outsourcing</td>
                            <tr>
                                <?php $i = 0; foreach($tableData[$department] as $item) { $targetTurun[3][$i] = 0; $targetSisa[3][$i] = 0; $aktualTurun[3][$i] = 0; $aktualSisa[3][$i] = 0; $i++; } ?>
                                <?php $target = 0; $aktual = 0; $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): $target = $item[3]['aktual'] ?>
                                <td class="row-4-target-sisa-<?= $department ?> row-4-aktual-sisa-<?= $department ?>"><?= $aktual = $item[3]['aktual']; $totalDataAwal += $aktual ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="row-4-target-turun-<?= $department ?>"><?= $item[3]['target']; $targetTurun[3][$i] += $item[3]['target'] ?></td>
                                <td class="row-4-target-sisa-<?= $department ?>"><?= $target = (($target - $item[3]['target']) < 0) ? 0 : ($target - $item[3]['target']); $targetSisa[3][$i] += $target; ?></td>
                                <td class="row-4-aktual-turun-<?= $department ?>"><?= $aktual = (($aktual - $item[3]['aktual']) < 0) ? 0 : ($aktual - $item[3]['aktual']); $aktualTurun[3][$i] += $aktual; ?></td>
                                <td class="row-4-aktual-sisa-<?= $department ?>"><?= $item[3]['aktual']; $aktualSisa[3][$i] += $item[3]['aktual'] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <td class="fixed-column" style="height: auto; padding-bottom: 20px; padding-top: 19px; font-weight: bold;">Total</td>
                            <tr style="font-weight: bold;">
                                <?php
                                    $totalTargetTurun = array(); $totalTargetSisa = array();
                                    for($i = 0; $i < count($tableData[$department]); $i++) { $totalTargetTurun[$i] = 0; $totalTargetSisa[$i] = 0; $totalAktualTurun[$i] = 0; $totalAktualSisa[$i] = 0; }
                                    for($i = 1; $i < count($tableData[$department]); $i++) {
                                        for($j = 0; $j < 4; $j++) {
                                            $totalTargetTurun[$i] += $targetTurun[$j][$i];
                                            $totalTargetSisa[$i] += $targetSisa[$j][$i];
                                            $totalAktualTurun[$i] += $aktualTurun[$j][$i];
                                            $totalAktualSisa[$i] += $aktualSisa[$j][$i];
                                        }
                                    }
                                ?>
                                <?php $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): ?>
                                <td class="total-data-awal-<?= $department ?>"><?= $totalDataAwal ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="total-target-turun-<?= $i ?>-<?= $department ?>"><?= $totalTargetTurun[$i] ?></td>
                                <td class="total-target-sisa-<?= $i ?>-<?= $department ?>"><?= $totalTargetSisa[$i] ?></td>
                                <td class="total-aktual-turun-<?= $i ?>-<?= $department ?>"><?= $totalAktualTurun[$i] ?></td>
                                <td class="total-aktual-sisa-<?= $i ?>-<?= $department ?>"><?= $totalAktualSisa[$i] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="margin-bottom: 18px; text-align: center;">
                    <b id="chart-loading-placeholder-<?= $department ?>">Memuat grafik...</b>
                    <div id="chart-frame-<?= $department ?>" style="display: none;">
                        <b>Kasie Utama ke atas</b>
                        <canvas id="chart-1-<?= $department ?>" style="width: 100%; margin-bottom: 8px;"></canvas>
                        <b>Staff s/d Kasie Madya</b>
                        <canvas id="chart-2-<?= $department ?>" style="width: 100%; margin-bottom: 8px;"></canvas>
                        <b>Non Staff</b>
                        <canvas id="chart-3-<?= $department ?>" style="width: 100%; margin-bottom: 8px;"></canvas>
                        <b>Outsourcing</b>
                        <canvas id="chart-4-<?= $department ?>" style="width: 100%;"></canvas>
                    </div>
                </div>
                <?php break; case 'Pemasaran': ?>
                <div style="margin-left: 98px;">
                    <table class="table table-bordered table-hover text-center" style="overflow-x: scroll; width: 100%; display: block;">
                        <thead>
                            <th class="fixed-column" style="background-color: #00a65a; color: white; min-width: 100px; padding-top: 56px; padding-bottom: 56px; margin-top: 1px;">Keterangan</th>
                            <tr>
                                <?php $i = 1; foreach($monthList as $key => $value): ?>
                                <th class="<?= ($i++ % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>" colspan="<?= $value ?>"><?= $key ?></th>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <?php $i = 1; foreach($monthListFormatted as $month): ?>
                                <?php if($i == 1): ?>
                                    <th class="bg-orange"><?= $month ?></th>
                                <?php else: ?>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>" colspan="3"><?= $month ?></th>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>"><?= $currentMonthFormatted ?></th>
                                <?php endif ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <tr>
                                <?php $i = 1; foreach($monthList as $key => $value): ?>
                                <?php if($i == 1): ?>
                                    <th class="bg-orange">Data Awal</th>
                                <?php else: ?>
                                    <th style="width: 60px;" class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Target Turun</th>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Target Sisa</th>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Aktual Turun</th>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Aktual Sisa</th>
                                <?php endif ?>
                                <?php $i++; endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <td class="fixed-column" style="height: auto; padding-bottom: 11px;">Kasie Utama ke atas</td>
                            <tr>
                                <?php $totalDataAwal = 0; $targetTurun = array(); $targetSisa = array(); $aktualTurun = array(); $aktualSisa = array(); ?>
                                <?php $i = 0; foreach($tableData[$department] as $item) { $targetTurun[0][$i] = 0; $targetSisa[0][$i] = 0; $aktualTurun[0][$i] = 0; $aktualSisa[0][$i] = 0; $i++; } ?>
                                <?php $target = 0; $aktual = 0; $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): $target = $item[0]['aktual'] ?>
                                <td class="row-1-target-sisa-<?= $department ?> row-1-aktual-sisa-<?= $department ?>"><?= $aktual = $item[0]['aktual']; $totalDataAwal += $aktual ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="row-1-target-turun-<?= $department ?>"><?= $item[0]['target']; $targetTurun[0][$i] += $item[0]['target'] ?></td>
                                <td class="row-1-target-sisa-<?= $department ?>"><?= $target = (($target - $item[0]['target']) < 0) ? 0 : ($target - $item[0]['target']); $targetSisa[0][$i] += $target; ?></td>
                                <td class="row-1-aktual-turun-<?= $department ?>"><?= $aktual = (($aktual - $item[0]['aktual']) < 0) ? 0 : ($aktual - $item[0]['aktual']); $aktualTurun[0][$i] += $aktual; ?></td>
                                <td class="row-1-aktual-sisa-<?= $department ?>"><?= $item[0]['aktual']; $aktualSisa[0][$i] += $item[0]['aktual'] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <td class="fixed-column" style="height: auto; padding-bottom: 11px;">Staff s/d Kasie Madya</td>
                            <tr>
                                <?php $i = 0; foreach($tableData[$department] as $item) { $targetTurun[1][$i] = 0; $targetSisa[1][$i] = 0; $aktualTurun[1][$i] = 0; $aktualSisa[1][$i] = 0; $i++; } ?>
                                <?php $target = 0; $aktual = 0; $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): $target = $item[1]['aktual'] ?>
                                <td class="row-2-target-sisa-<?= $department ?> row-2-aktual-sisa-<?= $department ?>"><?= $aktual = $item[1]['aktual']; $totalDataAwal += $aktual ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="row-2-target-turun-<?= $department ?>"><?= $item[1]['target']; $targetTurun[1][$i] += $item[1]['target'] ?></td>
                                <td class="row-2-target-sisa-<?= $department ?>"><?= $target = (($target - $item[1]['target']) < 0) ? 0 : ($target - $item[1]['target']); $targetSisa[1][$i] += $target; ?></td>
                                <td class="row-2-aktual-turun-<?= $department ?>"><?= $aktual = (($aktual - $item[1]['aktual']) < 0) ? 0 : ($aktual - $item[1]['aktual']); $aktualTurun[1][$i] += $aktual; ?></td>
                                <td class="row-2-aktual-sisa-<?= $department ?>"><?= $item[1]['aktual']; $aktualSisa[1][$i] += $item[1]['aktual'] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <td class="fixed-column" style="height: auto; padding-bottom: 20px; padding-top: 19px;">Non Staff</td>
                            <tr>
                                <?php $i = 0; foreach($tableData[$department] as $item) { $targetTurun[2][$i] = 0; $targetSisa[2][$i] = 0; $aktualTurun[2][$i] = 0; $aktualSisa[2][$i] = 0; $i++; } ?>
                                <?php $target = 0; $aktual = 0; $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): $target = $item[2]['aktual'] ?>
                                <td class="row-3-target-sisa-<?= $department ?> row-3-aktual-sisa-<?= $department ?>"><?= $aktual = $item[2]['aktual']; $totalDataAwal += $aktual ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="row-3-target-turun-<?= $department ?>"><?= $item[2]['target']; $targetTurun[2][$i] += $item[2]['target'] ?></td>
                                <td class="row-3-target-sisa-<?= $department ?>"><?= $target = (($target - $item[2]['target']) < 0) ? 0 : ($target - $item[2]['target']); $targetSisa[2][$i] += $target; ?></td>
                                <td class="row-3-aktual-turun-<?= $department ?>"><?= $aktual = (($aktual - $item[2]['aktual']) < 0) ? 0 : ($aktual - $item[2]['aktual']); $aktualTurun[2][$i] += $aktual; ?></td>
                                <td class="row-3-aktual-sisa-<?= $department ?>"><?= $item[2]['aktual']; $aktualSisa[2][$i] += $item[2]['aktual'] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <td class="fixed-column" style="height: auto; padding-bottom: 20px; padding-top: 19px;">Outsourcing</td>
                            <tr>
                                <?php $i = 0; foreach($tableData[$department] as $item) { $targetTurun[3][$i] = 0; $targetSisa[3][$i] = 0; $aktualTurun[3][$i] = 0; $aktualSisa[3][$i] = 0; $i++; } ?>
                                <?php $target = 0; $aktual = 0; $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): $target = $item[3]['aktual'] ?>
                                <td class="row-4-target-sisa-<?= $department ?> row-4-aktual-sisa-<?= $department ?>"><?= $aktual = $item[3]['aktual']; $totalDataAwal += $aktual ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="row-4-target-turun-<?= $department ?>"><?= $item[3]['target']; $targetTurun[3][$i] += $item[3]['target'] ?></td>
                                <td class="row-4-target-sisa-<?= $department ?>"><?= $target = (($target - $item[3]['target']) < 0) ? 0 : ($target - $item[3]['target']); $targetSisa[3][$i] += $target; ?></td>
                                <td class="row-4-aktual-turun-<?= $department ?>"><?= $aktual = (($aktual - $item[3]['aktual']) < 0) ? 0 : ($aktual - $item[3]['aktual']); $aktualTurun[3][$i] += $aktual; ?></td>
                                <td class="row-4-aktual-sisa-<?= $department ?>"><?= $item[3]['aktual']; $aktualSisa[3][$i] += $item[3]['aktual'] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <td class="fixed-column" style="height: auto; padding-bottom: 20px; padding-top: 19px;">Cabang</td>
                            <tr>
                                <?php $i = 0; foreach($tableData[$department] as $item) { $targetTurun[4][$i] = 0; $targetSisa[4][$i] = 0; $aktualTurun[4][$i] = 0; $aktualSisa[4][$i] = 0; $i++; } ?>
                                <?php $target = 0; $aktual = 0; $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): $target = $item[4]['aktual'] ?>
                                <td class="row-5-target-sisa-<?= $department ?> row-5-aktual-sisa-<?= $department ?>"><?= $aktual = $item[4]['aktual']; $totalDataAwal += $aktual ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="row-5-target-turun-<?= $department ?>"><?= $item[4]['target']; $targetTurun[4][$i] += $item[4]['target'] ?></td>
                                <td class="row-5-target-sisa-<?= $department ?>"><?= $target = (($target - $item[4]['target']) < 0) ? 0 : ($target - $item[4]['target']); $targetSisa[4][$i] += $target; ?></td>
                                <td class="row-5-aktual-turun-<?= $department ?>"><?= $aktual = (($aktual - $item[4]['aktual']) < 0) ? 0 : ($aktual - $item[4]['aktual']); $aktualTurun[4][$i] += $aktual; ?></td>
                                <td class="row-5-aktual-sisa-<?= $department ?>"><?= $item[4]['aktual']; $aktualSisa[4][$i] += $item[4]['aktual'] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <td class="fixed-column" style="height: auto; padding-bottom: 20px; padding-top: 19px; font-weight: bold;">Total</td>
                            <tr style="font-weight: bold;">
                                <?php
                                    $totalTargetTurun = array(); $totalTargetSisa = array();
                                    for($i = 0; $i < count($tableData[$department]); $i++) { $totalTargetTurun[$i] = 0; $totalTargetSisa[$i] = 0; $totalAktualTurun[$i] = 0; $totalAktualSisa[$i] = 0; }
                                    for($i = 1; $i < count($tableData[$department]); $i++) {
                                        for($j = 0; $j < 4; $j++) {
                                            $totalTargetTurun[$i] += $targetTurun[$j][$i];
                                            $totalTargetSisa[$i] += $targetSisa[$j][$i];
                                            $totalAktualTurun[$i] += $aktualTurun[$j][$i];
                                            $totalAktualSisa[$i] += $aktualSisa[$j][$i];
                                        }
                                    }
                                ?>
                                <?php $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): ?>
                                <td class="total-data-awal-<?= $department ?>"><?= $totalDataAwal ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="total-target-turun-<?= $i ?>-<?= $department ?>"><?= $totalTargetTurun[$i] ?></td>
                                <td class="total-target-sisa-<?= $i ?>-<?= $department ?>"><?= $totalTargetSisa[$i] ?></td>
                                <td class="total-aktual-turun-<?= $i ?>-<?= $department ?>"><?= $totalAktualTurun[$i] ?></td>
                                <td class="total-aktual-sisa-<?= $i ?>-<?= $department ?>"><?= $totalAktualSisa[$i] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="margin-bottom: 18px; text-align: center;">
                    <b id="chart-loading-placeholder-<?= $department ?>">Memuat grafik...</b>
                    <div id="chart-frame-<?= $department ?>" style="display: none;">
                        <b>Kasie Utama ke atas</b>
                        <canvas id="chart-1-<?= $department ?>" style="width: 100%; margin-bottom: 8px;"></canvas>
                        <b>Staff s/d Kasie Madya</b>
                        <canvas id="chart-2-<?= $department ?>" style="width: 100%; margin-bottom: 8px;"></canvas>
                        <b>Non Staff</b>
                        <canvas id="chart-3-<?= $department ?>" style="width: 100%; margin-bottom: 8px;"></canvas>
                        <b>Outsourcing</b>
                        <canvas id="chart-4-<?= $department ?>" style="width: 100%; margin-bottom: 8px;"></canvas>
                        <b>Cabang</b>
                        <canvas id="chart-5-<?= $department ?>" style="width: 100%;"></canvas>
                    </div>
                </div>
                <?php break; case 'Personalia': ?>
                <div style="margin-left: 98px;">
                    <table class="table table-bordered table-hover text-center" style="overflow-x: scroll; width: 100%; display: block;">
                        <thead>
                            <th class="fixed-column" style="background-color: #00a65a; color: white; min-width: 100px; padding-top: 56px; padding-bottom: 56px; margin-top: 1px;">Keterangan</th>
                            <tr>
                                <?php $i = 1; foreach($monthList as $key => $value): ?>
                                <th class="<?= ($i++ % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>" colspan="<?= $value ?>"><?= $key ?></th>
                                <?php endforeach ?>
                            </tr>
                            <tr>
                                <?php $i = 1; foreach($monthListFormatted as $month): ?>
                                <?php if($i == 1): ?>
                                    <th class="bg-orange"><?= $month ?></th>
                                <?php else: ?>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>" colspan="3"><?= $month ?></th>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>"><?= $currentMonthFormatted ?></th>
                                <?php endif ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <tr>
                                <?php $i = 1; foreach($monthList as $key => $value): ?>
                                <?php if($i == 1): ?>
                                    <th class="bg-orange">Data Awal</th>
                                <?php else: ?>
                                    <th style="width: 60px;" class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Target Turun</th>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Target Sisa</th>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Aktual Turun</th>
                                    <th class="<?= ($i % 2 == 0) ? 'bg-primary' : 'bg-orange' ?>">Aktual Sisa</th>
                                <?php endif ?>
                                <?php $i++; endforeach ?>
                            </tr>
                        </thead>
                        <tbody>
                            <td class="fixed-column" style="height: auto; padding-bottom: 11px;">Kasie Utama ke atas</td>
                            <tr>
                                <?php $totalDataAwal = 0; $targetTurun = array(); $targetSisa = array(); $aktualTurun = array(); $aktualSisa = array(); ?>
                                <?php $i = 0; foreach($tableData[$department] as $item) { $targetTurun[0][$i] = 0; $targetSisa[0][$i] = 0; $aktualTurun[0][$i] = 0; $aktualSisa[0][$i] = 0; $i++; } ?>
                                <?php $target = 0; $aktual = 0; $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): $target = $item[0]['aktual'] ?>
                                <td class="row-1-target-sisa-<?= $department ?> row-1-aktual-sisa-<?= $department ?>"><?= $aktual = $item[0]['aktual']; $totalDataAwal += $aktual ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="row-1-target-turun-<?= $department ?>"><?= $item[0]['target']; $targetTurun[0][$i] += $item[0]['target'] ?></td>
                                <td class="row-1-target-sisa-<?= $department ?>"><?= $target = (($target - $item[0]['target']) < 0) ? 0 : ($target - $item[0]['target']); $targetSisa[0][$i] += $target; ?></td>
                                <td class="row-1-aktual-turun-<?= $department ?>"><?= $aktual = (($aktual - $item[0]['aktual']) < 0) ? 0 : ($aktual - $item[0]['aktual']); $aktualTurun[0][$i] += $aktual; ?></td>
                                <td class="row-1-aktual-sisa-<?= $department ?>"><?= $item[0]['aktual']; $aktualSisa[0][$i] += $item[0]['aktual'] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <td class="fixed-column" style="height: auto; padding-bottom: 11px;">Staff s/d Kasie Madya</td>
                            <tr>
                                <?php $i = 0; foreach($tableData[$department] as $item) { $targetTurun[1][$i] = 0; $targetSisa[1][$i] = 0; $aktualTurun[1][$i] = 0; $aktualSisa[1][$i] = 0; $i++; } ?>
                                <?php $target = 0; $aktual = 0; $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): $target = $item[1]['aktual'] ?>
                                <td class="row-2-target-sisa-<?= $department ?> row-2-aktual-sisa-<?= $department ?>"><?= $aktual = $item[1]['aktual']; $totalDataAwal += $aktual ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="row-2-target-turun-<?= $department ?>"><?= $item[1]['target']; $targetTurun[1][$i] += $item[1]['target'] ?></td>
                                <td class="row-2-target-sisa-<?= $department ?>"><?= $target = (($target - $item[1]['target']) < 0) ? 0 : ($target - $item[1]['target']); $targetSisa[1][$i] += $target; ?></td>
                                <td class="row-2-aktual-turun-<?= $department ?>"><?= $aktual = (($aktual - $item[1]['aktual']) < 0) ? 0 : ($aktual - $item[1]['aktual']); $aktualTurun[1][$i] += $aktual; ?></td>
                                <td class="row-2-aktual-sisa-<?= $department ?>"><?= $item[1]['aktual']; $aktualSisa[1][$i] += $item[1]['aktual'] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <td class="fixed-column" style="height: auto; padding-bottom: 20px; padding-top: 19px;">Non Staff</td>
                            <tr>
                                <?php $i = 0; foreach($tableData[$department] as $item) { $targetTurun[2][$i] = 0; $targetSisa[2][$i] = 0; $aktualTurun[2][$i] = 0; $aktualSisa[2][$i] = 0; $i++; } ?>
                                <?php $target = 0; $aktual = 0; $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): $target = $item[2]['aktual'] ?>
                                <td class="row-3-target-sisa-<?= $department ?> row-3-aktual-sisa-<?= $department ?>"><?= $aktual = $item[2]['aktual']; $totalDataAwal += $aktual ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="row-3-target-turun-<?= $department ?>"><?= $item[2]['target']; $targetTurun[2][$i] += $item[2]['target'] ?></td>
                                <td class="row-3-target-sisa-<?= $department ?>"><?= $target = (($target - $item[2]['target']) < 0) ? 0 : ($target - $item[2]['target']); $targetSisa[2][$i] += $target; ?></td>
                                <td class="row-3-aktual-turun-<?= $department ?>"><?= $aktual = (($aktual - $item[2]['aktual']) < 0) ? 0 : ($aktual - $item[2]['aktual']); $aktualTurun[2][$i] += $aktual; ?></td>
                                <td class="row-3-aktual-sisa-<?= $department ?>"><?= $item[2]['aktual']; $aktualSisa[2][$i] += $item[2]['aktual'] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <td class="fixed-column" style="height: auto; padding-bottom: 20px; padding-top: 19px;">Outsourcing</td>
                            <tr>
                                <?php $i = 0; foreach($tableData[$department] as $item) { $targetTurun[3][$i] = 0; $targetSisa[3][$i] = 0; $aktualTurun[3][$i] = 0; $aktualSisa[3][$i] = 0; $i++; } ?>
                                <?php $target = 0; $aktual = 0; $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): $target = $item[3]['aktual'] ?>
                                <td class="row-4-target-sisa-<?= $department ?> row-4-aktual-sisa-<?= $department ?>"><?= $aktual = $item[3]['aktual']; $totalDataAwal += $aktual ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="row-4-target-turun-<?= $department ?>"><?= $item[3]['target']; $targetTurun[3][$i] += $item[3]['target'] ?></td>
                                <td class="row-4-target-sisa-<?= $department ?>"><?= $target = (($target - $item[3]['target']) < 0) ? 0 : ($target - $item[3]['target']); $targetSisa[3][$i] += $target; ?></td>
                                <td class="row-4-aktual-turun-<?= $department ?>"><?= $aktual = (($aktual - $item[3]['aktual']) < 0) ? 0 : ($aktual - $item[3]['aktual']); $aktualTurun[3][$i] += $aktual; ?></td>
                                <td class="row-4-aktual-sisa-<?= $department ?>"><?= $item[3]['aktual']; $aktualSisa[3][$i] += $item[3]['aktual'] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <td class="fixed-column" style="height: auto; padding-bottom: 20px; padding-top: 19px;">Harian Lepas</td>
                            <tr>
                                <?php $i = 0; foreach($tableData[$department] as $item) { $targetTurun[4][$i] = 0; $targetSisa[4][$i] = 0; $aktualTurun[4][$i] = 0; $aktualSisa[4][$i] = 0; $i++; } ?>
                                <?php $target = 0; $aktual = 0; $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): $target = $item[4]['aktual'] ?>
                                <td class="row-5-target-sisa-<?= $department ?> row-5-aktual-sisa-<?= $department ?>"><?= $aktual = $item[4]['aktual']; $totalDataAwal += $aktual ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="row-5-target-turun-<?= $department ?>"><?= $item[4]['target']; $targetTurun[4][$i] += $item[4]['target'] ?></td>
                                <td class="row-5-target-sisa-<?= $department ?>"><?= $target = (($target - $item[4]['target']) < 0) ? 0 : ($target - $item[4]['target']); $targetSisa[4][$i] += $target; ?></td>
                                <td class="row-5-aktual-turun-<?= $department ?>"><?= $aktual = (($aktual - $item[4]['aktual']) < 0) ? 0 : ($aktual - $item[4]['aktual']); $aktualTurun[4][$i] += $aktual; ?></td>
                                <td class="row-5-aktual-sisa-<?= $department ?>"><?= $item[4]['aktual']; $aktualSisa[4][$i] += $item[4]['aktual'] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                            <td class="fixed-column" style="height: auto; padding-bottom: 20px; padding-top: 19px; font-weight: bold;">Total</td>
                            <tr style="font-weight: bold;">
                                <?php
                                    $totalTargetTurun = array(); $totalTargetSisa = array();
                                    for($i = 0; $i < count($tableData[$department]); $i++) { $totalTargetTurun[$i] = 0; $totalTargetSisa[$i] = 0; $totalAktualTurun[$i] = 0; $totalAktualSisa[$i] = 0; }
                                    for($i = 1; $i < count($tableData[$department]); $i++) {
                                        for($j = 0; $j < 4; $j++) {
                                            $totalTargetTurun[$i] += $targetTurun[$j][$i];
                                            $totalTargetSisa[$i] += $targetSisa[$j][$i];
                                            $totalAktualTurun[$i] += $aktualTurun[$j][$i];
                                            $totalAktualSisa[$i] += $aktualSisa[$j][$i];
                                        }
                                    }
                                ?>
                                <?php $i = 0; foreach($tableData[$department] as $item): ?>
                                <?php if($i == 0): ?>
                                <td class="total-data-awal-<?= $department ?>"><?= $totalDataAwal ?></td>
                                <?php else: if($monthListNumber[$i] <= $currentMonth): ?>
                                <td class="total-target-turun-<?= $i ?>-<?= $department ?>"><?= $totalTargetTurun[$i] ?></td>
                                <td class="total-target-sisa-<?= $i ?>-<?= $department ?>"><?= $totalTargetSisa[$i] ?></td>
                                <td class="total-aktual-turun-<?= $i ?>-<?= $department ?>"><?= $totalAktualTurun[$i] ?></td>
                                <td class="total-aktual-sisa-<?= $i ?>-<?= $department ?>"><?= $totalAktualSisa[$i] ?></td>
                                <?php else: ?>
                                <td>-</td><td>-</td><td>-</td><td>-</td>
                                <?php endif; endif; ?>
                                <?php $i++; endforeach ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="margin-bottom: 18px; text-align: center;">
                    <b id="chart-loading-placeholder-<?= $department ?>">Memuat grafik...</b>
                    <div id="chart-frame-<?= $department ?>" style="display: none;">
                        <b>Kasie Utama ke atas</b>
                        <canvas id="chart-1-<?= $department ?>" style="width: 100%; margin-bottom: 8px;"></canvas>
                        <b>Staff s/d Kasie Madya</b>
                        <canvas id="chart-2-<?= $department ?>" style="width: 100%; margin-bottom: 8px;"></canvas>
                        <b>Non Staff</b>
                        <canvas id="chart-3-<?= $department ?>" style="width: 100%; margin-bottom: 8px;"></canvas>
                        <b>Outsourcing</b>
                        <canvas id="chart-4-<?= $department ?>" style="width: 100%; margin-bottom: 8px;"></canvas>
                        <b>Harian Lepas</b>
                        <canvas id="chart-5-<?= $department ?>" style="width: 100%;"></canvas>
                    </div>
                </div>
                <?php break; endswitch; ?>
            </div>
        </div>
    </div>
</div>
<? endforeach ?>