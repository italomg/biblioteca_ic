<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Biblioteca IC</title>
<link href="<?php echo URL; ?>css/bootstrap.css" rel='stylesheet' type='text/css' />
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="<?php echo URL; ?>js/jquery.min.js"></script>
<script src="<?php echo URL; ?>js/jquery.toaster.js"></script>
<script type="text/javascript" src="<?php echo URL; ?>js/biblioteca.js" charset="UTF-8"></script>

<!-- Sweet Alert CSS/JS files -->
<script type="text/javascript" src="<?php echo URL; ?>js/sweetalert2.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo URL; ?>css/sweetalert2.css">

<!-- <script type="text/javascript" src="web/js/responsive-nav.js"></script> -->
<script src="https://cdn.jsdelivr.net/promise.prototype.finally/1.0.1/finally.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.0.0.min.js"></script> -->

<!---- start-smoth-scrolling---->
<script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},1200);
            });
        });
    </script>
<!---- start-smoth-scrolling---->
<!-- Custom Theme files -->
<link href="<?php echo URL; ?>css/style.css" rel='stylesheet' type='text/css' />
<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<!--webfont-->
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,900' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lato:100,200,300,400,600,700,900' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
<!----start-top-nav-script---->
        <script>
            $(function() {
                var pull        = $('#pull');
                    menu        = $('nav ul');
                    menuHeight  = menu.height();
                $(pull).on('click', function(e) {
                    e.preventDefault();
                    menu.slideToggle();
                });
                $(window).resize(function(){
                    var w = $(window).width();
                    if(w > 320 && menu.is(':hidden')) {
                        menu.removeAttr('style');
                    }
                });
            });
        </script>
        <!----//End-top-nav-script---->
</script>

</head>
