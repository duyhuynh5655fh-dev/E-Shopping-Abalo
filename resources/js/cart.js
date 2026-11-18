import {add} from 'mathjs'
export let cartData = [];
const cartItems = document.getElementById('cart-items');
const cartButton = document.getElementById('cart');
window.addEventListener('DOMContentLoaded', () => {
    loadCartFromServer();

    // Toggle Cart Block bei Klick
    cartButton.addEventListener("click", (e) => {
        cartItems.style.display = (cartItems.style.display === "none") ? "block" : "none";
        e.stopPropagation();
    });
});

// Artikel hinzufügen
window.addToCart = function(articleId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", `/api/shoppingcart/${articleId}`, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    const token = document.querySelector('meta[name="auth-token"]').getAttribute('content');
    xhr.setRequestHeader("Authorization", `Bearer ${token}`);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                loadCartFromServer();
                const response = JSON.parse(xhr.responseText);
                alert(response.message || "Artikel wurde erfolgreich hinzugefügt.");
            } else {
                alert("Fehler beim Hinzufügen des Artikels.");
            }
        }
    };

    xhr.send();
};

// Artikel entfernen
 function removeFromCart(cartId, articleId) {
    const xhr = new XMLHttpRequest();
    xhr.open("DELETE", `/api/shoppingcart/${cartId}/articles/${articleId}`, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.setRequestHeader("X-CSRF-TOKEN", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    const token = document.querySelector('meta[name="auth-token"]').getAttribute('content');
    xhr.setRequestHeader("Authorization", `Bearer ${token}`);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                loadCartFromServer()
                articleVue.reload();
                const response = JSON.parse(xhr.responseText);
                alert(response.message || "Artikel wurde erfolgreich gelöscht.");
            } else {
                alert("Fehler beim Löschen des Artikels.");
            }
        }
    };

    xhr.send();
}

// Warenkorb aktualisieren
function updateCart(cartData) {
    const priceSumme = document.createElement("li");
    let summe = 0;

    cartItems.innerHTML = '';

    if (!cartData || cartData.length === 0) {
        cartItems.innerHTML = '<li style="text-align: center">Warenkorb ist leer.</li>';
        return;
    }

    cartData.forEach(item => {
        //summe += item.price / 100;
        summe = add(summe,item.price);

        const li = document.createElement('li');
        li.innerText = `${item.name} - ${item.price / 100} € `;

        const removeButton = document.createElement('button');
        removeButton.innerText = '-';
        removeButton.addEventListener("click", function (e) {
            removeFromCart(item.cartId, item.articleId);
            e.stopPropagation();
        });

        li.appendChild(removeButton);
        cartItems.appendChild(li);
        const row = document.querySelector(`tr[data-id='${item.articleId}']`);
        if (row) row.style.display = 'none';
    });

    priceSumme.innerText = "Summe: " + summe.toFixed(2) + " €";
    cartItems.appendChild(priceSumme);
}


function loadCartFromServer() {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", "/api/shoppingcart");
    xhr.setRequestHeader("Accept", "application/json");

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (csrfToken) {
        xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken);
    }

    const token = document.querySelector('meta[name="auth-token"]')?.getAttribute('content');
    if (token) {
        xhr.setRequestHeader("Authorization", `Bearer ${token}`);
    }

    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            const response = JSON.parse(xhr.responseText);
            cartData.length = 0;
            response.forEach(item => cartData.push(item));
            updateCart(cartData);
        }
    };

    xhr.send();
}
