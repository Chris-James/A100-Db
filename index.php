<html lang="en">
<head>
	<title>A100 Database Application</title>

</head>

<?php
	
	/* IMPORTS */

		//Limonade Micro Framework
		require_once 'library/limonade.php';

		//PHP Active Record
		require_once 'library/php-activerecord/ActiveRecord.php';



	/* CONFIGURATION */

		//Database
 			ActiveRecord\Config::initialize(function($cfg) {
				$cfg->set_model_directory('models');
				$cfg->set_connections(array('development' => 'mysql://julioa1:plswork@a100.juliomb.com/a100database'));
 			});

		//View Directory
			option('views_dir', dirname(__FILE__). 'views');

		//Routes
			dispatch('/','index');
			dispatch('/create','createRecord');
			dispatch('/add', 'add');
			dispatch('/view', 'view');
			dispatch('/show','show');
			dispatch('/delete','delete');




	/* FUNCTIONS */

		//Index
			function index() {
				return html('index.html');
			}

		//Create Form
			function createRecord() {
				return html('create.html');
			}

		//Add Record to Database
			function add() {
				Student::create(array('name'=>'Max'));
			}

		//Show Record
			function show() {

				#Retrieve Record from Database
				$student = Student::first();

				#Assign Properties to Variables
				$studentName = $student->name;
				$studentCohort = $student->cohort;

				#Output Information
				echo "Student Name: $studentName".'<br />'."Student Cohort: $studentCohort";
			}

			function delete() {
				$student = Student::last();
				$student->delete();
			}

	run();
?>

</html>