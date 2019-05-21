<?php
/*
 @main class
*/

class Page {

    protected   $args = array();
    protected   $params;
    protected   $config;
    public      $PageData=array();
    protected   $settings=array();
    public      $ViewTemplate=true;
    protected   $Class;
    protected   $action;

    function __construct($config=null,$params=null)
    {
        $this->params=$params;
        $this->args=$this->getUri();
        $this->lang=$this->args['lang'];
        $this->config=$config;
    }

    function getContent()
    {
        $this->Class=$this->args['class'];
        $this->method=(($this->args['method']=='index')?'initialize':$this->args['method']);
        $Class = new $this->Class($this->config,$this->args['params']);
        if (in_array($this->method,get_class_methods($this->Class)))
        {
            $data = $Class->{$this->method}();
            if ($Class->GetViewTemplate()){
                $PageData=$Class->getPageData();
                $PageData['Class']= $this->Class;
                $PageData['method']=$this->method;
                require_once APP_PATH_VIEWS.$this->Class.'/'.$this->method.'.tpl';
            } else {
                header('Content-Type:application/json');
                header('X-Robots-Tag : none, notranslate');
                if (is_string($data)) {
                    echo $data;
                } else {
                    echo json_encode($data);
                }
            }
        }
        else
        {
            Logs($this->Class."\t". $this->method);
            header('Location:'.SERVER_NAME.'/'.LANG.'/Index/error');
        }
    }

    /*
     * @return parameters passed through URL
     */
    function getParams()
    {
      return $this->params;
    }

    /*
     * @return parsing parameters passed through URL
     */
    protected function forward($uri)
    {
        $uriParts = explode('/', trim($uri, '/\\'));
        $params = array_slice($uriParts, 3);
        return array(
                    'lang'=>(!file_exists(APP_PATH . 'app/Locale/'.$uriParts[0]))?getLang():$uriParts[0],
                    'class' => (empty($uriParts[1]))?'Index':$uriParts[1],
                    'method' => (!empty($uriParts[2]))?$uriParts[2]:'initialize',
                    'params' => (!empty($params))?$params:null,
                );
    }

    /*
     * @get parameter $_GET['_url']
     */
    protected function getUri()
    {
        $route = $_GET['_url'];
        return $this->forward($route);
    }

    function setPageData($name,$value)
    {
        $this->PageData[$name] = $value;
    }

    function initPageData($data)
    {
         foreach ($data as $key => $value) {
            $this->setPageData($key, $value);
        }
    }

    function getDataFromFile($fileName=null)
    {
        return file_get_contents(APP_PATH_DATA.$fileName);
    }

    function getPageData()
    {
        return $this->PageData;
    }

    function SetViewDisable()
    {
        $this->ViewTemplate=false;
    }

    function GetViewTemplate()
    {
        return $this->ViewTemplate;
    }

    function getClassData($classname)
    {
        return include(APP_PATH_LOCALE.$this->lang.'/'.$classname.'PageData.php');
    }

    function getLangArg()
    {
        return $this->args['lang'];
    }

    function getPostDataJson()
    {
        $str = file_get_contents('php://input');
        $data=json_decode($str,true);
        return $data;
    }

    function getPostData()
    {
        $_POST = array_map(function($value){
            if(is_string($value)){
                return htmlspecialchars($value,ENT_QUOTES, "UTF-8");
            }
            return $value;
        }, $_POST);
        return $_POST;
    }

    function is_session_started()
    {
        return session_status() === PHP_SESSION_ACTIVE ? true : false;
    }

    function SessionStart() {
        $params = session_get_cookie_params();
        setcookie("PHPSESSID", session_id(), 0, $params["path"], $params["domain"], false, true );
    }

    function SessionDestroy()
    {
        session_destroy();
    }
}
