<?php
echo (!empty($msg))?$msg:false;
?>
<form action="<?php echo _WEB_ROOT;?>/home/post_user" method="post">
    <div>
        <input type="text" name="fullname" placeholder="Ho ten" value="<?php echo !empty($old['fullname'])?$old['fullname']:false?>"><br>
        <?php echo (!empty($errors) && array_key_exists('fullname', $errors))?'<span style="color: red">'.$errors['fullname'].'</span>':false?>
    </div>
    <div>
        <input type="text" name="email" placeholder="Email" value="<?php echo !empty($old['email'])?$old['email']:false?>"><br>
        <?php echo (!empty($errors) && array_key_exists('email', $errors))?'<span style="color: red">'.$errors['email'].'</span>':false?>
    </div>
    <div>
        <input type="password" name="password" placeholder="Mat khau" ><br>
        <?php echo (!empty($errors) && array_key_exists('password', $errors))?'<span style="color: red">'.$errors['password'].'</span>':false?>
    </div>
    <div>
        <input type="password" name="confirm_password" placeholder="Nhap lai mat khau"><br>
        <?php echo (!empty($errors) && array_key_exists('confirm_password', $errors))?'<span style="color: red">'.$errors['confirm_password'].'</span>':false?>
    </div>
    
    <button type="submit">submit</button>
</form>