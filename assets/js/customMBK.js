var MBKSplitURL = window.location.href.split('/')

if ( MBKSplitURL[3] == 'MonitoringBiayaKeuangan' ){
    CustomMBK()
}

function CustomMBK() {  
    $(document).ready(function(){

    // Universal Settings
        let MBKGetDate      =  new Date(),
            MBKGetYear      = MBKGetDate.getFullYear(),
            MBKGetMonth     = MBKGetDate.getMonth() + 1,
            MBKGetDay       = MBKGetDate.getDate(),
            MBKMonth        = ('0 Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember'),
            MBKDateMonth    = MBKMonth.split(' '),
            MBKDateLastYear = 'Januari '+ (MBKGetYear-1) +' - '+ MBKDateMonth[MBKGetMonth] +' '+ (MBKGetYear-1),
            MBKDateYearNow  = 'Januari '+ MBKGetYear +' - '+ MBKDateMonth[MBKGetMonth] +' '+ MBKGetYear

        $('.pMBKDate').html(MBKGetDay+'/'+MBKGetMonth+'/'+ MBKGetYear)

        $('.pMBKDateNow').html(MBKDateLastYear+'<br>'+MBKDateYearNow)

        $('.chartAreaWrapper').on("scroll", function () {
            $('.cnvMBKChartAxis').css('z-index','1').fadeIn()
            if ($(this).scrollLeft() < 70 ) {
                $('.cnvMBKChartAxis').css('z-index','-1').hide()
            }
        })

    // Dashboard
        if ( MBKSplitURL[3]+'/'+MBKSplitURL[4] == 'MonitoringBiayaKeuangan/Dashboard' ) {

            $('.btnMBKShowChartDashboard').on('click', function(){
                let SecName      = $('option:selected', $('.slcMBKSectionName')).attr('section'),
                    SecNameTitle = $('.slcMBKSectionName').val()
                if ( SecNameTitle != null ){
                    if ( SecNameTitle == 'All' ) {
                        $('.spnMBKSectionNameTitle').html('SEMUA SEKSI')
                        
                    } else {
                        $('.spnMBKSectionNameTitle').html('SEKSI '+SecNameTitle)
                    }
                    $('.slcMBKSectionName').select2({ disabled : true })
                    $('.btnMBKShowChartDashboard').attr('disabled','disabled')
                }
                $('.divMBKimgLoad').fadeIn()
                AjaxGetFinanceCostDashboardBySectionName(SecName)
            })

            $('.btnMBKShowChartDashboard').click()

            $('.btnMBKExportExcel').on('click', function(){
                let SecName      = $('option:selected', $('.slcMBKSectionName')).attr('section')
                $('.aMBKExportExcel').attr('href',baseurl+'MonitoringBiayaKeuangan/Dashboard/ExportReportToExcel/'+SecName)
            })

            function AjaxGetFinanceCostDashboardBySectionName(SecName) {
                $.ajax({
                    type: 'post',
                    data : { SecName : SecName },
                    url: baseurl + 'MonitoringBiayaKeuangan/Dashboard/AjaxGetFinanceCostDashboardBySectionName/',
                    dataType: 'json',
                    success: function (resp) {
                        let menu  = 'dashboard',
                            width = resp.label.length*7
                        MBKChartDestroy(width)
                        MBKChart(resp.label, resp.tahun1, resp.tahun2, menu)
                        $('.slcMBKSectionName').select2({ disabled : false })
                        $('.btnMBKShowChartDashboard').removeAttr('disabled','disabled')
                        $('.divMBKimgLoad').hide()
                    }
                })
            }

        }
        
    // Detail
        if ( MBKSplitURL[3]+'/'+MBKSplitURL[4] == 'MonitoringBiayaKeuangan/Detail' ) {

            $('.slcMBKSectionName').on('change', function(){
                let SecName = $('option:selected', $('.slcMBKSectionName')).attr('section')
                $('.divMBKimgLoadSec').fadeIn()
                $('.slcMBKAccountName').val(null).trigger('change').attr('disabled','disabled')
                $('.btnMBKShowChartDetail').attr('disabled','disabled')
                AjaxGetAccountListBySectionName(SecName)
            })

            $('.btnMBKShowChartDetail').on('click', function(){
                let SecName      = $('option:selected', $('.slcMBKSectionName')).attr('section'),
                    SecNameTitle = $('.slcMBKSectionName').val(),
                    AccName      = $('option:selected', $('.slcMBKAccountName')).attr('account'),
                    AccNameTitle = $('.slcMBKAccountName').val()
                if( AccName != null ){
                    if (SecNameTitle == 'All') {
                        $('.spnMBKSectionNameTitle').html('SEMUA SEKSI<br>')
                    } else {
                        $('.spnMBKSectionNameTitle').html('SEKSI '+SecNameTitle+'<br>')
                    }
                    $('.spnMBKAccountNameTitle').html('" Akun '+AccNameTitle + ' "')
                    $('.divMBKWarnAccount').fadeOut()
                    $('.spnMBKWarnAccount').siblings('i').attr('class','fa fa-remove')
                    $('.spnMBKWarnAccountColor').attr('class','bg-red spnMBKWarnAccountColor')
                    $('.slcMBKSectionName').select2({ disabled : true })
                    $('.slcMBKAccountName').select2({ disabled : true })
                    $('.btnMBKShowChartDetail').attr('disabled','disabled')
                    $('.divMBKWarnAccount').hide()
                    $('.divMBKimgLoad').fadeIn()
                    AjaxGetFinanceCostByAccountNameAndSection(AccName,SecName)
                } else {
                    $('.spnMBKWarnAccount').siblings('i').attr('class','fa fa-warning')
                    $('.spnMBKWarnAccountColor').attr('class','bg-yellow spnMBKWarnAccountColor')
                    $('.spnMBKWarnAccount').html(' Anda belum memilih akun biaya. ')
                    $('.divMBKWarnAccount').fadeIn()
                }
            })
            
            $('.btnMBKDetailExportExcel').on('click', function(){
                let SecName = $('option:selected', $('.slcMBKSectionName')).attr('section'),
                    AccName = $('option:selected', $('.slcMBKAccountName')).attr('account')
                if ( AccName != null ){
                    $('.aMBKDetailExportExcel').attr('href',baseurl+'MonitoringBiayaKeuangan/Detail/ExportDetailReportToExcel/'+SecName+'-'+AccName)
                }else {
                    $('.aMBKDetailExportExcel').removeAttr('href')
                    $('.divMBKWarnExport').fadeIn()
                    setTimeout(function() {
                        $('.divMBKWarnExport').fadeOut()
                    }, 3000)
                }
            })

            $('.btnMBKExportExcel').on('click', function(){
                let SecName = $('option:selected', $('.slcMBKSectionName')).attr('section'),
                    AccName = $('option:selected', $('.slcMBKAccountName')).attr('account')
                if ( AccName != null ){
                    $('.aMBKExportExcel').attr('href',baseurl+'MonitoringBiayaKeuangan/Detail/ExportReportToExcel/'+SecName+'-'+AccName)
                } else {
                    $('.aMBKExportExcel').removeAttr('href')
                    $('.divMBKWarnExport').fadeIn()
                    setTimeout(function() {
                        $('.divMBKWarnExport').fadeOut()
                    }, 3000)
                }
            })

            function AjaxGetAccountListBySectionName(SecName) {  
                $.ajax({
                    type: 'post',
                    data: { SecName : SecName },
                    url: baseurl + 'MonitoringBiayaKeuangan/Detail/AjaxGetAccountListBySectionName',
                    dataType: 'json',
                    success: function (resp) {
                        $('.btnMBKShowChartDetail').removeAttr('disabled')
                        $('.slcMBKAccountName').removeAttr('disabled').empty()
                        $(resp.SectionList).each(function(index,val){
                            $('.slcMBKAccountName').append('<option account="'+ val.ACCOUNT +
                            '" title="'+val.DESCRIPTION+'">'+val.DESCRIPTION+'</option>')
                        })
                        $('.divMBKimgLoadSec').hide()
                    }
                })
            }

            function AjaxGetFinanceCostByAccountNameAndSection(AccName, SecName) { 
                $.ajax({
                    type: 'post',
                    data: { 
                            AccName : AccName,
                            SecName : SecName
                        },
                    url: baseurl + 'MonitoringBiayaKeuangan/Detail/AjaxGetFinanceCostByAccountNameAndSection',
                    dataType: 'json',
                    success: function (resp) {
                        let tahun1 = resp.tahun1.map(Number),
                            tahun2 = resp.tahun2.map(Number),
                            menu   = 'detail',
                            totaltahun1 = tahun1.reduce(function(acc, val) { return acc + val }, 0),
                            totaltahun2 = tahun2.reduce(function(acc, val) { return acc + val }, 0)
                        $('.divMBKimgLoad').hide()
                        $('.btnMBKShowChartDetail').removeAttr('disabled','disabled')
                        $('.slcMBKAccountName').select2({ disabled : false })
                        $('.slcMBKSectionName').select2({ disabled : false })
                        if ( (totaltahun1+totaltahun2) > 0 ) {
                            MBKChartDestroy(width=100,height=375)
                            MBKChart(resp.label, resp.tahun1, resp.tahun2, menu)
                        } else {
                            MBKChartDestroy()
                            $('.spnMBKWarnAccount').html(' Tidak ditemukan data pada seksi '+SecName+' dengan akun '+AccName+'. ')
                            $('.divMBKWarnAccount').fadeIn()
                        }
                    }
                })
            }

        }

    // Biaya Seksi Tinggi ke Rendah
    if ( MBKSplitURL[3]+'/'+MBKSplitURL[4] == 'MonitoringBiayaKeuangan/BiayaSeksi' ) {

        AjaxGetSortedFinanceCostTotal()

        function AjaxGetSortedFinanceCostTotal() {
            $.ajax({
                type: 'post',
                url: baseurl+'MonitoringBiayaKeuangan/BiayaSeksi/AjaxGetSortedFinanceCostTotal',
                dataType: 'json',
                success: function (resp) {
                    let menu = 'biaya seksi'
                    MBKChartDestroy()
                    MBKChart(resp.label, resp.tahun1, resp.tahun2, menu)
                }
            })
        }

    }

        function MBKChartDestroy(width = 100, height = 525) {
            if ( width < 100 ){
                width = 100
            }
            $('.cnvMBKChart').remove()
            $('.chartAreaWrapper2').css({'width': width+'%','height': height+'px'}).append('<canvas class="cnvMBKChart"></canvas>')
            $('.cnvMBKChartAxis').attr('height',height)
            $('.chartjs-hidden-iframe').remove()
        }

        function MBKChart(label,tahun1,tahun2,menu) {
            if ( menu != 'detail'){
                var autoSkip = false,
                    maxRot =  90,
                    minRot = 90
            } else {
                var autoSkip = false,
                    maxRot =  0,
                    minRot = 0
            }
            var MBKChart = $('.cnvMBKChart')
            var newMBKChart = new Chart(MBKChart, {
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [ {
                        label: 'Tahun '+(MBKGetYear-1),
                        fill: false,
                        data: tahun1,
                        backgroundColor: '#ffffff',
                        borderColor: 'rgb(0, 0, 0)',
                        borderWidth: 1
                    },
                    
                    {
                        label: 'Tahun '+MBKGetYear,
                        fill:false,
                        data: tahun2,
                        backgroundColor: '#00bbff',
                        borderColor: 'rgb(0, 0, 0)',
                        borderWidth: 1
                    },
                    ]
                },
                options: {
                    scales: {
                        xAxes: [{
                            ticks: {
                                autoSkip: autoSkip,
                                maxRotation: maxRot,
                                minRotation: minRot,
                                callback: function(t) {
                                    if ( menu == 'dashboard' || menu == 'biaya seksi' ) {
                                        if ( t[1] != null){
                                            t = t[1].slice(0,17)
                                        }
                                        return t
                                    } else if ( menu == 'detail' ) {
                                        return t
                                    }
                                },
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                beginAtZero:true,
                                callback: function(value, index, values) {
                                    value = value.toString()
                                    value = value.replace('.', ',')
                                    value = value.split(/(?=(?:...)*$)/)
                                    value = value.join('.')
                                    return value
                                }
                            }
                            
                        }]
                    },
                    title: {
                        display: false,
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        onComplete: function(animation) {
                                let sourceCanvas = newMBKChart.chart.canvas,
                                    copyWidth = newMBKChart.scales['y-axis-0'].width - 10,
                                    copyHeight = newMBKChart.scales['y-axis-0'].height + newMBKChart.scales['y-axis-0'].top + 10,
                                    targetCtx = $('.cnvMBKChartAxis')[0].getContext('2d')
                                targetCtx.canvas.width = copyWidth
                                targetCtx.drawImage(sourceCanvas, 0, 0, copyWidth, copyHeight, 0, 0, copyWidth, copyHeight)
                            }
                        },
                    tooltips: {
                            callbacks: {
                                labelColor: function() {
                                    return {
                                        borderColor: 'rgb(0, 0, 0)',
                                        backgroundColor: '#ffff',
                                    }
                                },
                                title: function(t, d) {
                                    if ( menu == 'dashboard' || menu == 'biaya seksi' ){
                                       return d.labels[t[0].index]
                                    }
                                }
                            }
                        },
                    legend: {
                        display: false,
                        labels: {
                            fontColor: 'black',
                        }
                    }
                }
            })
        }
    })
}