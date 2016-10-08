<?php
session_start();
?>


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
   * PAGE: index
   * This method handles what happens when you move to http://yourproject/generator/index (which is the default page btw)
   */

  /*
  public function schedule(){

    $busca_n = 1;
    $reuniao = $this->model->getReuniao();
    $reuniao = array_values(get_object_vars($reuniao[0]));
    $cur_ano_reuniao = $reuniao[1];
    $cur_num_reuniao = $reuniao[0];

    $Available = $this->model->getAvailable();
    $InUse = $this->model->getInUse();
    $Informes = $this->model->getInformes($cur_num_reuniao, $cur_ano_reuniao);
    //Itens tem que ter um campo dizendo qual sua reuniao, qual seu tipo e uma descricao
    // load views

    require APP . 'view/_templates/header.php';
    require APP . 'view/solr/schedule.php';
    require APP . 'view/_templates/footer.php';
  }*/

  public function schedule(){

    $nome = '';
    $tipo = '';
    $ano_reuniao = -1;
    $num_reuniao = -1;

    if(isset($_POST['nome'])){
     $nome = $_POST['nome'];
   }
   if(isset($_POST['num_reuniao'])){
     $num_reuniao = $_POST['num_reuniao'];
   }
   if(isset($_POST['ano_reuniao'])){
     $ano_reuniao = $_POST['ano_reuniao'];
   }
   if(isset($_POST['tipo'])){
     $tipo = $_POST['tipo'];
   }

    //var_dump($_POST);

   $busca_n = 1;
   $reuniao = $this->model->get_ultima_reuniao();
   $reuniao = array_values(get_object_vars($reuniao[0]));
   $cur_ano_reuniao = intval($reuniao[1]);
   $cur_num_reuniao = intval($reuniao[0]);

   $seq_exp = $this->model->getLastSeq("exp");
   $seq_ciencia = $this->model->getLastSeq("ciencia");
   $seq_odia = $this->model->getLastSeq("odia");
   $seq_homo = $this->model->getLastSeq("homo");

   $seq_num_ciencia = intval($seq_ciencia[0]->{"max(seq_num)"});
   $seq_ano_ciencia = intval($seq_ciencia[0]->{"max(seq_ano)"});

   $seq_num_odia = intval($seq_odia[0]->{"max(seq_num)"});
   $seq_ano_odia = intval($seq_odia[0]->{"max(seq_ano)"});

   $seq_num_homo = intval($seq_homo[0]->{"max(seq_num)"});
   $seq_ano_homo = intval($seq_homo[0]->{"max(seq_ano)"});


   if($nome == '' && $tipo == '' && $ano_reuniao == -1 && $num_reuniao == -1){
    $Available = $this->model->getAvailable();
  }
  else{
    $Available_cur = $this->model->buscaPauta($nome, $num_reuniao, $ano_reuniao, $tipo);
  }
  $InUse = $this->model->getInUse();
  $Informes = $this->model->getInformes($cur_num_reuniao, $cur_ano_reuniao);

  require APP . 'view/_templates/header.php';
  require APP . 'view/solr/schedule.php';
  require APP . 'view/_templates/footer.php';
}

public function get_attachs_info(){
  $aResult = '';

  if(!isset($_POST['arguments']) || (count($_POST['arguments']) != 3)){
   $aResult = 'Argumentos invalidos!';
  }
  //var_dump($_POST);

  if($aResult == ''){
    $name = $_POST['arguments'][0];
    $num_reuniao = $_POST['arguments'][1];
    $ano_reuniao = $_POST['arguments'][2];

    $aResult = $this->model->get_attachs($name, $num_reuniao, $ano_reuniao);
  }

  $files = array();
  foreach ($aResult as $file) {
    if(is_file('download/' . $file->file_name))
      array_push($files, 'download/' . $file->file_name);
  }
  $zipname = 'file.zip';
  $zip = new ZipArchive;
  $zip->open($zipname, ZipArchive::CREATE);
  foreach ($files as $filename) {
    $zip->addFile($filename);
  }
  $zip->close();

  //header('Content-Type: application/zip');
  //header('Content-disposition: attachment; filename=$zipname');
  //header('Content-Length: ' . filesize($zipname));
  //header("Pragma: no-cache");
  //readfile($zipname);
  
  echo json_encode(array('zip' => $zipname));
}

