<?php
/**
 * Helper de Formatação
 * @author Felipe <felipe@wadtecnologia.com.br>
 */

function format_datetime($date)
{
	//printr(date('d/m/Y H:i:s', strtotime($date)));
	
	if($date){
		return date('d/m/Y H:i:s', strtotime($date));
	}
	
	return 'Não-Encontrado';
}

function format_date($date)
{
	if($date){
		return date('d/m/Y', strtotime($date));
	}
	
	return 'Não-Encontrado';
}

function format_time($date)
{

	if($date){
		return date('H:i:s', strtotime($date));
	}
	
	return 'Não-Encontrado';
}
function format_date_to_mysql($date)
{
	if($date){
		return implode("-",array_reverse(explode("/",$date)));
	}
	
	return 'Não-Encontrado';
}

function format_mysql_to_view($date)
{
	if($date){
		return implode("/",array_reverse(explode("-",$date)));
	}
	
	return 'Não-Encontrado';
}
function data_finish($date){	
	//Datas no formato aaaa-mm-dd
	$datainicio=strtotime(date('Y-m-d'));
	$datafim  =strtotime($date);
	$intervalo=($datafim-$datainicio); 
	
	return date("d", $intervalo);
}

function data_dif($date){	
	//Datas no formato aaaa-mm-dd
	$datainicio=strtotime(date('Y-m-d'));
	$datafim  =strtotime($date);
	$intervalo=($datafim-$datainicio); 
	
	return date("d", $intervalo);
}


function yesno($id)
{
	$yesno = array(
		0 => 'Não',
		1 => 'Sim'
	);
	
	return $yesno[$id];
}

function status($id)
{
	$status = array(
		0 => 'Inativo',
		1 => 'Ativo',
		2 => 'Pendente',
		3 => 'Aguardando Aprovação'
	);
	
	return $status[$id];
}

function status_select($selected)
{
	$status = array(
		0 => 'Inativo',
		1 => 'Ativo',
		2 => 'Pendente',
		3 => 'Aguardando Aprovação'
	);
	
	for($i = 0; $i < count($status); $i++){
		if($i == $selected){
			print('<option value="'.$i.'" selected="selected">'.$status[$i].'</option>');
		} else {
			print('<option value="'.$i.'">'.$status[$i].'</option>');
		}
	}
	
	return true;
}
function channel_type_select($selected,$on_combo=FALSE)
{
	$status = array(
		0 => 'Selecione',
		1 => 'DIRETO',
		2 => 'INDIRETO'
	);
	
	if($on_combo){	
		for($i = 0; $i < count($status); $i++){
			if($i == $selected){
				print('<option value="'.$i.'" selected="selected">'.$status[$i].'</option>');
			} else {
				print('<option value="'.$i.'">'.$status[$i].'</option>');
			}
		}
	}else{
		
	if(key_exists($selected,$status)){	
			return $status[$selected];
		}
	}
	return true;
}
function type_request_select($selected,$on_combo=FALSE)
{
	
	$status = array(
		0 => 'SUGERIDA',
		1 => 'EXTRA'
	);
	
	if($on_combo){	
		for($i = 0; $i < count($status); $i++){
			if($i == $selected){
				print('<option value="'.$i.'" selected="selected">'.$status[$i].'</option>');
			} else {
				print('<option value="'.$i.'">'.$status[$i].'</option>');
			}
		}
	}else{
		
	if(key_exists($selected,$status)){	
			return $status[$selected];
		}
	}
	return true;
}

function data_select($rows, $selected)
{
	
	print('<option value="-1">Selecione</option>');
	if(count($rows)<=1){
	    print('<option value="'.$rows[0]['id'].'" selected="selected">'.$rows[0]['name'].'</option>');
	}else{
	    foreach($rows as $row){
		    if($row['id'] == $selected){
			    print('<option value="'.$row['id'].'" selected="selected">'.$row['name'].'</option>');
		    } else {
			    print('<option value="'.$row['id'].'">'.$row['name'].'</option>');
		    }
	    }
	}
	
	return true;
}

