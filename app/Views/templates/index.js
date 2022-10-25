function init(){


    let nameValidation = false;
    let passValidation = false;


    document.getElementById("registerSubmit").addEventListener("click", function(event) {
        event.preventDefault();
        const form = document.getElementById("registerForm");
        var user = form.querySelector("#user").value;
        fetch("/signup", {
            method: "POST",
            body: JSON.stringify({user: `${form.querySelector("#user").value}`,pswd: `${form.querySelector("#pswd").value}`}),
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => {
            response.json().then(data => {
            if(data.code == 400){
                if(data.message == "Email déjà utilisé"){
                    form.querySelector("#user").classList.add("error");
                    alert("Email déjà utilisé");
                }
            }else if(data.code == 200){
                window.location.href = "/menu";
            }
            })
        })
    })
    
    
    document.getElementById("loginSubmit").addEventListener("click", function(event) {
        event.preventDefault();
        fetch("/login", {
            method: "POST",
            body: JSON.stringify({user: `${document.getElementById('userLog').value}`,pswd: `${document.getElementById('pswdLog').value}`}),
            headers: {
                "Content-Type": "application/json"
            }
        })
        .then(response => {
            response.json().then(data => {
                console.log(data)
            if(data.code == 400){
                if(data.message == "Email ou mot de passe incorrect"){
                    document.getElementById('userLog').classList.add("error");
                    document.getElementById('pswdLog').classList.add("error");
                    alert("Email ou mot de passe incorrect");
                }
            }
            if(data.code == 200) {
                window.location.href = '/menu'
            }
            })
        })
    })
    
    
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