public function get_item_info(){

  $aResult = '';

  if(!isset($_POST['arguments']) || (count($_POST['arguments']) != 3)){
   $aResult = 'Argumentos invalidos!';
  }
  //var_dump($_POST);

  if($aResult == ''){
    $name = $_POST['arguments'][0];
    $num_reuniao = $_POST['arguments'][1];
    $ano_reuniao = $_POST['arguments'][2];

    $item_info = $this->model->get_item($name, $num_reuniao, $ano_reuniao);
    $item_attachs = $this->model->get_attachs($name, $num_reuniao, $ano_reuniao);

    echo json_encode(array('item_info' => $item_info, 'item_attachs' => $item_attachs));
  } else{
    echo $aResult;
  }

}

public function get_reuniao_info(){

  $aResult = '';

  if(!isset($_POST['arguments']) || (count($_POST['arguments']) != 2)){
   $aResult = 'Argumentos invalidos!';
 }

 $num_reuniao = $_POST['arguments'][0];
 $ano_reuniao = $_POST['arguments'][1];

 $reuniao_info = $this->model->get_reuniao($num_reuniao, $ano_reuniao);

    //var_dump($item_attachs);

 echo json_encode($reuniao_info);

}

public function remove_attach(){
  $aResult = '';

  if(!isset($_POST['arguments']) || (count($_POST['arguments']) != 4)){
   $aResult = 'Argumentos invalidos!';
 }

 $item_name = $_POST['arguments'][0];
 $num_reuniao = $_POST['arguments'][1];
 $ano_reuniao = $_POST['arguments'][2];
 $file_name = $_POST['arguments'][3];

 $item_info = $this->model->remove_attach($item_name, $num_reuniao, $ano_reuniao, $file_name);
 if($item_info == 0)
  echo "ERROR";
else
  echo "OK";
}

public function set_handler(){

  $aResult = '';

  if(!isset($_POST['functionname'])){
   $aResult = 'Nome da funcao invalido!';
 }
 if(!isset($_POST['arguments']) || (count($_POST['arguments']) != 3)){
   $aResult = 'Argumentos invalidos!';
 }
 $name = $_POST['arguments'][0];
 $num_reuniao = $_POST['arguments'][1];
 $ano_reuniao = $_POST['arguments'][2];

 if($aResult == ''){
  switch($_POST['functionname']) {
    case 'set_inUse':
    $this->model->set_inUse($name, $num_reuniao, $ano_reuniao);
    $aResult = 'Item Adicionado a Pauta com Sucesso';
    break;
    case 'set_available':
    $this->model->set_available($name, $num_reuniao, $ano_reuniao);
    $aResult = 'Item Removido da Pauta com Sucesso';
    break;
    default:
    $aResult = 'Funcao: '.$_POST['functionname'].', nao pode ser encontrada!';
    break;
  }
}

echo json_encode($aResult);
}

public function informe_handler(){

  $aResult = '';
  $rowMod = 0;

  if(!isset($_POST['functionname'])){
   $aResult = 'Nome da funcao invalido!';
 }
 if(!isset($_POST['arguments']) || (count($_POST['arguments']) != 3)){
   $aResult = 'Numero de argumentos invalidos!';
 }
 if($_POST['arguments'][0] == ""){
  $aResult = 'Informe em branco!';
}

$informe = $_POST['arguments'][0];
$num_reuniao = $_POST['arguments'][1];
$ano_reuniao = $_POST['arguments'][2];

if($aResult == ''){
  switch($_POST['functionname']) {
    case 'add_informe':
    $rowMod = $this->model->add_informe($informe, $num_reuniao, $ano_reuniao);
    $aResult = 'Informe Adicionado com Sucesso';
    break;
    case 'remove_informe':
    $rowMod = $this->model->remove_informe($informe, $num_reuniao, $ano_reuniao);
    $aResult = 'Informe Removido com Sucesso';
    break;
    default:
    $aResult = 'Funcao: '.$_POST['functionname'].', nao pode ser encontrada!';
    break;
  }
}

echo json_encode($aResult);
echo json_encode($rowMod);
}

