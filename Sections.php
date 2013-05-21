<?php namespace components\sdk; if(!defined('TX')) die('No direct access.');

class Sections extends \dependencies\BaseViews
{
  
  protected
    $default_permission = 2,
    $permissions = array(
    );
  
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
          'resolve' => url('rest=sdk/resolve_translation_missing_files/'.$missing->component.'/'.$missing->language_code, true),
          'message' => transf('sdk',
            '{0}(v{1}) missing language file for {2}.',
            ($missing->component->is_empty() ? '' : 'Com:').'<strong>'.$missing->component->otherwise('Mokuji core').'</strong>',
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
          'resolve' => url('rest=sdk/resolve_translation_missing_phrases/'.$missing->component.'/'.$missing->language_code, true),
          'message' => transf('sdk',
            '{0}(v{1}) missing {3} phrase(s) for {2}.',
            ($missing->component->is_empty() ? '' : 'Com:').'<strong>'.$missing->component->otherwise('Mokuji core').'</strong>',
            $missing->component_version->otherwise('##'),
            '<strong>'.$missing->language_code.'</strong>',
            '<strong>'.$missing->count.'</strong>'
          ),
          'details' => tx('Sql')
            ->table('sdk', 'TranslationMissingPhrases')
            ->where('component', "'{$missing->component}'")
            ->where('language_code', "'{$missing->language_code}'")
            ->order('dt_last_registered', 'DESC')
            ->execute()
            ->map(function($string){
              return transf('sdk', 'Phrase: {0}', '<i>'.$string->phrase.'</i>');
            })
            ->join(br),
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
  
  protected function theme_create()
  {
    return array(
      'theme' => tx('Sql')->model('sdk', 'Theme')
    );
  }
  
  protected function template_create()
  {
    return array(
      'template' => tx('Sql')->model('sdk', 'Template')
    );
  }
  
  protected function package_json()
  {
    return array(
      'includes' => URL_COMPONENTS.'/sdk/includes/'
    );
  }
  
}
