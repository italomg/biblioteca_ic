
<body>
      <!----start-header---->
        <div class="header">
            <div class="container">
                <div class="logo">
                  <a href="<?php echo URL; ?>"><h1><strong>BIBLIOTECA DO IC</strong></h1></a>
                </div>
                <div class="menu">
                    <a class="toggleMenu" href="#"><img src="web/images/nav_icon.png" alt="" /> </a>
                    <ul class="nav" id="nav">
                      <li><a href="<?php echo URL; ?>">Home</a></li>
                      <li><a href="<?php echo URL; ?>solr/pesquisar">Pesquisar</a></li>
                      <li><a href="<?php echo URL; ?>solr/inserir">Inserir</a></li>
                      <li><a href="<?php echo URL; ?>solr/inserir_batch">Inserir Lote</a></li>
                      <li><a href="<?php echo URL; ?>solr/listar">Listar Todos</a></li>
                      <li><a href="<?php echo URL; ?>solr/listar_categoria">Listar Categoria/Ano</a></li>
                      <li><a href="<?php echo URL; ?>solr/contato">Contato</a></li>
                      <div class="clear"></div>
                    </ul>
                    <script type="text/javascript" src="web/js/responsive-nav.js"></script>
                </div>                          
                <div class="clearfix"> </div>
                <!----//End-top-nav---->
             </div>
        </div>
        <!----//End-header---->

    <div class="footer">
            <div class="footer_top">
                <div class="container">
                    <div class="footer_head_narrow">
                        <h2>Resultado da pesquisa</h2>
                        <p>Listagem de documentos correspondentes aos critérios da busca</p>
                    </div>
                </div>
            </div>
    </div>

    <div class="content_white_narrow"></div>

    <div class="container">

<?php

  if($number_of_results == 0) {
    echo "<br><br>Sua busca não retornou resultados!<br><br><br>";
  }
  else {

    $n = $number_of_results/2;
    $i = 0;

    // show documents using the resultset iterator
    foreach ($resultset as $document) {

        if($i%2 == 0) echo "<div class='row'>";
        echo "<div class='col-md-6'>";

          $arr = explode('.', $document["id"]);
              $type = end( $arr );

              switch($type) {
                case "pdf":
                  $icone = "pdf";
                  break;
                case "doc":
                case "docx":
                  $icone = "word";
                  break;
                default:
                  $icone = "text";
              }

              if(isset($document["date_s"])) {
                $arr = explode('-', $document["date_s"]);
                $data = $arr[2].'/'.$arr[1].'/'.$arr[0];
              }
              else {
                $data = "";
              }

              $arr = explode('/', $document["id"]);
              $file = end($arr);
  ?>

                  <div class="bs-callout bs-callout-default">
                    <div class="left-list">
                      <i class="fa fa-file-<?php echo $icone; ?>-o fa-7x"></i>
                      <br><a href="<?php echo (isset($document["image_s"]) ? URL.$document["image_s"] : URL."download/".$file)  ?>" target="_blank" class="feature_btn"><i class="fa fa-cloud-download fa-lg" style="color: white;"></i></a>
                      <a href="<?php echo URL.'solr/editar/'.$document["id"]; ?>" class="feature_btn"><i class="fa fa-pencil fa-lg" style="color: white;"></i></a>
                    </div>
                    <div>
                        <h4><strong><?php echo $file; ?></strong></h4>
                        <p><strong>Autor:</strong> <?php echo $document["author_txt_pt"]; ?></p>
                        <p><strong>Produção:</strong> <?php echo $data; ?></p>
                        <p><strong>Espécie:</strong> <?php echo $document["category_txt_pt"]; ?></p>
                        <p><strong>Identificação:</strong> <?php echo $document["identification_txt_pt"]; ?></p>
                        <p><strong>Setor:</strong> <?php echo $document["sector_txt_pt"]; ?></p>
                    </div>
                    <div class="clear-div"></div>
                  </div>

  <?php
        
        echo "</div>";
        if($i%2 == 1) echo "</div>";

        $i++;
    }

    if($n%2 == 1) echo "</div>";
  ?>

  </div>

<?php

  }

?>
  
<div class="content_white_narrow"></div>

</div>