public function criaReuniao(){

  if(count($_POST) >= 6){  
    $no = $_POST["no"];
    unset($_POST["no"]);

    $tipo = $_POST["tipo"];
    unset($_POST["tipo"]);

    $num_reuniao = intval($_POST["num_reuniao"]);
    unset($_POST["num_reuniao"]);

    $ano_reuniao = intval($_POST["ano_reuniao"]);
    unset($_POST["ano_reuniao"]);

    $data = $_POST["data"];
    unset($_POST["data"]);

    $hora = $_POST["hora"];
    unset($_POST["hora"]);
    $hora = $hora . ":00";

    $local = $_POST["local"];
    unset($_POST["local"]);

    $num_reuniao_ant = $_POST["num_reuniao_ant"];
    unset($_POST["num_reuniao_ant"]);

    $ano_reuniao_ant = $_POST["ano_reuniao_ant"];
    unset($_POST["ano_reuniao_ant"]);

    $datahora = $data . " " . $hora;

    //echo $tipo;

    $this->model->criaReuniao($no, $num_reuniao, $ano_reuniao, $datahora, $local, $num_reuniao_ant, $ano_reuniao_ant, $tipo);
  }

  // where to go after file has been added
  header('location: ' . URL . 'solr/schedule');

  // Cache dump
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");


}

public function salvaItem(){
  //var_dump($_POST);
  //var_dump($_FILES);

  if(count($_POST) >= 6){
    $suplementar = "nao";

    $name = $_POST["nome"];
    unset($_POST["nome"]);

    $num_reuniao = intval($_POST["num_reuniao"]);
    unset($_POST["num_reuniao"]);

    $ano_reuniao = intval($_POST["ano_reuniao"]);
    unset($_POST["ano_reuniao"]);

    $tipo = $_POST["tipo"];
    unset($_POST["tipo"]);

    $num_seq = intval($_POST["num_seq"]);
    unset($_POST["num_seq"]);

    $ano_seq = intval($_POST["ano_seq"]);
    unset($_POST["ano_seq"]);

    if(isset($_POST["suplementar"])){
      $suplementar = $_POST["suplementar"];
      unset($_POST["suplementar"]);
    }

    $descricao = $_POST["descricao"];
    unset($_POST["descricao"]);
  }

  $files = array();
  foreach($_FILES["item_attachs"]["name"] as $file){
    $files[] = basename($file);
  }
  
  if($_POST["envia"] == "Salvar"){
    $this->model->update_item($name, $num_reuniao, $ano_reuniao, $tipo, $num_seq, $ano_seq, $suplementar, $files, $descricao);
    $this->enviarArquivoParam($files);

    // where to go after file has been added
    header('location: ' . URL . 'solr/schedule');

    // Cache dump
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

  } else if($_POST["envia"] == "Criar"){
    $this->model->insert_item($name, $num_reuniao, $ano_reuniao, $tipo, $num_seq, $ano_seq, $suplementar, $files, $descricao);
    $this->enviarArquivoParam($files);

    // where to go after file has been added
    header('location: ' . URL . 'solr/schedule');

    // Cache dump
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

  } else if($_POST["envia"] == "Baixar Anexos"){
    ob_clean();
    ob_end_flush();
    $aResult = $this->model->get_attachs($name, $num_reuniao, $ano_reuniao);
    $files = array();
    foreach ($aResult as $file) {
      if(is_file('download/' . $file->file_name))
        array_push($files, 'download/' . $file->file_name);
    }
    $zipname = 'anexos.zip';
    $zip = new ZipArchive;
    $zip->open($zipname, ZipArchive::CREATE);
    foreach ($files as $filename) {
      $zip->addFile($filename);
    }
    $zip->close();

    header('Content-Type: application/zip');
    header('Content-disposition: attachment; filename='.$zipname);
    header('Content-Length: ' . filesize($zipname));
    header("Pragma: no-cache");
    readfile($zipname);

    unlink($zipname);
  }

}

public function enviarArquivoParam($files){
  date_default_timezone_set('America/Sao_Paulo');
  $creation = date('Y-m-d_H-i-s');
  //var_dump($_FILES);
  for($i = 0; $i < count($_FILES["item_attachs"]['name']); $i++){
    $fpath = $this->oneFileUpload($i, $creation);
    $this->indexaArquivo($fpath, $filename, false, "");
  }
}

