/*				Service Product 			*/
$(document).ready(function() {
		$('#form-service').bootstrapValidator({
			framework: 'bootstrap',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
            },
			 fields: {
                txtServiceNumber: {
                   validators: {
                        notEmpty: {
                            message: 'The Service Number is required and can\'t be empty'
                        }
                    }
                },
				txtSparePart: {
				   selector: '.txtSparePart',
                   validators: {
                        notEmpty: {
                            message: 'Can\'t be empty'
                        }
                    }
                }
			 }
		
		});
	});
	
/*				Customer Group 			*/
	$(document).ready(function() {
		$('#form-customer-group').bootstrapValidator({
			framework: 'bootstrap',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
            },
			 fields: {
                txtCustomerGroup: {
                   validators: {
                        notEmpty: {
                            message: 'The Service Number is required and can\'t be empty'
                        }
                    }
                }
			 }
		});
	});
	
/*				Buying Type 			*/
	$(document).ready(function() {
		$('#form-buying-type').bootstrapValidator({
			framework: 'bootstrap', 
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
            },
			 fields: {
                txtBuyingType: {
                   validators: {
                        notEmpty: {
                            message: 'The Service Number is required and can\'t be empty'
                        }
                    }
                }
			 }
		});
	});