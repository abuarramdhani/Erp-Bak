var baseurlMSO = baseurl+'MonitoringSalesOrder/C_MonitoringSalesOrder/'
$(document).ready(function(){
    load_data();
    $('#do_list').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "language": {
            'searchPlaceholder': 'Search . . .'
        },
        "autoWidth": false,
        
    } ); 

    $('#do_done').DataTable({
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "language": {
            'searchPlaceholder': 'Search . . .'
        },
        "autoWidth": false,
    } ); 

    setInterval(function() {
        fetch_data()
    }, 15000)

});

const swalConfirmNew = Swal.mixin({
    customClass: {
      confirmButton: 'btn btn-success'
    },
    buttonsStyling: false
  })

var old_count;
function fetch_data(){
    $.ajax({
        type : "POST",
        url : baseurlMSO + 'fetch_count',
        dataType: 'json',
        success : function(data){
            if (data[0].TOTAL > old_count) {
                console.log(data[0].TOTAL ,old_count);
                var sound = new Howl({
                    src: [baseurl + "assets/upload/MonitoringSalesOrder/alert.mp3"],
                    autoplay: true,
                    html5: true,
                  });  
                sound.play();
                swalConfirmNew.fire({
                    title: 'Attention!',
                    text: "New Order Arrived!",
                    type: 'warning',
                    confirmButtonText: 'Ok!',
                    reverseButtons: true
                  }).then((result) => {
                    if (result.value) {
                      sound.stop();
		      console.log("stop")
                    }
                  })
                old_count = data[0].TOTAL;
                console.log("set "+old_count)
                load_data()
            }
        }
    });
}


$(document).ready(function () {
    var url = window.location;
    $('ul.sidebar-menu a[href="'+ url +'"]').parent().addClass('active');
    $('ul.sidebar-menu a').filter(function() {
         return this.href == url;
    }).parent().addClass('active');
});

function done_(th) {
    var order_number = $('tr[no="'+th+'"] td.order_number').html();

    $.ajax({
        method: 'post',
        url: baseurlMSO + 'move_done',
        dataType: 'json',
        data: {
            order_number: order_number,
        },
        success: function(res) {
            if (res == 1) {
                $('tr[no="'+th+'"]').remove();
                old_count--
                printPage(order_number)
            }
        }
    })
}

function load_data(){
    $.ajax({
        type : 'ajax',
        url : baseurlMSO + 'do_outstanding',
        async : false,
        dataType : 'json',
        success : function(data){
            var row = '';
            
            $.each(data, (i, item) => {
                row += '<tr no="'+(i + 1)+'">' +
                        '<td>'+(i + 1)+'</td>' +
                        '<td class="order_number">'+item.ORDER_NUMBER+'</td>' +
                        '<td>'+item.CREATION_DATE+'</td>' +
                        '<td  class="text-center" style="width:16%">'+
                             '<a href="'+ baseurlMSO + 'do_detail/'+ item.ORDER_NUMBER +'">'+
                               '<button style="width:70px; margin-right:5px;" class ="btn btn-primary btn-sm"> Detail </button>'+
                             '</a>'+ 
                              '<button style="width:70px;" class ="btn btn-success btn-sm" onclick="done_('+(i + 1)+')"> Done </button>'+
                         '</td>' + 
                        '</tr>';
            })
            old_count = data.length;
            console.log(old_count, data.length);
            
            $('#do_list tbody').html(row);

        }
    });
}


function printPage(order_number) {
    $("<iframe class='printpage'>")
        .attr("src", baseurlMSO + "do_print/" + order_number)
        .appendTo("body");
}

 