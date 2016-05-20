<?php

/**
 * Class Songs
 * This class is responsible for all Solr operations.
 *
 * Please note:
 * Don't use the same name for class and method, as this might trigger an (unintended) __construct of the class.
 * This is really weird behaviour, but documented here: http://php.net/manual/en/language.oop5.decon.php
 *
 */

$imageLink = "";
class Solr extends Controller
{
    /**
     * PAGE: listar
     * This method handles what happens when you move to http://yourproject/solr/listar
     */
    public function listar($page = 1)
    {
        // create a client instance
        $client = new Solarium\Client($this->config);

        // get a select query instance
        $query = $client->createQuery($client::QUERY_SELECT);

        // set start and rows param (comparable to SQL limit) using fluent interface
        $query->setStart(($page-1)*10)->setRows(10);

        // this executes the query and returns the result
        $resultset = $client->execute($query);

        // display the total number of documents found by solr
        $number_of_results = $resultset->getNumFound();

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/solr/listar.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * PAGE: listarTudo
     * This method handles what happens when you move to http://yourproject/solr/listarTudo
     */
    public function listarTudo()
    {
        // create a client instance
        $client = new Solarium\Client($this->config);

        // get a select query instance
        $query = $client->createQuery($client::QUERY_SELECT);

        // set start and rows param (comparable to SQL limit) using fluent interface
        $query->setStart(0)->setRows(1000);

        // this executes the query and returns the result
        $resultset = $client->execute($query);

        // display the total number of documents found by solr
        $number_of_results = $resultset->getNumFound();

        header('Content-type: text/html; charset=utf-8');

        // display the total number of documents found by solr
        echo 'NumFound: '.$resultset->getNumFound();

        // display the max score
        echo '<br>MaxScore: '.$resultset->getMaxScore();

        // show documents using the resultset iterator
        foreach ($resultset as $document) {

            echo '<hr/><table>';

            // the documents are also iterable, to get all fields
            foreach ($document as $field => $value) {
                // this converts multivalue fields to a comma-separated string
                if (is_array($value)) {
                    $value = implode(', ', $value);
                }

                echo '<tr><th>' . $field . '</th><td>' . $value . '</td></tr>';
            }

            echo '</table>';
        }
    }

    /**
     * PAGE: inserir
     * This method handles what happens when you move to http://yourproject/solr/inserir
     */
    public function inserir()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/solr/inserir.php';
        require APP . 'view/_templates/footer.php';
    }
    
