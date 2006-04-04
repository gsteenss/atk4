<?
/*
 * This object enables many advanced actions only possible with using AJAX technology.
 *
 * You would need a compliant browser too.
 *
 * In order to use this module do $ajax = $this->add('Ajax');
 */

class Ajax extends AbstractModel {
    public $api;
    public $owner;


    private $form;

    public $ajax_output="";

    public $spinner = null;

    function ajaxFlush(){
        // Now, since we are returning AJAX stuff, we don't need to render anything.
        if($this->ajax_output){
            echo $this->ajax_output;
            exit;
        }
    }
    function getString(){
        if($this->spinner)$this->ajaxFunc("spinner_off('".$this->spinner."')");
        $s=$this->ajax_output;
        $this->ajax_output="";
        return $s;
    }


    function ajaxFunc($func_call){
        $this->ajax_output.="$func_call;\n";
        return $this;
    }
    function redirect($page,$args=array()){
        return $this->redirectURL($this->api->getDestinationURL($page,$args));
    }
    function redirectURL($url){
        $this->ajaxFunc("document.location='".$url."'");
    }
    function loadRegionURL($region_id,$url){
        $this->ajaxFunc("aasn('$region_id','$url')");
        return $this;
    }
    function reloadRegion($region_id,$args=array()){
		$args=array_merge(array('cut_region'=>$region_id),$args);
		$url=$this->api->getDestinationURL(null,$args);
		return $this->loadRegionURL($region_id,$url);
    }
    function loadFieldValue($field_id,$url){
        $this->ajaxFunc("aasv('$field_id','$url')");
        return $this;
    }
    function notImplemented($msg){
        $this->ajaxFunc("alert('not implemented: $msg')");
    }
    function closeExpander($lister){
        $page=preg_replace('/.*_/','',$this->api->page());
        $id=$_GET['id'];
        //$this->ajaxFunc("expander_flip('".$lister->name
    }

    // form specific fnuctions
    function withForm($form){
        // associates this class with form class
        $this->form=$form;
        return $this;
    }
    function reloadField($fld){
        $this->notImplemented("reloadField");
    }
    function submit($button='default'){
        $this->notImplemented('submit');
    }

    function displayFormError($fld,$message){
        $this->ajaxFunc("alert('$field: $message')");
        return $this;
    }
    function displayAlert($msg){
        $this->ajaxFunc("alert('$msg')");
        return $this;
    }
    function useProgressIndicator($id){
        $this->spinner=$id;
        $this->ajaxFunc("spinner_on('$id')");
        return $this;
    }



}
