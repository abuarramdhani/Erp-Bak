function getRegency(base){
		var id = $("select#txtProvince option:selected").attr('value');
		if(id == ''){
			$("#select2-txtCityRegency-container").html("<span style='color:#999;'>City/Regency</span>");
			$("select#txtCityRegency").prop("disabled", true);
			
			$("#select2-txtDistrict-container").html("<span style='color:#999;'>District</span>");
			$("select#txtDistrict").prop("disabled", true);
			
			$("#select2-txtVillage-container").html("<span style='color:#999;'>Village</span>");
			$("select#txtVillage").prop("disabled", true);
			
			
		}else{
			
			$("#select2-txtDistrict-container").html("<span style='color:#999;'>District</span>");
			$("select#txtDistrict").prop("disabled", true);
			
			$("#select2-txtVillage-container").html("<span style='color:#999;'>Village</span>");
			$("select#txtVillage").prop("disabled", true);
			
			$("#select2-txtCityRegency-container").html("<span style='color:#999;'>City/Regency</span>");
			$("select#txtCityRegency").prop("disabled", false);
			$.post(base+"ajax/GetRegency", {id:id}, function(data){
				$("select#txtCityRegency").html(data);
			});
		}
	}
	
	function getDistrict(base){
		 var id = $("select#txtCityRegency option:selected").attr('value');
		 var prov_id = $("select#txtProvince option:selected").attr('value');
		
		if(id == ''){
			
			$("#select2-txtDistrict-container").html("<span style='color:#999;'>District</span>");
			$("select#txtDistrict").prop("disabled", true);
			
			$("#select2-txtVillage-container").html("<span style='color:#999;'>Village</span>");
			$("select#txtVillage").prop("disabled", true);
			
			
		}else{
			
			$("#select2-txtVillage-container").html("<span style='color:#999;'>Village</span>");
			$("select#txtVillage").prop("disabled", true);
			
			$("#select2-txtDistrict-container").html("<span style='color:#999;'>District</span>");
			$("select#txtDistrict").prop("disabled", false);
			$.post(base+"ajax/GetDistrict", {id:id,prov_id:prov_id}, function(data){
				$("select#txtDistrict").html(data);
			});
		}
	}
	
	function getVillage(base){
		 var reg_id = $("select#txtCityRegency option:selected").attr('value');
		  var prov_id = $("select#txtProvince option:selected").attr('value');
		  var dis_id = $("select#txtDistrict option:selected").attr('value');
		if(dis_id == ''){
			
			$("#select2-txtVillage-container").html("<span style='color:#999;'>Village</span>");
			$("select#txtVillage").prop("disabled", true);
			
			
		}else{
			$("#select2-txtVillage-container").html("<span style='color:#999;'>Village</span>");
			$("select#txtVillage").prop("disabled", false);
			$.post(base+"ajax/GetVillage", {dis_id:dis_id,reg_id:reg_id,prov_id:prov_id}, function(data){
				$("select#txtVillage").html(data);
			});
		}
	}