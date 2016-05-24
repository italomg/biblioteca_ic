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
                      <li class="current"><a href="<?php echo URL; ?>solr/pesquisar">Pesquisar</a></li>
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
                    <div class="footer_head">
                        <h2>Pesquisar documentos</h2>
                        <p>Utilize os formulários abaixo para buscar o arquivo desejado</p>
                    </div>
                    <div class="row footer_grid">
                       <div class="col-md-6">
                            <ul class="message">
                                <li class="msg-icon"><i class="fa fa-search fa-2x" style="color: white;"></i></li>
                                <li class="msg-desc">
                                    <h4><a href="#">Busca Simples</a></h4>
                                    <p>Busca por termos presentes em qualquer parte do documento</p>
                                </li>
                                <div class="clearfix"> </div>
                            </ul>
                            <div class="subscribe">
                                <form class="busca-avancada" action="<?php echo URL; ?>solr/buscaSimples" method="POST">
                                    <div class="form-group">
                                        <input  class="form-control" type="text" name="searchValue" value="" required />
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="submit_simple_search" value="Buscar" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="message">
                                <li class="msg-icon"><i class="fa fa-search fa-2x" style="color: white;"></i></li>
                                <li class="msg-desc">
                                    <h4><a href="#">Busca Avançada</a></h4>
                                    <p>Busca avançada por metadados</p>
                                </li>
                                <div class="clearfix"> </div>
                            </ul>
                            <div>
                                <form class="busca-avancada" action="<?php echo URL; ?>solr/buscaAvancada" method="POST">
                                    <div class="form-group">
                                        <label>Conteúdo</label>
                                        <input class="form-control" type="text" name="content" value="" />
                                    </div>
                                    <div class="form-group">
                                        <label>Usuário (upload)</label>
                                        <input class="form-control" type="text" name="user" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Data (upload)</label>
                                        <input class="form-control" type="date" name="uploadDate" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Signatário</label>
                                        <input class="form-control" type="text" name="signer" value=""/>
                                    </div>
									<div class="form-group">
                                        <label>Destinatário</label>
                                        <input class="form-control" type="text" name="receiver" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Autor</label>
                                        <input class="form-control" type="text" name="author" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Data de produção</label>
                                        <input class="form-control" type="date" name="fileDate" value=""/>
                                    </div>
									<div class="form-group">
                                        <label>Identificação</label>
                                        <input class="form-control" type="text" name="identification" value=""/>
                                    </div>
									<div class="form-group">
                                        <label>Setor</label>
                                        <input class="form-control" type="text" name="sector" value=""/>
                                    </div>
                                    <div class="form-group">
                                        <label>Espécie</label>
                                        <select class="form-control" name="category">
                                            <option value=""></option>
                                            <option value="Ata de Congregação">Ata de Congregação</option>
                                            <option value="Pauta de Congregação">Pauta de Congregação</option>
                                            <option value="Deliberação de Congregação">Deliberação de Congregação</option>
                                            <option value="Ofício">Ofício</option>
                                            <option value="Portaria">Portaria</option>
                                            <option value="Item de Pauta">Item de Pauta</option>
                                            <option value="Ata de CI">Ata de CI</option>
                                            <option value="Pauta de CI">Pauta de CI</option>
                                            <option value="Deliberação de CI">Deliberação de CI</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Assunto</label>
                                        <input class="form-control" type="text" name="subject" value="" />
                                    </div>
									<div class="form-group">
                                        <label>Sigilo</label>
                                        <select class="form-control" name="secret">
                                            <option value=""></option>
                                            <option value="sim">SIM</option>
                                            <option value="nao">NÃO</option>                             
                                        </select>
                                    </div>
									<div class="form-group">
                                        <label>Anexo</label>
                                        <select class="form-control" name="attachment">
                                        	<option value=""></option>
                                            <option value="sim">SIM</option>
                                            <option value="nao">NÃO</option>                             
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="submit_advanced_search" value="Buscar" />
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