public function oneFileUpload($index, $creation)
{
    // if we have an id that should be edited
  if ($_FILES["item_attachs"]['error'][$index] == 0) {

    $upload_dir = 'download';

    if (!file_exists($upload_dir)) {
      mkdir($upload_dir, 0755, true);
    }

    $target_file = $upload_dir . '/' . basename($_FILES["item_attachs"]['name'][$index]);

    if ( !move_uploaded_file($_FILES["item_attachs"]["tmp_name"][$index], $target_file) ) {
      return null;
    }

    return $target_file;
  }

}

public function get_descricoes(){
  $aResult = '';

  if(!isset($_POST['arguments']) || (count($_POST['arguments']) != 3)) {
   $aResult = 'Argumentos invalidos!';
  }

  if($aResult == ''){
    $names = $_POST['arguments'][0];
    $num_reuniao = $_POST['arguments'][1];
    $ano_reuniao = $_POST['arguments'][2];

    $aResult = $this->model->get_descricoes($names, $num_reuniao, $ano_reuniao);
  }

  echo json_encode($aResult);
}


public function salvaDoc(){


  $aResult = '';

  if(!isset($_POST['content'])) {
   $aResult = 'Conteúdo Vazio !';
  }
  if(!isset($_POST['tipo'])) {
   $aResult = 'Conteúdo Sem Tipo !';
  }

  if($aResult == ''){
    $tipo = $_POST['tipo'];
    $content = $_POST['content'];

    if($tipo == "ata" && isset($_POST['num_reuniao']) && isset($_POST['ano_reuniao'])){
      $aResult = $this->model->salvaAta($content, $_POST['num_reuniao'], $_POST['ano_reuniao']);
    } else if($tipo == "pauta" && isset($_POST['num_reuniao']) && isset($_POST['ano_reuniao'])){
      $aResult = $this->model->salvaPauta($content, $_POST['num_reuniao'], $_POST['ano_reuniao']);
    } else if($tipo == "documento" && isset($_POST['num_reuniao']) && isset($_POST['ano_reuniao']) && isset($_POST['item_name'])){
      $aResult = $this->model->salvaDoc($content, $_POST['num_reuniao'], $_POST['ano_reuniao'], $_POST['item_name']);
    }
  }

  // where to go after file has been added
  header('location: ' . URL . 'solr/schedule');

  // Cache dump
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
}


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

    //var_dump($resultset);
      // load views
    require APP . 'view/_templates/header.php';
    require APP . 'view/solr/listar.php';
    require APP . 'view/_templates/footer.php';
  }



	/**
     * PAGE: listar_categoria
     * This method handles what happens when you move to http://yourproject/solr/listar_categoria
     */
  public function listar_categoria($page = 1)
  {
    if (isset($_POST["submit"])) {
     $_SESSION['category'] = $_POST["category"];
     $_SESSION['year'] = $_POST["year"];
   }

		// soh entra se setou ou a categoria ou o ano e sao diferentes de vazio
   if((isset($_SESSION['category']) || isset($_SESSION['year'])) && (!empty($_SESSION['year']) || !empty($_SESSION['category']))) {
			// create a client instance
     $client = new Solarium\Client($this->config);

			// get a select query instance
     $query = $client->createSelect();

     if(empty($_SESSION['year'])) {
      $query->setQuery('category_txt_pt:"/'.$_SESSION['category'].'"');
    }
    elseif(empty($_SESSION['category'])) {
      $query->setQuery('dateyear_s:'.$_SESSION['year']);

    }
    else {
      $query->setQuery('(dateyear_s:'.$_SESSION['year'].') AND (category_txt_pt:"'.$_SESSION['category'].'")');
      $this->console('(dateyear_s:'.$_SESSION['year'].') AND (category_txt_pt:"'.$_SESSION['category'].'")');
    }

			// set start and rows param (comparable to SQL limit) using fluent interface
    $query->setStart(($page-1)*10)->setRows(10);

			// this executes the query and returns the result
    $resultset = $client->execute($query);

			// display the total number of documents found by solr
    $number_of_results = $resultset->getNumFound();
  }

        // load views
  require APP . 'view/_templates/header.php';
  require APP . 'view/solr/listar_categoria.php';
  require APP . 'view/_templates/footer.php';
}



	// para debugar
