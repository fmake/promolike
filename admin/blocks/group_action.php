<?php
	$group_action_val = array(
		'g_active' => 'Включить',
		'g_non_active'=> 'Выключить',
		'g_invert_active'=>'Инвертировать активность'
	);
	
	//действия с кнопок
	switch (true){
		case $request->delall:
			$absitem->truncateTable();
		break;
		case $request->delmarked:
			
			$ccount = sizeof($_POST['check_action']);
			for($i=0;$i<$ccount;$i++){
				$absitem->setId($_POST['check_action'][$i]);
				$absitem->delete();
			}
		break;
		//остальные действия
		default:
			switch ($request->group_action){
				case 'g_active':
					$ccount = sizeof($_POST['check_action']);
					for($i=0;$i<$ccount;$i++){
						$absitem->setId($_POST['check_action'][$i]);
						$absitem->status_active(true);
					}
				break;
				case 'g_non_active':
					$ccount = sizeof($_POST['check_action']);
					for($i=0;$i<$ccount;$i++){
						$absitem->setId($_POST['check_action'][$i]);
						$absitem->status_active();
					}
				break;
				case 'g_invert_active':
					$ccount = sizeof($_POST['check_action']);
					for($i=0;$i<$ccount;$i++){
						$absitem->setId($_POST['check_action'][$i]);
						$absitem->active();
					}
				break;
			}
		break;
	}
	
	
	
	
	$absitem->setId(false);
	$absitem->setId($request->id);
	?>