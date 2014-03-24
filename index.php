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
		  #  set_model_directory is required by ActiveRecord.
		  #  set_connections method initializes connection to database.
		  #  ... => 'database-type://username:password@database-address/database-name'

 			ActiveRecord\Config::initialize(function($cfg) {
				$cfg->set_model_directory('models');
				$cfg->set_connections(array('development' => 'mysql://julioa1:plswork@a100.juliomb.com/a100database'));
 			});

		# B. Views Directory
 		  #  Tells app to look for HTML files in the directory named 'views'
 		  #  UNNECESSARY??
			option('views_dir', dirname(__FILE__). 'views');

		# C. Routes
		  #  In ('URL','FunctionName') format
		  #  Tells the app: When 'URL' is visited run code contained in 'FunctionName'.

			dispatch_get('/','index');
			dispatch_post('/', 'index_post');
			
			dispatch_get('/add','createNewApprentice');
			dispatch_post('/add', 'addApprentice');
			
			dispatch_get('/view', 'view');
			dispatch_get('/show','show');
			dispatch_get('/delete','delete');




	## FUNCTIONS  ________________________________________________________________

		# A. Index
			
			function index() {

				# @param partnerMenu is an array of all Partner Company records in database.
				# Used to display the company names in our drop-down menu.
				# Could be refactored to only retrieve Name column from records.
				# If refactored currentPartner must also be refactored since it requires a complete record object.

				$partnerMenu = allPartnersAscending();
				
				# @param currentPartner determines which partner company we are displaying in the table.
				$currentPartner = $partnerMenu[0];
				
				# @param skillsArray is an array of all skills required by given Partner company.
				$skillsArray = getCompanySkills($currentPartner);
				
				# @param apprenticeArray is an array of all Apprentice records database.
				$apprenticeArray = Apprentice::all();
				//$interestArray = getInterests($apprenticeArray);

				//$test = new h2o('views/test.html');
				//echo $test->render(compact('interestArray'));
				$index = new h2o('views/index.html');
				echo $index->render(compact('partnerMenu','currentPartner','skillsArray','apprenticeArray'));
			}

			function index_post() {
				$partnerMenu = allPartnersAscending();

				# @param currentPartner is set to whichever company was chosen from the drop-drown menu.
				$currentPartner = Partner::find_by_name($_POST['inputCompany']);

				$skillsArray = getCompanySkills($currentPartner);
				$apprenticeArray = Apprentice::all();
				
				$index = new h2o('views/index.html');
				echo $index->render(compact('partnerMenu','currentPartner','skillsArray','apprenticeArray'));
			}

		# B. Apprentice Form

			function createNewApprentice() {
				return html('apprenticeForm.html');
			}

		# C. Add Apprentice to Database

			function addApprentice() {
				Apprentice::create(array('name'		=>	$_POST['inputName'],
										'cohort'	=>	$_POST['inputCohort'],
										'address'	=>	$_POST['inputAddress'],
										'city'		=>	$_POST['inputCity'],
										'telephone'	=>	$_POST['inputTelephone'],
										'school'	=>	$_POST['inputSchool'],
										'education'	=>	$_POST['inputEducation'],
										'visa'		=>	$_POST['inputVisa'],
										'veteran'	=>	$_POST['inputVeteran'],
										'unixlinux'	=>	$_POST['inputUnixLinux'],
										'sql'		=>	$_POST['inputSql'],
										'git'		=>	$_POST['inputGit'],
										'wordpress'	=>	$_POST['inputWordpress'],
										'drupal'	=>	$_POST['inputDrupal'],
										'python'	=>	$_POST['inputPython'],
										'svn'		=>	$_POST['inputSVN'],
										'objectivec'=>	$_POST['inputObjectiveC'],
										'rubyrails'	=>	$_POST['inputRuby'],
										'c++'		=>	$_POST['inputCPlusPlus'],
										'.net'		=>	$_POST['inputNet'],
										'php'		=>	$_POST['inputPHP'],
										'htmlcss'	=>	$_POST['inputHtmlCss'],
										'java'		=>	$_POST['inputJava'],
										'javascript'=>	$_POST['inputJavascript'],
										'comments'	=>	$_POST['comments'])
				);
			}

		## HELPERS ______________________________________

			function allPartnersAscending() {
				return Partner::find('all', array('order'=>'name Asc'));
			}

			function getCompanySkills($record) {
				$skills = array();
				if ($record->unix_linux == 1)	{ $skills['Unix/Linux'] = 1; }
				if ($record->sql == 1)			{ $skills['SQL'] = 1; }
				if ($record->git == 1)			{ $skills['Git'] = 1; }
				if ($record->wordpress == 1)	{ $skills['WordPress'] = 1; }
				if ($record->drupal == 1)		{ $skills['Drupal'] = 1; }
				if ($record->python == 1)		{ $skills['Python'] = 1; }
				if ($record->svn == 1)			{ $skills['SVN'] = 1; }
				if ($record->objective_c == 1)	{ $skills['Objective-C'] = 1; }
				if ($record->ruby_rails == 1)	{ $skills['Ruby/Rails'] = 1; }
				if ($record->c_plusplus == 1)	{ $skills['C++'] = 1; }
				if ($record->dot_net == 1)		{ $skills['.Net'] = 1; }
				if ($record->php == 1)			{ $skills['PHP'] = 1; }
				if ($record->html_css == 1)		{ $skills['HTML/CSS'] = 1; }
				if ($record->java == 1)			{ $skills['Java'] = 1; }
				if ($record->javascript == 1)	{ $skills['Javascript'] = 1; }
				
				return $skills;
			}

			/*function getInterests($apprenticeArray) {
					$interests = array();
					foreach($apprenticeArray as $apprentice) {
						$interests[$apprentice->name] = array($apprentice->interest1, $apprentice->interest2, $apprentice->interest3);
					}
					return $interests;
				}*/

	run();
?>

</html>