<?php namespace components\sdk; if(!defined('TX')) die('No direct access.'); ?>

<h2><?php __($names->component, 'Notifications') ?></h2>

<table class="notification-list tx-table">
  <thead>
    <tr>
      <th><!-- icon space --></th>
      <th>Message</th>
      <th>Last registered</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($data as $notif): ?>
      <tr>
        <td><!-- icon space --></td>
        <td><?php echo $notif->message; ?></td>
        <td><?php echo $notif->dt_last_registered; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
