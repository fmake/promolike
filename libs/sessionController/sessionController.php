<?php

/*
 * работа с сессией
 */
class sessionController{
	/**
	 * стартуем сессию
	 */
	function __construct(){
		session_start();
	}
}