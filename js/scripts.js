$(document).ready(function(){

	$('.loginform .submit').click(function(e){
		e.preventDefault();
		if( $('.loginform input[name="user"]').val() == ""){
			alert('favor ingresar el usuario, es requerido');
		}else if( $('.loginform input[name="pass"]').val() == ""){
			alert('favor ingresar el password, es requerido');
		}else{
			var user = $('.loginform input[name="user"]').val();
			var password = $('.loginform input[name="pass"]').val();
			var url = $(this).attr('href');
			$.ajax({
			    url: 'functions.php',
			    data: {'checkUser': 'true', 'user': user, 'password':password },
			    type : 'POST',
			    success : function(response) {
					if(response=='true'){
						window.location.href = url;
					}else{
						alert('Datos erroneos, intente de nuevo');
					}
			    }
			});
		}
	});

	$('.recoverform .submit').click(function(e){
		e.preventDefault();
		if( $('.recoverform input').val() == ""){
			alert('favor ingresar el usuario, es requerido');
		}else{
			var user = $('.recoverform input[name="user"]').val();
			$.ajax({
			    url: 'functions.php',
			    data: {'recoverPassword': 'true', 'user': user },
			    type : 'POST',
			    success : function(response) {
					if(response=='true'){
						alert('Se ha enviado un correo al usuario con los pasos');
						window.location.href = "/proyecto/recover.php?id="+user+"";
					}else{
						alert('El usuario no se encontró en el sistema');
					}
			    }
			});
		}
	});

	$('.newpasswordform .submit').click(function(e){
		e.preventDefault();
		if( $('.newpasswordform input[name="password"]').val() == ""){
			alert('favor ingresar password, es requerido');
		}else if( $('.newpasswordform input[name="password"]').val() != $('.newpasswordform input[name="passwordconfirm"]').val() ){
			alert('Passwords no coinciden, intente de nuevo');
		}else{
			var newpassword = $('.newpasswordform input[name="password"]').val();
			$.ajax({
			    url: 'functions.php',
			    data: {'changePassword': 'true', 'newpassword': newpassword, user: $('.newpasswordform input[name="user"]').val() },
			    type : 'POST',
			    success : function(response) {
					if(response=='true'){
						alert('Se ha cambiado su contraseña');
						window.location.href = '/proyecto';
					}else{
						alert('Error, intente de nuevo');
					}
			    }
			});
		}
	});

	$('.editform .submit').click(function(e){
		e.preventDefault();
		if( $('.editform input[name="name"]').val() == ""){
			alert('favor ingresar nombre, es requerido');
		}else if( $('.editform input[name="cedula"]').val() == "" ){
			alert('favor ingresar cedula, es requerido');
		}else if( $('.editform input[name="email"]').val() == "" ){
			alert('favor ingresar email, es requerido');
		}else{
			$.ajax({
				url: 'functions.php',
				data: {
					'updateRepresentante': 'true',
					'nombre': $('.editform input[name="name"]').val(),
			    	'cedula': $('.editform input[name="cedula"]').val(),
			    	'email': $('.editform input[name="email"]').val(),
			    	'id': $('.editform input[name="id"]').val()
				},
			    type : 'POST',
			    success : function(response) {
			    	if(response=='true'){
						alert('Datos actualizados');
						window.location.href = '/proyecto/legalrepresentatives.php';
					}else{
						alert('Error actualizando, intente de nuevo');
					}
			    }
			});
		}
	});

	$('.addform .submit').click(function(e){
		e.preventDefault();
		if( $('.addform input[name="name"]').val() == ""){
			alert('favor ingresar nombre, es requerido');
		}else if( $('.addform input[name="cedula"]').val() == "" ){
			alert('favor ingresar cedula, es requerido');
		}else if( $('.addform input[name="email"]').val() == "" ){
			alert('favor ingresar email, es requerido');
		}else{
			$.ajax({
				url: 'functions.php',
				data: {
					'addRepresentante': 'true',
					'nombre': $('.addform input[name="name"]').val(),
			    	'cedula': $('.addform input[name="cedula"]').val(),
			    	'email': $('.addform input[name="email"]').val()
				},
			    type : 'POST',
			    success : function(response) {
			    	if(response=='true'){
						alert('Representante agregado');
						window.location.href = '/proyecto/legalrepresentatives.php';
					}else{
						alert('Error ingresando datos, intente de nuevo');
					}
			    }
			});
		}
	});

	$('.profileform .submit').click(function(e){
		e.preventDefault();
		if( $('.profileform input[name="name"]').val() == "" ){
			alert('favor ingresar nombre, es requerido');
		}else if( $('.profileform input[name="cedula"]').val() == "" ){
			alert('favor ingresar cedula, es requerido');
		}else if( $('.profileform input[name="email"]').val() == "" ){
			alert('favor ingresar email, es requerido');
		}else if( $('.profileform input[name="password"]').val() == "" ){
			alert('favor ingresar password, es requerido');
		}else{
			$.ajax({
			    url: 'functions.php',
			    data: {
			    	'updateProfile': 'true',
			    	'nombre': $('.profileform input[name="name"]').val(),
			    	'cedula': $('.profileform input[name="cedula"]').val(),
			    	'email': $('.profileform input[name="email"]').val(),
			    	'password': $('.profileform input[name="password"]').val(),
			    },
			    type : 'POST',
			    success : function(response) {
					if(response=='true'){
						alert('Datos actualizados');
						window.location.href = '/proyecto/admin.php';
					}else{
						alert('Error actualizando, intente de nuevo');
					}
			    }
			});
		}
	});
});