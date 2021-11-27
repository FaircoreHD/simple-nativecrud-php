<?php
    include_once("config.php");
    $getProdi = mysqli_query($mysqli, "SELECT * FROM prodi");

    if($_POST['submit']) {
        $nim = $_POST['nim'];
        $nmMahasiswa = $_POST['nmMahasiswa'];
        $tglLahir = $_POST['tglLahir'];
        $alamat = $_POST['alamat'];
        $idProdi = $_POST['idProdi'];
        $minat = implode(",", $_POST['minat']);
                
        $result = mysqli_query($mysqli, "INSERT INTO mahasiswa VALUES(null,'$nim','$nmMahasiswa','$tglLahir','$alamat','$minat','$idProdi')");

        if($result) {
            header("location:index.php?act=insertBerhasil");
        } else {
            header("location:form.php?act=insertGagal");
        }
    }

    if($_POST['update']) {
        $idMahasiswa = $_POST['idMahasiswa'];
        $nim = $_POST['nim'];
        $nmMahasiswa = $_POST['nmMahasiswa'];
        $tglLahir = $_POST['tglLahir'];
        $alamat = $_POST['alamat'];
        (int)$idProdi = $_POST['idProdi'];
        $minat = implode(",", $_POST['minat']);
                
        $result = mysqli_query($mysqli, "UPDATE mahasiswa SET nim='$nim', nmMahasiswa='$nmMahasiswa', tglLahir='$tglLahir', alamat='$alamat', minat='$minat', idProdi=$idProdi WHERE idMahasiswa=$idMahasiswa");
        if($result) {
            header("location:index.php?act=updateBerhasil");
        } else {
            header("location:form.php?act=updateGagal&id=$idMahasiswa");
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Insert Mahasiswa Baru</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='form.css'>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
    <div class="w3-container">
        <h1 class="w3-center">Tambah Mahasiswa Baru</h1>
        <p>
            <a href="index.php" class="w3-button w3-green">Kembali ke Home</a>
        </p>

        <?php
            if(isset($_GET['act'])) {
                if($_GET['act'] == "insertGagal") {
                    echo '<div class="w3-panel w3-red w3-display-container">
                    <a href="form.php"><span onclick="this.parentElement.style.display=\'none\'"
                    class="w3-button w3-display-topright">X</span></a>
                    <p>Gagal menambahkan mahasiswa, tekan X untuk menginputkan kembali</p>
                    </div>';
                }
                if($_GET['act'] == "updateGagal") {
                    echo '<div class="w3-panel w3-red w3-display-container">
                    <a href="form.php?act=edit&id='.$_GET['id'].'"><span onclick="this.parentElement.style.display=\'none\'"
                    class="w3-button w3-display-topright">X</span></a>
                    <p>Gagal memperbarui data mahasiswa, tekan X untuk menginputkan kembali</p>
                    </div>';
                }

                if($_GET['act'] == 'edit') {
                    $idMahasiswa = $_GET['id'];
                    $getMahasiswa = mysqli_query($mysqli, "SELECT * FROM mahasiswa WHERE idMahasiswa=$idMahasiswa");
                    if(!$getMahasiswa) {
                        echo "<script>alert('Tidak dapat mengambil data mahasiswa')</script>";
                    }

                    $mahasiswa = mysqli_fetch_array($getMahasiswa);
                    $dataMinat = explode(',', $mahasiswa['minat']);
                }
            }
        ?>

        <div class="container">
            <form class="w3-container" method="POST">
                <input type="hidden" name="idMahasiswa" value="<?= $mahasiswa['idMahasiswa'] ?>">

                <label for="nim">NIM</label>
                <input type="text" class="input-form w3-input" id="nim" name="nim" value="<?= $mahasiswa['nim'] ?>" placeholder="NIM Mahasiswa" required>
            
                <label for="nmMahasiswa">Nama Mahasiswa</label>
                <input type="text" class="input-form w3-input" id="nmMahasiswa" name="nmMahasiswa" value="<?= $mahasiswa['nmMahasiswa'] ?>" placeholder="Nama Mahasiswa" required>
            
                <label for="tglLahir">Tanggal Lahir</label>
                <input type="date" class="input-form w3-input" id="tglLahir" name="tglLahir" value="<?= $mahasiswa['tglLahir'] ?>" required>

                <label for="alamat">Alamat</label>
                <textarea id="alamat" class="input-form w3-input" name="alamat" placeholder="Alamat Lengkap" style="height:200px" required><?= $mahasiswa['alamat'] ?></textarea>

                <label for="prodi">Prodi</label>
                <select id="prodi" class="input-form w3-input" name="idProdi">
                    <?php
                    while($prodi = mysqli_fetch_array($getProdi)) { 
                    ?>
                    <option value="<?php echo $prodi['idProdi']; ?>" <?php if ($mahasiswa['idProdi'] == $prodi['idProdi']) echo "selected"; ?>><?php echo $prodi['nmProdi']; ?></option>
                    <?php
                    }
                    ?>
                </select>

                <label for="minat">Minat Mahasiswa</label>
                <br>
                <label><input class="w3-check input-form" name="minat[]" value="Membaca" type="checkbox" <?php if (in_array("Membaca", $dataMinat)) echo "checked"; ?>> Membaca</label>
                <label><input class="w3-check input-form" name="minat[]" value="Menggambar" type="checkbox" <?php if (in_array("Menggambar", $dataMinat)) echo "checked"; ?>> Menggambar</label>
                <label><input class="w3-check input-form" name="minat[]" value="Game" type="checkbox" <?php if (in_array("Game", $dataMinat)) echo "checked"; ?>> Game</label>
                <label><input class="w3-check input-form" name="minat[]" value="Musik" type="checkbox" <?php if (in_array("Musik", $dataMinat)) echo "checked"; ?>> Musik</label>
                <label><input class="w3-check input-form" name="minat[]" value="Pemograman" type="checkbox" <?php if (in_array("Pemograman", $dataMinat)) echo "checked"; ?>> Pemograman</label>
                <label><input class="w3-check input-form" name="minat[]" value="Video" type="checkbox" <?php if (in_array("Video", $dataMinat)) echo "checked"; ?>> Video</label>
                <label><input class="w3-check input-form" name="minat[]" value="Audio" type="checkbox" <?php if (in_array("Audio", $dataMinat)) echo "checked"; ?>> Audio</label>
                <label><input class="w3-check input-form" name="minat[]" value="Olahraga" type="checkbox" <?php if (in_array("Olahraga", $dataMinat)) echo "checked"; ?>> Olahraga</label>
                <br>

                <?php
                if($_GET['act'] == 'edit') { ?>
                <input type="submit" name="update" value="Perbarui">
                <?php
                } else { ?>
                <input type="submit" name="submit" value="Tambahkan">
                <?php
                }
                ?>
            </form>
        </div>
    </div>
</body>
</html>