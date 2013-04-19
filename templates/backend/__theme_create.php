<?php namespace components\sdk; if(!defined('TX')) die('No direct access.'); ?>

<h2><?php __($names->component, 'New theme') ?></h2>

<p class="com-path"><?php echo transf($names->component, "Will be created in {0}", PATH_THEMES.DS.'custom'.DS) ?></p>

<?php echo $data->theme->render_form($id, '?rest=sdk/theme', array(
  'method' => 'post'
)); ?>

<script type="text/javascript">
jQuery(function($){
  
  $('#<?php echo $id; ?>').restForm({
    
    success: function(theme){
      app.Feedback.success("Created theme at "+theme.path);
      $('#<?php echo $id; ?>')[0].reset();
    }
    
  });
  
});
</script>
