<?php     
    if($_SESSION['userType'] !== 'Admin')
    {
?>
        <script>  history.back();  </script>
<?php     
    }
?>