<?php namespace components\sdk\models; if(!defined('TX')) die('No direct access.');

class TranslationMissingFiles extends \dependencies\BaseModel
{
  
  protected static
    
    $table_name = 'sdk__translation__missing_files';
  
  public function register($data)
  {
    
    //Validate input. Mostly to help programmers implement this properly.
    try{
      $data = Data($data)->having('language_code', 'component')
        ->language_code->validate('Language code', array('required', 'string', 'not_empty', 'between'=>array(4, 10)), false)->back()
        ->component->validate('Component name', array('string', 'between'=>array(0,255)), false)->back();
    }
    
    //Don't crash this request just because we can't record problems.
    catch(\exception\Validation $vex){
      
      tx('Logging')->log('SDK', 'Registration error', 'Tried to register TranslationMissingFiles, but a validation error occurred. '.$vex->getMessage());
      
      //Return empty handed.
      return $this;
      
    }
    
    //Validate the component even exists in this installation (no hoax entries please).
    if(!$data->component->is_empty() && !tx('Component')->available($data->component))
      return $this;
    
    //First store the basic data we have.
    $this->merge($data->having('language_code', 'component'));
    
    //Then store the current time of registration.
    $this->merge(array(
      'dt_last_registered' => date('Y-m-d H:i:s')
    ));
    
    //If we have the update component, try to get version information for this component.
    if(tx('Component')->available('update')){
      
      $that = $this;
      
      tx('Component')
        ->helpers('update')
        ->_call('get_component_package', array($data->component))
        
        //Found a package in the update component.
        ->is('set', function($package)use($that){
          
          //Store the version info we want.
          $that->merge(array(
            'component_version' => $package->installed_version
          ));
          
        });
        
    }
    
    //Register it.
    return $this->save();
    
  }
  
}
