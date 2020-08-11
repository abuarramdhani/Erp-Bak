function readFilePdf_opp(input) {
		if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
						$('#showPre')
								.attr('src', e.target.result)
								.height(300);
				};
		reader.readAsDataURL(input.files[0]);
		}
}

const plus_proses_opp = () => {
	let n = $(`.table_opp tr`).length;
	let no = n + 1;
	let html = `<tr row-id="${no}">
	              <td style="text-align:center">${no}</td>
	              <td>
	                <select class="form-control" name="p_proses[]">
	                  <option value="P">PROSES</option>
	                  <option value="A">A</option>
	                </select>
	              </td>
	              <td>
	                <select class="form-control" name="p_seksi[]" >
	                  <option value="P">SEKSI</option>
	                  <option value="A">A</option>
	                </select>
	              </td>
	              <td>
	                <center><button type="button" name="button" class="btn btn-sm" onclick="minus_proses_opp(${no})"><i class="fa fa-minus-square"></i></button></center>
	              </td>
	            </tr>`;
	 $(`.table_opp`).append(html);
}

const minus_proses_opp = (no) => {
	$(`.table_opp tr[row-id="${no}"]`).remove();
}

const orderinopp = $('.orderInOpp').dataTable();
