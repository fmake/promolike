<?php
class Tester{
	function helloworld($test,$arr){
		echo "hello world!";
		echo $test;
		foreach ($arr as $ar){
			echo $ar."<br />";
		}
	}
}