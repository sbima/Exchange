
<?php
include("navbar.php");
if(isset($_SESSION["username"])) {
}
else {
header("location: index.php");
}
?>
<html>
    <head>
        <!--Start of Zendesk Chat Script-->
                <?php
            if($_SESSION["user_role"]!="administrator")
            {
                ?>
                <script type="text/javascript">
                window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
                d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
                _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
                $.src="https://v2.zopim.com/?4R6qwk4IPQ0PsV8UEQlVTHmfTiLFg9ER";z.t=+new Date;$.
                type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
                </script>
            <?php
            }
            ?>
            <!--End of Zendesk Chat Script-->s
    </head>
<body>
      <div class="container">
<div class="col-md-6">
        <div class="form-group">
    <form name="myForm" action="ques.php" onsubmit="return validate_askForm()" method="post"><br>
        <h3> Ask a Question</h3>
        <label for="content">Title:</label>&nbsp; <input type= "text " name="title" ><br><br>
         <label for="content">Content:</label>&nbsp;
        
            <textarea id="summernote" name="textbox"></textarea>
            <label for="tags">Tags:</label>&nbsp; <input type= "text " name="tags" ><br><br>
        
        <input type="submit" value="submit" name="submit">
            </form></div></div></div>  </body>
        </html>

  <script src="validate.js"></script>
  <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
  height: 170,                 // set editor height
  minHeight: null,             // set minimum height of editor
  maxHeight: null,             // set maximum height of editor
  focus: true                  // set focus to editable area after initializing summernote
});
    });
  </script>
        
       