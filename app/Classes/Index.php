<?php


class Index extends Page {

    private $IndexPageData;

    function initialize()
    {
        $this->IndexPageData=$this->getClassData(get_class($this));
        $this->IndexPageData['fileName']=$this->config['fileName'];
        $this->IndexPageData['Chart']=$this->config['Chart'];
        $this->initPageData($this->IndexPageData);
    }

    function getDataFromFile($filename=null)
    {
        $this->SetViewDisable();
        $filename=($filename==null)?$this->params:$filename;
        return parent::getDataFromFile($filename[0]);
    }

    function saveGraphConfig()
    {
        $this->SetViewDisable();
        $data=$this->getPostDataJson();
        $f = fopen(APP_PATH_DATA .$data['name'].'.conf', 'w');
        if (fputs($f, json_encode($data['conf']))) {
            fclose($f);
            return ['succes'=>true,'msg'=>'Successful write to file'];
        } else {
            fclose($f);
            return ['succes'=>false,'msg'=>'An error occurred while writing to the file.'];
        }
        
    }
    
    function error()
    {
        $this->initialize();
    }
}
