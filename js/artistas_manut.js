
function refreshTabela(){
	$.ajax({
        type: 'POST',
        url: '../php/artistas_manut.php',
        data: {funcao: "refreshTabela"},
        success: function (data) {
                $("#content").empty();
                $("#content").append(data);
				
				$("#tabela tr").on("click", function(){ 
					if(!$(this).hasClass('notSelectable')){
						if($(this).hasClass('selected')){
							$(this).removeClass('selected');
						} else{
							$(".selected").removeClass('selected');
							$(this).addClass('selected');
						}
					}
				});
				
				$('#add').on('click', function(){
					manutLinha('f');
				});
				
				$('#update').on('click', function(){
					var id = $('.selected').attr('id');
					if(id != null && id.length != 0){
						manutLinha(id);
					}
				});
				
				$('#hide').on('click', function(){
					var id = $('.selected').attr('id');
					if(id != null && id.length != 0){
						hideDados(id);
					}else
				});
				
        }
    });
}

function manutLinha(pId){
	$.ajax({
        type: 'POST',
        url: '../php/artistas_manut.php',
        data: {funcao: 'manutLinha', dados: pId},
        success: function (data) {
                $("#content").empty();
                $("#content").append(data);
				
				$('#save').on('click', function(){
					var nome = $('#nome').val();
					var nomeArtistico = $('#nomeArtistico').val();
					var idade = $('#idade').val();
					guardarDados(pId, nome, nomeArtistico, idade);
				});	
				
				$('#back').on('click', function(){
					refreshTabela();
				});
        }
    });
	
	
}

function guardarDados(pId, pNome, pNomeArtistico, pIdade){
	$.ajax({
        type: 'POST',
        url: '../php/artistas_manut.php',
        data: {funcao: 'save', id: pId, nome: pNome, nomeArtistico: pNomeArtistico, idade: pIdade},
        success: function (data) {
            refreshTabela();		
			
        }
    });
}

function hideDados(pId){
	$.ajax({
        type: 'POST',
        url: '../php/artistas_manut.php',
        data: {funcao: 'hide', id: pId},
        success: function (data) {
            refreshTabela();
				
        }
    });
}







