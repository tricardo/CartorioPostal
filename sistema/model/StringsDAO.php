<? class StringsDAO {

    public function html_entities($link_direto, $_string){
        if(!is_array($_string)){
            $_string = strip_tags($_string);
            #$_string = ($link_direto == 0) ? utf8_decode($_string) : $_string;
            $_string = str_replace("'", "´", $_string);
            $_string = str_replace("<script>", "", $_string);
            $_string = str_replace("</script>", "", $_string);
            $_string = str_replace("&lt;script&gt;", "", $_string);
            $_string = str_replace("&lt;/script&gt;", "", $_string);
        }
        return $_string;
    }

    public function url_entities($_string){
        $_string = htmlentities($_string);
        return $_string;
    }

    public function no_acents($_string){
        $_string = str_replace("ó", "o", $_string);
        return $_string;
    }

    public function clear_accents($_string){
        $_string   = strtolower(trim($_string));
        $chars = array('!','@','²','#','³','$','£','%','¢','¨','¬','&','*','(',')','-',
                '+','=','§','[','{','ª',']','}','º','^','~','?',',','<','.','>',';',':',
                '\\','|','/','"',"'",'´','`');
        for($i = 0; $i < count($chars); $i++){
                $_string = str_replace($chars[$i], '', $_string);
        }
        $_string = str_replace('á','a',$_string);
        $_string = str_replace('ã','a',$_string);
        $_string = str_replace('â','a',$_string);
        $_string = str_replace('à','a',$_string);
        $_string = str_replace('ä','a',$_string);
        $_string = str_replace('é','e',$_string);
        $_string = str_replace('ê','e',$_string);
        $_string = str_replace('è','e',$_string);
        $_string = str_replace('ë','e',$_string);
        $_string = str_replace('í','i',$_string);
        $_string = str_replace('î','i',$_string);
        $_string = str_replace('ì','i',$_string);
        $_string = str_replace('ï','i',$_string);
        $_string = str_replace('ó','o',$_string);
        $_string = str_replace('õ','o',$_string);
        $_string = str_replace('ò','o',$_string);
        $_string = str_replace('ô','o',$_string);
        $_string = str_replace('ö','o',$_string);
        $_string = str_replace('ú','u',$_string);
        $_string = str_replace('û','u',$_string);
        $_string = str_replace('ù','u',$_string);
        $_string = str_replace('ü','u',$_string);
        $_string = str_replace('ç','c',$_string);
        $_string = str_replace(' ','-',$_string);
        return $_string;
    }

    public function salt($string){
        $string = trim($string);
	for($i = 0; $i <= 255; $i++){
            if($string == chr($i)){
                return str_replace($string, $i.'¬',$string);
            }
	}
    }

    public function salt_str($string){
        $string = trim($string);
        $new_string = '';
        for($i = 0; $i < strlen($string); $i++){
            $new_string .= $this->salt((string)$string[$i]);
        }
        return $new_string;
    }
} ?>