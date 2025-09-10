<?php
	namespace Ai2i\Api;

	use Lidiun\Database;
	use Lidiun\Request;
	use Ai2i\Api\Portuguese;

	Class Language 
	{
		public $user;

		private $frase;
		private $words;
		private $ask;
		private $reply;

		private $pronomesRelativos;
		
		private $error;

		// SET FRASE
		public function setFrase($frase){
			$this->frase = trim(strtolower($frase));
		}

		// VERIFY USER
		public function verifyUser(){
			if (empty($_SESSION['memory']['name']) || strstr(strtolower($this->frase), 'meu nome é') || strstr(strtolower($this->frase), 'eu me chamo')) {
				$nome = explode(' ', strtolower($this->frase));
				foreach ($nome as $key => $value) {
					if ($value == 'eu' || $value == 'me' || $value == 'chamo' || $value == 'meu' || $value == 'nome' || $value == 'é' || $value == 'o' || $value == 'sou') {
						unset($nome[$key]);
					}
				}

				if (!empty($nome)) {
					$_SESSION['memory']['name'] = ucwords(implode($nome, ' '));
				} else {
					$_SESSION['memory']['name'] = 'Anônimo';
				}

				$this->reply = "Fale-me mais sobre você ".$_SESSION['memory']['name'].".";
			} else if (strstr(strtolower($this->frase), 'tchau')) {
				unset($_SESSION['memory']);
				echo json_encode(['refresh' => Request::$_url['site']]); 
				exit();
			}

			$this->user = $_SESSION['memory']['name'];
		}


		// VERIFY ASK
		public function verifyMemory(){
			$lastFrase = (!empty($_SESSION['memory']['lastFrase'])) ? $_SESSION['memory']['lastFrase']: false;
			$frase = str_replace('.', '', $this->frase);
			$frase = str_replace('!', '', $frase);

			if (!empty($_SESSION['memory']['offset'])) {
				if ($frase == "sim") {
					$this->frase = $_SESSION['memory']['lastFrase'];
				} else {
					unset($_SESSION['memory']['offset']);
				}
			}

			if ($frase == "esqueça o que disse" || $frase == "esqueça o que eu disse" || $frase == "esqueça o que falei" || $frase == "esqueça o que eu falei") {
				if ($lastFrase) {
					$this->forgetFrase($lastFrase);
					$this->reply = "Ok ".$this->user."... <br>Já Esqueci.";
				} else {
					$this->reply = "Não há do que esquecer";
				}
			}
		}

		// VERIFY ASK
		public function verifyAsk(){
			if (empty($this->reply)) {
				$ask = false;

				$this->getWords($this->frase, true);
				foreach ($this->words as $word) {
					if (in_array($word, Portuguese::$_pronomesRelativos)) {
						$ask = true;
					}
				}

				$this->ask = $ask;
				return $this->ask;
			}
		}

		// SET GRAMMA
		public function setGramma(){
			foreach ($this->words as $key => $word) {
				if (in_array($word, Portuguese::$_pronomesRelativos)) {
					unset($this->words[$key]);
				} else if (in_array($word, Portuguese::$_artigos)) {
					unset($this->words[$key]);
				}
			}
		}

		// SET ASK TYPE
		public function setReply(){
			$find = implode($this->words, ' ');
			$this->createReply($find);
		}

		// THINK A LITTLE BIT
		public function think(){
			return true;
		}

		// TREAT FRASE
		public function treatFrase(){
			$this->getWords($this->frase);
		}

		// WRITE IN MEMORY
		public function writeInMemory(){
			if (empty($this->reply)) {
				if (count($this->words) > 1) {
					$frase        = implode(' ', $this->words);
					$refere       = strtolower($this->user);
					$confiability = 50;

					$data = $this->fraseExists();
					if (!$data) {
						$query = "
							INSERT INTO memory (frase, refere, confiability) VALUES('".$frase."', '".$refere."', ".$confiability.")
						";
						if (!Database::query($query)) {
							$this->error = Portuguese::$_errorReply[rand(0,(count(Portuguese::$_errorReply) - 1))];
						}
					}
				}
			}
		}

		// GET REPLY
		public function getReply(){
			$_SESSION['memory']['lastFrase'] = $this->frase;

			if ($this->error) {
				return $this->error;
			} else if ($this->ask) {
				return $this->reply;
			} else {
				if ($this->reply) {
					return $this->reply;
				} else {
					if ($this->isGood()) {
						return Portuguese::$_goodReply[rand(0, (count(Portuguese::$_goodReply) - 1) )];
					} else if($this->isBad()) {
						return Portuguese::$_sorryReply[rand(0, (count(Portuguese::$_sorryReply) - 1) )];
					} else {
						return Portuguese::$_okReply[rand(0, (count(Portuguese::$_okReply) - 1) )];
					}
				}
			}
		}

		##################################################################################
		##################################################################################
		##################################################################################

		private function isGood() {
			return true;
			
			foreach ($this->words as $word) {
				$frase[] = "+".$word;
			}

			$frase = implode($frase, ' ');
			$frase .= " +é +(certo)";
			if ($this->fraseSimilar($frase)) {
				return true;
			} else {
				return false;
			}
		}
		
		private function isBad() {
			return true;

			foreach ($this->words as $word) {
				$frase[] = "+".$word;
			}

			$frase = implode($frase, ' ');
			$frase .= " +é +(errado)";
			if ($this->fraseSimilar($frase)) {
				return true;
			} else {
				return false;
			}
		}

		private function getWords($frase, $treat=false){
			$frase = str_replace(',', ' , ', $frase);
			$frase = str_replace('  ', ' ', $frase);
			
			$words = explode(' ', $frase);
			foreach ($words as $key => $word) {
				if ($treat) {
					$word = str_replace('?', '', $word);
					$word = str_replace('!', '', $word);
					$word = str_replace('.', '', $word);
					$word = str_replace('...', '', $word);
				}

				if ($word == 'eu') {
					$word = strtolower($this->user);
				}

				if ($word == 'sou') {
					$word = 'é';
				}

				$words[$key] = $word;
			}

			$this->words = $words;
		}

		private function createReply($findTo){
			$offset = (!empty($_SESSION['memory']['offset'])) ? $_SESSION['memory']['offset'] : 0;
			$limit  = 2;

			// SELECT frase FROM memory WHERE MATCH(frase) AGAINST('+".$findTo." -(".Portuguese::$_not." ".$findTo.")' IN BOOLEAN MODE);
			$query = "
				SELECT COUNT(id) AS count FROM memory WHERE frase LIKE '%".$findTo."%' AND frase NOT LIKE '%".Portuguese::$_not." ".$findTo."%'
			";
			$rows = Database::query($query, 'object');
			$numRows = (!empty($rows[0]->count)) ? $rows[0]->count: 0;
			if (!empty($numRows)) {
				$query = "
					SELECT frase FROM memory WHERE frase LIKE '%".$findTo."%' AND frase NOT LIKE '%".Portuguese::$_not." ".$findTo."%' LIMIT ".$limit." OFFSET ".$offset."
				";
				$result = Database::query($query, 'object');
				foreach ($result as $data) {
					$frases[] = $data->frase;
				}

				if ($numRows > $limit && $numRows > ($offset + $limit)) {
					$offset += $limit;
					$_SESSION['memory']['offset'] = $offset;

					$more = (($numRows - $offset) >= $limit) ? ".<br>Você quer mais ".$limit." de ".$numRows." respostas?": ".<br>Você quer mais ".($numRows - $offset)." de ".$numRows." respostas?";
				} else {
					unset($_SESSION['memory']['offset']);
					$more = ".";
				}

				$reply = implode($frases, ' e ') . $more;
				$words = explode(' ', $reply);
				foreach ($words as $key => $word) {
					if (in_array($word, Portuguese::$_adverbios)) {
						unset($words[$key]);
					}
				}
				$this->reply = implode($words, ' ');
			} else {
				$this->reply = Portuguese::$_dontNowReply[rand(0,(count(Portuguese::$_dontNowReply) - 1))];
			}
		}

		private function forgetFrase($lastFrase){
			$query = "
				DELETE FROM memory WHERE frase = '".$lastFrase."'
			";
			Database::query($query);
		}

		private function fraseExists($frase=null){
			if (empty($frase)) {			
				foreach ($this->words as $word) {
					$frase[] = "+".$word;
				}

				$frase = implode($frase, ' ');
			}

			$query = "
				SELECT id FROM memory 
				WHERE MATCH(frase) AGAINST('".$frase."' IN BOOLEAN MODE)
			";
			return Database::query($query, 'num_rows');
		}

		private function fraseSimilar($frase=null){
			if (empty($frase)) {			
				foreach ($this->words as $word) {
					$frase[] = "+".$word;
				}

				$frase = implode($frase, ' ');
			}

			$query = "
				SELECT frase, MATCH(frase) AGAINST('".$frase."' IN BOOLEAN MODE) AS score FROM memory 
				WHERE MATCH(frase) AGAINST('".$frase."' IN BOOLEAN MODE)
				ORDER BY score DESC
			";
			return Database::query($query, 'object');
		}
	}