    /**
     * PAGE: inserir_batch
     * This method handles what happens when you move to http://yourproject/solr/inserir
     */
    public function inserir_batch()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/solr/inserir_batch.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * PAGE: contato
     * This method handles what happens when you move to http://yourproject/solr/contato
     */
    public function contato()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/solr/contato.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * PAGE: pesquisar
     * This method handles what happens when you move to http://yourproject/solr/pesquisar
     */
    public function pesquisar()
    {
        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/solr/buscar.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * PAGE: editar
     * This method handles what happens when you move to http://yourproject/solr/editar
     */
    public function editar($id)
    {
        // Cache dump
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // create a client instance
        $client = new Solarium\Client($this->config);

        // get a select query instance
        $query = $client->createSelect();

        $query->setQuery('id:"/'.$id.'"');

        // set start and rows param (comparable to SQL limit) using fluent interface
        $query->setRows(1);

        // this executes the query and returns the result
        $resultset = $client->select($query);

        // display the total number of documents found by solr
        $number_of_results = $resultset->getNumFound();

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/solr/editar.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * PAGE: detalhes
     * This method handles what happens when you move to http://yourproject/solr/detalhes
     */
    public function detalhes($id)
    {
        // Cache dump
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        // create a client instance
        $client = new Solarium\Client($this->config);

        // get a select query instance
        $query = $client->createSelect();

        $query->setQuery('id:"/'.$id.'"');

        // set start and rows param (comparable to SQL limit) using fluent interface
        $query->setRows(1);

        // this executes the query and returns the result
        $resultset = $client->select($query);

        // display the total number of documents found by solr
        $number_of_results = $resultset->getNumFound();

        // load views
        require APP . 'view/_templates/header.php';
        require APP . 'view/solr/resultado.php';
        require APP . 'view/_templates/footer.php';
    }

    /**
     * ACTION: enviarArquivo
     * This method handles what happens when you move to http://yourproject/solr/enviarArquivo
     * IMPORTANT: This is not a normal page, it's an ACTION that handles a POST request.
     */
    public function enviarArquivo()
    {
        // if we have POST data
        if (isset($_POST["submit_add_file"])) {
            date_default_timezone_set('America/Sao_Paulo');
            $creation = date('Y-m-d_H-i-s');

            $fname = basename($_FILES['userfile']['name'][0]);

            $fpath = $this->fileUpload('userfile', $creation, 0);
            if (!empty($_FILES['userfile']['name'][1])) {
            	$upload2 = $this->fileUpload('userfile', $creation, 1);
            } else {
            	$upload2 = "";
            }

            $this->indexaArquivo($fpath, $fname, false, $upload2);
        }

        // where to go after file has been added
        header('location: ' . URL . 'solr/inserir');
	
        // Cache dump
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }
    
    /**
	 * ACTION: enviarArquivoZip
	 * This method handles what happens when you move to http://yourproject/solr/enviarArquivoZip
	 * IMPORTANT: This is not a normal page, it's an ACTION that handles a POST request.
	 */
	public function enviarArquivoZip() 
    {
		$upload_dir = 'temp/';
		
		if (isset ( $_POST ["submit_add_file"] )) {
			date_default_timezone_set ( 'America/Sao_Paulo' );
			$creation = date ( 'Y-m-d_H-i-s' );
			
			$fname = basename ( $_FILES ['zipToUpload'] ['name'] );
			
			$flist = $this->batchUpload ( 'zipToUpload', $creation, $upload_dir );
            
            $dest_dir = 'download/';
			
			if ($flist == null)
				return false;
			
			foreach ( $flist as $f ) {
                rename($upload_dir.$f, $dest_dir.$f);
				$this->indexaArquivo($dest_dir.$f, $f, false, "");
			}
		}
		
		// where to go after file has been added
		header ( 'location: ' . URL . 'solr/inserir_batch' );
		
		// Cache dump
		header ( "Cache-Control: no-store, no-cache, must-revalidate, max-age=0" );
		header ( "Cache-Control: post-check=0, pre-check=0", false );
		header ( "Pragma: no-cache" );
	}
    
	// edicao eh um booleano que indica se a funcao que chamou foi a editaArquivo()
    function indexaArquivo($fpath, $fname, $edicao, $image ) 
    {
         // create a client instance
        $client = new Solarium\Client($this->config);

        // get an extract query instance and add settings
        $query = $client->createExtract();
        $query->addFieldMapping('content', 'plain_text_txt_pt');
        $query->setUprefix('attr_');
        $query->setFile($fpath);
        $query->setCommit(true);
        $query->setOmitHeader(false);

        // add document
        $doc = $query->createDocument();
        $doc->id = '/'.$fname;
        $doc->file_path_s = $fpath;
        if (!empty($_POST["subject"])) {
            $doc->subject_txt_pt = $_POST["subject"];
        }
        if (!empty($_POST["receiver"])) {
            $doc->receiver_txt_pt = $_POST["receiver"];
        }
        if (!empty($_POST["sector"])) {
            $doc->sector_txt_pt = $_POST["sector"];
        }
        if (!empty($_POST["identification"])) {
            $doc->identification_txt_pt = $_POST["identification"];
        }
        if (!empty($_POST["signer"])) {
            $doc->signer_txt_pt = $_POST["signer"];
        }
        if (!empty($_POST["author"])) {
            $doc->author_txt_pt = $_POST["author"];
        }
        if (!empty($_POST["fileDate"])){
            $doc->date_s = $_POST["fileDate"];
            $arr = explode('-', $_POST["fileDate"]);
            $doc->dateYear_s  = $arr[0];
            $doc->dateMonth_s = $arr[1];
            $doc->dateDay_s   = $arr[2];
        }
        if (!empty($_POST["category"])){
            $doc->category_txt_pt = $_POST["category"];
        }
        if (!empty($_POST["secret"])) {
            $doc->secret_txt_pt = $_POST["secret"];
        }
        if (!empty($_POST["attachment"])) {
            $doc->attachment_txt_pt = $_POST["attachment"];
        }
		
		// nao pega a data de indexacao na edicao de arquivo
		if(!$edicao) {
			$doc->indexingDate_s = date('Y-m-d');
			$doc->indexingYear_s  = date('Y');
			$doc->indexingMonth_s = date('m');
			$doc->indexingDay_s  = date('d');
			$doc->link_s = URL . 'downloads/' . $fname;
		}
		if ($image != "") {
			$doc->image_s = $image;
		}
        $query->setDocument($doc);
        
        // this executes the query and returns the result
        $result = $client->extract($query);

        // get an update query instance
        $update = $client->createUpdate();

        // optimize the index
        $update->addOptimize(true, false, 1);

        // this executes the query and returns the result
        $result = $client->update($update);
    }
    

    /**
     * ACTION: editarArquivo
     * This method handles what happens when you move to http://yourproject/solr/editarArquivo
     * IMPORTANT: This is not a normal page, it's an ACTION that handles a POST request.
     */
    public function editarArquivo($id)
    {
        // if we have POST data
        if (isset($_POST["submit_edit_file"])) {
			
			$arr = explode('/', $id);

            $fname = end($arr);

            $fpath = 'download/' . $fname;
			
			
            $this->indexaArquivo($fpath, $fname, true,"");
			

        }

        // where to go after file has been edited
        header('location: ' . URL . 'solr/detalhes/' . $fname);

        // Cache dump
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
    }

    /**
     * ACTION: buscaSimples
     * This method handles what happens when you move to http://yourproject/solr/buscaSimples
     * IMPORTANT: This is not a normal page, it's an ACTION that handles a POST request.
     */
    public function buscaSimples()
    {
        // if we have POST data
        if (isset($_POST["submit_simple_search"])) {
            // create a client instance
            $client = new Solarium\Client($this->config);

            // get a select query instance
            $query = $client->createSelect();

            $q = preg_replace("/[\s]+/","+",$_POST["searchValue"]);

            $query->setQuery('_text_:'.$q);

            // set start and rows param (comparable to SQL limit) using fluent interface
            $query->setRows(100);

            // this executes the query and returns the result
            $resultset = $client->select($query);

            // display the total number of documents found by solr
            $number_of_results = $resultset->getNumFound();

            // load views
            require APP . 'view/_templates/header.php';
            require APP . 'view/solr/resultado.php';
            require APP . 'view/_templates/footer.php';
        }
    }

    /**
     * ACTION: buscaAvancada
     * This method handles what happens when you move to http://yourproject/solr/buscaAvancada
     * IMPORTANT: This is not a normal page, it's an ACTION that handles a POST request.
     */
    public function buscaAvancada()
    {
        // if we have POST data
        if (isset($_POST["submit_advanced_search"])) {
            // create a client instance
            $client = new Solarium\Client($this->config);

            // get a select query instance
            $query = $client->createSelect();

            $prefix = '';
            $q = '';

            if(!empty($_POST["content"])) {
                $q .= $prefix . "_text_:" . preg_replace("/[\s]+/","+",$_POST["content"]);
                $prefix = " AND ";
            } if(!empty($_POST["author"])) {
                $q .= $prefix . "author_txt_pt:\"" . $_POST["author"] . "\"";
                $prefix = " AND ";
            } 
            if(!empty($_POST["user"])) {
            	$q .= $prefix . "user_s:\"" . $_POST["user"] . "\"";
            	$prefix = " AND ";
            }
            if(!empty($_POST["uploadDate"])) {
            	$q .= $prefix . "indexingDate_s:\"" . $_POST["uploadDate"] . "\"";
            	$prefix = " AND ";
            }
            if(!empty($_POST["signer"])) {
            	$q .= $prefix . "signer_txt_pt:\"" . $_POST["signer"] . "\"";
            	$prefix = " AND ";
            }
            if(!empty($_POST["receiver"])) {
                $q .= $prefix . "receiver_txt_pt:\"" . $_POST["receiver"] . "\"";
                $prefix = " AND ";
            }
            if(!empty($_POST["fileDate"])) {
            	$q .= $prefix . "date_s:\"" . $_POST["fileDate"] . "\"";
            	$prefix = " AND ";
            }
            if(!empty($_POST["category"])) {
                $q .= $prefix . "category_txt_pt:\"" . $_POST["category"] . "\"";
                $prefix = " AND ";
            }
            if(!empty($_POST["identification"])) {
            	$q .= $prefix . "identification_txt_pt:\"" . $_POST["identification"] . "\"";
            	$prefix = " AND ";
            }
            if(!empty($_POST["identification"])) {
            	$q .= $prefix . "identification_txt_pt:\"" . $_POST["identification"] . "\"";
            	$prefix = " AND ";
            }
            if(!empty($_POST["subject"])) {
                $q .= $prefix . "subject_txt_pt:" . preg_replace("/[\s]+/","+",$_POST["subject"]);
            }
            if(!empty($_POST["sector"])) {
            	$q .= $prefix . "sector_txt_pt:\"" . $_POST["sector"] . "\"";
            	$prefix = " AND ";
            }
            if(!empty($_POST["secret"])) {
            	$q .= $prefix . "secret_txt_pt:\"" . $_POST["secret"] . "\"";
            	$prefix = " AND ";
            }
            if(!empty($_POST["attachment"])) {
            	$q .= $prefix . "attachment_txt_pt:\"" . $_POST["attachment"] . "\"";
            	$prefix = " AND ";
            }
            $query->setQuery($q);

            // set start and rows param (comparable to SQL limit) using fluent interface
            $query->setRows(100);

            // this executes the query and returns the result
            $resultset = $client->select($query);

            // display the total number of documents found by solr
            $number_of_results = $resultset->getNumFound();

            // load views. within the views we can echo out $songs and $amount_of_songs easily
            require APP . 'view/_templates/header.php';
            require APP . 'view/solr/resultado.php';
            require APP . 'view/_templates/footer.php';
        }
    }
    
    /**
     * ACTION: imageUpload
     * IMPORTANT: This is not a normal page, it's an ACTION.
    */
     
    public function fileUpload($input_name, $creation, $i)
    {
        // if we have an id that should be edited
        if ($_FILES[$input_name]['error'][$i] == 0) {

            $upload_dir = 'download';
            
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $target_file = $upload_dir . '/' . basename($_FILES[$input_name]['name'][$i]);
            
            if ( !move_uploaded_file($_FILES[$input_name]["tmp_name"][$i], $target_file) ) {
                return null;
            }
            
            return $target_file;
        }
    }
    
    	/**
	 * ACTION: batchUpload
	 * IMPORTANT: This is not a normal page, it's an ACTION.
	 */
	public function batchUpload($input_name, $creation, $upload_dir) {
		// if we have an id that should be edited
		if ($_FILES [$input_name] ['error'] == 0) {
			if (! file_exists ( $upload_dir )) {
				mkdir ( $upload_dir, 0755, true );
			}
			
			$target_file = $upload_dir . '/' . basename ( $_FILES [$input_name] ['name'] );
			
			if (file_exists ( $target_file )) {
				unlink ( $target_file );
			}
			
			if (! move_uploaded_file ( $_FILES [$input_name] ["tmp_name"], $target_file )) {
				return false;
			}
			
			if ($this->endsWith ( $target_file, ".zip" )) {
				$zip = new ZipArchive ();
				if ($zip->open ( $target_file ) === TRUE) {
					$zip->extractTo ( $upload_dir );
					$zip->close ();
				} else {
					echo 'Erro ao extrair arquivo zip';
					return null;
				}
				
				unlink ( $target_file );
			} 			

			// .tar.gz
			else {
				$pos = strrpos ( $target_file, ".tar.gz" );
				$tar_file = null;
				
				if ($pos !== false) {
					$tar_file = substr_replace ( $target_file, ".tar", $pos, strlen ( ".tar.gz" ) );
				} 

				else {
					echo "Erro ao extrair o arquivo: " . $target_file;
				}
				
				if (file_exists ( $tar_file ))
					unlink ( $target_file );
				
				try {
					// decompress from gz
					$p = new PharData ( $target_file );
					$p->decompress ();
					
					// unarchive from the tar
					$phar = new PharData ( $tar_file );
					$phar->extractTo ( $upload_dir );
					
					unlink ( $target_file );
					unlink ( $tar_file );
				} catch ( Exception $e ) {
					echo "Erro ao extrair o arquivo " . $_FILES [$input_name] ['name'] . ". para " . $target_file;
					echo "<br>Certifique-se de que o repositorio temp esta vazio<br>";
					
					unlink ( $target_file );
					unlink ( $tar_file );
					
					return null;
				}
			}
			
			// pega os arquivos do diretorio
			$files1 = scandir ( $upload_dir );
			
			// remove . e ..
			if (($key = array_search ( '.', $files1 )) !== false) {
				unset ( $files1 [$key] );
			}
			
			if (($key = array_search ( '..', $files1 )) !== false) {
				unset ( $files1 [$key] );
			}
            
            // remove os arquivos que nao terminam com .pdf ou .doc
            foreach($files1 as $f) {
                if(!($this->endsWith($f, ".pdf") || $this->endsWith($f, ".doc"))) {
                    echo $f."<br>";
                    unset ( $files1 [$f]);
                    unlink ( $upload_dir."/".$f);
                }
            }
            
			return $files1;
		}
	}
	function endsWith($haystack, $needle) {
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = strlen ( $haystack ) - strlen ( $needle )) >= 0 && strpos ( $haystack, $needle, $temp ) !== false);
	}

}
