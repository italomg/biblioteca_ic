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
                      <li class="current"><a href="<?php echo URL; ?>">Home</a></li>
                      <li><a href="<?php echo URL; ?>solr/pesquisar">Pesquisar</a></li>
                      <li><a href="<?php echo URL; ?>solr/inserir">Inserir</a></li>
                      <li><a href="<?php echo URL; ?>solr/inserir_batch">Inserir Lote</a></li>
                      <li><a href="<?php echo URL; ?>solr/listar">Listar Todos</a></li>
                      <li><a href="<?php echo URL; ?>solr/listar_categoria">Listar Categoria/Ano</a></li>
                      <li><a href="<?php echo URL; ?>solr/contato">Contato</a></li>
                      <li><a href="<?php echo URL; ?>solr/schedule">Criar Pauta</a></li>
                      <div class="clear"></div>
                    </ul>
                    <script type="text/javascript" src="web/js/responsive-nav.js"></script>
                </div>
                <div class="clearfix"> </div>
                <!----//End-top-nav---->
             </div>
        </div>
        <!----//End-header---->

       <img class="banner text-center" src="../images/banner.jpg">

        <div class="footer">
            <div class="footer_top">
                <div class="container">
                    <div class="footer_head">
                        <h2>Bem-vindo à biblioteca institucional do IC!</h2>
                    </div>
                    <div class="row footer_grid">
                       <div class="col-md-6">
                            <ul class="message">
                                <li class="msg-icon"><i class="fa fa-search fa-2x" style="color: white;"></i></li>
                                <li class="msg-desc">
                                    <h4><a href="#">Busca rápida</a></h4>
                                    <p>Busca por termos presentes em qualquer parte do documento</p>
                                </li>
                                <div class="clearfix"> </div>
                            </ul>
                            <div class="subscribe">
                                <form class="busca-avancada" action="<?php echo URL; ?>solr/buscaSimples" method="POST">
                                        <input type="text" name="searchValue" value="" required />
                                        <input type="submit" name="submit_simple_search" value="Buscar" />
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="twitter">
                                <li class="twt_icon"><i class="fa fa-info-circle fa-4x" style="color: white;"></i></li>
                                <li class="twt_desc"><p>Para realizar uma busca mais detalhada, utilize o formulário "Busca Avançada" no menu "Pesquisar" e preencha os campos nos quais deseja realizar a busca.</p></li>
                                <div class="clearfix"> </div>
                            </ul>
                        </div>
                    </div>
               </div>
             </div>
            </div>


        <!----//start-content---->
        <div class="main">
           <div class="content_white">
            <h2>Documentos recentes</h2>
            <p>Acesse de maneira rápida os últimos documentos adicionados à biblioteca</p>
           </div>
           <div class="featured_content" id="feature">
             <div class="container">
                <div class="row text-center">


<?php


        $num_found = $resultset->getNumFound();

        $i = 1;

        // show documents using the resultset iterator
        foreach ($resultset as $document) {

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

?>
                    <div class="col-md-3 feature_grid<?php echo ($i == 4) ? '2' : '1'; ?>">
                        <i class="fa fa-file-<?php echo $icone; ?>-o fa-5x"></i>
                        
                        <!-- substr($document["id"], 1) pois a string id comeca com /  -->
                        
                        <h4 class="m_1"><a href="solr/detalhes/<?php echo $document['id']; ?>"><?php echo substr($document["id"], 1) ; ?></a></h3>
                        <p class="m_2"><?php echo (isset($document["category_txt_pt"])) ? $document["category_txt_pt"].'<br>' : ''; ?>

                        Inserido em <?php echo $document["indexingday_s"] ?> de <?php

                        $mes_num = $document["indexingmonth_s"];

                        if($mes_num == 1){
                        $mes_nome = "Janeiro";
                        }elseif($mes_num == 2){
                        $mes_nome = "Fevereiro";
                        }elseif($mes_num == 3){
                        $mes_nome = "Março";
                        }elseif($mes_num == 4){
                        $mes_nome = "Abril";
                        }elseif($mes_num == 5){
                        $mes_nome = "Maio";
                        }elseif($mes_num == 6){
                        $mes_nome = "Junho";
                        }elseif($mes_num == 7){
                        $mes_nome = "Julho";
                        }elseif($mes_num == 8){
                        $mes_nome = "Agosto";
                        }elseif($mes_num == 9){
                        $mes_nome = "Setembro";
                        }elseif($mes_num == 10){
                        $mes_nome = "Outubro";
                        }elseif($mes_num == 11){
                        $mes_nome = "Novembro";
                        }else{
                        $mes_nome = "Dezembro";
                        }

                       echo $mes_nome; ?> de <?php echo $document["indexingyear_s"] ?></p>

                        <a href="<?php echo URL; ?>solr/detalhes/<?php echo $document['id']; ?>" class="feature_btn">Detalhes</a>
                    </div>

<?php
          $i++;
        }
?>
                </div>
            </div>
           </div>


        </div>