private function console( $data ) {
  if ( is_array( $data ) )
   $output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
 else
   $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

 echo $output;
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

      var_dump($_FILES);
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

   public function enviarCategoria()
   {
        // if we have POST data
    if (isset($_POST["category"])) {
     $this->categoria = $_POST["category"];
   }

   header('location: ' . URL . 'solr/listar_categoria');

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

			// recebe vetor ordenado com o nome dos arquivos a serem indexados
       $flist = $this->batchUpload ( 'zipToUpload', $upload_dir );

       $dest_dir = 'download/';

       if ($flist != null && count($flist) != 0) {
        for($i = 0 ; $i < count($flist); $i++) {
					// soh tem o imagem, indexa como se fosse o texto
         if($this->endsWith($flist[$i], "_img.pdf")) {
          rename($upload_dir.$flist[$i], $dest_dir.$flist[$i]);
          $this->indexaArquivo($dest_dir.$flist[$i], $flist[$i], false, "");
          continue;
        }

        $imagem = "";

					// se nao for o ultimo, ve se o proximo tem
					// o mesmo nome e termina com _img.pdf
					// se positivo, indexa os dois, se nao, indexa soh o texto
        if($i < count($flist)-1) {
          if($this->endsWith($flist[$i+1], "_img.pdf")) {
           $a = str_replace(".pdf", "", $flist[$i]);
           
           if($this->endsWith($a, ".doc")) {
            $a = str_replace(".doc", "", $a);
          }

          else if($this->endsWith($a, ".docx")) {
            $a = str_replace(".docx", "", $a);
          }

          else if($this->endsWith($a, ".odt")) {
            $a = str_replace(".odt", "", $a);
          }

          $b = str_replace("_img.pdf", "", $flist[$i+1]);

		   // sao iguais
          if(strcmp($a, $b) == 0) {
            $imagem = $dest_dir.$flist[$i+1];
            rename($upload_dir.$flist[$i+1], $imagem);
          }
        }
      }

      rename($upload_dir.$flist[$i], $dest_dir.$flist[$i]);
      $this->indexaArquivo($dest_dir.$flist[$i], $flist[$i], false, $imagem);

					// se ja indexou a imagem, pula um indice
      if(!empty($imagem))
        $i++;
    }
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
          echo $upload_dir;
          mkdir($upload_dir, 0755, true);
        }

        $target_file = $upload_dir . '/' . basename($_FILES[$input_name]['name'][$i]);
        echo getcwd();

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
     public function batchUpload($input_name, $upload_dir) {
		// if we have an id that should be edited
      if ($_FILES [$input_name] ['error'] == 0) {
       if (! file_exists ( $upload_dir )) {
        mkdir ( $upload_dir, 0755, true );
      }

			// esvazia o diretorio temp
      else {
        $files1 = scandir ( $upload_dir );
        foreach($files1 as $f){
          if(is_file($f))
           unlink($f);
       }
     }

     $target_file = $upload_dir . '/' . basename ( $_FILES [$input_name] ['name'] );

     if (file_exists ( $target_file )) {
      unlink ( $target_file );
    }

    if (! move_uploaded_file ( $_FILES [$input_name] ["tmp_name"], $target_file )) {
      echo "Erro ao mover arquivo".$_FILES [$input_name] ["tmp_name"]." para ".$target_file;
      return null;
    }

			// extrai .zip
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
  if(!($this->endsWith($f, ".pdf") || $this->endsWith($f, ".doc") || $this->endsWith($f, ".docx") || $this->endsWith($f, ".odt"))) {
    unset ( $files1 [$f]);
    unlink ( $upload_dir."/".$f);
  }
}

asort($files1);

$flist = [];

			// associa os valores do array com o indice
$i = 0 ;
foreach($files1 as $f) {
  $flist[$i] = $f;
  $i++;
}

return $flist;
}
}
function endsWith($haystack, $needle) {
		// search forward starting from end minus needle length characters
  return $needle === "" || (($temp = strlen ( $haystack ) - strlen ( $needle )) >= 0 && strpos ( $haystack, $needle, $temp ) !== false);
}

}
