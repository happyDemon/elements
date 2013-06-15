# Navbar

After [setting up](examples) your navigation config file and your routes you'd want to start rendering your nav bar.

## Controller

	<?php
		class Controller_Tracker extends Controller {
			public function before() {
				parent::before();
				$this->view = View::factory('test/nav');
				$this->view->navbar = Element::('example')->render('Menu', 'bootstrap/navbar');
				$this->view->breadcrumb = Element::('example');
			}

			public function action_issues_recent() {
				//for example set the last breadcrumb item's text
				$this->view->breadcrumb->last_item('Recent issues');
			}
			public function after() {
				$this->response->body($this->view->render());
			}
		}

## View

		<?=$breadcrumb->render('Breadcrumb', 'bootstrap');?>