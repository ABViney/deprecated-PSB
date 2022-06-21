
window.onload = function() {
    document.getElementById("push-form").addEventListener("click", () => {
        if(!checkValidity()) {
            return false;
        } parseForm();
    });
    document.querySelectorAll("input[name=\"cm\"]").forEach((elem) =>
    {
        elem.addEventListener('click', () => {
            let phone = document.getElementById("phone");
            if(document.getElementById("p").checked) {
                phone.disabled = false;
                phone.required = true;

            } else {
                phone.required = false;
                phone.disabled = true;
            }
        })
    })
    document.getElementById("comment").addEventListener('keyup', (e, counter = document.getElementById("status")) => {
        counter.innerHTML = e.target.value.length + "/500";
        if(e.target.value.length === 500 || e.target.value.length === 0) counter.style.color = "RED"
        else counter.style.color = "initial";
    })
}

function checkValidity() {
    let params = {
        "name"  : document.getElementById("name").value,
        "org"   : (() => {
            let org = document.getElementById("org").value;
            if(org.length < 1) return "Not Specified";
            return org;
        })(),
        "email" : document.getElementById("email").value,
        "cm"    : (() => {
            let cm = document.getElementsByName("cm");
            for(let i = 0; i < cm.length; i++) {
                if(cm[i].checked) return cm[i].value;
            } return "undefined";
        })(),
        "phone" : (document.getElementById("p").checked) ? document.getElementById("phone").value : "N/A",
        "comment" : document.getElementById("comment").value
    };

    let name_isvalid = /^[a-zA-Z'-`]+( [a-zA-Z'-`]+)?/.test(params.name);
    // TODO: Set up proper regex filter, all fields may need their own validation function
    let email_isvalid = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/.test(params.email);
    let cm_isvalid = (params.cm === "phone") ? /^(\+?\d{1,2}\s?)?\(?\d{3}\)?[\s.-]?\d{3}[\s.-]?\d{4}$/.test(params.phone) : true;
    let comment_isvalid = document.getElementById("comment").value.length > 0;
    if( name_isvalid && email_isvalid && cm_isvalid && comment_isvalid ) {
        return true;
    } else {
        const notate = function(e) {
            e.target.style.backgroundColor = "white";
            e.target.removeEventListener('keydown', notate, false);
        }
        if(!name_isvalid) {
            document.getElementById("name").style.backgroundColor = "rgb(240, 100, 100, 0.2)";
            document.getElementById("name").addEventListener('keydown', notate, false);
        }
        if(!email_isvalid) {
            document.getElementById("email").style.backgroundColor = "rgb(240, 100, 100, 0.2)";
            document.getElementById("email").addEventListener('keydown', notate, false);
        }
        if(!cm_isvalid) {
            document.getElementById("phone").style.backgroundColor = "rgb(240, 100, 100, 0.2)";
            document.getElementById("phone").addEventListener('keydown', notate, false);
        }
        if(!comment_isvalid) {
            document.getElementById("comment").style.backgroundColor = "rgb(240, 100, 100, 0.2)";
            document.getElementById("comment").addEventListener('keydown', notate, false);
        }
    } return false;
}

function parseForm() {

    let params = {
        "name"  : document.getElementById("name").value,
        "org"   : (() => {
            let org = document.getElementById("org").value;
            if(org.length < 1) return "Not Specified";
            return org;
        })(),
        "email" : document.getElementById("email").value,
        "cm"    : (() => {
            let cm = document.getElementsByName("cm");
            for(let i = 0; i < cm.length; i++) {
                if(cm[i].checked) return cm[i].value;
            } return "undefined";
        })(),
        "phone" : (document.getElementById("p").checked) ? document.getElementById("phone").value : "N/A",
        "comment" : document.getElementById("comment").value
    };

    packageAndSend(params);
}

function packageAndSend(params) {
    let button = document.getElementById('push-form');
    let status = document.getElementById('status');

    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://www.vindig.dev/PSB/php/send-form.php', true);
    xhr.setRequestHeader("Accept", "text/html");
    xhr.onprogress = () => {
        button.style.color = "var(--clr-g)";
        status.innerHTML = "Sending...";
    };
    xhr.onload = () => {
        let response = "";
        status.style.color = "initial";
        if(xhr.status === 200) {
            let xhrResponse = xhr.responseText;
            if(xhrResponse.includes('E: ')) {
                status.style.color = "RED";
                status.innerHTML = "Submission Failed";
                alert(xhrResponse.replace("E: ", ""));
            }
            else {
                status.style.color = "GREEN";
                status.innerHTML = "Form Sent Successfully";
                button.disabled = "true";
                button.style.visibility = "hidden";
                alert(xhrResponse);
            }
        }
        else if(xhr.status === 403) {
            console.error("Request not permitted");
            alert("Error 403");
        }
        else if(xhr.status === 404) {
            console.error("Resource not found");
            alert("Error 404");
        } else {
            console.error("Unknown resolve");
            alert("Something went wrong. Please try again later.");
        }
    };
    xhr.onerror = () => {
        console.error("Failed to contact server");
        alert('Error contacting server.\nPlease try again later');
    };

    let formData = new FormData();
    formData.append('name', params.name);
    formData.append('org', params.org);
    formData.append('email', params.email);
    formData.append('cm', params.cm);
    formData.append('phone', params.phone);
    formData.append('comment', params.comment);
    xhr.send(formData);
}