var fraseTmp = [];
var i = -1;

var myBlock        = '<div class="block"><b class="font blue">AI2I:&nbsp;</b><span class="font gray">#text#</span></div>';
var yourBlock      = '<div class="block"><b class="font green">#user#:&nbsp;</b><span class="font white">#text#</span></div>';
var yourBlockType  = '<div class="block"><b class="font green">#user#:&nbsp;</b><input class="font" type="text" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false"></div>';

var help = ''
	+'Faça perguntas simples e curtas.<br>'
	+'Use a gramática da maneira mais correta possível.<br>'
	+'Para respostas use apenas "sim" ou "não".<br>'
	+'Para se apresentar digite "eu me chamo" ou "meu nom é" e seu nome em seguida.<br>'
	+'Use as cetas "para cima" e "para baixo" para navegar entre o histórico digitado.<br>'
	+'Digite "tchau" para sair ou recomeçar uma conversa.<br>'
	+'Digite "clear" para limpar a tela.<br>'
	+'Não minta para mim, confio em você.<br>'
	+'Reporte erros ou bugs à dyonenedi@hotmail.com.<br>'
;

function sendFrase(frase){
	$.ajax({
		type: "POST",
		url: "/web/",					
		async: true,
		cache: false,
		dataType: "json",
		timeout:8000,
		data: {'render':'ihm', 'frase':frase},
		success: function(data){
			runReturn(data,frase);
		},
		error: function(){
			console.log("Error in connection");
		}
	});
}

function runReturn(data,frase){
	if (data != undefined && data) {
		if (data.reply != undefined) {
			user = data.user;
			var block1 = myBlock.replace('#text#', data.reply);
			var block2 = yourBlockType.replace('#user#', user);
			
			$("section").append(block1);
			$("section").append(block2);
			inputFocus();
		} else if (data.refresh != undefined) {
			document.location.href = data.refresh;
		} else {
			console.log("No data.reply return");
			
			var block1 = myBlock.replace('#text#', 'Ops, eu estou me sentindo confuso.');
			var block2 = yourBlockType.replace('#user#', user);
			
			$("section").append(block1);
			$("section").append(block2);
			inputFocus();
		}
	} else {
		console.log("No data return");
		
		var block1 = myBlock.replace('#text#', 'Ops, eu estou me sentindo confuso.');
		var block2 = yourBlockType.replace('#user#', user);
		
		$("section").append(block1);
		$("section").append(block2);
		inputFocus();
	}
}

function inputFocus(){
	$("input").focus();
}

$(window).on("load resize", function(){  
	var screenHeight = $(window).height();
	$("section").css("min-height",screenHeight);
});

$(document).ready(function(){  
	inputFocus();
	
	$(document).on("click", "html", function(){
		inputFocus();
	});

	$(document).on("keyup", "input",function(e){
		var tecla = (e.keyCode?e.keyCode:e.which);
		
		if (tecla == 13 && e.originalEvent.shiftKey == false) {
			i = -1;
			var frase = $(this).val();
			frase = $.trim(frase);
			if (frase != "") {
				if (fraseTmp.length == 50) {
					$.each(fraseTmp,function(index,value){
						if (index != 0) {
							fraseTmp[index-1] = value;
						}
					});
					fraseTmp[fraseTmp.length-1] = frase;
				} else {
					fraseTmp.push(frase);
				}
				
				if (frase == "clear") { 
					var block = yourBlockType.replace('#user#', user);
					$("section").html("");
					$("section").append(block);
					inputFocus();
				} else if (frase == "help") {
					var block = yourBlock.replace('#text#', frase);
					block = block.replace('#user#', user);
					$(this).parent().parent().append(block);
					$(this).parent().remove();

					var block1 = myBlock.replace('#text#', help);
					var block2 = yourBlockType.replace('#user#', user);
					
					$("section").append(block1);
					$("section").append(block2);
				} else {
					var block = yourBlock.replace('#text#', frase);
					block = block.replace('#user#', user);
					$(this).parent().parent().append(block);
					$(this).parent().remove();
					sendFrase(frase);
				}
			}
		} else if ((tecla == 38 || tecla == 40) && e.originalEvent.shiftKey == false) {
			if (tecla == 40) {
				if (i == -1) {

				} else if (i == 0) {
					$(this).val(fraseTmp[fraseTmp.length - (i+1)]);
				} else if (i < fraseTmp.length){
					i--;
					$(this).val(fraseTmp[fraseTmp.length - (i+1)]);
				}
			} else {
				if (fraseTmp.length == i+1){
					$(this).val(fraseTmp[fraseTmp.length - i - 1]);
				} else if (fraseTmp.length > i) {
					i++;
					$(this).val(fraseTmp[fraseTmp.length - i - 1]);
				}
			}
		}
	});
});