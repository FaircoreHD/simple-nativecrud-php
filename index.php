<?php
    include_once("config.php");
    $result = mysqli_query($mysqli, "SELECT * FROM mahasiswa LEFT JOIN prodi ON prodi.idProdi = mahasiswa.idProdi ORDER BY nmMahasiswa ASC");

    if($_GET['act'] == 'del') {
        $idMahasiswa = $_GET['id'];
        $del = mysqli_query($mysqli, "DELETE FROM mahasiswa WHERE idMahasiswa=$idMahasiswa");
        if(!$del) {
            echo "<script>
                    window.location.href='index.php?act=delGagal';
                </script>";
        } else {
            echo "<script>
                    window.location.href='index.php?act=delBerhasil';
                </script>";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>UTS</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div class="w3-container w3-responsive">
        <h1 class="w3-center">Data Mahasiswa</h1>
        <p><a href="form.php" class="w3-button w3-green">Tambah Mahasiswa Baru</a></p>

        <?php
            switch ($_GET['act']) {
                case 'insertBerhasil':
                    echo '<div class="w3-panel w3-blue w3-display-container">
                    <a href="index.php"><span onclick="this.parentElement.style.display=\'none\'"
                    class="w3-button w3-display-topright">X</span></a>
                    <p>Berhasil menambahkan mahasiswa, tekan X untuk menutup modal</p>
                    </div>';
                    break;

                case 'delBerhasil':
                    echo '<div class="w3-panel w3-blue w3-display-container">
                    <a href="index.php"><span onclick="this.parentElement.style.display=\'none\'"
                    class="w3-button w3-display-topright">X</span></a>
                    <p>Berhasil menghapus mahasiswa, tekan X untuk menutup modal</p>
                    </div>';
                    break;
                
                case 'delGagal':
                    echo '<div class="w3-panel w3-red w3-display-container">
                    <a href="index.php"><span onclick="this.parentElement.style.display=\'none\'"
                    class="w3-button w3-display-topright">X</span></a>
                    <p>Gagal menghapus mahasiswa, tekan X untuk menutup modal</p>
                    </div>';
                    break;

                case 'updateBerhasil':
                    echo '<div class="w3-panel w3-blue w3-display-container">
                    <a href="index.php"><span onclick="this.parentElement.style.display=\'none\'"
                    class="w3-button w3-display-topright">X</span></a>
                    <p>Berhasil memperbarui data mahasiswa, tekan X untuk menutup modal</p>
                    </div>';
                    break;
            }
            // if(isset($_GET['act'])) {
            //     if($_GET['act'] == "insertBerhasil") {
            //         echo '<div class="w3-panel w3-blue w3-display-container">
            //         <a href="index.php"><span onclick="this.parentElement.style.display=\'none\'"
            //         class="w3-button w3-display-topright">X</span></a>
            //         <p>Berhasil menambahkan mahasiswa, tekan X untuk menutup modal</p>
            //         </div>';
            //     }

            //     if($_GET['act'] == "delBerhasil") {
            //         echo '<div class="w3-panel w3-blue w3-display-container">
            //         <a href="index.php"><span onclick="this.parentElement.style.display=\'none\'"
            //         class="w3-button w3-display-topright">X</span></a>
            //         <p>Berhasil menghapus mahasiswa, tekan X untuk menutup modal</p>
            //         </div>';
            //     }

            //     if($_GET['act'] == "delGagal") {
            //         echo '<div class="w3-panel w3-red w3-display-container">
            //         <a href="index.php"><span onclick="this.parentElement.style.display=\'none\'"
            //         class="w3-button w3-display-topright">X</span></a>
            //         <p>Gagal menghapus mahasiswa, tekan X untuk menutup modal</p>
            //         </div>';
            //     }
            // }
        ?>

        <div id="id01" class="modal">
            <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
            <div class="modal-content">
                <div class="container">
                    <h1>Hapus Mahasiswa</h1>
                    <p>Apakah anda yakin ingin menghapus data Mahasiswa?</p>

                    <div class="clearfix">
                        <button type="button" class="cancelbtn" onclick="document.getElementById('id01').style.display='none'">Batalkan</button>
                        <button data-id="" type="button" id="confirm-delete" class="deletebtn" onclick="doDelete()">Ya, Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <table id="customers" class="w3-table-all">
            <tr>
                <th width="5%">NIM</th>
                <th width="15%">NAMA MAHASISWA</th>
                <th width="10%">TANGGAL LAHIR</th>
                <th width="15%">ALAMAT</th>
                <th width="15%">PRODI</th>
                <th width="20%">MINAT</th>
                <th width="5%"><center>OPSI</center></th>
            </tr>

            <?php  
            while($mahasiswa = mysqli_fetch_array($result)) { ?>
            <tr>
                <td><?php echo $mahasiswa['nim']; ?></td>
                <td><?php echo $mahasiswa['nmMahasiswa']; ?></td>
                <td><?php echo date_format(date_create($mahasiswa['tglLahir']), "d-m-Y"); ?></td>
                <td><?php echo $mahasiswa['alamat']; ?></td>
                <td><?php echo $mahasiswa['nmProdi']; ?></td>
                <td><?php echo $mahasiswa['minat']; ?></td>
                <td>
                    <a href="form.php?act=edit&id=<?php echo $mahasiswa['idMahasiswa']; ?>"><i class="w3-xlarge updbtn fa fa-edit"></i></a>
                    <buttom data-id="<?php echo $mahasiswa['idMahasiswa']; ?>" type="button" id="delete-button"><i onclick="confirmDelete()" class="w3-xlarge delbtn fa fa-trash"></i></button>
                </td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>

    <script>
        let modal = document.getElementById('id01');
        let confDelBtn = document.getElementById("confirm-delete");
        let deleteBtn = document.getElementById("delete-button");

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function confirmDelete() {
            document.getElementById("id01").style.display = "block";
            let id = deleteBtn.getAttribute("data-id");
            confDelBtn.setAttribute("data-id", id);
        }

        function doDelete() {
            location.href="index.php?act=del&id="+confDelBtn.getAttribute("data-id");
        }
    </script>
</body>
</html>