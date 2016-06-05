<?php

class Controller_Adminka extends Controller
{
	function __construct()
	{
		// $this->model = new Model_adminka();
		$this->view = new View();
	}

	function action_index()
	{	
		$this->view->generate(null, 'admin_view.php');
	}
}