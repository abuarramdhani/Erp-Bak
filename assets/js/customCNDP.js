var i = 2;
function addinputFile() {
	$('#tambahTarget').append('<div class="tambahtarget" ><br><br><div class="col-md-2" align="right"></div><div class="col-md-2"><input type="file" name="txt_file[]" id="txt_file" accept=".txt, .NC, .NF" /></div><div class="col-md-1" style="text-align:right"><button class = "btn btn-default tombolhapus'+i+'" type="button"><i class = "fa fa-minus" ></i></button></div></div></div></div>');
	$(document).on('click', '.tombolhapus'+i,  function() {
		$(this).parents('.tambahtarget').remove()
	});
	i++; 
}