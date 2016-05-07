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
    
    <?php
        // show documents using the resultset iterator
        foreach ($resultset as $document) {
    ?>

        <div class="footer">
            <div class="footer_top">
                <div class="container">
                    <div class="footer_head">
                        <h2>Edição de documento</h2>
                        <p>Preencha os campos para editar um arquivo</p>
                    </div>
                    <div class="row footer_grid">

                        <div class="col-md-3">
                        </div>
                        <div class="col-md-7">
                            <ul class="message">
                                <li class="msg-icon"><i class="fa fa-pencil fa-2x" style="color: white;"></i></li>
                                <li class="msg-desc">
                                    <h4><a href="#">Edição de arquivo</a></h4>
                                    <p>Edição de arquivo e seus metadados</p>
                                </li>
                                <div class="clearfix"> </div>
                            </ul>
                            <div>
                                <form class="busca-avancada" action="<?php echo URL; ?>solr/editarArquivo/<?php echo $id; ?>" method="POST">
                                    <div class="form-group">
                                        <label>Autor</label>
                                        <input class="form-control" type="text" name="author" value="<?php echo (isset($document["author_txt_pt"])) ? $document["author_txt_pt"] : ''; ?>" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Data de producão</label>
                                        <input class="form-control" type="date" name="fileDate" value="<?php echo (isset($document["date_s"])) ? $document["date_s"] : ''; ?>" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Signatário</label>
                                        <input class="form-control" type="text" name="signer" value="<?php echo (isset($document["signer_txt_pt"])) ? $document["signer_txt_pt"] : ''; ?>" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Destinatário</label>
                                        <input class="form-control" type="text" name="receiver" value="<?php echo (isset($document["receiver_txt_pt"])) ? $document["receiver_txt_pt"] : ''; ?>" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Setor</label>
                                        <input class="form-control" type="text" name="sector" value="<?php echo (isset($document["sector_txt_pt"])) ? $document["sector_txt_pt"] : ''; ?>" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Identificacão</label>
                                        <input class="form-control" type="text" name="identification" value="<?php echo (isset($document["identification_txt_pt"])) ? $document["identification_txt_pt"] : ''; ?>" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Espécie</label>
                                        <select class="form-control" name="category">
                                            <option value=""></option>
                                            <option <?php if(isset($document["category_txt_pt"]) && $document["category_txt_pt"] == "Ata de Congregação") echo 'selected'; ?> value="Ata de Congregação">Ata de Congregação</option>
                                            <option <?php if(isset($document["category_txt_pt"]) && $document["category_txt_pt"] == "Pauta de Congregação") echo 'selected'; ?> value="Pauta de Congregação">Pauta de Congregação</option>
                                            <option <?php if(isset($document["category_txt_pt"]) && $document["category_txt_pt"] == "Deliberação de Congregação") echo 'selected'; ?> value="Deliberação de Congregação">Deliberação de Congregação</option>
                                            <option <?php if(isset($document["category_txt_pt"]) && $document["category_txt_pt"] == "Ofício") echo 'selected'; ?> value="Ofício">Ofício</option>
                                            <option <?php if(isset($document["category_txt_pt"]) && $document["category_txt_pt"] == "Portaria") echo 'selected'; ?> value="Portaria">Portaria</option>
                                            <option <?php if(isset($document["category_txt_pt"]) && $document["category_txt_pt"] == "Item de Pauta") echo 'selected'; ?> value="Item de Pauta">Item de Pauta</option>
                                            <option <?php if(isset($document["category_txt_pt"]) && $document["category_txt_pt"] == "Ata de CI") echo 'selected'; ?> value="Ata de CI">Ata de CI</option>
                                            <option <?php if(isset($document["category_txt_pt"]) && $document["category_txt_pt"] == "Pauta de CI") echo 'selected'; ?> value="Pauta de CI">Pauta de CI</option>
                                            <option <?php if(isset($document["category_txt_pt"]) && $document["category_txt_pt"] == "Deliberação de CI") echo 'selected'; ?> value="Deliberação de CI">Deliberação de CI</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Assunto</label>
                                        <input class="form-control" type="text" name="subject" value="<?php echo (isset($document["subject_txt_pt"])) ? $document["subject_txt_pt"] : ''; ?>" required/>
                                    </div>
                                    <div class="form-group">
                                        <label>Sigilo</label>
                                        <select class="form-control" name="secret">
                                            <option <?php if(isset($document["secret_txt_pt"]) && $document["secret_txt_pt"] == "sim") echo 'selected'; ?> value="sim">SIM</option>
                                            <option <?php if(isset($document["secret_txt_pt"]) && $document["secret_txt_pt"] == "nao") echo 'selected'; ?> value="nao">NÃO</option>                             
                                        </select>
                                    </div>
									<div class="form-group">
                                        <label>Anexo</label>
                                        <select class="form-control" name="attachment">
                                            <option <?php if(isset($document["attachment_txt_pt"]) && $document["attachment_txt_pt"] == "sim") echo 'selected'; ?> value="sim">SIM</option>
                                            <option <?php if(isset($document["attachment_txt_pt"]) && $document["attachment_txt_pt"] == "nao") echo 'selected'; ?> value="nao">NÃO</option>                            
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" name="submit_edit_file" value="Enviar" />
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
    <?php
        }
    ?>



<div class="content_white">
           </div>

</div>
