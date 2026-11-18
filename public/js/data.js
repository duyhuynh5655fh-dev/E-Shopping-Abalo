"use strict"
var data = {
    'produkte': [
        { name: 'Ritterburg', preis: 59.99, kategorie: 1, anzahl: 3 },
        { name: 'Gartenschlau 10m', preis: 6.50, kategorie: 2, anzahl: 5 },
        { name: 'Robomaster' ,preis: 199.99, kategorie: 1, anzahl: 2 },
        { name: 'Pool 250x400', preis: 250, kategorie: 2, anzahl: 8 },
        { name: 'Rasenmähroboter', preis: 380.95, kategorie: 2, anzahl: 4 },
        { name: 'Prinzessinnenschloss', preis: 59.99, kategorie: 1, anzahl: 5 }
    ],
    'kategorien': [
        { id: 1, name: 'Spielzeug' },
        { id: 2, name: 'Garten' }
    ]
};

function getProdukte(data) {
    return data.produkte;
}

function getKategorien(data) {
    return data.kategorien;
}

function getMaxPreis(data) {
    let produkte = getProdukte(data);
    let max = 0;
    for(const el of produkte) {
        max = el.preis > max ? el.preis : max;
    }
    return produkte.find(el => el.preis === max).name;
}

function getMinPreisProdukt(data) {
    let produkte = getProdukte(data);
    let min = produkte[0].preis;
    for(const el of produkte) {
        min = el.preis < min ? el.preis : min;
    }
    return produkte.find(el => el.preis === min);
}

function getPreisSum(data) {
    let produkte = getProdukte(data);
    let sum = 0;
    for(const el of produkte) {
        sum += el.preis;
    }
    return sum;
}

function getGesamtWert(data) {
    let produkte = getProdukte(data);
    let sum = 0;
    for(const el of produkte) {
        sum += el.preis * el.anzahl;
    }
    return sum;
}

function getAnzahlProdukteOfKategorie(data, kategorie) {
    let produkte = getProdukte(data);
    let kategorieId = getKategorien(data).find(el => el.name === kategorie).id;
    let anzahl = 0;
    for(const el of produkte) {
        if(el.kategorie === kategorieId) {
            anzahl++;
        }
    }
    return anzahl;
}

console.log(getMaxPreis(data));
console.log(getMinPreisProdukt(data));
console.log(getPreisSum(data));
console.log(getGesamtWert(data));
console.log(getAnzahlProdukteOfKategorie(data, 'Spielzeug'));
