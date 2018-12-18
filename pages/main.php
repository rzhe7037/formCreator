<?php 
    include_once('./header.php');
    session_start();
?>
<style>
    .container{
        margin-top: 100px !important;
    }
</style>
<div class="container">
    <div class="my-6">
        <h2><?php echo 'Hi, '.$_SESSION['username'].'!';?></h2>
    </div>
    <div class="my-6">
        <?php echo "<a href='./create.php/?username=".$_SESSION['username']."'><h5>Create new shop info</h5></a>" ?>
    </div>
    <div class="my-6"> 
        <?php echo "<a href='./view.php/?username=".$_SESSION['username']."'><h5>View all shops info</h5></a>" ?>
    </div>
    
</div>

