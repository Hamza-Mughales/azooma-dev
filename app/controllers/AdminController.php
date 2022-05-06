<?php
class AdminController extends BaseController {
	

	function __construct() {
		$this->beforeFilter('admin-user');
	}

}