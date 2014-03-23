<?php

class Employer extends ActiveRecord\Model {

	#============#
	# DEPRECATED #
	#============#

	public static $table_name = "employers";
	public static $primary_key = "name";

	public static $name = "name";
	public static $address = "address";
	public static $city = "city";
	public static $telephone = "telephone";
	
	//Skillset
	public static $unixLinux = "unixlinux";
	public static $sql = "sql";
	public static $git = "git";
	public static $wordpress = "wordpress";
	public static $drupal = "drupal";
	public static $python = "python";
	public static $svn = "svn";
	public static $objectiveC = "objectivec";
	public static $rubyRails = "rubyrails";
	public static $cPlusPlus = "c++";
	public static $net = ".net";
	public static $php = "php";
	public static $htmlCss = "htmlcss";
	public static $java = "java";
	public static $javascript = "javascript";

	public static $comments = "comments";

}