<?php
$host   = "localhost";
$user   = "root";
$pass   = "";
$db     = "karyawan";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if(!$koneksi){ //cek koneksi
    die("Tidak bisa terkoneksi ke database");
} 
$nim    = "";
$nama   = "";
$alamat = "";
$jabatan= "";
$sukses = "";
$error  = "";
$urut   = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}
if($op == 'delete'){
    $id     = $_GET ['id'];
    $sql1   = "delete from status where id = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error = "Gagal melakukan delete data";
    }
}
if($op == 'edit'){
    $id     = $_GET ['id'];
    $sql1   = "select * from status where id = '$id'";
    $q1     = mysqli_query($koneksi, $sql1);
    $r1     = mysqli_fetch_array($q1);
    $nim    = $r1['nim'];
    $nama   = $r1['nama'];
    $alamat = $r1['alamat'];
    $jabatan = $r1['jabatan'];

    if($nim == ''){
        $error = "Data tidak ditemukan";
    }
}
if(isset($_POST['simpan'])){ //untuk create
    $nim        = $_POST['nim'];
    $nama       = $_POST['nama'];
    $alamat     = $_POST['alamat'];
    $jabatan    = $_POST['jabatan'];

    if($nim && $nama && $alamat && $jabatan){
        if($op == 'edit'){ // untuk update
            $sql1       = "update status set nim = '$nim',nama = '$nama',alamat = '$alamat',jabatan = '$jabatan' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if($q1) {
                $sukses = "Data berhasil diupdate";
            }else{
                $error  = "Data gagal diupdate";
        }
        }else { //untuk insert
            $sql1 = "insert into status (nim,nama,alamat,jabatan) values ('$nim','$nama','$alamat','$jabatan')";
            $q1   = mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses = "Berhasil memasukan data baru";
            }else{
                    $error  = "Gagal memasukkan data";
                }
            }
     
    }else{
        $error = "Silahkan masukkan semua data";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .mx-auto{width: 800px}
        .card {margin-top: 10px;}
    </style>
</head>

</head>
<body>
    <div class="max-auto">
        <!--masukan data-->
    <div class="card">
  <div class="card-header">
    Create / Edite Data
  </div>
  <div class="card-body">
    <?php
    if($error){
        ?>
        <div class="alert alert-danger" role="alert">
  <?php echo $error ?>
</div>
        <?php
        header("refresh:5;url=index.php");
    }
  ?>
  <?php
    if($sukses){
        ?>
        <div class="alert alert-success" role="alert">
  <?php echo $sukses ?>
        </div>
  <?php
        header("refresh:5;url=index.php");
    }
    ?>
    <form action="" method="POST">
    <div class="mb-3 row">
    <label for="nim" class="col-sm-2 col-form-label">NIM</label>
    <div class="col-sm-10">
      <input type="text"  class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-10">
      <input type="text"  class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
    <div class="col-sm-10">
      <input type="text"  class="form-control" id="alamat" name="alamat" value="<?php echo $alamat ?>">
    </div>
  </div>
  <div class="mb-3 row">
    <label for="jabatan" class="col-sm-2 col-form-label">Jabatan</label>
    <div class="col-sm-10">
      <select class="form-control" name="jabatan" id="jabatan">
        <option value="">-Pilih Jabatan-</option>
        <option value="teknisi" <?php if($jabatan == "teknisi") echo "selected"?>>Teknisi</option>
        <option value="admin" <?php if($jabatan == "admin") echo "selected"?>>Admin</option>
        <option value="tl" <?php if($jabatan == "tl") echo "selected"?>>Team Leader</option>
      </select>
    </div>
  </div>
<div class="col-12">
    <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
</div>
    </form>
  </div>
</div>
 <!--mengeluarkan data-->
<div class="card">
  <div class="card-header text-white bg-secondary">
    Data Karyawan
  </div>
  <div class="card-body">
   <table class="table">
    <thead>
        <tr>
            <th scope="col1">#</th>
            <th scope="col1">NIM</th>
            <th scope="col1">Nama</th>
            <th scope="col1">Alamat</th>
            <th scope="col1">Jabatan</th>
            <th scope="col1">Aksi</th>
        </tr>
        <tbody>
            <?php
            $sql2   = "select * from status order by id desc";
            $q2     = mysqli_query($koneksi,$sql2);
            while($r2 = mysqli_fetch_array($q2)){
                $id         = $r2['id'];
                $nim        = $r2['nim'];
                $nama       = $r2['nama'];
                $alamat     = $r2['alamat'];
                $jabatan    = $r2['jabatan'];

                ?>
                <tr>
                    <th scobe="row"><?php echo $urut++ ?></th>
                    <th scobe="row"><?php echo $nim ?></th>
                    <th scobe="row"><?php echo $nama ?></th>
                    <th scobe="row"><?php echo $alamat ?></th>
                    <th scobe="row"><?php echo $jabatan ?></th>
                    <td scobe="row">
                       <a href="index.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-warning">Edit</button></a> 
                       <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </thead>
   </table>
  </div>
</div>
    </div>
</body>
</html>