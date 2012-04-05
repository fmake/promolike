<?

class TUser{
   protected $pLogin;                                                          // Логин
   protected $pPassword;                                                       // Пароль

   protected $pAccess;                                                         // Привилегии
   protected $pInfo;                                                           // Дополнительная информация
   
   
   /* ************************** */
   /* Функции установки значений */
   /* ************************** */
  
   function set($login, $password){
      $this->pLogin = $login;
      $this->pPassword = $password;
   }
   
   // Устанивка прав доступа
   function setAccess($parameter, $access){
      $this->pAccess[$parameter] = $access;
   }

   // Установка дополнительных параметров 
   function setInfo($parameter, $value){
      $this->pInfo[$parameter] = $value;
   }

   /* ************************* */
   /* Функции чнения информации */
   /* ************************* */

   // права доступа
   final function getAccess($parameter){
      return $this->pAccess[$parameter];
   }

   // Дополнительная информация
   final function getInfo($parameter=""){
      if ($parameter=="") { return $this->pInfo; }
      else { return $this->pInfo[$parameter]; }
   } 
   final function getLogin()         { return $this->pLogin;            }      // Логин
   final function getPassword()      { return $this->pPassword;         }      // Пароль
}


/**/


class CAuthUser extends TUser{
   protected $pStatus;                                                         // Статус "Учетной записи".    
   protected $pType;														   // Тип "Учетной записи".
   /* ************************** */
   /* Функции установки значений */
   /* ************************** */
   
   function  __construct($type){
      session_start();
      $this->pType = $type;
      $this->pStatus = FALSE;
   }   
   
   // Загрузка переменных содержащих информацию о "Пользователе
   function load(){
      $this->pLogin = @$_SESSION['pLogin'];                                    // Логин
      $this->pPassword = @$_SESSION['pPassword'];                              // Пароль  
      $this->pAccess = @$_SESSION['pAccess'];                                  // Привилегии
      $this->pInfo = @$_SESSION['pInfo'];                                      // Дополнительная информация
      $this->pType = @$_SESSION['pType'];
      
      
      if ($this->pLogin != ""){
         $this->pStatus = TRUE;
      }

      return $this->pStatus;
   }

   function setType($type) {
	  $this->pType = $type;
   }

   // Сохранение переменных содержащих информацию о "Пользователе
   function save(){
      $_SESSION['pLogin'] =    $this->pLogin;                                  // Логин
      $_SESSION['pPassword'] = $this->pPassword;                               // Пароль  
      $_SESSION['pAccess'] =   $this->pAccess;                                 // Привилегии
      $_SESSION['pInfo'] =     $this->pInfo;                                   // Дополнительная информация
      $_SESSION['pType'] = 	   $this->pType;
      $this->pStatus = TRUE;
   }
   
   // Удаление переменных содержащих информацию о "Пользователе"
   function clear(){
      unset($_SESSION['pLogin']);                                              // Логин
      unset($_SESSION['pPassword']);                                           // Пароль  
      unset($_SESSION['pAccess']);                                             // Привилегии
      unset($_SESSION['pInfo']);                                               // Дополнительная информация
      unset($_SESSION['pType']);
      $this->pStatus = FALSE;
   }
   
   /* ************************* */
   /* Функции чнения информации */
   /* ************************* */

   final function getStatus($type)        { return ($this->pStatus && (($this->pType == $type)? true:false));           }      // Статус
   
}

?>
