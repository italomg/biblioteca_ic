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
                      <li class="current"><a href="<?php echo URL; ?>solr/schedule">Criar Pauta</a></li>
                      <div class="clear"></div>
                    </ul>
                    <script type="text/javascript" src="web/js/responsive-nav.js"></script>
                </div>
                <div class="clearfix"> </div>
                <!----//End-top-nav---->
             </div>
        </div>
        <!----//End-header---->

        <!-- Start my scripts -->
        <script>

          function allowDrop(ev) {
              ev.preventDefault();
          }

          function drag(ev) {
              ev.dataTransfer.setData("text", ev.target.id);
          }

          function drop(ev) {
              ev.preventDefault();

              var data = ev.dataTransfer.getData("text");
              var txt = document.getElementById(data).innerHTML;
              var data_id = document.getElementById(data).id;

              var pos = data_id.split('_')[1];
              var pre = ev.target.id.split('_')[0];

              if(pre == pos || ev.target.id == 'buscas'){
                ev.target.appendChild(document.getElementById(data));
              }
              if(ev.target.id == 'buscas'){
                //set_available(txt);
                alert("<?php echo "OHOLAA MUNDO !!"; ?>");
                console.log(echo_res);
              }
              else{
              //  set_inUse(txt);
              }
          }


          $(document).ready(function(){

            /* Informes Gerais COMECO */
            var i = 1;
            $('#inf_grl_add').click(function(){
              $('#informes_gerais_div').append('<div id="'+i+'inf_grl_div" class="col-md-11" style="padding-left: 0px; padding-right: 0px; width: 25em;">\
                  <input class="form-control" type="text" name="content" value="" style="margin: 2px; width: 95%;"/>\
                </div>\
                <div class="col-md-1" id="'+i+'inf_grl_rm" style="padding: 0px; margin: 0px; margin-top: 0.4em;">\
                  <span class="input-group-btn">\
                    <button type="button" id="'+i+'inf_grl" class="btn btn-danger btn-number inf_grl_btn">\
                        <span class="glyphicon glyphicon-minus"></span>\
                    </button>\
                  </span>\
                </div>');
                i++;
            });

            $(document).on('click','.inf_grl_btn', function(){
              var button_id = $(this).attr("id");
              $('#' + button_id + '_div').remove();
              $('#' + button_id + '_rm').remove();
              i--;
            });
            /* Informes Gerais FIM */

            var dbclk = 0;
            $(document).on('dblclick','.dbclick', function(){
              dbclk = 2;
              var parent_id = $(this).parent().attr("id");
              var pos = $(this).attr("id").split('_')[1];

              if(parent_id == 'buscas'){
                $('#' + pos + '_div').append($(this));
                //set_inUse($(this).text());
              }
              else{
                $('#buscas').append($(this));
                //set_available($(this).text());
              }
            });

            function donothing(){
              if(dbclk == 0)
                console.log("clk=0");
              else {
                dbclk--;
              }
            }

            $(document).on('click','.dbclick', function(){
              setTimeout(donothing, 300);
            });

          });
        </script>
        <!-- End my scripts -->

        <div class="footer">
            <div class="footer_top">
                <div class="container">
                    <div class="footer_head">
                        <h2>Criar documentos</h2>
                        <p>Utilize os formulários abaixo para criar Atas, Pautas e Deliberacao</p>
                    </div>
                    <div class="row footer_grid">
                       <div class="col-md-6">
                            <div class="row">
                              <ul class="message">
                                  <li class="msg-icon"><i class="fa fa-search fa-2x" style="color: white;"></i></li>
                                  <li class="msg-desc">
                                      <h4>Busca</h4>
                                      <p>Busca por itens que foram previamentes adicionados</p>
                                  </li>
                                  <div class="clearfix"> </div>
                              </ul>
                              <div class="subscribe">
                                  <form class="busca-avancada" action="<?php echo URL; ?>generator/busca" method="POST">
                                      <div class="form-group">
                                        <label> Nome: </label>
                                        <input class="form-control" type="text" name="nome" value=""/>
                                      </div>
                                      <div class="form-group">
                                        <label> Tipo: </label>
                                        <select class="form-control" name="tipo">
                                            <option value="">Qualquer</option>
                                            <option value="exp">Expediente</option>
                                            <option value="ciencia">Ciencia</option>
                                            <option value="odia">Ordem do Dia</option>
                                            <option value="homo">Homologacao</option>
                                        </select>
                                      </div>
                                      <div class="form-group">
                                        <div class="row" style="padding-left: 0.8em;">
                                          <label> Reuniao: </label>
                                        </div>
                                        <div class="row">
                                          <div class="col-md-2" style="width: 4em;">
                                            <input class="form-control" type="number" name="reuniao" value="" style="width: 100%;font-size: 1em;"/>
                                          </div>
                                          <h1 class="col-md-1" style="color: white; padding: 0px; margin-top: 0.07em; width: 0.4em;">/</h1>
                                          <div class="col-md-4" style="width: 5em;">
                                            <input class="form-control" type="number" name="reuniao" value="" style="width: 100%; font-size: 1em;"/>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                          <input type="submit" name="submit_simple_search" value="Buscar" />
                                      </div>
                                  </form>
                              </div>
                            </div>
                            <div class="row footer_grid">
                                <ul id="buscas" class="twitter img-rounded col-md-10" ondrop="drop(event)" ondragover="allowDrop(event)" style="padding-bottom: 4em">
                                    <?php
                                      foreach($Available as $item){
                                        if(($item->ano_reuniao === $cur_ano_reuniao) && ($item->num_reuniao == $cur_num_reuniao))
                                          echo "<li id=\"busca$busca_n\_$item->tipo\" class=\"item_pauta_$item->tipo dbclick\" draggable=\"true\" ondragstart=\"drag(event)\"> $item->short_name </li>";
                                      }
                                     ?>
                                    <div class="clearfix"> </div>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="message">
                                <li class="msg-desc">
                                    <h4>Itens da Pauta</h4>
                                    <p>Aqui estao os itens que serao usados para gerar a pauta, ata e deliberacoes</p>
                                </li>
                                <div class="clearfix"> </div>
                            </ul>
                            <div>
                                <form class="busca-avancada" action="<?php echo URL; ?>solr/buscaAvancada" method="POST">
                                    <div id="informes_gerais_div" class="form-group footer_head_notaligned">
                                      <div class="col-md-11" style="padding-left: 0px; padding-right: 0px; width: 25em;">
                                        <label>Informes Gerais</label>
                                        <input class="form-control" type="text" name="content" value="" style="margin: 2px; width: 95%;"/>
                                      </div>
                                      <div class="col-md-1" style="padding: 0px; margin: 0px; margin-top: 2.1em;">
                                        <span class="input-group-btn">
                                          <button type="button" id="inf_grl_add" class="btn btn-success btn-number">
                                              <span class="glyphicon glyphicon-plus"></span>
                                          </button>
                                        </span>
                                      </div>

                                    </div>
                                    <div class="form-group footer_head_notaligned" style="width: 100%;">
                                        <label>Expediente</label>
                                        <br>
                                        <ul id="exp_div" class="expediente_border item_ul" ondrop="drop(event)" ondragover="allowDrop(event)">
                                          <?php
                                            foreach($InUse as $item){
                                              if(($item->ano_reuniao == $cur_ano_reuniao) && ($item->num_reuniao == $cur_num_reuniao))
                                                echo "<li id=\"busca$busca_n\_$item->tipo\" class=\"item_pauta_$item->tipo dbclick\" draggable=\"true\" ondragstart=\"drag(event)\"> $item->short_name </li>";
                                            }
                                           ?>
                                        </ul>
                                    </div>
                                    <div class="form-group footer_head_notaligned" style="width: 100%;">
                                        <label>Para Ciencia</label>
                                        <br>
                                        <ul id="ciencia_div" class="ciencia_border item_ul" ondrop="drop(event)" ondragover="allowDrop(event)">
                                          <?php
                                            foreach($InUse as $item){
                                              if(($item->ano_reuniao == $cur_ano_reuniao) && ($item->num_reuniao == $cur_num_reuniao))
                                                echo "<li id=\"busca$busca_n\_$item->tipo\" class=\"item_pauta_$item->tipo dbclick\" draggable=\"true\" ondragstart=\"drag(event)\"> $item->short_name </li>";
                                            }
                                           ?>
                                        </ul>
                                    </div>
                                    <div class="form-group footer_head_notaligned" style="width: 100%;">
                                        <label>Ordem do Dia</label>
                                        <br>
                                        <ul id="odia_div" class="odia_border item_ul" ondrop="drop(event)" ondragover="allowDrop(event)">
                                          <?php
                                            foreach($InUse as $item){
                                              if(($item->ano_reuniao == $cur_ano_reuniao) && ($item->num_reuniao == $cur_num_reuniao))
                                                echo "<li id=\"busca$busca_n\_$item->tipo\" class=\"item_pauta_$item->tipo dbclick\" draggable=\"true\" ondragstart=\"drag(event)\"> $item->short_name </li>";
                                            }
                                           ?>
                                        </ul>
                                    </div>
                                    <div class="form-group footer_head_notaligned" style="width: 100%;">
                                        <label>Homologacao</label>
                                        <br>
                                        <ul id="homo_div" class="homo_border item_ul" ondrop="drop(event)" ondragover="allowDrop(event)">
                                          <?php
                                            foreach($InUse as $item){
                                              if(($item->ano_reuniao == $cur_ano_reuniao) && ($item->num_reuniao == $cur_num_reuniao))
                                                echo "<li id=\"busca$busca_n\_$item->tipo\" class=\"item_pauta_$item->tipo dbclick\" draggable=\"true\" ondragstart=\"drag(event)\"> $item->short_name </li>";
                                            }
                                           ?>
                                        </ul>
                                    </div>

                                  </div>

                                </form>
                            </div>
                        </div>
                    </div>
               </div>
             </div>
            </div>

<div class="content_white">
           </div>

</div>
