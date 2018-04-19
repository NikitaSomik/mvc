<?php 

ini_set('display_errors', 1);// вкл вывод ошибок на экран
error_reporting(E_ALL);// это говорит, то что буду выводить все ошибки: error. warning и обычные notice

function debug($str) {
	echo '<pre>', var_dump($str), '<pre>';
	exit;
}