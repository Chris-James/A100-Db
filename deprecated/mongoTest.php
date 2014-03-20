<?php

	$user = array(
		'first_name'	=> 'MongoDB',
		'last_name'		=> 'Fan',
		'tags'			=> array('developer','user')
	);

	$dbhost = 'localhost';
	$dbname = 'test';

	$m = new MongoClient("mongodb://$dbhost");
	$db = $m->$dbname;

	$c_users = $db->users;

	$c_users->save($user);


?>