<?php namespace components\sdk; if(!defined('TX')) die('No direct access.');

$id = tx('Security')->random_string(20);

?>
<h2><?php __($names->component, 'Replace string') ?></h2>

<form method="put" action="<?php echo url('rest=sdk/string_replace', 1); ?>" id="<?php echo $id; ?>">

  <input type="text" name="original" placeholder="Original string" />
  
  <input type="text" name="replace_by" placeholder="Replace by string" />

  <input type="submit" value="Replace all" class="button blue" />

</form>

<script type="text/javascript">
jQuery(function($){
  
  $('#<?php echo $id; ?>').restForm({
    
    success: function(template){
      app.Feedback.success("String replaced in text items");
      $('#<?php echo $id; ?>')[0].reset();
    }
    
  });
  
});
</script>
