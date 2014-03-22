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
			dispatch_get('/','index');
			
			dispatch_get('/add','createStudent');
			dispatch_post('/add', 'addStudent');
			
			dispatch_get('/view', 'view');
			dispatch_get('/show','show');
			dispatch_get('/delete','delete');




	/* FUNCTIONS */

		//Index
			function index() {
				return html('index.html');
			}

		// Student Form
			function createStudent() {
				return html('studentForm.html');
			}

		// Add Student to Database
			Function createTest() {
				Student::create(array(	'name'		=>$_POST['inputName'],
										'cohort'	=>$_POST['inputCohort'],
										'address'	=>$_POST['inputAddress'],
										'city'		=>$_POST['inputCity'],
										'telephone'	=>$_POST['inputTelephone'],
										'school'	=>$_POST['inputSchool'],
										'education'	=>$_POST['inputEducation'],
										'visa'		=>$_POST['inputVisa'],
										'veteran'	=>$_POST['inputVeteran'],
										'unixlinux'	=>$_POST['inputUnixLinux'],
										'sql'		=>$_POST['inputSql'],
										'git'		=>$_POST['inputGit'],
										'wordpress'	=>$_POST['inputWordpress'],
										'drupal'	=>$_POST['inputDrupal'],
										'python'	=>$_POST['inputPython'],
										'svn'		=>$_POST['inputSVN'],
										'objectivec'=>$_POST['inputObjectiveC'],
										'rubyrails'	=>$_POST['inputRuby'],
										'c++'		=>$_POST['inputCPlusPlus'],
										'.net'		=>$_POST['inputNet'],
										'php'		=>$_POST['inputPHP'],
										'htmlcss'	=>$_POST['inputHtmlCss'],
										'java'		=>$_POST['inputJava'],
										'javascript'=>$_POST['inputJavascript'],
										'comments'	=>$_POST['comments'])
				);
			}

		//Test Show
			function show() {

				#Retrieve Record from Database
				$student = Student::first();

				#Assign Properties to Variables
				$studentName = $student->name;
				$studentCohort = $student->cohort;

				#Output Information
				echo "Student Name: $studentName".'<br />'."Student Cohort: $studentCohort";
			}

		// Test Delete
			function delete() {
				$student = Student::last();
				$student->delete();
			}

	run();
?>

</html>