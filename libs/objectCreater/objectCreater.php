<?php
/*
 * Создание объектов во всей системе (фабрка)
 * 
 * */

	class objectCreater{
		static $startPathSearcher = 1;
		static $endPathSearcher = 1;
		/*
		 * установка директорий которые будут прослушиваться, для подключения классов
		 * выставляем spl_autoload_call
		 */
		static function setDirPaths(){
			set_include_path(
				get_include_path().ROOT.DIRECTORY_SEPARATOR.PATH_SEPARATOR
				.ROOT.DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.PATH_SEPARATOR
				.ROOT.DIRECTORY_SEPARATOR.'modules'.DIRECTORY_SEPARATOR.PATH_SEPARATOR
				.ROOT.DIRECTORY_SEPARATOR.'calculating'.DIRECTORY_SEPARATOR
			);	
			
			ini_set('unserialize_callback_func', 'spl_autoload_call');
        	spl_autoload_register(array(new self, 'createObj'));
			//размер уже установленных патчей, чтобы не смотреть в лишних директориях
			objectCreater::$endPathSearcher = sizeof(explode(PATH_SEPARATOR, get_include_path())) - 1;
				
		}
		
		/*
		 * создание объекта
		 * @param string name ия класса
		 */
		static function createObj($name){
			
			//выкачиваем все патхи
			$paths = explode(PATH_SEPARATOR, get_include_path());
			//заменяем _ на / для того что бы загрузить вспомогательные классы в папке
			$name = str_replace('_', '/', $name);
			//бежимся только по раннее установленным путям
			for( $i=objectCreater::$startPathSearcher; $i <= objectCreater::$endPathSearcher;$i++){
				//добавляем путь для класса
				$paths[$i] .= $name.DIRECTORY_SEPARATOR;
				
			}
			
			objectCreater::add_include_path($paths,$name);
			require $name . ".php";
		}
		
		static function add_include_path ($paths,$name){
		    foreach ($paths AS $path)
		    {
		        if ( !file_exists($path) OR (file_exists($path) && filetype($path) !== 'dir') )
		        {
		            //trigger_error("Include path '{$path}' not exists", E_USER_WARNING);
		            continue;
		        }
		       
		        $paths = explode(PATH_SEPARATOR, get_include_path());
		       
		        if (array_search($path, $paths) === false)
		            array_push($paths, $path);
		       
		        set_include_path(implode(PATH_SEPARATOR, $paths));
		    }
		}
	
		static function remove_include_path ($path){
			
		    foreach (func_get_args() AS $path)
		    {
		        $paths = explode(PATH_SEPARATOR, get_include_path());
		       
		        if (($k = array_search($path, $paths)) !== false)
		            unset($paths[$k]);
		        else
		            continue;
		       
		        if (!count($paths))
		        {
		            //trigger_error("Include path '{$path}' can not be removed because it is the only", E_USER_NOTICE);
		            continue;
		        }
		       
		        set_include_path(implode(PATH_SEPARATOR, $paths));
		    }
		}
		
		
		
		
		
	}

	
?>