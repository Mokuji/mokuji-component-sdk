<?php namespace components\sdk; if(!defined('TX')) die('No direct access.'); ?>

<h1><?php __($names->component, 'SDK_SDK_DASHBOARD_TITLE'); ?></h1>

<div class="clearfix">
  
  <ul id="sdk-navigation" class="config-navigation">
    <?php foreach($data->menu as $name => $title): ?>
      <li><a class="nav-item <?php echo $name; ?>" href="<?php echo url('?section=sdk/'.$name, true); ?>"><?php echo $title; ?></a></li>
    <?php endforeach; ?>
  </ul>
  
  <div id="sdk-content-pane" class="config-content-pane"><?php echo $data->content; ?></div>
  
</div>

<script type="text/javascript">
jQuery(function($){
  
  var $navigation = $('#sdk-navigation')
    , $content = $('#sdk-content-pane');
  
  //Clicking the navigation.
  $navigation.on('click', 'li a', function(e){
    e.preventDefault();
    
    var hasFeedback = (window.app && app.Feedback);
    
    if(hasFeedback) app.Feedback.working("<?php __($names->component, 'Loading'); ?>");
    
    $.ajax($(this).attr('href'))
      .done(function(html){
        
        if(html){
          $content.html(html);
          app.Feedback.success("<?php __($names->component, 'Loaded'); ?>")
        }else{
          app.Feedback.error("<?php __($names->component, 'There was a problem loading the SDK section'); ?>");
        }
        
      })
      .error(function(xhs, request, message){
        app.Feedback.error(message);
      });
  });
  
});
</script>
