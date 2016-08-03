<?php

class Model
{
    /**
     * @param object $db A PDO database connection
     */
    function __construct($db)
    {
      try {
        $this->db = $db;
      } catch (PDOException $e) {
        exit('Database connection could not be established.');
      }
    }

    public function getInformes($num_reuniao, $ano_reuniao){

      $sql = "SELECT informe FROM informes WHERE num_reuniao = :num_reuniao AND ano_reuniao = :ano_reuniao";
      $query = $this->db->prepare($sql);
      $parameters = array(':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao);

      $query->execute($parameters);
      $res = $query->fetchAll();
      if(count($res) == 0){
        $res = new stdClass;
        $res->informe = "";
        return array($res);
      } else{
        return $res;
      }
    }

    public function getAvailable(){

      $sql = "SELECT * FROM itens WHERE in_use = False";
      $query = $this->db->prepare($sql);

      $query->execute();
      return $query->fetchAll();
    }

    public function getInUse(){

      $sql = "SELECT * FROM itens WHERE in_use = True";
      $query = $this->db->prepare($sql);

      $query->execute();
      return $query->fetchAll();
    }

    public function get_ultima_reuniao(){

      $sql = "SELECT max(num), max(ano) FROM reunioes";
      $query = $this->db->prepare($sql);

      $query->execute();
      return $query->fetchAll();
    }

    public function get_reuniao($num_reuniao, $ano_reuniao){

      $sql = "SELECT * FROM reunioes WHERE num = :num_reuniao AND ano = :ano_reuniao";
      $query = $this->db->prepare($sql);
      $parameters = array(':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao);

      $query->execute($parameters);
      return $query->fetchAll();
    }

    public function set_available($name, $num_reuniao, $ano_reuniao){

      $name = trim($name);
      $sql = "UPDATE itens SET in_use=False WHERE name = :name AND num_reuniao = :num_reuniao AND ano_reuniao = :ano_reuniao";
      $query = $this->db->prepare($sql);
      $parameters = array(':name' => $name, ':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao);

      $query->execute($parameters);
    }

    public function set_inUse($name, $num_reuniao, $ano_reuniao){

      $name = trim($name);
      $sql = "UPDATE itens SET in_use=True WHERE name = :name AND num_reuniao = :num_reuniao AND ano_reuniao = :ano_reuniao";
      $query = $this->db->prepare($sql);
      $parameters = array(':name' => $name, ':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao);

      $query->execute($parameters);
    }

    public function add_informe($informe, $num_reuniao, $ano_reuniao){

      $sql = "INSERT INTO informes VALUES (:informe, :num_reuniao, :ano_reuniao)";
      $query = $this->db->prepare($sql);
      $parameters = array(':informe' => $informe, ':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao);

      $query->execute($parameters);

      return $query->rowCount();
    }

    public function remove_informe($informe, $num_reuniao, $ano_reuniao){

      $sql = "DELETE FROM informes WHERE informe = :informe AND num_reuniao = :num_reuniao AND ano_reuniao = :ano_reuniao";
      $query = $this->db->prepare($sql);
      $parameters = array(':informe' => $informe, ':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao);

      $query->execute($parameters);

      return $query->rowCount();
    }

    public function buscaPauta($name, $num_reuniao, $ano_reuniao, $tipo){

      $name = trim($name);
      $tipo = trim($tipo);
      $name = "%" . $name . "%";
      $sql = "SELECT * FROM itens WHERE in_use = False ";

      $num_str = "num_reuniao = :num_reuniao ";
      $and_str = "AND ";
      $ano_str = "ano_reuniao = :ano_reuniao ";
      $name_str = "name LIKE :name ";
      $tipo_str = "tipo = :tipo ";

      if($name != ''){
        $sql = $sql . $and_str;
        $sql = $sql . $name_str;
      }
      if($num_reuniao > 0){
        $sql = $sql . $and_str;
        $sql = $sql . $num_str;
      }
      if($ano_reuniao > 0){
        $sql = $sql . $and_str;
        $sql = $sql . $num_str;
      }
      if($tipo != ''){
        $sql = $sql . $and_str;
        $sql = $sql . $tipo_str;
      }

      $query = $this->db->prepare($sql);

      if($name != ''){
        $query->bindParam(':name', $name);
      }
      if($num_reuniao > 0){
        $query->bindParam(':num_reuniao', $num_reuniao);
      }
      if($ano_reuniao > 0){
        $query->bindParam(':ano_reuniao', $ano_reuniao);
      }
      if($tipo != ''){
        $query->bindParam(':tipo', $tipo);
      }

      $query->execute();

      return $query->fetchAll();
    }

    public function get_item($name, $num_reuniao, $ano_reuniao){

      $sql = "SELECT * FROM itens WHERE name = :name AND num_reuniao = :num_reuniao AND ano_reuniao = :ano_reuniao";
      $query = $this->db->prepare($sql);
      $parameters = array(':name' => $name, ':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao);

      $query->execute($parameters);
      return $query->fetchAll();
    }

    public function get_attachs($name, $num_reuniao, $ano_reuniao){

      $sql = "SELECT * FROM attachments WHERE item_name = :name AND num_reuniao = :num_reuniao AND ano_reuniao = :ano_reuniao";
      $query = $this->db->prepare($sql);
      $parameters = array(':name' => $name, ':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao);

      $query->execute($parameters);
      return $query->fetchAll();
    }

    public function remove_attach($item_name, $num_reuniao, $ano_reuniao, $file_name){

      $sql = "DELETE FROM attachments WHERE item_name = :name AND num_reuniao = :num_reuniao AND ano_reuniao = :ano_reuniao AND file_name = :file_name";
      $query = $this->db->prepare($sql);
      $parameters = array(':name' => $item_name, ':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao, ':file_name' => $file_name);

      $query->execute($parameters);
      return $query->rowCount();
    }

    public function update_item($name, $num_reuniao, $ano_reuniao, $tipo, $num_seq, $ano_seq, $suplementar, $files, $descricao){
      //$sql = "INSERT INTO itens VALUES (:name, NOW(), :num_reuniao, :ano_reuniao, :num_seq, :ano_seq, :tipo, :descricao, false, :suplementar, true)";

      $sql = "";
      if($suplementar == "sim"){
        $sql = "UPDATE itens SET date = NOW(), seq_num = :num_seq, seq_ano = :ano_seq, tipo = :tipo, descricao = :descricao, in_use = false, suplementar = true, latest = true WHERE name = :name AND num_reuniao = :num_reuniao AND ano_reuniao = :ano_reuniao";
      }
      else{
        $sql = "UPDATE itens SET date = NOW(), seq_num = :num_seq, seq_ano = :ano_seq, tipo = :tipo, descricao = :descricao, in_use = false, suplementar = false, latest = true WHERE name = :name AND num_reuniao = :num_reuniao AND ano_reuniao = :ano_reuniao";
      }
      $query = $this->db->prepare($sql);
      $parameters = array(':name' => $name, ':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao, ':num_seq' => $num_seq, ':ano_seq' => $ano_seq, ':tipo' => $tipo, ':descricao' => $descricao);
      $query->execute($parameters);



      $tot_count = $query->rowCount();
      if($tot_count > 0){
        foreach ($files as $file) {
          $sqlf = "INSERT INTO attachments VALUES (:item_name, :num_reuniao, :ano_reuniao, :file_name)";
          $queryf = $this->db->prepare($sqlf);
          $parametersf = array(':item_name' => $name, ':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao, ':file_name' => $file);
          $queryf->execute($parametersf);
        }
      }


      return $query->rowCount(); 
    }

    public function item_exist($name, $num_reuniao, $ano_reuniao){
      $sql = "SELECT * FROM itens WHERE name = :name AND num_reuniao = :num_reuniao AND ano_reuniao = :ano_reuniao LIMIT 1";
      $query = $this->db->prepare($sql);
      $parameters = array(':name' => $name, ':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao);
      $query->execute($parameters);
      if($query->rowCount() > 0)
        return true;
      else
        return false;
    }

    public function insert_item($name, $num_reuniao, $ano_reuniao, $tipo, $num_seq, $ano_seq, $suplementar, $files, $descricao){
      //$sql = "INSERT INTO itens VALUES (:name, NOW(), :num_reuniao, :ano_reuniao, :num_seq, :ano_seq, :tipo, :descricao, false, :suplementar, true)";
      
      $sql = "";
      if($suplementar == "sim"){
        $sql = "INSERT INTO itens values(:name, NOW(), :num_reuniao, :ano_reuniao, :num_seq, :ano_seq, :tipo, :descricao,NULL, false, true, true)";
      }
      else{
        $sql = "INSERT INTO itens values(:name, NOW(), :num_reuniao, :ano_reuniao, :num_seq, :ano_seq, :tipo, :descricao,NULL, false, false, true)";
      }
      $query = $this->db->prepare($sql);


      $parameters = array(':name' => $name, ':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao, ':num_seq' => $num_seq, ':ano_seq' => $ano_seq, ':tipo' => $tipo, ':descricao' => $descricao);
      $query->execute($parameters);

      $tot_count = $query->rowCount();
      if($tot_count > 0){
        foreach ($files as $file) {
          $sqlf = "INSERT INTO attachments VALUES (:item_name, :num_reuniao, :ano_reuniao, :file_name)";
          $queryf = $this->db->prepare($sqlf);
          $parametersf = array(':item_name' => $name, ':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao, ':file_name' => $file);
          $queryf->execute($parametersf);
        }
      }
      

      return $query->rowCount(); 
    }

    //Parametrizar esta funcao no futuro
    public function get_descricoes($names, $num_reuniao, $ano_reuniao){

      $sql = "SELECT descricao, suplementar, tipo FROM itens WHERE (num_reuniao = $num_reuniao AND ano_reuniao = $ano_reuniao) AND (";

      for($i = 0; $i < count($names); $i++){
        $sql = $sql . " name = \"" . $names[$i] . "\" ";
        if($i < count($names)-1){
          $sql = $sql . " OR";
        }
      }

      $sql = $sql . ")";

      $query = $this->db->prepare($sql);
      $query->execute();

      return $query->fetchAll();
    }

    public function salvaDoc($content, $num_reuniao, $ano_reuniao, $name){

      $content = trim($content);
      $name = trim($name);

      $sql = "UPDATE itens SET documento = :content WHERE name = :name AND num_reuniao = :num_reuniao AND ano_reuniao = :ano_reuniao";
      $query = $this->db->prepare($sql);
      $parameters = array(':name' => $name, ':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao, ':content' => $content);

      $query->execute($parameters);
    }

    public function salvaAta($content, $num_reuniao, $ano_reuniao){

      $content = trim($content);

      $sql = "UPDATE reunioes SET ata = :content WHERE num = :num_reuniao AND ano = :ano_reuniao";
      $query = $this->db->prepare($sql);
      $parameters = array(':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao, ':content' => $content);

      $query->execute($parameters);
    }

    public function salvaPauta($content, $num_reuniao, $ano_reuniao){

      $content = trim($content);

      $sql = "UPDATE reunioes SET pauta = :content WHERE num = :num_reuniao AND ano = :ano_reuniao";
      $query = $this->db->prepare($sql);
      $parameters = array(':num_reuniao' => $num_reuniao, ':ano_reuniao' => $ano_reuniao, ':content' => $content);

      $query->execute($parameters);
    }



    /**
     * Get all songs from database
     */
    public function getAllSongs()
    {
      $sql = "SELECT id, artist, track, link FROM song";
      $query = $this->db->prepare($sql);
      $query->execute();

        // fetchAll() is the PDO method that gets all result rows, here in object-style because we defined this in
        // core/controller.php! If you prefer to get an associative array as the result, then do
        // $query->fetchAll(PDO::FETCH_ASSOC); or change core/controller.php's PDO options to
        // $options = array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC ...
      return $query->fetchAll();
    }

    /**
     * Add a song to database
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     */
    public function addSong($artist, $track, $link)
    {
      $sql = "INSERT INTO song (artist, track, link) VALUES (:artist, :track, :link)";
      $query = $this->db->prepare($sql);
      $parameters = array(':artist' => $artist, ':track' => $track, ':link' => $link);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

      $query->execute($parameters);
    }

    /**
     * Delete a song in the database
     * Please note: this is just an example! In a real application you would not simply let everybody
     * add/update/delete stuff!
     * @param int $song_id Id of song
     */
    public function deleteSong($song_id)
    {
      $sql = "DELETE FROM song WHERE id = :song_id";
      $query = $this->db->prepare($sql);
      $parameters = array(':song_id' => $song_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

      $query->execute($parameters);
    }

    /**
     * Get a song from database
     */
    public function getSong($song_id)
    {
      $sql = "SELECT id, artist, track, link FROM song WHERE id = :song_id LIMIT 1";
      $query = $this->db->prepare($sql);
      $parameters = array(':song_id' => $song_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

      $query->execute($parameters);

        // fetch() is the PDO method that get exactly one result
      return $query->fetch();
    }

    /**
     * Update a song in database
     * Please note that it's not necessary to "clean" our input in any way. With PDO all input is escaped properly
     * automatically. We also don't use strip_tags() etc. here so we keep the input 100% original (so it's possible
     * to save HTML and JS to the database, which is a valid use case). Data will only be cleaned when putting it out
     * in the views (see the views for more info).
     * @param string $artist Artist
     * @param string $track Track
     * @param string $link Link
     * @param int $song_id Id
     */
    public function updateSong($artist, $track, $link, $song_id)
    {
      $sql = "UPDATE song SET artist = :artist, track = :track, link = :link WHERE id = :song_id";
      $query = $this->db->prepare($sql);
      $parameters = array(':artist' => $artist, ':track' => $track, ':link' => $link, ':song_id' => $song_id);

        // useful for debugging: you can see the SQL behind above construction by using:
        // echo '[ PDO DEBUG ]: ' . Helper::debugPDO($sql, $parameters);  exit();

      $query->execute($parameters);
    }

    /**
     * Get simple "stats". This is just a simple demo to show
     * how to use more than one model in a controller (see application/controller/songs.php for more)
     */
    public function getAmountOfSongs()
    {
      $sql = "SELECT COUNT(id) AS amount_of_songs FROM song";
      $query = $this->db->prepare($sql);
      $query->execute();

        // fetch() is the PDO method that get exactly one result
      return $query->fetch()->amount_of_songs;
    }
  }
