$(document).ready(function(){
	console.log(actualStatus);
	
	$('input[type=checkbox]').tzCheckbox({labels:['Enable','Disable']});

	$('.tzCheckBox').click(function () {
		var _this = $(this);
		var _parent = _this.parent();
		var opcao = "";

		if(_this.hasClass('checked')){
			opcao += "Ligar";
		}else{
			opcao += "Desligar";
		}

		if(_parent.hasClass('btnVerde')){
			opcao += " Verde";
		}else{
			opcao += " Laranja";
		}

	    console.log(opcao); 
	    
	    $.ajax({
	      url: "test.html",
	      context: document.body
	    }).done(function() {
	      $( this ).addClass( "done" );
	    });
	});
});