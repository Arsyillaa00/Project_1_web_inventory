<a href="form.php?page=create">Tambah Data</a>
<table> 
    <thead> 
        <tr>
            <th>No</th>
            <th>Email</th>
            <th>Nama</th>
            <th>Menu</th>
        </tr>
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