var MBISplitURL = window.location.href.split('/')

if ( MBISplitURL[3] == 'MonitoringBiayaSeksiICT' ){
    CustomMBI()
}

function CustomMBI() {  
    $(document).ready(function(){

    // Universal Settings
        let MBIGetDate      =  new Date(),
            MBIGetYear      = MBIGetDate.getFullYear(),
            MBIGetMonth     = MBIGetDate.getMonth() + 1,
            MBIGetDay       = MBIGetDate.getDate(),
            MBIMonth        = ('0 Januari Februari Maret April Mei Juni Juli Agustus September Oktober November Desember'),
            MBIDateMonth    = MBIMonth.split(' '),
            MBIDateLastYear = 'Januari '+ (MBIGetYear-1) +' - '+ MBIDateMonth[MBIGetMonth] +' '+ (MBIGetYear-1),
            MBIDateYearNow  = 'Januari '+ MBIGetYear +' - '+ MBIDateMonth[MBIGetMonth] +' '+ MBIGetYear

        $('.pMBIDate').html(MBIGetDay+'/'+MBIGetMonth+'/'+ MBIGetYear)

        $('.pMBIDateNow').html(MBIDateLastYear+'<br>'+MBIDateYearNow)

        $('.chartAreaWrapper').on('scroll', function () {
            $('.cnvMBIChartAxis').css('z-index','1').fadeIn()
            if ($(this).scrollLeft() < 70 ) {
                $('.cnvMBIChartAxis').css('z-index','-1').hide()
            }
        })

    // Dashboard
        if ( MBISplitURL[3]+'/'+MBISplitURL[4] == 'MonitoringBiayaSeksiICT/Dashboard' ) {
         
            $('.slcMBISectionName').val('1E01 - PROGRAMMER (IT)').trigger('change')

            let SecName      = $('option:selected', $('.slcMBISectionName')).attr('section')

            $('.divMBIhdnSection').remove()

            AjaxGetFinanceCostDashboardBySectionName(SecName)
                        
            $('.btnMBIExportExcel').on('click', function(){
                $('.aMBIExportExcel').attr('href',baseurl+'MonitoringBiayaSeksiICT/Dashboard/ExportReportToExcel/'+SecName)
            })

            function AjaxGetFinanceCostDashboardBySectionName(SecName) {
                $.ajax({
                    type: 'post',
                    data : { SecName : SecName },
                    url: baseurl + 'MonitoringBiayaSeksiICT/Dashboard/AjaxGetFinanceCostDashboardBySectionName/',
                    dataType: 'json',
                    success: function (resp) {
                        let menu  = 'dashboard',
                            width = resp.label.length*7
                        MBIChartDestroy(width)
                        MBIChart(resp.label, resp.tahun1, resp.tahun2, menu)
                        $('.divMBIimgLoad').hide()
                    }
                })
            }

        }
        
    // Detail
        if ( MBISplitURL[3]+'/'+MBISplitURL[4] == 'MonitoringBiayaSeksiICT/Detail' ) {

            $('.slcMBISectionName').val('1E01 - PROGRAMMER (IT)').trigger('change')
            
            let SecName      = $('option:selected', $('.slcMBISectionName')).attr('section')

            $('.divMBIhdnSection').remove()

            $('.btnMBIShowChartDetail').on('click', function(){
                let AccName      = $('option:selected', $('.slcMBIAccountName')).attr('account'),
                    AccNameTitle = $('.slcMBIAccountName').val()
                if( AccName != null ){
                    $('.spnMBIAccountNameTitle').html(' AKUN '+AccNameTitle.toUpperCase())
                    $('.divMBIWarnAccount').fadeOut()
                    $('.spnMBIWarnAccount').siblings('i').attr('class','fa fa-remove')
                    $('.spnMBIWarnAccountColor').attr('class','bg-red spnMBIWarnAccountColor')
                    $('.slcMBIAccountName').select2({ disabled : true })
                    $('.btnMBIShowChartDetail').attr('disabled','disabled')
                    $('.divMBIWarnAccount').hide()
                    $('.divMBIimgLoad').fadeIn()
                    AjaxGetFinanceCostByAccountNameAndSection(AccName,SecName)
                } else {
                    $('.spnMBIWarnAccount').siblings('i').attr('class','fa fa-warning')
                    $('.spnMBIWarnAccountColor').attr('class','bg-yellow spnMBIWarnAccountColor')
                    $('.spnMBIWarnAccount').html(' Anda belum memilih akun biaya. ')
                    $('.divMBIWarnAccount').fadeIn()
                }
            })
            
            $('.btnMBIDetailExportExcel').on('click', function(){
                let AccName = $('option:selected', $('.slcMBIAccountName')).attr('account')
                if ( AccName != null ){
                    $('.aMBIDetailExportExcel').attr('href',baseurl+'MonitoringBiayaSeksiICT/Detail/ExportDetailReportToExcel/'+SecName+'-'+AccName)
                }else {
                    $('.aMBIDetailExportExcel').removeAttr('href')
                    $('.divMBIWarnExport').fadeIn()
                    setTimeout(function() {
                        $('.divMBIWarnExport').fadeOut()
                    }, 3000)
                }
            })

            $('.btnMBIExportExcel').on('click', function(){
                let AccName = $('option:selected', $('.slcMBIAccountName')).attr('account')
                if ( AccName != null ){
                    $('.aMBIExportExcel').attr('href',baseurl+'MonitoringBiayaSeksiICT/Detail/ExportReportToExcel/'+SecName+'-'+AccName)
                } else {
                    $('.aMBIExportExcel').removeAttr('href')
                    $('.divMBIWarnExport').fadeIn()
                    setTimeout(function() {
                        $('.divMBIWarnExport').fadeOut()
                    }, 3000)
                }
            })

            function AjaxGetFinanceCostByAccountNameAndSection(AccName, SecName) { 
                $.ajax({
                    type: 'post',
                    data: { 
                            AccName : AccName,
                            SecName : SecName
                        },
                    url: baseurl + 'MonitoringBiayaSeksiICT/Detail/AjaxGetFinanceCostByAccountNameAndSection',
                    dataType: 'json',
                    success: function (resp) {
                        let tahun1 = resp.tahun1.map(Number),
                            tahun2 = resp.tahun2.map(Number),
                            menu   = 'detail',
                            totaltahun1 = tahun1.reduce(function(acc, val) { return acc + val }, 0),
                            totaltahun2 = tahun2.reduce(function(acc, val) { return acc + val }, 0)
                        $('.divMBIimgLoad').hide()
                        $('.btnMBIShowChartDetail').removeAttr('disabled','disabled')
                        $('.slcMBIAccountName').select2({ disabled : false })
                        $('.slcMBISectionName').select2({ disabled : false })
                        if ( (totaltahun1+totaltahun2) > 0 ) {
                            MBIChartDestroy(width=100,height=375)
                            MBIChart(resp.label, resp.tahun1, resp.tahun2, menu)
                        } else {
                            MBIChartDestroy()
                            $('.spnMBIWarnAccount').html(' Tidak ditemukan data pada seksi '+SecName+' dengan akun '+AccName+'. ')
                            $('.divMBIWarnAccount').fadeIn()
                        }
                    }
                })
            }

        }

        function MBIChartDestroy(width = 100, height = 525) {
            if ( width < 100 ){
                width = 100
            }
            $('.cnvMBIChart').remove()
            $('.chartAreaWrapper2').css({'width': width+'%','height': height+'px'}).append('<canvas class="cnvMBIChart"></canvas>')
            $('.cnvMBIChartAxis').attr('height',height)
            $('.chartjs-hidden-iframe').remove()
        }

        function MBIChart(label,tahun1,tahun2,menu) {
            if ( menu != 'detail'){
                var autoSkip = false,
                    maxRot =  90,
                    minRot = 90
            } else {
                var autoSkip = false,
                    maxRot =  0,
                    minRot = 0
            }
            var MBIChart = $('.cnvMBIChart')
            var newMBIChart = new Chart(MBIChart, {
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [ {
                        label: 'Tahun '+(MBIGetYear-1),
                        fill: false,
                        data: tahun1,
                        backgroundColor: '#ffffff',
                        borderColor: 'rgb(0, 0, 0)',
                        borderWidth: 1
                    },
                    
                    {
                        label: 'Tahun '+MBIGetYear,
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
                                    if ( menu == 'dashboard' ) {
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
                                    if ( value < 1 ) {
                                        value = value.toFixed(1)
                                    }
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
                                let sourceCanvas = newMBIChart.chart.canvas,
                                    copyWidth = newMBIChart.scales['y-axis-0'].width - 10,
                                    copyHeight = newMBIChart.scales['y-axis-0'].height + newMBIChart.scales['y-axis-0'].top + 10,
                                    targetCtx = $('.cnvMBIChartAxis')[0].getContext('2d')
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
                                        val = t[0].yLabel.toString()
                                        t[0].yLabel = val.replace('.', ',')
                                       return d.labels[t[0].index]
                                    } else {
                                        val = t[0].yLabel.toString()
                                        t[0].yLabel = val.replace('.', ',')
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