function selectAll($rows,$field)
{
	$option="";
	foreach($rows as $row){
			$option=$option.$row->$field.",";	
	}
	$option = substr($option, 0, -1); 
	
	print('<option value="'.$option.'">TODOS</option>');
	
	return false;
}
/**
* Função para pegar extensão do arquivo
* @access public static
* @param String $tUrl
* @return void
*/
function findExt($arquivo_nome = '') {
	if(!isset($arquivo_nome)) {
		return false;
	} else {
		$arquivo_sep = explode('.', $arquivo_nome);
	   
		if(is_array($arquivo_sep)) {
			$arquivo_ext = strtolower(end($arquivo_sep));
			return $arquivo_ext;
		} else {
			return false;
		}
	}
}

/**
* Função para pegar extensão do arquivo
* @access public static
* @param String $tUrl
* @return void
*/
function getExt($arquivo_nome = '') {
	if(!isset($arquivo_nome)) {
		return false;
	} else {
		return pathinfo($arquivo_nome, PATHINFO_EXTENSION);
	}
}

function getSizeArchive($arquivo='') {
    $tamanhoarquivo = filesize($arquivo);
 
    /* Medidas */
    $medidas = array('kb', 'mb', 'gb', 'tb');
 
    /* Se for menor que 1KB arredonda para 1KB */
    if($tamanhoarquivo < 999){
        $tamanhoarquivo = 1000;
    }
 
    for ($i = 0; $tamanhoarquivo > 999; $i++){
        $tamanhoarquivo /= 1024;
    }
 
    return round($tamanhoarquivo,2) ." ".$medidas[$i - 1];
}
function getHash() {
	return md5(rand(0,1000).date('Y-m-d H:i:s').rand(0,1000));
}

function printr($data = array())
{
	print "<pre>";
	print_r($data);
	print "</pre>";
	die();
}
function slug($name)
{
	return url_title($name, 'dash', TRUE);
}

function zcol($num)
{
	if(!is_par($num)){
		print(' background:#FFFFFF');
	} else {
		print(' ');
	}
}
function is_par($num)
{
	if($num % 2 == 0){
		return true;
	} else {
		return false;
	}
}
function limparString( $cadeia ) {
 $cadeia = trim($cadeia); 
 $cadeia = strtr($cadeia, 
"ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ", 
"aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn"); 
 $cadeia = strtr($cadeia,"ABCDEFGHIJKLMNOPQRSTUVWXYZ","abcdefghijklmnopqrstuvwxyz"); 
 $cadeia = preg_replace('#([^.a-z0-9]+)#i', '-', $cadeia); 
        $cadeia = preg_replace('#-{2,}#','-',$cadeia); 
        $cadeia = preg_replace('#-$#','',$cadeia); 
        $cadeia = preg_replace('#^-#','',$cadeia); 
 return $cadeia; 
     
}

function retiraTagHTML($textoComTag){
	
	return strip_tags($textoComTag, '<(.*?)>');
}


/**
* Função para gerar senhas aleatórias
*
*
* @param integer $tamanho Tamanho da senha a ser gerada
* @param boolean $maiusculas Se terá letras maiúsculas
* @param boolean $numeros Se terá números
* @param boolean $simbolos Se terá símbolos
*
* @return string A senha gerada
*/

function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
{
	$lmin		= 'abcdefghijklmnopqrstuvwxyz';
	$lmai		= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num 		= '1234567890';
	$simb 		= '!@#$%*-';
	$retorno	= '';
	$caracteres	= '';
	
	$caracteres .= $lmin;
	
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;
	if ($simbolos) $caracteres .= $simb;
	
	$len = strlen($caracteres);
	
	for ($n = 1; $n <= $tamanho; $n++) {
		$rand = mt_rand(1, $len);
		$retorno .= $caracteres[$rand-1];
	}
	
	return $retorno;
}
