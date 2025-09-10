<?php
	use Lidiun\Render;
	use Ai2i\Api\Language;

	Class Ihm
	{

		public function __construct() {
			if (!empty($_POST["frase"])) {
				// Start Language Class
				$Language = new Language();
				
				// Set Frase
				$Language->setFrase($_POST['frase']);

				// Verify user
				$Language->verifyUser();

				// Verify memory
				$Language->verifyMemory();

				if ($Language->verifyAsk()) {
					$Language->setGramma();
					$Language->setReply();
					$Language->think();
					$reply = $Language->getReply();
				} else {
					$Language->treatFrase();
					$Language->writeInMemory();
					$reply = $Language->getReply();
				}


				Render::setReply(["reply" => $reply, 'user' => $Language->user]);
			}			
		}
	}