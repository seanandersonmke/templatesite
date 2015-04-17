<form action="<?=base_url();?>index.php/login/register_submit" method="post">
 <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="user_name" placeholder="Username">
  </div>
  <div class="form-group">
    <label for="username">Password</label>
    <input type="password" class="form-control" name="word_of_passing" placeholder="Password">
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>