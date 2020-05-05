<!DOCTYPE html>
<?php  include('server.php'); ?>
<?php include('functions.php');?>

<html>
<head>
	<title>BOILER ON/OFF</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
</head>

<body>

<div class="background">

<?php 

$omega_status = hb_diff();
if ($omega_status == "disabled")
{
    echo '<div class="alert-red">';
    echo '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
    echo '<strong>SYSTEM IS NOT READY</strong>';
    echo '</div>';
}
else
{
    echo '<div class="alert-green">';
    echo '<span class="closebtn" onclick="this.parentElement.style.display=\'none\';">&times;</span>';
    echo '<strong>SYSTEM READY</strong>';
    echo '</div>';
}
?>
<?php if (isset($_SESSION['message'])): ?>
	<div class="alert-purpel">
        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
        <strong>
		<?php 
			echo $_SESSION['message']; 
			unset($_SESSION['message']);
		?>
        </strong>
	</div>
<?php endif ?>

  <div class="toggle-body">
    <form method="post" action="server.php">
       <button class="toggle-btn" type="submit" name="<?php echo last_value();?>" <?php echo hb_diff();?>> </button>
    </form>
  </div>
</div>

<script>
     var bool = "<?php echo last_value();?>";

     const background = document.querySelector('.background');
     const toggleBody = document.querySelector('.toggle-body');
     const toggleBtn = document.querySelector('.toggle-btn');
     
     if (bool == "off") {
       background.classList.toggle('background--on');
       toggleBody.classList.toggle('toggle-body--on');
       toggleBtn.classList.toggle('toggle-btn--on');
       toggleBtn.classList.toggle('toggle-btn--scale');
     }
     toggleBtn.addEventListener('click', () => {
     background.classList.toggle('background--on');
     toggleBody.classList.toggle('toggle-body--on');
     toggleBtn.classList.toggle('toggle-btn--on');
     toggleBtn.classList.toggle('toggle-btn--scale');
     });

</script>
</body>
</html>

