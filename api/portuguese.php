<?php
	namespace Ai2i\Api;

	Class Portuguese 
	{
		public static $_pronomesRelativos = ['o que', 'por quê', 'por que', 'porque', 'onde', 'quem', 'quando', 'como', 'quanto'];
		public static $_verbos            = ['corre', 'anda', 'caminha', 'ama', 'gosta', 'curti', 'tem', 'quer', 'deseja', 'precisa', 'mora', 'vai', 'está', 'é'];
		public static $_adjetivos         = ['amarelo', 'preto', 'vermelho', 'azul', 'verde', 'bonito', 'feio', 'orrível', 'lindo', 'mais', 'menos', 'muito', 'pouco', 'feliz', 'triste'];
		public static $_substantivos      = ['carro', 'pessoa', 'menino', 'menina', 'homem', 'mulher', 'cachorro', 'gato', 'celular', 'google', 'android', 'casa', 'apartamento'];
		public static $_artigos           = ['o', 'a', 'os', 'as', 'um', 'uma', 'uns', 'umas'];
		public static $_adverbios         = ['também', 'aqui', 'ali', 'lá', 'logo'];
		public static $_not               = 'não';

		public static $_errorReply = [
			0 => 'Não escutei, estou meio surdo hoje.', 
			1 => 'Sabe aquela hora que te dá um branco?',
			2 => 'Estou muito estranho, pode repetir?',
			3 => 'Não estou legal, pode repetir?',
			4 => 'Poxa não entendi, pode repetir?',
		];

		public static $_dontNowReply = [
			0 => 'Poxa vida, eu não sei.', 
			1 => 'Eu realemnte não sei.',
			2 => 'Não faço a mínima ideia.',
			3 => 'Eu não sei.',
			4 => 'Não sei te responder.',
		];

		public static $_okReply = [
			0 => 'Ok.', 
			1 => 'Certo.',
			2 => 'Entendi.',
		];

		public static $_goodReply = [
			0 => 'Que bom!', 
			1 => 'Que legal!',
			2 => 'Que ótimo!',
			3 => 'Que maravilha!',
			4 => 'Perfeito!',
		];

		public static $_sorryReply = [
			0 => 'Que ruim.', 
			3 => 'Que pena.',
			1 => 'Puxa.',
			2 => 'Lamento.',
			4 => 'Nossa.',
		];

	}