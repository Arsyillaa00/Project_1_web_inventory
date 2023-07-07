<?php 

    $tabel = $_GET['db']??"";
    $head = "";

    switch($tabel){
        case 'user':
            $head = "<tr>
                        <th>Nomor</th>
                        <th>Email</th>
                        <th>Nama</th>
                        <th>Menu</th>
                    </tr>";
        break;

        case 'status':
            $head = "<tr>
                        <th>Nomor</th>
                        <th>Title</th>
                        <th>Level</th>
                        <th>Menu</th>
                    </tr>";
        break;

        case 'products':
        break;

        default :
            //perintah untuk redirect
            header("Location: ../index.php");
        break;
    }

?>
<a href="form.php?page=create&db=<?php echo $tabel;?>">Tambah Data</a>
<table> 
    <thead> 
        <?php echo $head;?>
    </thead> 

    <tbody>
        <?php  echo $html;?>
    </tbody>

    <tfoot>
        <tr>
            <td>
                <?php echo $prev.$next; ?>
            </td>
        </tr>
    </tfoot>
    <caption></caption>
</table>