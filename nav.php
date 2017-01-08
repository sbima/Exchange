<html>
    <head>
        <style>
            
        </style>
      <title>EXchange</title>
        <link href="abc.css" rel="stylesheet">
      <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>    
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
    <title> Login</title>
    </head><body>
    <nav class="navbar navbar-fixed-top" role="navigation">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#"><img src="images/1.JPG" width="130px" alt=""></a>
    </div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li> <a href="help.php">
             Help Page
          </a>
          </li>
        
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input class="form-control" type='text' class="search-term" placeholder="Search User" id="Search_Text">
        </div>
        <button type="submit" class="btn btn-default"  onclick="search()">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Link</a></li>
          <li><a href="#">Link</a></li>
          </ul>
        </ul>

    </div><!-- /.navbar-collapse -->
  </div>
</nav>
    </body>
</html>

<script type="text/javascript">
$(function() {
    
    //autocomplete
    $(".search-term").autocomplete({
        source: "search.php",
        minLength: 1
    });                

});
function search(){
    var uname=document.getElementById('Search_Text').value;
    console.log(uname);
    window.location.href="profile.php?name="+uname;
}
</script>