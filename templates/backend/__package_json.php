<?php namespace components\sdk; if(!defined('TX')) die('No direct access.'); ?>

<h2><?php __($names->component, 'package.json generator') ?></h2>

<iframe src="<?php echo $data->includes; ?>html/package-gen.html"
  style="width:100%;height:100%;min-height:700px;border:1px solid #000;"></iframe>
