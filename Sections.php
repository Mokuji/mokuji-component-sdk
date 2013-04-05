<?php namespace components\sdk; if(!defined('TX')) die('No direct access.');

class Sections extends \dependencies\BaseViews
{
  
  protected function notifications()
  {
    
    $notifs = Data();
    
    //Untranslated files.
    tx('Sql')
      ->table('sdk', 'TranslationMissingFiles')
      ->order('dt_last_registered', 'DESC')
      ->execute()
      ->each(function($missing)use($notifs){
        $notifs->push(array(
          'icons' => 'alert',
          'message' => transf('sdk',
            'Com:{0}(v{1}) missing language file for {2}.',
            '<strong>'.$missing->component.'</strong>',
            $missing->component_version->otherwise('##'),
            '<strong>'.$missing->language_code.'</strong>'
          ),
          'dt_last_registered' => $missing->dt_last_registered
        ));
      });
    
    //Untranslated phrases.
    tx('Sql')
      ->table('sdk', 'TranslationMissingPhrases')
      ->select('COUNT(*)', 'count')
      ->select('MAX(`dt_last_registered`)', 'latest')
      ->group('component')
      ->group('language_code')
      ->order('latest', 'DESC')
      ->execute()
      ->each(function($missing)use($notifs){
        $notifs->push(array(
          'icons' => 'alert',
          'message' => transf('sdk',
            'Com:{0}(v{1}) missing {3} phrase(s) for {2}.',
            '<strong>'.$missing->component.'</strong>',
            $missing->component_version->otherwise('##'),
            '<strong>'.$missing->language_code.'</strong>',
            '<strong>'.$missing->count.'</strong>'
          ),
          'dt_last_registered' => $missing->latest
        ));
      });
    
    return $notifs;
    
  }
  
  protected function component_create()
  {
    return array(
      'component' => tx('Sql')->model('sdk', 'Component')
    );
  }
  
  protected function package_json()
  {
    return array(
      'includes' => URL_COMPONENTS.'/sdk/includes/'
    );
  }
  
}
