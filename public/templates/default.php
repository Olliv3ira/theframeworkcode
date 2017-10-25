<!doctype html>
<html lang="en">
  <head>
    <title>Welcome to TheFrameworkCode!</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- custom styles -->
  	<?= $this->links['css']; ?>
    
    </head>
    <body>
  	<div class="container">
  		<div class="col-xs-12">
  		<!-- PAGE CONTENT BEGINS -->
  			<?php self::outputData(); ?>								
  		<!-- PAGE CONTENT ENDS -->
  		</div><!-- /.col -->
  	</div><!-- /.container -->

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- custom scripts -->
	<?= $this->links['js']; ?>	
  </body>
</html>