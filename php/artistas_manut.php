<?php

require_once ('../config/database.php');

function getDados(){
	$db = new Database();
	$db->query("SELECT id, nome, nomeArtistico, idade FROM info WHERE visivel = 1");
	$array = $db->getAll();
	
	return $array;
}

function getDadosById($pId){
	$db = new Database();
	$db->query("SELECT nome, nomeArtistico, idade FROM info WHERE id =".$pId." AND visivel = 1");
	$row = $db->getRow();
	
	return $row;
}

function addDados($pNome, $pNomeArtistico, $pIdade){
	$db = new Database();
	$db->query("INSERT INTO info (nome, nomeArtistico, idade) VALUES ('".$pNome."', '".$pNomeArtistico."', ".$pIdade.")");
	$db->execute();
	$db->disconnect();
}

function updateDados($pId, $pNome, $pNomeArtistico, $pIdade){	

	$db = new Database();
	$db->query("UPDATE info SET nome='".$pNome."', nomeArtistico='".$pNomeArtistico."', idade='".$pIdade."' WHERE id='".$pId."'");
	$db->execute();
	$db->disconnect();
}

function hideDados ($pId){ 
	$db = new Database();
	$db->query("UPDATE info SET visivel=0 WHERE id=?");
	$db->bind(0, $pId, PDO::PARAM_INT);
	$db->execute();
	$db->disconnect();
}

function criarTabela(){
	
	$dados = getDados();
	
	$html= "<table id='tabela'>"
			."<tr class='notSelectable' >"
				."<th>Nome</th>"
				."<th>Nome Artistico</th>"
				."<th>Idade</th>"
			."</tr>";
	
	for($i= 0; $i < count($dados); $i++){
		$html = $html
			."<tr id= '".$dados[$i]['id']."'>"
				."<td >".$dados[$i]['nome']."</td>"
				."<td >".$dados[$i]['nomeArtistico']."</td>"
				."<td >".$dados[$i]['idade']."</td>"
			."</tr>";
	}
	
	$html = $html 
		."</table>"
		."<div>"
		.	"<button id='add'>Adicionar Linha</button>"
		.	"<button id='update'>Modificar Linha Selecionada</button>"
		.	"<button id='hide'>Apagar Linha Selecionada</button>"
		."</div>";
	
	return $html;
	
}

function manutLinha($pId){
	$dados['nome']= "";
	$dados['nomeArtistico']= "";
	$dados['idade']= "";
	
	if ($pId != 'f'){
		$dados = getDadosById($pId);
	}

	$html= "<table id='tabela'>"
			."<tr class='notSelectable' >"
				."<th>Nome</th>"
				."<th>Nome Artistico</th>"
				."<th>Idade</th>"
			."</tr>"
			."<tr class='notSelectable' >"
				."<td> <input id='nome' type='text' value='".$dados['nome']."'> </th>"
				."<td> <input id='nomeArtistico' type='text' value='".$dados['nomeArtistico']."'> </th>"
				."<td> <input id='idade' type='text' value='".$dados['idade']."'> </th>"
			."</tr>"
		."</table>"
		."<div>"
		.	"<button id='save'>Guardar</button>"
		.	"<button id='back'>Voltar</button>"
		."</div>";
	
	return $html;

}

function saveDados($pId, $pNome, $pNomeArtistico, $pIdade){
	
	
	if ($pId == 'f'){
		addDados($pNome, $pNomeArtistico, $pIdade);
	}else{
		updateDados($pId, $pNome, $pNomeArtistico, $pIdade);
	}
	
}

if (isset($_POST['funcao'])){
	$funcao = $_POST['funcao'];
	
	switch ($funcao){
		case "refreshTabela": {echo criarTabela(); break;}
		case "manutLinha": {echo manutLinha($_POST['dados']); break;}
		case "save": { saveDados($_POST['id'], $_POST['nome'], $_POST['nomeArtistico'], $_POST['idade']); break;}
		case "hide": {hideDados($_POST['id']); break;}
	}
}
























?>