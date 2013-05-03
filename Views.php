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
        'notifications' => 'Notifications',
        'component_create' => 'New component',
        'theme_create' => 'New theme',
        'template_create' => 'New template',
        'package_json' => 'package.json'
      ),
      'content' => $this->section('notifications')
    );
    
  }
  
}
