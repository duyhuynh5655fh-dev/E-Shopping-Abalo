import './bootstrap';
import './cookiecheck'

import axios from 'axios';
import {createApp} from 'vue';
import {round} from "mathjs";

import SiteHeader from './components/siteheader.vue';
import SiteBody from './components/sitebody.vue';
import SiteFooter from './components/sitefooter.vue';

createApp({
    components: {
        SiteHeader,
        SiteBody,
        SiteFooter
    },
    data() {
        return {
            show: 'articles'
        };
    },
    methods: {
        handleShowBody(content) {
            this.show = content;
        }
    }
}).mount('#app');

// Vue für neuer Artikel hinzufügen newarticle.blade.php
createApp({
    data() {
        return {
            ab_name: '',
            ab_price: 0,
            ab_description: '',
        };
    },
    methods: {
        articleValidate() {
            const $name = this.$data.ab_name;
            const $price = this.$data.ab_price;
            const $description = this.$data.ab_description;
            let isError = false;
            let message = '';

            if (!$name) {
                isError = true;
                message+= "Name darf nicht leer sein. ";

            }

            if (isNaN($price) || $price <= 0) {
                isError = true;
                message+= "Preis muss eine Zahl und größer als 0 sein.";
            }

            if (!isError) {
                this.sendData($name, round($price,2), $description);
            }
            this.displayError(message);
        },
        displayError(message) {
            const messageBox = document.getElementById('message');
            messageBox.innerText = message;
            messageBox.style.color = "red";
        },
        sendData(name, price, description) {
            axios.post('/api/articles', {
                name: name,
                price: price,
                description: description
            }, {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Authorization': 'Bearer ' + document.querySelector('meta[name="auth-token"]').getAttribute('content')
                }
            })
                .then(response => {
                    alert("Artikel gespeichert: " + response.data.id);
                })
                .catch(error => {
                    this.displayError("Fehler beim Speichern des Artikels.");
                    console.error(error);
                });
        }
    }
}).mount('#article-form');

