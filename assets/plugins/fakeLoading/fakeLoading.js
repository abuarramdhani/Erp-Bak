var fl_interv;
function fakeLoading(stat = 0) {
	//cek status
	if (stat > 1) {
		console.log('Fake Loading \n Error Parameter salah');
		return false;
	}

	if (stat === 1) {
		if (typeof fl_interv === 'undefined') {
			console.log('Fake Loading \n Undefinied interval')
		}
		clearInterval(fl_interv);

		$('.rjpProgres').css('width','100%');
		setTimeout(function (){
			$('#fakeLoading').remove();
		}, 2000);
		return false;
	}else{
		// do not
	}
	//End of cek status

	//defind FakeLoading
	var t = [5, 1, 0.1];
	var template = '<div id="fakeLoading" style="top: 0;left: 0;right: 0;bottom: 0; margin: auto; position: fixed; background: rgba(0,0,0,.5); z-index: 11;">'+
						'<div class="col-md-6" style="position: fixed; top: 40%;left: 0;right: 0;bottom: 0; margin: auto; padding-left: 0px; padding-right: 0px;">'+
							'<div class="col-md-12 text-center" style="height: 100px; background-color: #fff; border-radius: 10px;">'+
								'<h3>Now Loading ...</h3>'+
								'<div class="progress">'+
									'<div class="progress-bar progress-bar-striped active rjpProgres" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%;">'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>'+
					'</div>';
	$('section.content').append(template);

	var x = 0;
	fl_interv = setInterval(function(){
		if(x + t[0] <= 50){
			x += t[0];
		}else if (x + t[1] <= 75) {
			x += t[1];
		}else if (x + t[2] <= 99) {
			x += t[2];
		}else{
			clearInterval(fl_interv);
		}
		$('.rjpProgres').css('width',x+'%'); 
	}, 500);
}