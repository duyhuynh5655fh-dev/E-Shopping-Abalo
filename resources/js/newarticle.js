import {round} from 'mathjs'

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById('input_submit').addEventListener('click', event => {
        event.preventDefault();

        const name = document.querySelector('#input_name').value;
        const price = document.querySelector('#input_price').value;
        const description = document.querySelector('#input_description').value;

        // Formulardaten validieren
        const messageBox = document.getElementById('message');
        messageBox.innerText = "";  // Reset Message Box
        let message="";
        let isError = false;


        // Name Validierung
        if (!name) {
            isError = true;
            message+= "Name darf nicht leer sein. ";

        }

        // Preis Validierung
        if (isNaN(price) || price <= 0) {
            isError = true;
            message += " Preis muss eine Zahl und größer als 0 sein.";
        }

        if (!isError) {
            sendData(name, round(price,2), description);
        }
        displayError(message);
    });

    // Fehlerausgabe-Funktion
    function displayError(message) {
        const messageBox = document.getElementById('message');
        messageBox.innerText = message;
        messageBox.style.color = "red";
    }

    function sendData(name, price, description) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/articles');

        // CSRF-Token aus dem <meta> übernehmen
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        xhr.setRequestHeader('X-CSRF-TOKEN', token);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                const messageBox = document.getElementById('message');
                if (xhr.status === 200) {
                    messageBox.innerText = xhr.responseText;
                    messageBox.style.color = "green";
                } else {
                    if (xhr.responseText.includes('<!DOCTYPE html')) {
                        messageBox.innerText = "Fehler: Server hat HTML zurückgegeben – wahrscheinlich ein Validierungsfehler.";
                    } else {
                        messageBox.innerText = "Fehler: " + xhr.responseText;
                    }
                    messageBox.style.color = "red";
                }
            }
        };

        xhr.onerror = function () {
            const messageBox = document.getElementById('message');
            messageBox.innerText = "Fehler: Netzwerkfehler";
            messageBox.style.color = "red";  // Netzwerkfehleranzeige in rot
        };

        const formData = new FormData();
        formData.append("ab_name", name);
        formData.append("ab_price", price);
        formData.append("ab_description", description);
        xhr.send(formData);
    }
});
