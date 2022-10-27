function init(){


    let nameValidation = false;
    let passValidation = false;

   
    
    document.getElementById("pswd").addEventListener("keyup", function(event) {
    
        if(document.getElementById("pswd").value !== document.getElementById("psd").value){
            document.getElementById("psd").classList.add("error");
            document.getElementById("pswd").classList.add("error");
            passValidation = false;
            document.getElementById("registerSubmit").disabled = true;
        }else{
            document.getElementById("psd").classList.remove("error");
            document.getElementById("pswd").classList.remove("error");
            passValidation = true;
        } 

        if(passValidation && nameValidation){
            document.getElementById("registerSubmit").disabled = false;
        }
    })

    document.getElementById("user").addEventListener("keyup", function(event) {
        if(document.getElementById("user").value == ""){
            document.querySelector("#user").classList.add("error");
            nameValidation = false;
            document.getElementById("registerSubmit").disabled = true;

        }else{
            document.querySelector("#user").classList.remove("error");
            nameValidation = true;
        }

        if(passValidation && nameValidation){
            document.getElementById("registerSubmit").disabled = false;
        }
    })

}


init();