	function masc(obj,mascara) {
		str   = obj.value
		len   = str.length
		str2  = ""
		for (i = 0 , j = 0 ; j < len && i<mascara.length; i ++ ) {
			if (mascara.charAt(i) == "#") {
				str2 += str.charAt(j)
				j++
			} else {
				if( str.charAt(j) != mascara.charAt(i)) 
					str2 += mascara.charAt(i)
			}
		}
		obj.value = str2
	}
	
	function masc_numeros(obj,mascara) {
		str   = obj.value
		len   = str.length
		str2  = ""
		digito = /^\d$/
		for (i = 0; i < len ; i ++ ) {
			if (digito.test(str.charAt(i))) str2 += str.charAt(i)
		}
		str   = str2
		len   = str.length
		str2  = ""
		for (i = 0 , j = 0 ; j < len && i<mascara.length; i ++ ) {
			if (mascara.charAt(i) == "#") {
				str2 += str.charAt(j)
				j++
			} else {
				str2 += mascara.charAt(i)
			}
		}
		obj.value = str2
	}
	function validaCPF(op,msg) {
		cpf   = document.getElementById(op).value
		len   = cpf.length
		cpf2  = ""
		digito = /^\d$/
		for (i = 0; i < len ; i ++ ) {
			if (digito.test(cpf.charAt(i))) cpf2 += cpf.charAt(i)
		}
		cpf = cpf2

		//cpf = document.getElementById(op).value
		valor = true
		erro = new String
		if (cpf.length < 11) erro += "Sao necessarios 11 digitos para verificacao do CPF! <br>" 
		var nonNumbers = /\D/;
		if (nonNumbers.test(cpf)) erro += "A verificacao de CPF suporta apenas numeros! <br>"	
		if (cpf == "00000000000" || cpf == "11111111111" || cpf == "22222222222" || cpf == "33333333333" || cpf == "44444444444" || cpf == "55555555555" || cpf == "66666666666" || cpf == "77777777777" || cpf == "88888888888" || cpf == "99999999999"){
			  erro += "Numero de CPF invalido!"
		}
		var a = []
		var b = new Number
		var c = 11
		for (i=0; i<11; i++){
			a[i] = cpf.charAt(i)
			if (i < 9) b += (a[i] *  --c)
		}
		if ((x = b % 11) < 2) { a[9] = 0 } else { a[9] = 11-x }
		b = 0
		c = 11
		for (y=0; y<10; y++) b += (a[y] *  c--)
		if ((x = b % 11) < 2) { a[10] = 0 } else { a[10] = 11-x }
		if ((cpf.charAt(9) != a[9]) || (cpf.charAt(10) != a[10])){
			erro +="Digito verificador com problema!"
		}
		if (erro.length > 0){
			document.getElementById(msg).innerHTML = erro			
			document.getElementById(msg).style.visibility = 'visible';
			return false
		}
		return true
	}
	
	function valida_email(email){
		var valida = false
		if (email.search(/^\w+((-\w+)|(\.\w+))*\@\w+((\.|-)\w+)*\.\w+$/) == -1) valida = true
		return valida
	}
	
	function trim(string){
		while(''+string.charAt(string.length-1)==' '){
			  string=string.substring(0,string.length-1)
			}	
		return string
	}

