<?php
echo form_open('users/profile');
?>
<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Your Account</h3>
  </div>
  <div class="panel-body">
<table class="table table-bordered">
    
    <tr><td width="100">Username</td><td> <?php echo inputan('text', 'username','col-sm-4','Username ..', 1, $r['username'],'');?></td></tr>
    <tr><td>Password</td><td> <?php echo inputan('password', 'password','col-sm-3','Password ..', 1, '','');?></td></tr>
    <tr>
         <td colspan="2"> 
            <input type="submit" name="submit" value="simpan" class="btn btn-danger  btn-sm">
            
        </td></tr>
</table>
  </div></div>
</FORM>