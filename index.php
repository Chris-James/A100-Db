<html lang="en">

<?php
	
	## IMPORTS  __________________________________________________________________

		# A. Limonade
		  #  A PHP micro framework.
		  #  Facilitates the use of MVC structure.
		  #  @link https://github.com/sofadesign/limonade

			require_once 'library/limonade.php';

		# B. php-activerecord
		  #  A PHP implementation of the Active Record ORM.
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

		# B. Routes
		  
 			option('base_uri', '/');

		  #  In ('URL','FunctionName') format
		  #  Tells the app: When 'URL' is visited run code contained in 'FunctionName'.

			dispatch_get('/','index');
			dispatch_post('/', 'index_post');
		
			dispatch_get('/addApprentice','createApprentice');
			dispatch_post('/addApprentice', 'addApprentice');

			dispatch_get('/apprentice/*', 'showApprentice');
			dispatch_post('/apprentice/*', 'editApprentice');

			dispatch_get('/addCompany','createCompany');
			dispatch_post('/addCompany', 'addCompany');

			dispatch_get('/company/*', 'showCompany');
			dispatch_post('/company/*', 'editCompany');



	## FUNCTIONS  ________________________________________________________________

		# A. Index Functions
			
			# A.1 Display Index

				function index() {

					# @param partnerMenu is an array containing all Partner Company records in database.
					# Used to display the company names in our drop-down menu.
					# Could be refactored to only retrieve Name column from records.
					# If refactored currentPartner must also be refactored since it requires a complete record object.

					$partnerMenu = allPartnersAscending();
					
					# @param currentPartner determines which partner company we are displaying in the table.
					$currentPartner = $partnerMenu[0];
					
					# @param skillsArray is an array of all skills required by given Partner company.
					$skillsArray = getCompanySkills($currentPartner);
					
					# @param apprenticeArray is an array containing all Apprentice records in database.
					$apprenticeArray = Apprentice::all();

					# h2o calls 'table.html'.
					# Since 'table.html' inherits from 'base.html' the application will automatically load 'base.html' as well.
					$index = new h2o('views/table.html');
					echo $index->render(compact('partnerMenu','currentPartner','skillsArray','apprenticeArray'));
				}

			# A.2 Change Company

				function index_post() {
					$partnerMenu = allPartnersAscending();

					# @param currentPartner is set to whichever company was chosen from the drop-drown menu.
					$currentPartner = Partner::find_by_name($_POST['inputCompany']);

					$skillsArray = getCompanySkills($currentPartner);
					$apprenticeArray = Apprentice::all();
					
					$index = new h2o('views/table.html');
					echo $index->render(compact('partnerMenu','currentPartner','skillsArray','apprenticeArray'));
				}

		# B. Apprentice Functions

			# B.1 Display Add Apprentice Form

				function createApprentice() {
					$addForm = new h2o('views/addApprentice.html');
					echo $addForm->render();
				}

			# B.2 Add New Apprentice Record

				function addApprentice() {
						Apprentice::create(array('name'			  =>	$_POST['inputName'],
												 'cohort'		  =>	$_POST['inputCohort'],
												 'address'		  =>	$_POST['inputAddress'],
												 'city'			  =>	$_POST['inputCity'],
												 'telephone'	  =>	$_POST['inputTelephone'],
												 'school'		  =>	$_POST['inputSchool'],
												 'graduation'	  =>	$_POST['inputGraduation'],
												 'workexperience' =>	$_POST['inputWorkExperience'],
												 'visa'			  =>	$_POST['inputVisa'],
												 'veteran'		  =>	$_POST['inputVeteran'],
												 'unix_linux'	  =>	$_POST['inputUnixLinux'],
												 'sql'			  =>	$_POST['inputSql'],
												 'git'			  =>	$_POST['inputGit'],
												 'wordpress'	  =>	$_POST['inputWordpress'],
												 'drupal'		  =>	$_POST['inputDrupal'],
												 'python'		  =>	$_POST['inputPython'],
												 'svn'			  =>	$_POST['inputSVN'],
												 'objective_c'	  =>	$_POST['inputObjectiveC'],
												 'ruby_rails'	  =>	$_POST['inputRuby'],
												 'c_plusplus'	  =>	$_POST['inputCPlusPlus'],
												 'dot_net'		  =>	$_POST['inputNet'],
												 'php'			  =>	$_POST['inputPHP'],
												 'html_css'		  =>	$_POST['inputHtmlCss'],
												 'java'			  =>	$_POST['inputJava'],
												 'javascript'	  =>	$_POST['inputJavascript'],
												 'comments'		  =>	$_POST['inputComments'],
												 'email'		  =>	$POST['inputEmail'])
					);
					$success = new h2o('views/happySuccess.html');
					echo $success->render();
				}

			# B.3 Display Edit Apprentice Form

				function showApprentice() {
					$apprentice = Apprentice::find_by_name(params(0));
					
					$editForm = new h2o('views/editApprentice.html');
					echo $editForm->render(compact('apprentice'));
				}

			# B.4 Edit Apprentice Record
				function editApprentice() {
					if ($_POST['updateDelete'] == 'update') {
						$apprentice = Apprentice::find_by_name($_POST['inputName']);
						$apprentice->update_attributes(array('name'			  =>	$_POST['inputName'],
															 'cohort'		  =>	$_POST['inputCohort'],
															 'address'		  =>	$_POST['inputAddress'],
															 'city'			  =>	$_POST['inputCity'],
															 'telephone'	  =>	$_POST['inputTelephone'],
															 'school'		  =>	$_POST['inputSchool'],
															 'graduation'	  =>	$_POST['inputGraduation'],
															 'workexperience' =>	$_POST['inputWorkExperience'],
															 'visa'			  =>	$_POST['inputVisa'],
															 'veteran'		  =>	$_POST['inputVeteran'],
															 'unix_linux'	  =>	$_POST['inputUnixLinux'],
															 'sql'			  =>	$_POST['inputSql'],
															 'git'			  =>	$_POST['inputGit'],
															 'wordpress'	  =>	$_POST['inputWordpress'],
															 'drupal'		  =>	$_POST['inputDrupal'],
															 'python'		  =>	$_POST['inputPython'],
															 'svn'			  =>	$_POST['inputSVN'],
															 'objective_c'	  =>	$_POST['inputObjectiveC'],
															 'ruby_rails'	  =>	$_POST['inputRuby'],
															 'c_plusplus'	  =>	$_POST['inputCPlusPlus'],
															 'dot_net'		  =>	$_POST['inputNet'],
															 'php'			  =>	$_POST['inputPHP'],
															 'html_css'		  =>	$_POST['inputHtmlCss'],
															 'java'			  =>	$_POST['inputJava'],
															 'javascript'	  =>	$_POST['inputJavascript'],
															 'comments'		  =>	$_POST['inputComments'],
															 'email'		  =>	$_POST['inputEmail'])
						);
					} else if ($_POST['updateDelete'] == 'delete') {
						echo "We will delete now.";
						//$apprentice = Apprentice::find_by_name($_POST['inputName']);
						//$apprentice->delete();
					}

					$success = new h2o('views/happySuccess.html');
					echo $success->render();
				}

		
		# C. Partner Company Functions

			# C.1 Display Add Company Form

				function createCompany() {
					$addForm = new h2o('views/addCompany.html');
					echo $addForm->render();
				}

			# C.2 Add New Company Record
				function addCompany() {
					Partner::create(array(  'name'		  =>	$_POST['inputName'],
											'city'		  =>	$_POST['inputCity'],
											'unix_linux'  =>	$_POST['inputUnixLinux'],
											'sql'		  =>	$_POST['inputSql'],
											'git'		  =>	$_POST['inputGit'],
											'wordpress'	  =>	$_POST['inputWordpress'],
											'drupal'	  =>	$_POST['inputDrupal'],
											'python'	  =>	$_POST['inputPython'],
											'svn'		  =>	$_POST['inputSVN'],
											'objective_c' =>	$_POST['inputObjectiveC'],
											'ruby_rails'  =>	$_POST['inputRuby'],
											'c_plusplus'  =>	$_POST['inputCPlusPlus'],
											'dot_net'	  =>	$_POST['inputNet'],
											'php'		  =>	$_POST['inputPHP'],
											'html_css'	  =>	$_POST['inputHtmlCss'],
											'java'		  =>	$_POST['inputJava'],
											'javascript'  =>	$_POST['inputJavascript'],
											'comments'	  =>	$_POST['inputComments'])
					);
					$success = new h2o('views/happySuccess.html');
					echo $success->render();
				}

			# C.3 Display Company Edit Form

				function showCompany() {
					$company = Partner::find_by_name(params(0));

					$editForm = new h2o('views/editCompany.html');
					echo $editForm->render(compact('company'));
				}
			
			# C.4 Edit Company Record
				function editCompany() {
					$company = Partner::find_by_name(params(0));
					$company->update_attributes(array('name'		  =>	$_POST['inputName'],
												 	  'city'		  =>	$_POST['inputCity'],
													  'unix_linux'	  =>	$_POST['inputUnixLinux'],
													  'sql'			  =>	$_POST['inputSql'],
													  'git'			  =>	$_POST['inputGit'],
													  'wordpress'	  =>	$_POST['inputWordpress'],
													  'drupal'		  =>	$_POST['inputDrupal'],
													  'python'		  =>	$_POST['inputPython'],
													  'svn'			  =>	$_POST['inputSVN'],
													  'objective_c'	  =>	$_POST['inputObjectiveC'],
													  'ruby_rails'	  =>	$_POST['inputRuby'],
													  'c_plusplus'	  =>	$_POST['inputCPlusPlus'],
													  'dot_net'		  =>	$_POST['inputNet'],
													  'php'			  =>	$_POST['inputPHP'],
													  'html_css'	  =>	$_POST['inputHtmlCss'],
													  'java'		  =>	$_POST['inputJava'],
													  'javascript'	  =>	$_POST['inputJavascript'],
													  'comments'	  =>	$_POST['inputComments'])
				);

				$success = new h2o('views/happySuccess.html');
				echo $success->render();
				}


		## HELPERS ______________________________________

			# A. Database
			
				function allPartnersAscending() {

					/* Returns all partner companies in database in alphabetical order. */

					return Partner::find('all', array('order'=>'name Asc'));
				}

				function allApprenticesAscending() {

					/* Returns all partner companies in database in alphabetical order. */

					return Apprentice::find('all', array('order'=>'name Asc'));
				}
				

				function getCompanySkills($record) {

					/* @return an associate array of all skills marked important by partner company.
					 * @param $record Partner Company record object.
					 * Used by index.html to determine which skills columns to include in table. */

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

			# B. Templates

				h2o::addFilter('stripSpaces');
				function stripSpaces($string) {
					return preg_replace('/\s+/', '-', $string);
				}

				h2o::addFilter('lineBreaks');
				function lineBreaks($string) {
					return preg_replace('/\s\s+/', '/[\n]/', $string);
				}

	run();
?>

</html>