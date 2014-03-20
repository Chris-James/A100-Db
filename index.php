<html lang="en">
<head>
	<title>A100 Apprentice Database</title>

</head>

<?php
	
	/* IMPORTS */

		//Limonade Micro Framework
		require_once 'library/limonade.php';

		//PHP Active Record
		require_once 'library/php-activerecord/ActiveRecord.php';



	/* CONTROLLERS */

		//Database
			ActiveRecord\Config::initialize(function($cfg) {
				$cfg->set_model_directory('models');
				$cfg->set_connections(array('development' => 'sqlite://a100'));
 			});

		//View Directory
			option('views_dir', dirname(__FILE__). 'views');

		//Routes
			dispatch('/add', 'add');
			dispatch('/view', 'view');
			dispatch('/show','show');
			dispatch('/delete','delete');




	/* FUNCTIONS */

		//Add Record to Database
			function add() {
				Student::create(array('studentName'=>'Max', 'java'=>'3', 'python'=>'1', 'html'=>'0'));
			}
		
		//View Front-End
			function view() {
				return html('index.html');
			}

		//Show Record
			function show() {

				#Retrieve Record from Database
				$student = Student::first();

				#Assign Properties to Variables
				$studentName = $student->studentname;
				$studentId = $student->studentid;

				#Output Information
				echo "Student Name: $studentName".'<br />'."Student ID: $studentId";
			}

			function delete() {
				$student = Student::first();
				$student->delete();
			}


	run();
?>

</html>