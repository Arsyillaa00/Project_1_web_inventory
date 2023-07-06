<?php 
    $list_status = list_status($db);
    $input_status = "";
    foreach($list_status as $key){
        $input_status.="<option value='".$key['id_status']."' ".($key['id_status']==$status?'selected':'')."> ".$key['title']." </option>";
    }

?>

<form action="?page=update&id=<?php echo $id_user; ?>" method="POST">
    <label for="">Nama</label>
    <input type="text" name="nama" placeholder="masukkan nama lengkap" value="<?php echo $nama; ?>" required>
    <br>
    <label for="">Email</label>
    <input type="email" name="email" placeholder="xxx@gmail.com" value="<?php echo $email; ?>" required>
    <br>
    <label for="">Status</label>
    <select name="status" id=""><?php echo $input_status; ?></select>

    <br>
    <button type="submit" class="btn btn-primary">SUBMIT</button>
    <button type="reset" class="btn btn-warning">Reset</button>
    
</form>
