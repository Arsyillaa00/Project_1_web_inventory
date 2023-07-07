<?php 
    $form_edit = $_GET['db']??"";
    $edit = "";

    switch($form_edit){
        case 'user':
            $list_status = list_status($db);
            $input_status = "";
            foreach($list_status as $key){
                $input_status.="<option value='".$key['id_status']."' ".($key['id_status']==$status?'selected':'')."> ".$key['title']." </option>";
            }

            $edit = " 
                        <label for=''>Nama</label>
                        <input type='text' name='nama' placeholder='masukkan nama lengkap' value='".$nama."' required>
                        <br>
                        <label for=''>Email</label>
                        <input type='email' name='email' placeholder='xxx@gmail.com' value='".$email."' required>
                        <br>
                        <label for=''>Status</label>
                        <select name='status' id=''>".$input_status."</select>  
                     ";
        break;

        case 'status':
            $edit = "
                        <label>Title</label>
                        <input type='text' name='title' placeholder='masukkan status saat ini' value='".$title."' required>
                        <br>
                        <label>Level</label>
                        <input type='text' name='level' placeholder='masukkan level saat ini' value='".$level."' required>
                    ";
        break;

        case 'products':
        break;

        default :
            //perintah untuk redirect
            header("Location: ../index.php");
        break;
    }
?>

<form action="?page=update&id=<?php echo $id_user; ?>&db=<?php echo $form_edit;?>" method="POST">
    <?php echo $edit;?>

    <br>
    <button type="submit" class="btn btn-primary">SUBMIT</button>
    <button type="reset" class="btn btn-warning">Reset</button>
    
</form>
