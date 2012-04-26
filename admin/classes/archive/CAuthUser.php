<?

class TUser{
   protected $pLogin;                                                          // �����
   protected $pPassword;                                                       // ������

   protected $pAccess;                                                         // ����������
   protected $pInfo;                                                           // �������������� ����������
   
   
   /* ************************** */
   /* ������� ��������� �������� */
   /* ************************** */
  
   function set($login, $password){
      $this->pLogin = $login;
      $this->pPassword = $password;
   }
   
   // ��������� ���� �������
   function setAccess($parameter, $access){
      $this->pAccess[$parameter] = $access;
   }

   // ��������� �������������� ���������� 
   function setInfo($parameter, $value){
      $this->pInfo[$parameter] = $value;
   }

   /* ************************* */
   /* ������� ������ ���������� */
   /* ************************* */

   // ����� �������
   final function getAccess($parameter){
      return $this->pAccess[$parameter];
   }

   // �������������� ����������
   final function getInfo($parameter=""){
      if ($parameter=="") { return $this->pInfo; }
      else { return $this->pInfo[$parameter]; }
   } 
   final function getLogin()         { return $this->pLogin;            }      // �����
   final function getPassword()      { return $this->pPassword;         }      // ������
}


/**/


class CAuthUser extends TUser{
   protected $pStatus;                                                         // ������ "������� ������".    
   protected $pType;														   // ��� "������� ������".
   /* ************************** */
   /* ������� ��������� �������� */
   /* ************************** */
   
   function  __construct($type){
      session_start();
      $this->pType = $type;
      $this->pStatus = FALSE;
   }   
   
   // �������� ���������� ���������� ���������� � "������������
   function load(){
      $this->pLogin = @$_SESSION['pLogin'];                                    // �����
      $this->pPassword = @$_SESSION['pPassword'];                              // ������  
      $this->pAccess = @$_SESSION['pAccess'];                                  // ����������
      $this->pInfo = @$_SESSION['pInfo'];                                      // �������������� ����������
      $this->pType = @$_SESSION['pType'];
      
      
      if ($this->pLogin != ""){
         $this->pStatus = TRUE;
      }

      return $this->pStatus;
   }

   function setType($type) {
	  $this->pType = $type;
   }

   // ���������� ���������� ���������� ���������� � "������������
   function save(){
      $_SESSION['pLogin'] =    $this->pLogin;                                  // �����
      $_SESSION['pPassword'] = $this->pPassword;                               // ������  
      $_SESSION['pAccess'] =   $this->pAccess;                                 // ����������
      $_SESSION['pInfo'] =     $this->pInfo;                                   // �������������� ����������
      $_SESSION['pType'] = 	   $this->pType;
      $this->pStatus = TRUE;
   }
   
   // �������� ���������� ���������� ���������� � "������������"
   function clear(){
      unset($_SESSION['pLogin']);                                              // �����
      unset($_SESSION['pPassword']);                                           // ������  
      unset($_SESSION['pAccess']);                                             // ����������
      unset($_SESSION['pInfo']);                                               // �������������� ����������
      unset($_SESSION['pType']);
      $this->pStatus = FALSE;
   }
   
   /* ************************* */
   /* ������� ������ ���������� */
   /* ************************* */

   final function getStatus($type)        { return ($this->pStatus && (($this->pType == $type)? true:false));           }      // ������
   
}

?>
