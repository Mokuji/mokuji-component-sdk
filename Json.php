<?php namespace components\sdk; if(!defined('TX')) die('No direct access.');

class Json extends \dependencies\BaseComponent
{
  
  protected function create_component($data, $params)
  {
    
    return tx('Sql')
      ->model('sdk', 'Component')
      ->set($data)
      
      ->validate_model(array(
        'force_create' => true,
      ))
      
      ->is('set', function($com){
        
        $com->merge(array(
          'path' => tx('Component')->helpers('sdk')->call('create_component', $com->having('name', 'title'))
        ));
        
      });
    
  }
  
}
