<?php namespace components\sdk; if(!defined('TX')) die('No direct access.');

class Helpers extends \dependencies\BaseComponent
{
  
  /**
   * Creates a new component.
   * 
   * @param String $data->name The name of the component. Should be a valid component name.
   */
  public function create_component($data)
  {
    
    //Validate input.
    $data = Data($data)->having('name', 'title')
      ->name->validate('Component name', array('required', 'string', 'not_empty', 'component_name'))->back()
      ->title->validate('Component title', array('required', 'string', 'not_empty'))->back();
    
    //What's the path?
    $path = PATH_COMPONENTS.DS.$data->name;
    
    //See if it exists.
    if(file_exists($path))
      throw new \exception\Validation('A component with that name already exists.');
    
    //Start with the actual folder.
    mkdir($path);
    
    //Define basic sub-folders.
    $subpaths = array(
      'package' => '.package',
      'i18n' => 'i18n',
      'includes' => 'includes',
      'models' => 'models',
      'templates' => 'templates',
      'global' => 'templates'.DS.'global',
      'backend' => 'templates'.DS.'backend',
      'frontend' => 'templates'.DS.'frontend'
    );
    
    $gitignore = array(
      'includes',
      'models',
      'global',
      'backend',
      'frontend'
    );
    
    //Create basic sub-folders.
    foreach($subpaths as $key => $subpath){
      
      mkdir($path.DS.$subpath);
      
      if(in_array($key, $gitignore))
        file_put_contents($path.DS.$subpath.DS.'.gitignore', '');
      
    }
    
    //Where to copy some template files.
    $copy = array(
      array(null, 'Actions.php'),
      array(null, 'Helpers.php'),
      array(null, 'Json.php'),
      array(null, 'Modules.php'),
      array(null, 'Sections.php'),
      array(null, 'Views.php'),
      array(null, 'README.md'),
      array('package', 'package.json'),
      array('i18n', '.htaccess')
    );
    
    foreach($copy as $target){
      
      $tpath = $target[0] && $subpaths[$target[0]] ? $subpaths[$target[0]].DS : '';
      $srcpath = PATH_COMPONENTS.DS.'sdk'.DS.'includes'.DS.'component_templates'.DS.$tpath;
      
      $contents = file_get_contents($srcpath.$target[1].'.tmpl');
      $contents = str_replace('{{NAME}}', $data->name->get('string'), $contents);
      $contents = str_replace('{{TITLE}}', $data->title->get('string'), $contents);
      file_put_contents($path.DS.$tpath.$target[1], $contents);
      
    }
    
    //That should be it!
    return $path;
    
  }
  
}
