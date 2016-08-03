<body>
  <!----start-header---->
  <div class="header">
    <div class="container">
      <div class="logo">
        <a href="<?php echo URL; ?>"><h1><strong>BIBLIOTECA DO IC</strong></h1></a>
      </div>
      <div class="menu">
        <!-- <a class="toggleMenu" href="#"><img src="web/images/nav_icon.png" alt="" /> </a> -->
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

      </div>
      <div class="clearfix"> </div>
      <!----//End-top-nav---->
    </div>
  </div>
  <!----//End-header---->

  <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
  <script src="<?php echo URL; ?>js/jquery.toaster.js"></script>
  <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({ 
    selector:'textarea',
    height: 500,
    plugins: [
    'advlist autolink lists link charmap print preview',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime table contextmenu paste'
    ]
    });</script>
  <script src="<?php echo URL; ?>js/fileDownload.js" type="text/javascript"></script>

  <!-- Start my scripts -->
  <script>

    function query(func, name, num_reuniao, ano_reuniao){
      jQuery.post("<?php echo URL; ?>solr/set_handler", {functionname: func, arguments: [name, num_reuniao, ano_reuniao]}, function(data){
        //console.log(data);
        $.toaster({ message : data.replace(/['"\n]+/g, ''), priority: 'info' });
      });
    }

    function allowDrop(ev) {
      ev.preventDefault();
    }

    function drag(ev) {
      ev.dataTransfer.setData("text", ev.target.id);
    }

    function drop(ev) {
      ev.preventDefault();

      var data = ev.dataTransfer.getData("text");
      var name = document.getElementById(data).innerHTML;
      name = name.substring(0, name.length-9);
      var data_id = document.getElementById(data).id;
      var parent_id = document.getElementById(data).parentElement.id;

      var pos = data_id.split('_')[1];
      var pre = ev.target.id.split('_')[0];

      if((pre === pos || ev.target.id == 'buscas') && ev.target.id != parent_id){
        ev.target.appendChild(document.getElementById(data));
        ano_reuniao = Number("<?php echo $cur_ano_reuniao?>");
        num_reuniao = Number("<?php echo $cur_num_reuniao?>");
        if(ev.target.id == 'buscas'){
          query('set_available', name, num_reuniao, ano_reuniao);
        }
        else{
          query('set_inUse', name, num_reuniao, ano_reuniao);
        }
      }
    }

    $(document).ready(function(){

      /* Informes Gerais COMECO */
    //Inicializar o i em PHP
    var amount = Number("<?php echo count($Informes)?>");
    var i = amount + 1;

    $(document).on('click','.informes_btn_suc', function(){
      var pre = $(this).prop("id").split('_')[0];
      pre += "_input";
      var this_elem = $(this);
      var num_reuniao = Number("<?php echo $cur_num_reuniao?>");
      var ano_reuniao = Number("<?php echo $cur_ano_reuniao?>");
      //Ao adicionar informe no futuro sera necessario mandar # da reuniao e ano.
      //console.log(document.getElementById(pre).value);
      jQuery.post("<?php echo URL; ?>solr/informe_handler", {functionname: "add_informe", arguments: [document.getElementById(pre).value, num_reuniao, ano_reuniao]}, function(data){
        //console.log(i);
        if(data.split("\"")[2] >= 1){
          $.toaster({ message : data.split("\"")[1], priority: 'info' });
          if((amount == 1 && (this_elem.prop("id") == 'informes_add')) || (this_elem.prop("id") != 'informes_add')){
            $('#informes_div').append('<div id="'+ i +'informes_row" class="row">\
              <div class="col-md-9" style="padding-left: 0.75em; padding-right: 0px; width: 82%;">\
                <input id="'+ i +'informes_input" class="form-control" type="text" name="content" value="" style="margin: 2px; width: 95%;"/>\
              </div>\
              <div class="col-md-1" style="padding: 0px; margin: 0px; margin-top: 0.45em;">\
                <span class="input-group-btn">\
                  <button type="button" id="'+ i +'informes_add" class="btn btn-success btn-number informes_btn_suc">\
                    <span class="glyphicon glyphicon-plus"></span>\
                  </button>\
                </span>\
              </div>\
              <div class="col-md-1" id="informes_rm" style="padding: 0px; margin: 0px; margin-top: 0.5em; margin-bottom: 0.07em">\
                <span class="input-group-btn">\
                  <button type="button" id="'+ i +'informes" class="btn btn-danger btn-number informes_btn">\
                    <span class="glyphicon glyphicon-minus"></span>\
                  </button>\
                </span>\
              </div>\
            </div>');
            amount++;
            i++;
          }
          this_elem.prop('disabled', true);
          document.getElementById(pre).readOnly = true;
        }
      });
    });

    $(document).on('click','.informes_btn', function(){
      var pre = $(this).prop("id").split('_')[0];
      pre += "_input";
      var this_elem = $(this);
      var num_reuniao = Number("<?php echo $cur_num_reuniao?>");
      var ano_reuniao = Number("<?php echo $cur_ano_reuniao?>");
      //console.log(document.getElementById(pre).value);
      //console.log(pre);
      jQuery.post("<?php echo URL; ?>solr/informe_handler", {functionname: "remove_informe", arguments: [document.getElementById(pre).value, num_reuniao, ano_reuniao]}, function(data){
        //console.log(data);
        if(data.split("\"")[2] >= 1){
          $.toaster({ message : data.split("\"")[1], priority: 'info' });
          var button_id = this_elem.prop("id");
          $('#' + button_id + '_row').remove();
          amount--;
        }
      });
    });

    $(document).on('click','.informes_btn_spc', function(){
      var pre = $(this).prop("id").split('_')[0];
      pre += "_input";
      var num_reuniao = Number("<?php echo $cur_num_reuniao?>");
      var ano_reuniao = Number("<?php echo $cur_ano_reuniao?>");

      jQuery.post("<?php echo URL; ?>solr/informe_handler", {functionname: "remove_informe", arguments: [document.getElementById(pre).value, num_reuniao, ano_reuniao]}, function(data){
        if(data.split("\"")[2] >= 1){
          $.toaster({ message : data.split("\"")[1], priority: 'info' });
          document.getElementById('informes_input').value = "";
          $('#informes_add').prop('disabled', false);
          document.getElementById("informes_input").readOnly = false;
        }
      });
    });
    /* Informes Gerais FIM */

    /* Reacao pra click e double_click COMECO*/
    var dbclk = 0;
    $(document).on('dblclick','.dbclick', function(){
      dbclk = 2;
      var parent_id = $(this).parent().prop("id");
      var pos = $(this).prop("id").split('_')[1];
      ano_reuniao = Number("<?php echo $cur_ano_reuniao?>");
      num_reuniao = Number("<?php echo $cur_num_reuniao?>");
      name = $(this)[0].innerText;
      name = name.substring(0, name.length-9);

      if(parent_id == 'buscas'){
        $('#' + pos + '_div').append($(this));
        query('set_inUse', name, num_reuniao, ano_reuniao);
      }
      else{
        $('#buscas').append($(this));
        query('set_available', name, num_reuniao, ano_reuniao);
      }
    });

    function donothing(elem){
      if(dbclk == 0){
        //console.log(elem.innerHTML.split(/\s{4}/));
        splited = elem.innerHTML.split(/\s{4}/);
        name = splited[0].trim();
        num_reuniao = splited[1].split("/")[0];
        ano_reuniao = splited[1].split("/")[1];
        jsonReuniaoData = "";
        reuniaoData = "";

        jQuery.post("<?php echo URL; ?>solr/get_reuniao_info", {arguments: [num_reuniao, ano_reuniao]}, function(data){
          jsonReuniaoData = data;
          reuniaoData = JSON.parse(data);
          jQuery.post("<?php echo URL; ?>solr/get_item_info", {arguments: [name, num_reuniao, ano_reuniao]}, function(data){
            jsonData = data;
            data = JSON.parse(data);
            $('#item_info_form')[0].reset();
            $('#item_info_exp').removeAttr("selected");
            $('#item_info_ciencia').removeAttr("selected");
            $('#item_info_odia').removeAttr("selected");
            $('#item_info_homo').removeAttr("selected");

            //console.log(data);
            $("#item_info_nome").val(data.item_info[0].name);
            $("#item_info_"+data.item_info[0].tipo).prop("selected", "selected").change();
            if(data.item_info[0].suplementar == "0")
              $("#squaredOne").prop("checked", false);
            else
              $("#squaredOne").prop("checked", true);

            var dia = reuniaoData[0].data.split("-")[2];
            var mes = reuniaoData[0].data.split("-")[1];
            var ano = reuniaoData[0].data.split("-")[0];

            $("#item_info_reuniao").html(reuniaoData[0].num +'/'+ reuniaoData[0].ano +'&emsp;'+ reuniaoData[0].no + '&ordf; Reunião ' + reuniaoData[0].tipo + ' --- ' + dia +'/'+ mes +'/'+ ano);

            if(data.item_info[0].tipo === "exp"){
              $("#gera_deliberacao").hide();
              $("#gera_informacao").hide();
              $("#gera_homologacao").hide();

            } else if(data.item_info[0].tipo === "ciencia"){
              $("#gera_deliberacao").hide();
              $("#gera_homologacao").hide();
              $("#gera_informacao").show();
              $("#gera_informacao").attr("onclick", "").attr("onclick", "geraDoc('INFORMA&Ccedil;&Atilde;O', "+jsonData+", "+jsonReuniaoData+");");

            } else if(data.item_info[0].tipo === "odia"){
              $("#gera_informacao").hide();
              $("#gera_homologacao").hide();
              $("#gera_deliberacao").show();
              $("#gera_deliberacao").attr("onclick", "").attr("onclick", "geraDoc('DELIBERA&Ccedil;&Atilde;O', "+jsonData+", "+jsonReuniaoData+");");

            } else if(data.item_info[0].tipo === "homo"){
              $("#gera_deliberacao").hide();
              $("#gera_informacao").hide();
              $("#gera_homologacao").show();
              $("#gera_homologacao").attr("onclick", "").attr("onclick", "geraDoc('HOMOLOGA&Ccedil;&Atilde;O', "+jsonData+", "+jsonReuniaoData+");");

            }

            if(data.item_info[0].seq_num > 0 && data.item_info[0].seq_ano > 0){
              $("#item_info_seq_num").val(data.item_info[0].seq_num);
              $("#item_info_seq_ano").val(data.item_info[0].seq_ano);
            } else{
              $("#item_info_seq_num").val("");
              $("#item_info_seq_ano").val("");
            }


            item_info_data = data.item_info[0].date.split(" ")[0].split('-');
            $("#item_info_datahora").html(item_info_data[2] +'/'+ item_info_data[1] +'/'+ item_info_data[0] + '&emsp; - &emsp;' + data.item_info[0].date.split(" ")[1]);

            tinymce.get("item_info_descricao").setContent(data.item_info[0].descricao);
            //$("#item_info_descricao").val(data.item_info[0].descricao);

            //FILES
            $("#item_info_file_list").empty();
            $("#item_info_file_list").append('<div id="file_clearfix" class="clearfix"></div>');

            N = Object.keys(data.item_attachs).length;
            for(i = 0; i < N; i++){
              $('<li class="item_info_file" style="width: 85%;"> <img src="<?php echo URL; ?>images/pdf-icon.gif" alt="image"/> &emsp; ' + data.item_attachs[i].file_name + '</li>\
                <li style="display: inline; margin-top:8px; margin-left: 5px;">\
                  <span class="input-group-btn" style="display: inline;">\
                    <button type="button" class="btn btn-danger btn-number item_info_rmv_file">\
                      <span class="glyphicon glyphicon-trash"></span>\
                    </button>\
                  </span>\
                </li>').insertBefore("#file_clearfix");
            }

          });
        });

        $("#item_info_modal").modal();
      }
      else {
        dbclk--;
      }
    }

    $(document).on('click','.click', function(){
      setTimeout(donothing, 300, this);
    });

    $(".modal-wide").on("show.bs.modal", function() {
      var height = $(window).height() - 200;
      $(this).find(".modal-body").css("height", height);
    });


    $(document).on('click','.item_info_rmv_file', function(){
      var liprev = $(this).parent().parent();
      var licur = $(this).parent().parent().prev();
      liprev.remove();
      licur.remove();

      filename = licur.text().trim();
      item_name = $("#item_info_nome").val();
      if($('input[name="'+ filename +'"]').length == 0){
        jQuery.post("<?php echo URL; ?>solr/remove_attach", {arguments: [item_name, num_reuniao, ano_reuniao, filename]}, function(data){
          console.log(data);
        });
      } else{
        $('input[name="'+ filename +'"]').remove();
      }
      //console.log($('input[name="'+ filename +'"]').length);
      //console.log(licur.text().trim());
    });

  });
/* Reacao pra click e double_click FIM*/

function addNewFile(elem, clearfixid){
  var filename = $(elem).val().replace(/^.*[\\\/]/, '');
  $(elem).hide();
  $(elem).prop("name", filename);
  $('<input class="form-control" type="file" value="" onchange="if(validateSingleInput2(this)) addNewFile(this,\''+clearfixid+'\');" style="margin-bottom: 2%;" />').insertAfter($(elem));
  $('<li class="item_info_file" style="width: 85%;"> <img src="<?php echo URL; ?>images/pdf-icon.gif" alt="image"/> &emsp; ' + filename + '</li>\
    <li style="display: inline; margin-top:8px; margin-left: 5px;">\
      <span class="input-group-btn" style="display: inline;">\
        <button type="button" class="btn btn-danger btn-number item_info_rmv_file">\
          <span class="glyphicon glyphicon-trash"></span>\
        </button>\
      </span>\
    </li>').insertBefore(clearfixid);   
}

function addItem(){

  var ano_reuniao = Number("<?php echo $cur_ano_reuniao?>");
  var num_reuniao = Number("<?php echo $cur_num_reuniao?>");

  $('#insere_item_form')[0].reset();
  tinymce.get("insere_item_descricao").setContent("");
  //FILES
  $("#insere_item_file_list").empty();
  $("#insere_item_file_list").append('<div id="insere_file_clearfix" class="clearfix"></div>');

  jQuery.post("<?php echo URL; ?>solr/get_reuniao_info", {arguments: [num_reuniao, ano_reuniao]}, function(data){
    var reuniaoData = JSON.parse(data);
    var dia = reuniaoData[0].data.split("-")[2];
    var mes = reuniaoData[0].data.split("-")[1];
    var ano = reuniaoData[0].data.split("-")[0];

    $("#insere_item_reuniao").html(reuniaoData[0].num +'/'+ reuniaoData[0].ano +'&emsp;'+ reuniaoData[0].no + '&ordf; Reunião ' + reuniaoData[0].tipo + ' --- ' + dia +'/'+ mes +'/'+ ano);
    $("#insere_item_ano_reuniao").val(ano_reuniao);
    $("#insere_item_num_reuniao").val(num_reuniao);
  });

  $("#insere_item_modal").modal();
}

function copyItem(){

  $('#insere_item_form')[0].reset();

  $("#insere_item_nome").val($("#item_info_nome").val());
  if($("#item_info_exp").prop("selected") === true){
    $("#insere_item_exp").prop("selected", "selected");

  } else if($("#item_info_ciencia").prop("selected") === true){
    $("#insere_item_ciencia").prop("selected", "selected");

  } else if($("#item_info_odia").prop("selected") === true){
    $("#insere_item_odia").prop("selected", "selected");

  } else if($("#item_info_homo").prop("selected") === true){
    $("#insere_item_homo").prop("selected", "selected");
  }

  $("#insere_item_squaredOne").prop("checked", false);
  $("#insere_item_reuniao").html($("#item_info_reuniao").html());
  $("#insere_item_datahora").html($("#item_info_datahora").html());

  tinymce.get("insere_item_descricao").setContent(tinymce.get("item_info_descricao").getContent());

  $("#item_info_modal").modal('hide');
  $("#insere_item_modal").modal();
}

function makeString(object) {
  if (object == null) return '';
  return String(object);
};
function escapeRegExp(str) {
  return makeString(str).replace(/([.*+?^=!:${}()|[\]\/\\])/g, '\\$1');
};
function defaultToWhiteSpace(characters) {
  if (characters == null)
    return '\\s';
  else if (characters.source)
    return characters.source;
  else
    return '[' + escapeRegExp(characters) + ']';
};
function myltrim(str, characters) {
  var nativeTrimLeft = String.prototype.trimLeft;
  str = makeString(str);
  if (!characters && nativeTrimLeft) 
    return nativeTrimLeft.call(str);
  characters = defaultToWhiteSpace(characters);
  return str.replace(new RegExp('^' + characters + '+'), '');
};
function mytrim(str, characters) {
  var nativeTrim = String.prototype.trim;
  str = makeString(str);
  if (!characters && nativeTrim) 
    return nativeTrim.call(str);
  characters = defaultToWhiteSpace(characters);
  return str.replace(new RegExp('^' + characters + '+|' + characters + '+$', 'g'), '');
};
function myrtrim(str, characters) {
  var nativeTrimRight = String.prototype.trimRight;
  str = makeString(str);
  if (!characters && nativeTrimRight) 
      return nativeTrimRight.call(str);
  characters = defaultToWhiteSpace(characters);
  return str.replace(new RegExp(characters + '+$'), '');
};

function geraDoc(tipoDoc, itemData, reuniaoData){

  $("#gera_doc_hidden_tipo").val("documento");
  $("#gera_doc_hidden_name").val(itemData.item_info[0].name);
  $("#gera_doc_hidden_num").val("<?php echo $cur_num_reuniao; ?>");
  $("#gera_doc_hidden_ano").val("<?php echo $cur_ano_reuniao; ?>");

  if(itemData.item_info[0].documento == null){
    var tipo  = reuniaoData[0].tipo.replace(/á/g, '&aacute;').replace(/Á/g, '&Aacute;');
    var dia = reuniaoData[0].data.split("-")[2];
    var mes = reuniaoData[0].data.split("-")[1];
    var ano = reuniaoData[0].data.split("-")[0];
    var data = dia + "/" + mes + "/" + ano;

    var seq = itemData.item_info[0].seq_num + "/" + itemData.item_info[0].seq_ano;

    var assunto = $('<div/>').text(itemData.item_info[0].name).html();
    var conteudo = itemData.item_info[0].descricao;

    conteudo = conteudo.replace("<p>","");
    conteudo = conteudo.replace("</p>","");

    littleTxt = "";
    if(tipoDoc === "INFORMA&Ccedil;&Atilde;O"){
      littleTxt = "tomou ci&ecirc;ncia do";
    }
    else if(tipoDoc === "DELIBERA&Ccedil;&Atilde;O"){
      littleTxt = "aprovou a "; 
    }

    var template = '<p style="text-align: center;"><strong>'+ reuniaoData[0].no+ '&ordf;. REUNI&Atilde;O '+ tipo +' DA</strong></p>\
    <p style="text-align: center;"><strong>CONGREGA&Ccedil;&Atilde;O DO INSTITUTO DE COMPUTA&Ccedil;&Atilde;O,</strong></p>\
    <p style="text-align: center;"><strong>REALIZADA EM '+ data +'</strong></p>\
    <p style="text-align: center;">&nbsp;</p>\
    <p style="text-align: center;"><strong>'+ tipoDoc +' N&ordm; '+ seq +'</strong></p>\
    <p style="text-align: center;">&nbsp;</p>\
    <p style="text-align: left;"><strong>Assunto:&nbsp;</strong>'+ assunto +'.</p>\
    <p>A Congrega&ccedil;&atilde;o do Instituto de Computa&ccedil;&atilde;o, reunida em '+ data +', <strong>'+ littleTxt +''+ conteudo+'</strong> </p>\
    <p style="text-align: center;">&nbsp;</p>\
    <p style="text-align: center;">&nbsp;</p>\
    <p style="text-align: center;">Campinas, '+ dia +' de Maio de '+ ano +'.</p>\
    <p style="text-align: center;">&nbsp;</p>\
    <p style="text-align: center;">&nbsp;</p>\
    <p style="text-align: center;"><strong>Prof. Dr. XXXXXXXXXXXXXXXXXXX</strong></p>\
    <p style="text-align: center;"><strong>Presidente da Congrega&ccedil;&atilde;o</strong></p>';
    tinymce.get("gera_doc_content").setContent(template);
  } else {
    tinymce.get("gera_doc_content").setContent(itemData.item_info[0].documento);
  }
  

  $("#item_info_modal").modal('hide');
  $("#gera_doc_modal").modal();
}

function geraPauta(){

  $("#gera_doc_hidden_tipo").val("pauta");
  $("#gera_doc_hidden_num").val("<?php echo $cur_num_reuniao; ?>");
  $("#gera_doc_hidden_ano").val("<?php echo $cur_ano_reuniao; ?>");


  var template = '';
  names = [];

  $('#exp_div').children().each(function () {
    names.push(this.innerHTML.split(/\s{4}/)[0].trim());
  });
  $('#ciencia_div').children().each(function () {
    names.push(this.innerHTML.split(/\s{4}/)[0].trim());
  });
  $('#odia_div').children().each(function () {
    names.push(this.innerHTML.split(/\s{4}/)[0].trim());
  });
  $('#homo_div').children().each(function () {
    names.push(this.innerHTML.split(/\s{4}/)[0].trim());
  });

  ano_reuniao = Number("<?php echo $cur_ano_reuniao?>");
  num_reuniao = Number("<?php echo $cur_num_reuniao?>");

  //console.log(names);
  if(names.length > 0){
    jQuery.post("<?php echo URL; ?>solr/get_descricoes", {arguments: [names, num_reuniao, ano_reuniao]}, function(data){
      descricaoData = JSON.parse(data);
      jQuery.post("<?php echo URL; ?>solr/get_reuniao_info", {arguments: [num_reuniao, ano_reuniao]}, function(data){
        reuniaoData = JSON.parse(data);
        jQuery.post("<?php echo URL; ?>solr/get_reuniao_info", {arguments: [reuniaoData[0].ata_ant_num, reuniaoData[0].ata_ant_ano]}, function(data){
          reuniaoAntigaData = JSON.parse(data);

          if(reuniaoData[0].pauta == null){
            var tipo  = reuniaoData[0].tipo.replace(/á/g, '&aacute;').replace(/Á/g, '&Aacute;');
            var tipoAntigo  = reuniaoAntigaData[0].tipo.replace(/á/g, '&aacute;').replace(/Á/g, '&Aacute;');

            var onlyData = reuniaoData[0].data.split(" ")[0];
            var hh = reuniaoData[0].data.split(" ")[1].split(":")[0];
            var mm = reuniaoData[0].data.split(" ")[1].split(":")[1];
            var dia = onlyData.split("-")[2];
            var mes = onlyData.split("-")[1];
            var ano = onlyData.split("-")[0];
            var data = dia + "/" + mes + "/" + ano;

            var onlyDataAntiga = reuniaoAntigaData[0].data.split(" ")[0];
            var dia = onlyDataAntiga.split("-")[2];
            var mes = onlyDataAntiga.split("-")[1];
            var ano = onlyDataAntiga.split("-")[0];
            var dataAntiga = dia + "/" + mes + "/" + ano;

            var exp_content = "";
            var ciencia_content = "";
            var odia_content = "";
            var homo_content = "";

            var exp_c = 2;
            var ciencia_c = 1;
            var odia_c = 1;
            var homo_c = 1;

            descricaoData.forEach(function(item){
              if(item.suplementar == 0){
                if(item.tipo == "exp"){
                  conteudo = item.descricao;
                  conteudo = conteudo.replace("<p>","");
                  conteudo = conteudo.replace("</p>","");
                  exp_content = exp_content +'<p>'+ exp_c + ' - ' + conteudo + '</p>';
                  exp_c = exp_c + 1;

                } else if(item.tipo == "ciencia"){
                  conteudo = item.descricao;
                  conteudo = conteudo.replace("<p>","");
                  conteudo = conteudo.replace("</p>","");
                  ciencia_content = ciencia_content +'<p>'+ ciencia_c + ' - ' + conteudo + '</p>';
                  ciencia_c = ciencia_c + 1;

                } else if(item.tipo == "odia"){
                  conteudo = item.descricao;
                  conteudo = conteudo.replace("<p>","");
                  conteudo = conteudo.replace("</p>","");
                  odia_content = odia_content +'<p>'+ odia_c + ' - ' + conteudo + '</p>';
                  odia_c = odia_c + 1;

                } else if(item.tipo == "homo"){
                  conteudo = item.descricao;
                  conteudo = conteudo.replace("<p>","");
                  conteudo = conteudo.replace("</p>","");
                  homo_content = homo_content +'<p>'+ homo_c + ' - ' + conteudo + '</p>';
                  homo_c = homo_c + 1;

                }
              }
              //console.log(item.descricao);
            });


            template = '<h3><strong>De ordem, convocamos os Membros da Congrega&ccedil;&atilde;o do Instituto de Computa&ccedil;&atilde;o para a '+ reuniaoData[0].no +'&ordf; Reuni&atilde;o '+ tipo +' da Congrega&ccedil;&atilde;o, a realizar-se dia '+ data +', &agrave;s '+ hh +'h'+ mm +', na sala '+ reuniaoData[0].local +' do Instituto de Computa&ccedil;&atilde;o.</strong></h3>\
              <p>&nbsp;</p>\
              <h2>ATA DE REUNI&Atilde;O:</h2>\
              <p>'+ reuniaoAntigaData[0].no +'&ordf; Reuni&atilde;o '+ tipoAntigo +' da Congrega&ccedil;&atilde;o, realizada no dia '+ dataAntiga +'</p>\
              <p>&nbsp;</p>\
              <h2>EXPEDIENTE:</h2>\
              <p>1 - Informes Gerais.</p>\
              '+ exp_content +'\
              <p>&nbsp;</p>\
              <h2>PARA CI&Ecirc;NCIA:</h2>\
              '+ ciencia_content +'\
              <p>&nbsp;</p>\
              <h2>ORDEM DO DIA <br /> PARA APROVA&Ccedil;&Atilde;O:</h2>\
              '+ odia_content +'\
              <p>&nbsp;</p>\
              <h2>HOMOLOGA&Ccedil;&Atilde;O:</h2>\
              '+ homo_content +'\
              <p>&nbsp;</p>\
              <p>---</p>\
              <p>Obs.: Os documentos encontram-se &agrave; disposi&ccedil;&atilde;o na Sala 57 ou no link "Reuni&otilde;es" <a href="http://congrega.ic.unicamp.br/">http://congrega.ic.unicamp.br/</a>. Para acesso utilize: username "guestic" e password "guestic".</p>';
              tinymce.get("gera_doc_content").setContent(template);
          } else {
            tinymce.get("gera_doc_content").setContent(reuniaoData[0].pauta);
          }
          $("#gera_doc_modal").modal();
        });
      });
    });
  }
}

function geraAta(){


  $("#gera_doc_hidden_tipo").val("ata");
  $("#gera_doc_hidden_num").val("<?php echo $cur_num_reuniao; ?>");
  $("#gera_doc_hidden_ano").val("<?php echo $cur_ano_reuniao; ?>");

  var template = '';
  var names = [];
  var informes = "";

  $('#exp_div').children().each(function () {
    names.push(this.innerHTML.split(/\s{4}/)[0].trim());
  });
  $('#ciencia_div').children().each(function () {
    names.push(this.innerHTML.split(/\s{4}/)[0].trim());
  });
  $('#odia_div').children().each(function () {
    names.push(this.innerHTML.split(/\s{4}/)[0].trim());
  });
  $('#homo_div').children().each(function () {
    names.push(this.innerHTML.split(/\s{4}/)[0].trim());
  });

  var cur_letter = 'a';
  $('#informes_div').children().each(function () {
    curVal = $(this).children(':first').children(':first').val();
    if(curVal != undefined && curVal.length > 0){
      informes = informes + '<strong>('+ cur_letter +')</strong>' + $(this).children(':first').children(':first').val() + '. ';
      cur_letter = String.fromCharCode(cur_letter.charCodeAt() + 1);
    }
  });

  //MAP START

  var ordinal = {};
  ordinal[1] = "PRIMEIRA";
  ordinal[2] = "SEGUNDA";
  ordinal[3] = "TERCEIRA";
  ordinal[4] = "QUARTA";
  ordinal[5] = "QUINTA";
  ordinal[6] = "SEXTA";
  ordinal[7] = "S&Eacute;TIMA";
  ordinal[8] = "OITAVA";
  ordinal[9] = "NONA";
  ordinal[10] = "D&Eacute;CIMA";
  ordinal[11] = "D&Eacute;CIMA PRIMEIRA";
  ordinal[12] = "D&Eacute;CIMA SEGUNDA";
  ordinal[13] = "D&Eacute;CIMA TERCEIRA";
  ordinal[14] = "D&Eacute;CIMA QUARTA";
  ordinal[15] = "D&Eacute;CIMA QUINTA";
  ordinal[16] = "D&Eacute;CIMA SEXTA";
  ordinal[17] = "D&Eacute;CIMA S&Eacute;TIMA";
  ordinal[18] = "D&Eacute;CIMA OITAVA";
  ordinal[19] = "D&Eacute;CIMA NONA";
  ordinal[20] = "VIG&Eacute;SIMA";
  ordinal[21] = "VIG&Eacute;SIMA PRIMEIRA";

  //MAP END

  ano_reuniao = Number("<?php echo $cur_ano_reuniao?>");
  num_reuniao = Number("<?php echo $cur_num_reuniao?>");

  //console.log(names);
  if(names.length > 0){
    jQuery.post("<?php echo URL; ?>solr/get_descricoes", {arguments: [names, num_reuniao, ano_reuniao]}, function(data){
      //console.log(data);
      descricaoData = JSON.parse(data);
      jQuery.post("<?php echo URL; ?>solr/get_reuniao_info", {arguments: [num_reuniao, ano_reuniao]}, function(data){
        reuniaoData = JSON.parse(data);
        jQuery.post("<?php echo URL; ?>solr/get_reuniao_info", {arguments: [reuniaoData[0].ata_ant_num, reuniaoData[0].ata_ant_ano]}, function(data){
          reuniaoAntigaData = JSON.parse(data);

          if(reuniaoData[0].ata == null){
            var tipo  = reuniaoData[0].tipo.replace(/á/g, '&aacute;').replace(/Á/g, '&Aacute;');
            var tipoAntigo  = reuniaoAntigaData[0].tipo.replace(/á/g, '&aacute;').replace(/Á/g, '&Aacute;');

            var onlyData = reuniaoData[0].data.split(" ")[0];
            var hh = reuniaoData[0].data.split(" ")[1].split(":")[0];
            var mm = reuniaoData[0].data.split(" ")[1].split(":")[1];
            var dia = onlyData.split("-")[2];
            var mes = onlyData.split("-")[1];
            var ano = onlyData.split("-")[0];
            var data = dia + "/" + mes + "/" + ano;

            var onlyDataAntiga = reuniaoAntigaData[0].data.split(" ")[0];
            var dia = onlyDataAntiga.split("-")[2];
            var mes = onlyDataAntiga.split("-")[1];
            var ano = onlyDataAntiga.split("-")[0];
            var dataAntiga = dia + "/" + mes + "/" + ano;

            var exp_content = "";
            var ciencia_content = "";
            var odia_content = "";
            var homo_content = "";

            var exp_c = 2;
            var ciencia_c = 1;
            var odia_c = 1;
            var homo_c = 1;


            var suplementar_content = "";
            var supl_exp_content = "";
            var supl_ciencia_content = "";
            var supl_odia_content = "";
            var supl_homo_content = "";

            var supl_exp_c = 1;
            var supl_ciencia_c = 1;
            var supl_odia_c = 1;
            var supl_homo_c = 1;          

            descricaoData.forEach(function(item){
              console.log(item.suplementar);
              if(item.suplementar == 0){
                if(item.tipo == "exp"){
                  conteudo = item.descricao;
                  conteudo = conteudo.replace("<p>","");
                  conteudo = conteudo.replace("</p>","");
                  exp_content = exp_content +'<strong>Item '+ exp_c + ' - </strong>' + conteudo + '. ';
                  exp_c = exp_c + 1;

                } else if(item.tipo == "ciencia"){
                  conteudo = item.descricao;
                  conteudo = conteudo.replace("<p>","");
                  conteudo = conteudo.replace("</p>","");
                  ciencia_content = ciencia_content +'<strong>Item '+ ciencia_c + ' - </strong>' + conteudo + '. ';
                  ciencia_c = ciencia_c + 1;

                } else if(item.tipo == "odia"){
                  conteudo = item.descricao;
                  conteudo = conteudo.replace("<p>","");
                  conteudo = conteudo.replace("</p>","");
                  odia_content = odia_content +'<strong>Item '+ odia_c + ' - </strong>' + conteudo + '. ';
                  odia_c = odia_c + 1;

                } else if(item.tipo == "homo"){
                  conteudo = item.descricao;
                  conteudo = conteudo.replace("<p>","");
                  conteudo = conteudo.replace("</p>","");
                  homo_content = homo_content +'<strong>Item '+ homo_c + ' - </strong>' + conteudo + '. ';
                  homo_c = homo_c + 1;

                }
            } else {
                if(suplementar_content == ""){
                  suplementar_content = suplementar_content + "<strong>PAUTA SUPLEMENTAR: </strong> ATA DE REUNI&Atilde;O: " + reuniaoAntigaData[0].no +"&ordf; Reuni&atilde;o "+ tipoAntigo +" da Congrega&ccedil;&atilde;o, realizada no dia "+ dataAntiga + ". ";
                }
                if(item.tipo == "exp"){
                  if(supl_exp_content == ""){
                    supl_exp_content = supl_exp_content + "<strong>EXPEDIENTE: </strong>";
                  }
                  conteudo = item.descricao;
                  conteudo = conteudo.replace("<p>","");
                  conteudo = conteudo.replace("</p>","");
                  supl_exp_content = supl_exp_content +'<strong>Item '+ supl_exp_c + ' - </strong>' + conteudo + '. ';
                  supl_exp_c = supl_exp_c + 1;

                } else if(item.tipo == "ciencia"){
                  if(supl_ciencia_content == ""){
                    supl_ciencia_content = supl_ciencia_content + "<strong>PARA CI&Ecirc;NCIA: </strong>";
                  }
                  conteudo = item.descricao;
                  conteudo = conteudo.replace("<p>","");
                  conteudo = conteudo.replace("</p>","");
                  supl_ciencia_content = supl_ciencia_content +'<strong>Item '+ supl_ciencia_c + ' - </strong>' + conteudo + '. ';
                  supl_ciencia_c = supl_ciencia_c + 1;

                } else if(item.tipo == "odia"){
                  if(supl_odia_content == ""){
                    supl_odia_content = supl_odia_content + "<strong>ORDERM DO DIA. PARA APROVA&Ccedil;&Atilde;O: </strong>";
                  }
                  conteudo = item.descricao;
                  conteudo = conteudo.replace("<p>","");
                  conteudo = conteudo.replace("</p>","");
                  supl_odia_content = supl_odia_content +'<strong>Item '+ supl_odia_c + ' - </strong>' + conteudo + '. ';
                  supl_odia_c = supl_odia_c + 1;

                } else if(item.tipo == "homo"){
                  if(supl_homo_content == ""){
                    supl_homo_content = supl_homo_content + "<strong>HOMOLOGA&Ccedil;&Atilde;O: </strong>";
                  }
                  conteudo = item.descricao;
                  conteudo = conteudo.replace("<p>","");
                  conteudo = conteudo.replace("</p>","");
                  supl_homo_content = supl_homo_content +'<strong>Item '+ supl_homo_c + ' - </strong>' + conteudo + '. ';
                  supl_homo_c = supl_homo_c + 1;

                }
              //console.log(item.descricao);
              }
            });

            suplementar_content = suplementar_content + supl_exp_content + supl_ciencia_content + supl_odia_content + supl_homo_content;
            console.log(exp_content);

            template = '<h2><strong>ATA DA '+ ordinal[reuniaoData[0].no] +' REUNI&Atilde;O '+ tipo +' DA CONGREGA&Ccedil;&Atilde;O DO INSTITUTO DE COMPUTA&Ccedil;&Atilde;O, REALIZADA EM '+ data +'.</strong></h2>\
              <p>O <span style="text-decoration: underline;"><strong>Sr. Presidente</strong></span> d&aacute; in&iacute;cio &agrave; '+ reuniaoData[0].no +'&ordf; Sess&atilde;o '+ tipo +' da Congrega&ccedil;&atilde;o de '+ ano +' e coloca em vota&ccedil;&atilde;o as Atas: '+ reuniaoAntigaData[0].no +'&ordf; Reuni&atilde;o '+ tipoAntigo +' da Congrega&ccedil;&atilde;o, realizada no dia '+ dataAntiga +'. <strong>APROVADA POR UNANIMIDADE. </strong>A seguir, o <span style="text-decoration: underline;"><strong>Sr. Presidente</strong></span> inicia o <strong>EXPEDIENTE: Item 1 - Informes Gerais:</strong> O<span style="text-decoration: underline;"><strong> Sr. Presidente </strong></span>informa: '+ informes +'. '+ exp_content +'. <strong>PARA CI&Ecirc;NCIA: </strong>'+ ciencia_content +'. O <span style="text-decoration: underline;"><strong>Sr. Presidente</strong></span> em seguida, entra na <strong>ORDEM DO DIA. DESTAQUES:. </strong>O <span style="text-decoration: underline;"><strong>Sr. Presidente</strong></span> coloca para vota&ccedil;&atilde;o em bloco os itens da <strong>ORDEM DO DIA. PARA APROVA&Ccedil;&Atilde;O: </strong>'+ odia_content +'. <strong>HOMOLOGA&Ccedil;&Atilde;O:</strong> '+ homo_content +''+ suplementar_content +' <strong>APROVADOS POR UNANIMIDADE. </strong>O <span style="text-decoration: underline;"><strong>Sr. Presidente</strong></span> abre para discuss&atilde;o os <strong>DESTAQUES</strong>.</p>';
              tinymce.get("gera_doc_content").setContent(template);
            } else {
              tinymce.get("gera_doc_content").setContent(reuniaoData[0].pauta);
            }
            $("#gera_doc_modal").modal();
        });
      });
    });
  }
}

function novaReuniao(){

}

</script>
<!-- End my scripts -->

<div id="gera_doc_modal" class="modal modal-wide fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="font-weight: bold;"></h4>
      </div>
      <form id="gera_doc_form" class="busca-avancada" action="<?php echo URL; ?>solr/salvaDoc" method="POST" style="height: 100%;">
        <div class="modal-body" style="background: #637f83;">
          <textarea id="gera_doc_content" name="content" ></textarea>
        </div>
        <div class="modal-footer">
          <input id="gera_doc_hidden_tipo" type="hidden" name="tipo" value="">
          <input id="gera_doc_hidden_num" type="hidden" name="num_reuniao" value="">
          <input id="gera_doc_hidden_ano" type="hidden" name="ano_reuniao" value="">
          <input id="gera_doc_hidden_name" type="hidden" name="item_name" value="">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="padding: 12px; font-size: 0.8125em; float: left;">Fechar</button>
          <input type="submit" class="btn btn-primary item_info_btn" name="envia" value="Salvar" style="position: static;">
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="item_info_modal" class="modal modal-wide fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="font-weight: bold;">Informações do Item</h4>
      </div>
      <form id="item_info_form" class="busca-avancada" action="<?php echo URL; ?>solr/salvaItem" method="POST" style="height: 100%;" enctype="multipart/form-data">
        <div class="modal-body" style="background: #637f83;">
            <div class="col-md-2" style="height: 80%; display: none;">
              <ul id="historico" class="twitter img-rounded" style="padding-bottom: 4em; height: 100%;">
                <label style="color: white; font-size: large; font-style: italic;">Histórico de Alterações:</label>
              </ul>
            </div>
            <div class="col-md-5" style="height: 100%; margin-left: 8%;">
              <div class="form-group" style="border-bottom: 1px solid #597275; padding-bottom: 2%;">
                <label style="font-size: large; font-style: italic;"> Nome: </label>
                <input id="item_info_nome" class="form-control" type="text" name="nome" value="" />
              </div>
              <div class="form-group" style="border-bottom: 1px solid #597275; padding-bottom: 2%;">
                <label style="font-size: large; font-style: italic;"> Tipo: </label>
                <select class="form-control" name="tipo">
                  <option value="">Outro</option>
                  <option id="item_info_exp" value="exp" >Expediente</option>
                  <option id="item_info_ciencia" value="ciencia" >Ciência</option>
                  <option id="item_info_odia" value="odia" >Ordem do Dia</option>
                  <option id="item_info_homo" value="homo" >Homologação</option>
                </select>
              </div>
              <div class="form-group row" style="border-bottom: 1px solid #597275; padding-bottom: 2%;">
                <label class="col-md-6" style="margin-top: 0.3%; width: 40% font-size: large; font-style: italic;">Pertence à pauta suplementar:</label>
                <div class="squaredOne col-md-3" style="margin: 0px;">
                  <input type="checkbox" value="sim" id="squaredOne" name="suplementar" />
                  <label for="squaredOne"></label>
                </div>
              </div>
              <div class="form-group" style="border-bottom: 1px solid #597275; padding-bottom: 2%;">
                <div class="row" style="padding-left: 0.8em;">
                  <label style="font-size: large; font-style: italic;"> Reunião: </label>
                </div>
                <div class="row">
                 <label  id="item_info_reuniao" style="padding-left: 2em; font-weight: normal; font-size: larger; color: #4c4c4c;"> </label>
               </div>
              </div>
              <div class="form-group" style="border-bottom: 1px solid #597275; padding-bottom: 2%;">
                <div class="row" style="padding-left: 0.8em;">
                  <label style="font-size: large; font-style: italic;"> Numero de Sequência: </label>
                </div>
                <div class="row">
                  <div class="col-md-2" style="width: 4.5em;">
                    <input id="item_info_seq_num" class="form-control" type="number" name="num_seq" value="" style="width: 100%;font-size: 1em;" max="31" min="1" />
                  </div>
                  <h1 class="col-md-1" style="color: white; padding: 0px; margin-top: 0.07em; width: 0.4em;">/</h1>
                  <div class="col-md-4" style="width: 5.5em;">
                    <input id="item_info_seq_ano" class="form-control" type="number" name="ano_seq" value="" style="width: 100%; font-size: 1em;" max="2100" min="2014"/>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label style="font-size: large; font-style: italic;">Arquivos Anexados: </label>
                <ul id="item_info_file_list" class="twitter img-rounded" style="background: #637f83; padding-left: 0px;">

                  <div id="file_clearfix" class="clearfix"></div>
                </ul> 
                <input class="form-control" type="file" value="" onchange="if(validateSingleInput2(this)) addNewFile(this, '#file_clearfix');" style="margin-bottom: 2%;" />
              </div>
            </div>
            <div class="col-md-5" style="height: 100%;">
              <div class="form-group" style="border-bottom: 1px solid #597275; padding-bottom: 2%;">
                <div class="row" style="padding-left: 0.8em;">
                  <label style="font-size: large; font-style: italic;"> Data e Hora da última alteração: </label>
                </div>
                <div class="row">
                  <label  id="item_info_datahora" style="padding-left: 2em; font-weight: normal; font-size: larger; color: #4c4c4c;"> </label>
                </div>
              </div>
              <div class="form-group" style="height: 70%;">
                <label style="font-size: large; font-style: italic;"> Descrição: </label>
                <!--  name="descricao" value="" cols="0" rows="5" class="descricao_textarea" -->
                <textarea id="item_info_descricao" name="descricao" ></textarea>
              </div>
            </div>

            <input type="hidden" name="num_reuniao" value="<?php echo $cur_num_reuniao; ?>">
            <input type="hidden" name="ano_reuniao" value="<?php echo $cur_ano_reuniao; ?>">
        </div>
        <div class="modal-footer">
          <button id="gera_deliberacao" type="button" class="btn btn-primary item_info_btn" style="float: left;">Gerar Deliberação</button>
          <button id="gera_homologacao" type="button" class="btn btn-primary item_info_btn" style="float: left;">Gerar Homologação</button>
          <button id="gera_informacao" type="button" class="btn btn-primary item_info_btn" style="float: left;">Gerar Informação</button>
          <button type="button" id="item_info_copy" class="btn btn-primary item_info_btn" style="float: left;" onclick="copyItem();">Gerar Item a partir deste</button>
          <input  type="submit" class="btn btn-primary item_info_btn" name="envia" value="Baixar Anexos" style="float: left; position: static; font-weight: normal; font-size: 1.1em;">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="padding: 12px; font-size: 0.8125em;">Fechar</button>
          <input type="submit" class="btn btn-primary item_info_btn" name="envia" value="Salvar" style="position: static; font-weight: normal; font-size: 1.1em;">
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="insere_item_modal" class="modal modal-wide fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" style="font-weight: bold;">Novo Item</h4>
      </div>
      <form id="insere_item_form" class="busca-avancada" action="<?php echo URL; ?>solr/salvaItem" method="POST" style="height: 100%;" enctype="multipart/form-data">
        <div class="modal-body" style="background: #637f83;">
          <div class="col-md-2" style="height: 80%; display: none;">
            <ul id="insere_item_historico" class="twitter img-rounded" style="padding-bottom: 4em; height: 100%;">
              <label style="color: white;">Histórico de Alterações:</label>
            </ul>
          </div>
          <div class="col-md-5" style="height: 100%; margin-left: 8%;">
            <div class="form-group" style="border-bottom: 1px solid #597275; padding-bottom: 2%;">
              <label style="font-size: large; font-style: italic;"> Nome: </label>
              <input id="insere_item_nome" class="form-control" type="text" name="nome" value="" placeholder="Descrever de forma simples qual o assunto deste Item" />
            </div>
            <div class="form-group" style="border-bottom: 1px solid #597275; padding-bottom: 2%;">
              <label style="font-size: large; font-style: italic;"> Tipo: </label>
              <select class="form-control" name="tipo">
                <option value="">Outro</option>
                <option id="insere_item_exp" value="exp">Expediente</option>
                <option id="insere_item_ciencia" value="ciencia">Ciência</option>
                <option id="insere_item_odia" value="odia">Ordem do Dia</option>
                <option id="insere_item_homo" value="homo">Homologação</option>
              </select>
            </div>
            <div class="form-group row" style="border-bottom: 1px solid #597275; padding-bottom: 2%;">
              <label class="col-md-6" style="margin-top: 0.3%; width: 40%; font-size: large; font-style: italic;">Pertence à pauta suplementar:</label>
              <div class="squaredOne col-md-3" style="margin: 0px; margin-top: 0.5%;">
                <input type="checkbox" value="sim" id="insere_item_squaredOne" name="suplementar" />
                <label for="insere_item_squaredOne"></label>
              </div>
            </div>
            <div class="form-group" style="border-bottom: 1px solid #597275; padding-bottom: 2%;">
              <div class="row" style="padding-left: 0.8em;">
                <label style="font-size: large; font-style: italic; margin-bottom: 2%;"> Dados da Reunião: </label>
              </div>
              <div class="row">
                <label style="margin-top: 1%; font-weight: normal; font-size: large; float: left; padding-left: 2%;"> N&ordm; de Referência:  </label>
                <div class="col-md-2" style="width: 4.5em;">
                  <input id="insere_item_num_reuniao" class="form-control" type="number" name="num_reuniao" value="" style="width: 100%;font-size: 1em;" max="31" min="1" placeholder="<?php echo $cur_num_reuniao; ?>" />
                </div>
                <h1 class="col-md-1" style="color: white; padding: 0px; margin-top: 0.07em; width: 0.4em;">/</h1>
                <div class="col-md-4" style="width: 5.5em;">
                  <input id="insere_item_ano_reuniao" class="form-control" type="number" name="ano_reuniao" value="" style="width: 100%; font-size: 1em;" max="2100" min="2014" placeholder="<?php echo $cur_ano_reuniao; ?>"/>
                </div>
              </div>
              <div class="row" style="margin-bottom: 1%;">
                <label style="margin-top: 1%; font-weight: normal; font-size: large; float: left; padding-left: 2%; margin-right: 13%;"> N&ordm; de Referência da Reunião Atual:  </label>
                <label  id="insere_item_reuniao" style="padding-left: 2em; font-weight: normal; font-size: larger; color: #4c4c4c;"> </label>
              </div>
            </div>
            <div class="form-group" style="border-bottom: 1px solid #597275; padding-bottom: 2%;">
              <div class="row" style="padding-left: 0.8em;">
                <label style="font-size: large; font-style: italic;"> Número de Sequência: </label>
              </div>
              <div class="row">
                <div class="col-md-2" style="width: 4.5em;">
                  <input id="insere_item_seq_num" class="form-control" type="number" name="num_seq" value="" style="width: 100%;font-size: 1em;" max="31" min="1" readonly/>
                </div>
                <h1 class="col-md-1" style="color: white; padding: 0px; margin-top: 0.07em; width: 0.4em;">/</h1>
                <div class="col-md-4" style="width: 5.5em;">
                  <input id="insere_item_seq_ano" class="form-control" type="number" name="ano_seq" value="" style="width: 100%; font-size: 1em;" max="2100" min="2014" readonly/>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label style="font-size: large; font-style: italic;">Arquivos Anexados: </label>
              <ul id="insere_item_file_list" class="twitter img-rounded" style="background: #637f83; padding-left: 0px;">

                <div id="insere_file_clearfix" class="clearfix"></div>
              </ul> 
              <input class="form-control" type="file" value="" onchange="if(validateSingleInput2(this)) addNewFile(this, '#insere_file_clearfix');" style="margin-bottom: 2%;" />
            </div>
          </div>
          <div class="col-md-5" style="height: 100%;">
            <div class="form-group" style="border-bottom: 1px solid #597275; padding-bottom: 2%;">
              <div class="row" style="padding-left: 0.8em;">
                <label style="font-size: large; font-style: italic;"> Data e Hora da última alteração: </label>
              </div>
              <div class="row">
                <label  id="insere_item_datahora" style="padding-left: 2em; font-weight: normal; font-size: larger; color: #4c4c4c;"> </label>
              </div>
            </div>
            <div class="form-group" style="height: 70%;">
              <label style="font-size: large; font-style: italic;"> Descrição: </label>
              <textarea id="insere_item_descricao" name="descricao" value="" cols="0" rows="5" class="descricao_textarea" placeholder="Descrever de forma detalhada sobre o que se trata este item."></textarea>
            </div>
          </div>

          <input type="hidden" name="num_seq" value="-1">
          <input type="hidden" name="ano_ano" value="-1">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" style="padding: 12px; font-size: 0.8125em;">Fechar</button>
          <input type="submit" class="btn btn-primary item_info_btn" name="envia" value="Criar" style="position: static;">
        </div>
      </form>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="footer_top" style="clear: both;">
  <!-- <div class="footer_top" style="clear: both;"> -->
  <div class="container">

    <div class="footer_head">
      <h2>Criar documentos</h2>
      <p>Utilize os formulários abaixo para criar Atas, Pautas e Deliberacao</p>
    </div>

    <div class="row footer_grid">

      <!-- Aqui comeca a primeira coluna da pagina -->
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
            <form id="form-busca" class="busca-avancada" action="<?php echo URL; ?>solr/schedule" method="POST">
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
                  <div class="col-md-2" style="width: 4.5em;">
                    <input class="form-control" type="number" name="num_reuniao" value="" style="width: 100%;font-size: 1em;" max="31" min="1"/>
                  </div>
                  <h1 class="col-md-1" style="color: white; padding: 0px; margin-top: 0.07em; width: 0.4em;">/</h1>
                  <div class="col-md-4" style="width: 5.5em;">
                    <input class="form-control" type="number" name="ano_reuniao" value="" style="width: 100%; font-size: 1em;" max="2100" min="2014" />
                  </div>
                </div>
              </div>
              <div class="form-group" style="border-top: 1px solid #597275; padding-top: 3%;">
                <input type="submit" name="busca" value="Buscar"/>
              </div>
            </form>
          </div>
        </div>
        <div class="row footer_grid">
          <ul id="buscas" class="twitter img-rounded col-md-10" ondrop="drop(event)" ondragover="allowDrop(event)" style="padding-bottom: 4em">
            <label style="color: white;">Itens:</label>
            <?php
            if(isset($Available_cur)){
                  //var_dump($Available_cur);
              foreach($Available_cur as $item){
                if(($item->ano_reuniao === $cur_ano_reuniao) && ($item->num_reuniao == $cur_num_reuniao)){
                  echo "<li id=\"busca$busca_n"."_$item->tipo\" class=\"item_pauta_$item->tipo dbclick click\" draggable=\"true\" ondragstart=\"drag(event)\"> $item->name &emsp;&emsp; $item->num_reuniao/$item->ano_reuniao</li>";
                }
                else{
                  echo "<li id=\"busca$busca_n"."_$item->tipo\" class=\"item_pauta_$item->tipo"."_unav click\"> $item->name &emsp;&emsp; $item->num_reuniao/$item->ano_reuniao</li>";
                }
                $busca_n++;
              }
            }
            else{
              foreach($Available as $item){
                    //var_dump($Available);
                if(($item->ano_reuniao === $cur_ano_reuniao) && ($item->num_reuniao == $cur_num_reuniao))
                  echo "<li id=\"busca$busca_n"."_$item->tipo\" class=\"item_pauta_$item->tipo dbclick click\" draggable=\"true\" ondragstart=\"drag(event)\"> $item->name &emsp;&emsp; $item->num_reuniao/$item->ano_reuniao</li>";
                $busca_n++;
              }
            }
            ?>
            <div class="clearfix"> </div>
          </ul>
        </div>
      </div>
      <!-- Aqui termina a primeira coluna da pagina -->

      <!-- Aqui comeca a segunda coluna da pagina -->
      <div class="col-md-6">
        <ul class="message">
          <li class="msg-desc">
            <h4>Itens da Pauta</h4>
            <p>Aqui estao os itens que serao usados para gerar a pauta, ata e deliberacoes</p>
          </li>
          <div class="clearfix"> </div>
        </ul>
        <div>
          <form class="busca-avancada" action="" method="POST">
            <div id="informes_div" class="form-group footer_head_notaligned">
              <label>Informes Gerais</label>

              <?php

              $is_disabled = "disabled";
              $is_readonly = "readonly";
              if($Informes[0]->informe == ""){
                $is_disabled = "";
                $is_readonly = "";
              }

              echo "<div id=\"informes_row\" class=\"row\">
              <div class=\"col-md-9\" style=\"padding-left: 0.75em; padding-right: 0px; width: 82%;\">
                <input id=\"informes_input\" class=\"form-control\" type=\"text\" name=\"content\" value=\"".$Informes[0]->informe."\" style=\"margin: 2px; width: 95%;\" $is_readonly/>
              </div>
              <div class=\"col-md-1\" style=\"padding: 0px; margin: 0px; margin-top: 0.45em;\">
                <span class=\"input-group-btn\">
                  <button type=\"button\" id=\"informes_add\" class=\"btn btn-success btn-number informes_btn_suc\" $is_disabled>
                    <span class=\"glyphicon glyphicon-plus\"></span>
                  </button>
                </span>
              </div>
              <div class=\"col-md-1\" id=\"informes_rm\" style=\"padding: 0px; margin: 0px; margin-top: 0.5em; margin-bottom: 0.07em\">
                <span class=\"input-group-btn\">
                  <button type=\"button\" id=\"informes\" class=\"btn btn-danger btn-number informes_btn_spc\">
                    <span class=\"glyphicon glyphicon-minus\"></span>
                  </button>
                </span>
                </div>
              </div>";

              for($inf = 1; $inf < count($Informes); $inf++){
                echo "<div id=\"".$inf."informes_row\" class=\"row\">
                <div class=\"col-md-9\" style=\"padding-left: 0.75em; padding-right: 0px; width: 82%;\">
                  <input id=\"".$inf."informes_input\" class=\"form-control\" type=\"text\" name=\"".$inf."content\" value=\"".$Informes[$inf]->informe."\" style=\"margin: 2px; width: 95%;\" readonly/>
                </div>
                <div class=\"col-md-1\" style=\"padding: 0px; margin: 0px; margin-top: 0.45em;\">
                  <span class=\"input-group-btn\">
                    <button type=\"button\" id=\"".$inf."informes_add\" class=\"btn btn-success btn-number informes_btn_suc\" disabled>
                      <span class=\"glyphicon glyphicon-plus\"></span>
                    </button>
                  </span>
                </div>
                <div class=\"col-md-1\" id=\"informes_rm\" style=\"padding: 0px; margin: 0px; margin-top: 0.5em; margin-bottom: 0.07em\">
                  <span class=\"input-group-btn\">
                    <button type=\"button\" id=\"".$inf."informes\" class=\"btn btn-danger btn-number informes_btn\">
                      <span class=\"glyphicon glyphicon-minus\"></span>
                    </button>
                  </span>
                </div>
              </div>";
              }
              if(count($Informes) > 0 || (count($Informes) == 1 && $is_disabled != "")){
                echo "<div id=\"".count($Informes)."informes_row\" class=\"row\">
                <div class=\"col-md-9\" style=\"padding-left: 0.75em; padding-right: 0px; width: 82%;\">
                  <input id=\"".count($Informes)."informes_input\" class=\"form-control\" type=\"text\" name=\"".count($Informes)."content\" value=\"\" style=\"margin: 2px; width: 95%;\"/>
                </div>
                <div class=\"col-md-1\" style=\"padding: 0px; margin: 0px; margin-top: 0.45em;\">
                  <span class=\"input-group-btn\">
                    <button type=\"button\" id=\"".count($Informes)."informes_add\" class=\"btn btn-success btn-number informes_btn_suc\">
                      <span class=\"glyphicon glyphicon-plus\"></span>
                    </button>
                  </span>
                </div>
                <div class=\"col-md-1\" id=\"informes_rm\" style=\"padding: 0px; margin: 0px; margin-top: 0.5em; margin-bottom: 0.07em\">
                  <span class=\"input-group-btn\">
                    <button type=\"button\" id=\"".count($Informes)."informes\" class=\"btn btn-danger btn-number informes_btn\">
                      <span class=\"glyphicon glyphicon-minus\"></span>
                    </button>
                  </span>
                </div>
              </div>";
              }
              ?>
            </div>
            <div class="form-group footer_head_notaligned" style="width: 100%;">
              <label>Expediente</label>
              <br>
              <ul id="exp_div" class="expediente_border item_ul" ondrop="drop(event)" ondragover="allowDrop(event)">
                <?php
                foreach($InUse as $item){
                  if(($item->ano_reuniao == $cur_ano_reuniao) && ($item->num_reuniao == $cur_num_reuniao) && ("exp" == $item->tipo)){
                    echo "<li id=\"busca$busca_n"."_$item->tipo\" class=\"item_pauta_$item->tipo dbclick click\" draggable=\"true\" ondragstart=\"drag(event)\"> $item->name &emsp;&emsp; $item->num_reuniao/$item->ano_reuniao</li>";
                    //echo "<input type=\"hidden\" name=\"busca$busca_n"."_$item->tipo\" value=\"$item->name\">";
                  }
                }
                ?>
              </ul>
            </div>
            <div class="form-group footer_head_notaligned" style="width: 100%;">
              <label>Para Ciência</label>
              <br>
              <ul id="ciencia_div" class="ciencia_border item_ul" ondrop="drop(event)" ondragover="allowDrop(event)">
                <?php
                foreach($InUse as $item){
                  if(($item->ano_reuniao == $cur_ano_reuniao) && ($item->num_reuniao == $cur_num_reuniao) && ("ciencia" == $item->tipo)){
                    echo "<li id=\"busca$busca_n"."_$item->tipo\" class=\"item_pauta_$item->tipo dbclick click\" draggable=\"true\" ondragstart=\"drag(event)\"> $item->name &emsp;&emsp; $item->num_reuniao/$item->ano_reuniao</li>";
                    //echo "<input type=\"hidden\" name=\"busca$busca_n"."_$item->tipo\" value=\"$item->name\">";
                  }
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
                  if(($item->ano_reuniao == $cur_ano_reuniao) && ($item->num_reuniao == $cur_num_reuniao) && ("odia" == $item->tipo)){
                    echo "<li id=\"busca$busca_n"."_$item->tipo\" class=\"item_pauta_$item->tipo dbclick click\" draggable=\"true\" ondragstart=\"drag(event)\"> $item->name &emsp;&emsp; $item->num_reuniao/$item->ano_reuniao</li>";
                    //echo "<input type=\"hidden\" name=\"busca$busca_n"."_$item->tipo\" value=\"$item->name\">";
                  }
                }
                ?>
              </ul>
            </div>
            <div class="form-group footer_head_notaligned" style="width: 100%;">
              <label>Homologação</label>
              <br>
              <ul id="homo_div" class="homo_border item_ul" ondrop="drop(event)" ondragover="allowDrop(event)">
                <?php
                foreach($InUse as $item){
                  if(($item->ano_reuniao == $cur_ano_reuniao) && ($item->num_reuniao == $cur_num_reuniao) && ("homo" == $item->tipo)){
                    echo "<li id=\"busca$busca_n"."_$item->tipo\" class=\"item_pauta_$item->tipo dbclick click\" draggable=\"true\" ondragstart=\"drag(event)\"> $item->name &emsp;&emsp; $item->num_reuniao/$item->ano_reuniao</li>";
                    //echo "<input type=\"hidden\" name=\"busca$busca_n"."_$item->tipo\" value=\"$item->name\">";
                  }
                }
                ?>
              </ul>
            </div>
            <div>
              <div class="row" style="height: 3em;">
                <div class="col-md-4" style="margin: 0px;">
                  <input type="button" name="item" value="Novo Item" onclick="addItem();"/>
                </div>
                <div class="col-md-4" style="margin: 0px;">
                  <input type="button" name="pauta" value="Gerar Pauta" onclick="geraPauta();"/>
                </div>
              </div>
              <div class="row" style="height: 3em;">
                <div class="col-md-4" style="margin: 0px;">
                  <input type="button" name="ata" value="Gerar Ata"onclick="geraAta();"/>
                </div>
                <div class="col-md-4" style="margin: 0px;">
                  <input type="button" name="nova_reuniao" value=" Nova Reunião" onclick="novaReuniao();"/>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- Aqui termina a segunda coluna da pagina -->

    </div>
  </div>
</div>

<div class="content_white"></div>
