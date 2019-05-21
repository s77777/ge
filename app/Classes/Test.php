<?php
if (php_sapi_name()!=='cli') header('Location:'.SERVER_NAME.'/'.LANG.'/Index/error');

require_once 'OutConsole.php';

class Test extends Page {

    use OutConsole;

    private $IndexPageData;

    function initialize()
    {
        $this->SetViewDisable();
        $this->IndexPageData=$this->getClassData('Index');
        $this->IndexPageData['fileName']=$this->config['fileName'];
        $this->IndexPageData['Chart']=$this->config['Chart'];
        $this->initPageData($this->IndexPageData);
        $this->outConsole($this->PageData,'PageData');
        exit();
    }

    function getDataFromFile($filename=null)
    {
        $this->SetViewDisable();
        $filename=($filename==null)?$this->params[0]:$filename;
        $this->outConsole($filename);
        $this->outConsole($this->forward($_GET['_url']),'Parsing URL');
        $this->outConsole(parent::getDataFromFile($filename),'getDataFromFile');
        $this->outConsole(null,'end');
        exit();
    }

    function saveGraphConfig()
    {
        $this->SetViewDisable();
        $data=['name'=>'chart','conf'=>['test'=>'test']];
        $f = fopen(APP_PATH_DATA .$data['name'].'.conf', 'w');
        $res=fputs($f, json_encode($data));
        $this->outConsole($res,'Res');
        if ($res) {
            $this->outConsole(['succes'=>true,'msg'=>'Successful write to file']);
        } else {
            $this->outConsole(['succes'=>false,'msg'=>'An error occurred while writing to the file.']);
        }
        fclose($f);
        exit();
    }
}
