<?php namespace components\sdk; if(!defined('TX')) die('No direct access.');

class Views extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
    );
  
  protected function sdk_dashboard()
  {
    
    return array(
      'menu' => array(
        'notifications' => __($this->component, 'Notifications', true),
        'component_create' => __($this->component, 'New component', true),
        'theme_create' => __($this->component, 'New theme', true),
        'template_create' => __($this->component, 'New template', true),
        'string_replace' => __($this->component, 'Replace string', true),
        'package_json' => __($this->component, 'package.json', true)
      ),
      'content' => $this->section('notifications')
    );
    
  }
  
}
