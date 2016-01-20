
function mascara(o,f){
    v_obj=o
    v_fun=f
    //setTimeout("execmascara()",0.005)
    execmascara();
}

function execmascara(){
    v_obj.value=v_fun(v_obj.value);
}

function numeroMasc(inp){
    v = inp.value
    v=v.replace(/\D/g,"")//Remove tudo o que n�o � d�gito
	inp.value=v;
}

function valorMasc(inp){
	v = inp.value
    v=v.replace(/\D/g,"") 	//Remove tudo o que n�o � d�gito
    v=v.replace(/(\d+)(\d{2})/,"$1,$2")
    inp.value = v
}

function telefoneMasc(inp){
    v = inp.value
    v=v.replace(/\D/g,"")                 //Remove tudo o que n�o � d�gito
    v=v.replace(/(\d{4})(\d)/,"$1-$2")    //Coloca h�fen entre o quarto e o quinto d�gitos
    v=v.replace(/^(\d{4})-(\d{4})(.*)/g,"$1-$2");
    inp.value = v
}

function dataMasc(inp){
    v = inp.value
    v=v.replace(/\D/g,"")                 //Remove tudo o que n�o � d�gito
    v=v.replace(/^([0-9]{2})([0-9])/g,"$1/$2");

    v=v.replace(/^([0-9]{2}\/)([0-9]{2})([0-9])/g,"$1$2/$3");
    v=v.replace(/^([0-9]{2}\/[0-9]{2}\/[0-9]{4})(.*)/g,"$1")
    
	inp.value = v
}

function placaMasc(obj){
    v = obj.value;
	
	v=v.toUpperCase();
    v=v.replace(/^([^A-Z]+)/g,"")
	
	v=v.replace(/^([A-Z]{3})([0-9]+)$/g,"$1-$2")
	v=v.replace(/^([A-Z]{3})([^0-9]+)$/g,"$1-")
	v=v.replace(/^([A-Z]{3})[-]{1}([0-9]*)([^0-9]*)/g,"$1-$2")
    v=v.replace(/^([A-Z]{3})[-]{1}([0-9]+)/g,"$1-$2")
    v=v.replace(/^([A-Z]{3})(-{1})([0-9]{4})(.*)/g,"$1-$3")
	
	//v=v.replace(/^([A-Z]+)[^-]/g,"$1")
	
	//console.info(v);
    obj.value = v;
}

function cpfMasc(obj){
    v = obj.value
	v=v.replace(/\D/g,"")                    //Remove tudo o que n�o � d�gito
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto d�gitos
    v=v.replace(/(\d{3})(\d)/,"$1.$2")       //Coloca um ponto entre o terceiro e o quarto d�gitos
                                             //de novo (para o segundo bloco de n�meros)
    v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um h�fen entre o terceiro e o quarto d�gitos
    obj.value =v
}

function cepMasc(obj){
    v = obj.value
    v=v.replace(/\D/g,"")                //Remove tudo o que n�o � d�gito
    v=v.replace(/^(\d{5})(\d)/,"$1-$2") //Esse � t�o f�cil que n�o merece explica��es
    obj.value = v
}

function cnpjMasc(v){
    v=v.replace(/\D/g,"")                           //Remove tudo o que n�o � d�gito
    v=v.replace(/^(\d{2})(\d)/,"$1.$2")             //Coloca ponto entre o segundo e o terceiro d�gitos
    v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto d�gitos
    v=v.replace(/\.(\d{3})(\d)/,".$1/$2")           //Coloca uma barra entre o oitavo e o nono d�gitos
    v=v.replace(/(\d{4})(\d)/,"$1-$2")              //Coloca um h�fen depois do bloco de quatro d�gitos
    return v
}

function romanosMasc(v){
    v=v.toUpperCase()             //Mai�sculas
    v=v.replace(/[^IVXLCDM]/g,"") //Remove tudo o que n�o for I, V, X, L, C, D ou M
    //Essa � complicada! Copiei daqui: http://www.diveintopython.org/refactoring/refactoring.html
    while(v.replace(/^M{0,4}(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/,"")!="")
        v=v.replace(/.$/,"")
    return v
}

function siteMasc(v){
    //Esse sem comentarios para que voc� entenda sozinho ;-)
    v=v.replace(/^http:\/\/?/,"")
    dominio=v
    caminho=""
    if(v.indexOf("/")>-1)
        dominio=v.split("/")[0]
        caminho=v.replace(/[^\/]*/,"")
    dominio=dominio.replace(/[^\w\.\+-:@]/g,"")
    caminho=caminho.replace(/[^\w\d\+-@:\?&=%\(\)\.]/g,"")
    caminho=caminho.replace(/([\?&])=/,"$1")
    if(caminho!="")dominio=dominio.replace(/\.+$/,"")
    v="http://"+dominio+caminho
    return v
}

function toUpper(obj){
    v = obj.value.toUpperCase();
    obj.value=v;
}

function toLower(obj){
    v = obj.value.toLowerCase();
    obj.value=v;
}
