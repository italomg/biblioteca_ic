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
                      <li class="current"><a href="<?php echo URL; ?>solr/inserir">Inserir</a></li>
                      <li><a href="<?php echo URL; ?>solr/listar">Listar Todos</a></li>
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
                        <h2>Envio de documento</h2>
                        <p>Preencha os campos para adicionar um novo arquivo</p>
                    </div>
                    <div class="row footer_grid">

                        <div class="col-md-3">
                        </div>
                        <div class="col-md-7">
                            <ul class="message">
                                <li class="msg-icon"><i class="fa fa-cloud-upload fa-2x" style="color: white;"></i></li>
                                <li class="msg-desc">
                                    <h4><a href="#">Envio de arquivo</a></h4>
                                    <p>Indexação de arquivo e seus metadados</p>
                                </li>
                                <div class="clearfix"> </div>
                            </ul>
                            <div>
                                <form class="busca-avancada" action="<?php echo URL; ?>solr/enviarArquivo" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Arquivo-texto</label>
                                        <input class="form-control" type="file" name="userfile[]" required />
                                    </div>
									<div class="form-group">
                                        <label>Arquivo-imagem</label>
                                        <input class="form-control" type="file" name="userfile[]" value="" />
                                    </div>
                                    <div class="form-group">
                                        <label>Signatário</label>
                                        <input class="form-control" type="text" name="signer" value="" required/>
                                    </div>
									<div class="form-group">
                                        <label>Destinatário</label>
                                        <input class="form-control" type="text" name="receiver" value="" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Autor</label>
                                        <input class="form-control" type="text" name="author" value="" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Data de produção</label>
                                        <input class="form-control" type="date" name="fileDate" value="" required/>
                                    </div>
									<div class="form-group">
                                        <label>Identificação</label>
                                        <input class="form-control" type="text" name="identification" value="" required/>
                                    </div>
									<div class="form-group">
                                        <label>Setor</label>
                                        <input class="form-control" type="text" name="sector" value="" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Espécie</label>
                                        <select class="form-control" name="category">
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
                                        <input class="form-control" type="text" name="subject" value="" required/>
                                    </div>
									<div class="form-group">
                                        <label>Sigilo</label>
                                        <select class="form-control" name="secret">
                                            <option value="sim">SIM</option>
                                            <option value="nao">NÃO</option>                             
                                        </select>
                                    </div>
									<div class="form-group">
                                        <label>Anexo</label>
                                        <select class="form-control" name="attachment">
                                            <option value="sim">SIM</option>
                                            <option value="nao">NÃO</option>                             
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="submit_add_file" value="Enviar" />
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="col-md-2">
                        </div>
                    </div>
               </div>
             </div>
            </div>


<div class="content_white">
           </div>

</div>