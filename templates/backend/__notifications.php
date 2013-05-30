<?php namespace components\sdk; if(!defined('TX')) die('No direct access.'); ?>

<h2><?php __($names->component, 'Notifications') ?></h2>

<table class="notification-list tx-table">
  <thead>
    <tr>
      <th><!-- icon space --></th>
      <th><?php __($names->component, 'Message'); ?></th>
      <th><?php __($names->component, 'Last registered'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($data as $notif): ?>
      <tr>
        <td class="row-header">
          
          <!-- icon space -->
          
          <?php if($notif->resolve->is_set()){ ?>
            <input type="checkbox" class="resolve-notification" data-action="<?php echo $notif->resolve; ?>"
              title="<?php __($names->component, 'Mark notification as resolved'); ?>" />
          <?php } ?>
          
        </td>
        <td>
          
          <?php
            echo $notif->details->is_set() ?
             '<a href="#" class="toggle-details">'.$notif->message.'</a>'.n:
             $notif->message.n;
          ?>
          
          <div class="details">
            <?php echo $notif->details; ?>
          </div>
          
        </td>
        <td><?php echo $notif->dt_last_registered; ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<script type="text/javascript">
jQuery(function($){
  
  $('.notification-list')
    .on('click', '.toggle-details', function(e){
      
      e.preventDefault();
      $(this).closest('td').find('.details').slideToggle('fast');
      
    })
    
    .on('click', '.resolve-notification', function(e){
      
      e.preventDefault();
      $this = $(this);
      
      //Ignore clicking several times.
      if($this.attr('data-working') == '1')
        return;
      
      //Disable to show that we're working.
      $this.attr('disabled', 'disabled');
      
      //Mark that we're working.
      $this.attr('data-working', 1);
      
      $.rest('PUT', $this.attr('data-action'))
        .done(function(result){
          
          if(result.success === true){
            
            //Check the checkbox.
            $this.removeAttr('disabled');
            $this.attr('checked', 'checked');
            
            //After 1 second slide up the row.
            $.after('1s').done(function(){
              $this.closest('tr').slideUp();
            });
            
          }
          
          else{
            
            //Failed, so simply remove disabled and working.
            $this.removeAttr('disabled').removeAttr('data-working');
            
          }
          
        })
        .error(function(){
          
          //Failed, so simply remove disabled and working.
          $this.removeAttr('disabled').removeAttr('data-working');
          
        });
      
    });
    
});
</script>
