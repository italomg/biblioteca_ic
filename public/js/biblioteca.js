// Valida form da indexacao em batch

var _validFileExtensions = [".tar.gz", ".zip"];    
function validateSingleInput(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
             
            if (!blnValid) {
                alert("Desculpe, " + sFileName + " é inválida, extensões permitidas são: " + _validFileExtensions.join(", "));
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}

var _validFileExtensions2 = [".pdf", ".doc"];    
function validateSingleInput2(oInput) {
    if (oInput.type == "file") {
        var sFileName = oInput.value;
         if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions2.length; j++) {
                var sCurExtension = _validFileExtensions2[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
             
            if (!blnValid) {
                alert("Desculpe, " + sFileName + " é inválida, extensões permitidas são: " + _validFileExtensions2.join(", "));
                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}
