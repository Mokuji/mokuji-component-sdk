<?php namespace components\sdk; if(!defined('TX')) die('No direct access.'); ?>

<h2><?php __($names->component, 'New component') ?></h2>

<p class="com-path"><?php echo transf($names->component, "Will be created in {0}", PATH_COMPONENTS.DS) ?></p>

<?php echo $data->component->render_form($id, '?rest=sdk/component', array(
  'method' => 'post'
)); ?>

<script type="text/javascript">
jQuery(function($){
  
  $('#<?php echo $id; ?>').restForm({
    
    success: function(component){
      app.Feedback.success("Created component at "+component.path);
      $('#<?php echo $id; ?>')[0].reset();
    }
    
  });
  
});
</script>
