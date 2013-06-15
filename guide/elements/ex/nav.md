# Navbar

After [setting up](examples) your navigation config file and your routes you'd want to start rendering your nav bar.

## Controller

	<?php

		public function action_index() {
			$view = View::factory('test/nav');
			$view->navbar = Element::('example')->render('Menu', 'bootstrap/navbar');
			$this->response->body($view->render());
		}

## View

		<div class="navbar navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<?=$navbar;?>
				</div>
			</div>
		</div>