<?php namespace components\sdk; if(!defined('TX')) die('No direct access.'); ?>

<h2><?php __($names->component, 'New template') ?></h2>

<p class="com-path"><?php echo transf($names->component, "Will be created in {0}", PATH_TEMPLATES.DS.'custom'.DS) ?></p>

<?php echo $data->template->render_form($id, '?rest=sdk/template', array(
  'method' => 'post'
)); ?>

<script type="text/javascript">
jQuery(function($){
  
  $('#<?php echo $id; ?>').restForm({
    
    success: function(template){
      app.Feedback.success("Created template at "+template.path);
      $('#<?php echo $id; ?>')[0].reset();
    }
    
  });
  
});
</script>
