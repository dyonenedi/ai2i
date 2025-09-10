<?php
	use Lidiun\Layout;

	Class Ihm
	{
		public function __construct() {
			Layout::setTitle('IHM');
			Layout::addJs('main.js');

			if (!empty($_SESSION['memory']['name'])) {
				$name = $_SESSION['memory']['name'];
				$aksName = '';
			} else {
				$name = 'Anônimo';
				$aksName = '<div class="block"><b class="font blue">AI2I:&nbsp;</b><span class="font gray">Olá, Como você se chama?</span></div>';
			}

			Layout::replaceContent('user_name', ucwords($name));
			Layout::replaceContent('ask_name', $aksName);
		}
	}