<?php namespace components\sdk; if(!defined('TX')) die('No direct access.');

class Helpers extends \dependencies\BaseComponent
{
  
  protected
    $default_permission = 2;
  
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
    
    //Define basic sub-folders.
    $subpaths = array(
      'package' => '.package',
      'i18n' => 'i18n',
      'includes' => 'includes',
      'models' => 'models',
      'templates' => 'templates',
      'pagetypes' => 'pagetypes',
      'global' => 'templates'.DS.'global',
      'backend' => 'templates'.DS.'backend',
      'frontend' => 'templates'.DS.'frontend'
    );
    
    $gitignore = array(
      'includes',
      'models',
      'pagetypes',
      'global',
      'backend',
      'frontend'
    );
    
    //Where to copy some template files.
    $copy = array(
      array(null, 'Actions.php'),
      array(null, 'Helpers.php'),
      array(null, 'Json.php'),
      array(null, 'Modules.php'),
      array(null, 'Sections.php'),
      array(null, 'Views.php'),
      array(null, 'README.md'),
      array('package', '.htaccess'),
      array('package', 'package.json'),
      array('i18n', '.htaccess')
    );
    
    //The strings to replace inside template files.
    $replace = array(
      '{{NAME}}' => $data->name->get('string'),
      '{{TITLE}}' => $data->title->get('string')
    );
    
    //Perform the filling of the folder.
    $this->make_it('component', $path, $subpaths, $gitignore, $copy, $replace);
    
    //That should be it!
    return $path;
    
  }
  
  /**
   * Creates a new theme.
   * 
   * @param String $data->name The name of the theme. Should be a valid theme name.
   */
  public function create_theme($data)
  {
    
    //Validate input.
    $data = Data($data)->having('name', 'title')
      ->name->validate('Theme name', array('required', 'string', 'not_empty', 'component_name'))->back()
      ->title->validate('Theme title', array('required', 'string', 'not_empty'))->back();
    
    //What's the path?
    $path = PATH_THEMES.DS.'custom'.DS.$data->name;
    
    //Define basic sub-folders.
    $subpaths = array(
      'package' => '.package',
      'css' => 'css',
      'img' => 'img'
    );
    
    $gitignore = array(
      'img'
    );
    
    //Where to copy some template files.
    $copy = array(
      array(null, 'theme.php'),
      array('css', 'style.css'),
      array('package', '.htaccess'),
      array('package', 'DBUpdates.php'),
      array('package', 'package.json')
    );
    
    //The strings to replace inside template files.
    $replace = array(
      '{{TITLE}}' => $data->title->get('string'),
      '{{NAME}}' => $data->name->get('string')
    );
    
    //Perform the filling of the folder.
    $this->make_it('theme', $path, $subpaths, $gitignore, $copy, $replace);
    
    //That should be it!
    return $path;
    
  }
  
  /**
   * Creates a new template.
   * 
   * @param String $data->name The name of the template. Should be a valid template name.
   */
  public function create_template($data)
  {
    
    //Validate input.
    $data = Data($data)->having('name', 'title')
      ->name->validate('Template name', array('required', 'string', 'not_empty', 'component_name'))->back()
      ->title->validate('Template title', array('required', 'string', 'not_empty'))->back();
    
    //What's the path?
    $path = PATH_TEMPLATES.DS.'custom'.DS.$data->name;
    
    //Define basic sub-folders.
    $subpaths = array(
      'package' => '.package'
    );
    
    $gitignore = array(
    );
    
    //Where to copy some template files.
    $copy = array(
      array(null, 'template.php'),
      array('package', '.htaccess'),
      array('package', 'DBUpdates.php'),
      array('package', 'package.json')
    );
    
    //The strings to replace inside template files.
    $replace = array(
      '{{NAME}}' => $data->name->get('string'),
      '{{TITLE}}' => $data->title->get('string')
    );
    
    //Perform the filling of the folder.
    $this->make_it('template', $path, $subpaths, $gitignore, $copy, $replace);
    
    //That should be it!
    return $path;
    
  }
  
  private function make_it($type, $path, $subpaths, $gitignore, $copy, $replace=array())
  {
    
    //See if it exists.
    if(file_exists($path))
      throw new \exception\Validation('A '.$type.' with that name already exists.');
    
    //Start with the actual folder.
    mkdir($path);
    
    //Create basic sub-folders.
    foreach($subpaths as $key => $subpath){
      
      mkdir($path.DS.$subpath);
      
      if(in_array($key, $gitignore))
        file_put_contents($path.DS.$subpath.DS.'.gitignore', '');
      
    }
    
    foreach($copy as $target){
      
      $tpath = $target[0] && $subpaths[$target[0]] ? $subpaths[$target[0]].DS : '';
      $srcpath = PATH_COMPONENTS.DS.'sdk'.DS.'includes'.DS.$type.'_templates'.DS.$tpath;
      
      $contents = file_get_contents($srcpath.$target[1].'.tmpl');
      foreach($replace as $tag => $value){
        $contents = str_replace($tag, $value, $contents);
      }
      file_put_contents($path.DS.$tpath.$target[1], $contents);
      
    }
    
  }
  
}
