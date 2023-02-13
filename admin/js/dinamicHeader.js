
jQuery(document).ready(function(){


    document.getElementById("add-img-input").addEventListener("click",addInput)

    document.getElementById("delete-img-input").addEventListener("click",removeLastInput)





    // Función para agregar inputs dinamicamente

    function addInput(e){

        // Aumento en 1 el contador de campos

        button = document.getElementById("add-img-input");
        var count = parseInt(button.value) +1;
        button.value = count;

        // Creo el input en un string

        var content= '<hr><div class="general-form-field image-row">' +
                        '<div><h2 class="filds-titles"> Imagen '+ count + '</h2>' +
            '<input type="file" name="image-'+ count + '" value="" ></div>' + 

            '<div><h2 class="filds-titles"> Enlace de imagen '+ count + ' </h2>' +
            '<input type="url" name="image_link-' + count + '" ></div></div>'


        // Parseo el String a HTML y lo agrego al div que contiene los campos de imagen

        document.getElementById("images-container").append(stringToHTML(content))

        if (button.value > 1){
            document.getElementById("delete-img-input").hidden = false
        }
    }





    // Función para eliminar inputs dinamicamente

    function removeLastInput(){

        // Modifico el contador de campos
        inputCount = parseInt(document.getElementById("add-img-input").value);
        document.getElementById("add-img-input").value = inputCount -1;

        // Si quedan al menos 2 campos
        if(inputCount > 1){

            if(inputCount-1 == 1){
                document.getElementById("delete-img-input").hidden = true
            }
            // Elimino el último campo
            lastChild = document.getElementById("images-container").lastChild.remove()
       
        }
    }



    // Func. Auxiliar para parsear string a HTML
    var stringToHTML = function (str) {
        var parser = new DOMParser();
        var doc = parser.parseFromString(str, 'text/html');
        return doc.body;
    };  


})
