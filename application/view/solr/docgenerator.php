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
                      <li class="current"><a href="<?php echo URL; ?>solr/docgenerator">Criar Pauta</a></li>
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
                                      <h4><a href="#">Busca</a></h4>
                                      <p>Busca por itens que foram previamentes adicionados</p>
                                  </li>
                                  <div class="clearfix"> </div>
                              </ul>
                              <div class="subscribe">
                                  <form class="busca-avancada" action="<?php echo URL; ?>generator/busca" method="POST">
                                      <div class="form-group">
                                          <input class="form-control" type="text" name="searchValue" value="" required />
                                      </div>
                                      <div class="form-group">
                                          <input type="submit" name="submit_simple_search" value="Buscar" />
                                      </div>
                                  </form>
                              </div>
                            </div>
                            <div class="row footer_grid">
                                <ul class="twitter img-rounded col-md-10" >
                                    <li class="twt_desc"><p>ar" e preencha os campos nos quais deseja realizar a.</p></li>
                                    <li class="twt_desc"><p>ar" e preencha os campos nos quais deseja realizar.</p></li>
                                    <li class="twt_desc"><p>ar" e preencha os campos nos quais deseja.</p></li>
                                    <li class="twt_desc"><p>ar" e preencha os campos nos quais deseja realizar a busca.</p></li>
                                    <li class="twt_desc"><p>ar" e preencha os campos nos quais deseja realizar a busca.</p></li>
                                    <li class="twt_desc"><p>ar" e preencha os campos nos quais deseja realizar a busca.</p></li>
                                    <div class="clearfix"> </div>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="message">
                                <li class="msg-icon"><i class="fa fa-search fa-2x" style="color: white;"></i></li>
                                <li class="msg-desc">
                                    <h4><a href="#">Itens da Pauta</a></h4>
                                    <p>Aqui estao os itens que serao usados para gerar a pauta, ata e deliberacoes</p>
                                </li>
                                <div class="clearfix"> </div>
                            </ul>
                            <div>
                                <form class="busca-avancada" action="<?php echo URL; ?>solr/buscaAvancada" method="POST">
                                    <div class="form-group footer_head_notaligned">
                                        <label>Informes Gerais</label>
                                        <input class="form-control" type="text" name="content" value="" />
                                        <input class="form-control" type="text" name="user" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Item title</label>
                                        <input class="form-control" type="text" name="user" value="" placeholder="Descricao"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Item title</label>
                                        <input class="form-control" type="text" name="user" value="" placeholder="Descricao"/>
                                    </div>
                                    <div class="form-group row">
                                      <div class="col-md-1">
                                        <input type="submit" name="submit_advanced_search" value="Pauta" />
                                      </div>
                                      <div class="col-sm-offset-2 col-md-1">
                                        <input type="submit" name="submit_advanced_search" value="Ata" />
                                      </div>
                                      <div class="col-sm-offset-2 col-md-1">
                                        <input type="submit" name="submit_advanced_search" value="Deliberacao" />
                                      </div>
                                    </div>
                                    <div class="form-group row footer_grid">
                                      <div class="col-md-1">
                                        <input type="submit" name="submit_advanced_search" value="Criar Item" />
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
