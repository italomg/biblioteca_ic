<body>
<!----start-header---->
<div class="header">
<div class="container">
<div class="logo">
<a href="<?php echo URL; ?>"><h1><strong>BIBLIOTECA DO IC</strong></h1></a>
</div>
<div class="clearfix"> </div>
<!----//End-top-nav---->
</div>
</div>
<!----//End-header---->


<div class="footer">
<div class="footer_top">
<form class="busca-avancada" action="index.php" method="POST" style="width:250px;margin-left:150px">
    	<label>Usuário</label>
        <input class="form-control" type="text" name="user" value="" required/>
    	<label>Senha</label>
        <input class="form-control" type="password" name="passwd" value="" required/>
		<br/>
    	<input type="submit" name="submit" value="Enviar" />
</form>

</div>
</div>
