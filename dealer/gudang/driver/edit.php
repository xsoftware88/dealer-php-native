<?php
/*session_start();

include "head.php";

if (empty($_SESSION['username']) && ($modul == 'driver')) {
    ?>
    <script type="text/javascript">
        window.location = "../login/login-form.php";
    </script>
    <?php
} else {
    $user = $_SESSION['username'];
}
*/
include __DIR__ . "/../head.php";
include __DIR__ . "/../menu.php";

  if (isset($_GET['id']) && !empty($_GET['id'])) {

    $cariID = $_GET['id'];
    
    $sql    = "SELECT * FROM sales_unit_kirim WHERE id='".$cariID."'";
    $stmt   = $conn->prepare($sql);
    $stmt->execute();
    $dataEdit = $stmt->fetch();
?>

<div class="container-fluid">
  <form class="form-horizontal" action="update.php" method="POST">
  <div class="control-group">
    <div class="controls">
      <input type="hidden" value="<?php echo $_GET['id']; ?>" name="id">
      <?php 
      if ($dataEdit['approve_driver'] == 1) {
      ?>
      <input type="submit" class="btn btn-danger" value="Belum" name="batal">
      <?php 
      } else {
      ?>
      <input type="submit" class="btn btn-Success" value="Siap" name="setuju">
    <?php
    }
      ?>
    </div>
  </div>
</form>
</div>
<?php } else {
// buang ke depan, g isa edit g ada id
  } ?>