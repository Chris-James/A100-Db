<html lang="en">
<head>
	<title>A100 Database Application</title>

</head>

<?php
	
	## IMPORTS  __________________________________________________________________

		# A. Limonade
		  #  A PHP micro framework.
		  #  Facilitates the use of MVC structure.
		  #  @link https://github.com/sofadesign/limonade

			require_once 'library/limonade.php';

		# B. php-activerecord
		  #	 A PHP implementation of the Active Record ORM.
		  #  Simplifies interactions with the database.
		  #  @link http://www.phpactiverecord.org

			require_once 'library/php-activerecord/ActiveRecord.php';

		# C. h2o
		  #  PHP template engine inspired by Django, Smarty, Jinja style engines.
		  #  @link http://www.h2o-template.org

			require 'library/h2o/h2o.php';



	## CONFIGURATIONS  ___________________________________________________________

		# A. Database
		  #  set_model_directory ...
		  #  set_connections method initializes connection to database.
		  #  ... => 'database-type://username:password@database-address/database-name'

 			ActiveRecord\Config::initialize(function($cfg) {
				$cfg->set_model_directory('models');
				$cfg->set_connections(array('development' => 'mysql://julioa1:plswork@a100.juliomb.com/a100database'));
 			});

		# B. Views Directory
 		  #  Tells app to look for HTML files in the directory named 'views'
 		  # UNNECESSARY??
			option('views_dir', dirname(__FILE__). 'views');

		# C. Routes
		  #  ...

			dispatch_get('/','index');
			
			dispatch_get('/add','createStudent');
			dispatch_post('/add', 'addStudent');
			
			dispatch_get('/view', 'view');
			dispatch_get('/show','show');
			dispatch_get('/delete','delete');




	## FUNCTIONS  ________________________________________________________________

		# A. Index
			
			function index() {
				$index = new h2o('views/index.html');

				echo $index->render();
			}

		# B. Student Form

			function createStudent() {
				return html('studentForm.html');
			}

		# C. Add Student to Database

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

				#Assign Properties to An Array
				$info = array(
					'name' => $student->name,
					'cohort' => $student->cohort
				);

				#Output Information via h2o
				$output = new h2o('views/templateTest.html');
				echo $output->render(compact('info'));

			}

		// Test Delete
			function delete() {
				$student = Student::last();
				$student->delete();
			}

	run();
?>

</html>