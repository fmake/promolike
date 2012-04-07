<?php
class xmlParser{
	
	function fileXmlToArray($path){
		$data = file_get_contents($path);
		//printAr(@simplexml_load_string($data));
		return $this->objectsIntoArray(@simplexml_load_string($data));
	}
	
	function xmlToArray($data){
		return $this->objectsIntoArray(@simplexml_load_string($data));
	}
	
	function objectsIntoArray($arrObjData, $arrSkipIndices = array()){
	    $arrData = array();
	   
	    if (is_object($arrObjData)) {
	        $arrObjData = get_object_vars($arrObjData);
	    }
	   
	    if (is_array($arrObjData)) {
	        foreach ($arrObjData as $index => $value) {
	            if (is_object($value) || is_array($value)) {
	                $value = $this->objectsIntoArray($value, $arrSkipIndices);
	            }
	            if (in_array($index, $arrSkipIndices)) {
	                continue;
	            }
	            $arrData[$index] = $value;
	        }
	    }
	    return $arrData;
	}
	
}