<?php

class Admin extends Controller {

	public $data;

	// add call to require login, then pass control back to parent
	function __construct($controller_path,$web_folder,$default_controller,$default_function)  {
		$this->require_login();
		return parent::__construct($controller_path,$web_folder,$default_controller,$default_function);
	}

	function index() {
    	header('Location: '.myUrl('admin/login', true));
	}

	function login() {

	  $login = false;

	  if( isset($_POST['admin_username']) && $_POST['admin_password']){
		$username=trim($_POST['admin_username']);
		$password=$_POST['admin_password'];
		// check for the entered data
		if($username == $GLOBALS['admin']['username'] && $password == $GLOBALS['admin']['password']){
			$login = true;
		}
	  }

	  if($login == true) {
		$_SESSION['admin']="true";
		header('Location: '.myUrl('', true));
		exit();
	  } else {
		// display login form
		$this->data['body']['admin']= View::do_fetch( getPath('views/admin/login.php'), $this->data);
		
		// display the page
		Template::output($this->data);
	  }

	}

	function logout() {
	  unset($_SESSION['admin']);
	  header('Location: '.myUrl('', true));
	  exit();
	}

	
	function config( $action=null) {

	  if($action == "save" && $GLOBALS['db_pages']){

		$dbh = $GLOBALS['db_pages'];
		$s='';
		foreach($_POST as $k=>$v){
			$sql = 'UPDATE "config" SET "value"="' . $v . '" WHERE "name"="' . $k . '"';
			$results = $dbh->query($sql);
		//echo $sql . "<br />\n";
		}
		header('Location: '.myUrl('main', true));
	  } else {
	  // show the configuration
	  $this->data['body']['admin']=View::do_fetch( getPath('views/admin/config.php'),$this->data);
	  
		// display the page
		Template::output($this->data);
	  }
	}

	/*
	*  CMS Actions
	*/
	function create($path=null) {
		
		$this->data['status']="create";
		$this->data['path']= ( isset($path) ) ? $path : $_POST['path'];
		$this->data['tags']= "";
		$this->data['template']= DEFAULT_TEMPLATE;
		$this->data['admin']=isset($_SESSION['admin']) ? $_SESSION['admin'] : 0;
		$this->data['body']['admin']= View::do_fetch( getPath('views/admin/edit_page.php'), $this->data);

		// display the page
		Template::output($this->data);
	}
	
	function edit($id=null) {

		$page=new Page($id);

		// see if we have found a page
		if( $page->get('id') ){
			// store the information of the page
			$this->data['id'] = $page->get('id');
			$this->data['title'] = stripslashes( $page->get('title') );
			$this->data['content'] = stripslashes( $page->get('content') );
			$this->data['path'] = $page->get('path');
			$this->data['tags'] = $page->get('tags');
			$this->data['template'] = $page->get('template');
			// presentation variables
			$this->data['status']="edit";
			$this->data['view'] = "admin/edit_page.php";
		} else {
			$this->data['status']="error";
			$this->data['view']="admin/error.php";
		}
		// Now render the output
	  	$this->data['body']['admin']= View::do_fetch( getPath('views/'.$this->data['view']), $this->data);
		
		// display the page
		Template::output($this->data);
	}

	function update($id=null) {
		
		$validate = $this->validate();
		// see if we have found a page
		if( $validate == true ){
			$this->save($id);
		}
		header('Location: '.myUrl($_POST['path'], true));

	}
	
	function validate() {
		return true;
	}

	function save($id=null) {

		if( $id ){
			// Update existing page 
			$page=new Page($id);
			$page->set('title', $_POST['title']);
			$page->set('content', $_POST['content']);
			$page->set('tags', $_POST['tags']);
			$page->set('template', $_POST['template']);
			$page->update();
		} else {
			// Create new page 
			$page=new Page();
			$page->set('title', $_POST['title']);
			$page->set('content', $_POST['content']);
			$page->set('tags', $_POST['tags']);
			$page->set('template', $_POST['template']);
			$page->set('path', $_POST['path']);
			$page->create();
		}
	}
	
	function delete($id=null) {

		if( $id ){
			$page=new Page($id);
			$page->delete();
		} 
		header('Location: '.myUrl('', true));
	}

}
?>