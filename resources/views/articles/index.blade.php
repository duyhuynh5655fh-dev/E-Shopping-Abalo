<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="auth-token" content="{{ $token }}">
    <title>Artikelübersicht</title>
    @vite(['resources/js/app.js', 'resources/css/app.scss'])
    <style>
        #search-bar {
            border: 1px solid black;
            border-radius: 5px;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            text-align: center;
        }
        #add-to-cart {
            border: 1px solid black;
            border-radius: 5px;
            width: 25px;
            display: block;
            margin: 0 auto;
        }
        #categories-select {
            display: flex;
            flex-wrap: wrap;
        }
        #categories-select>div {
            border: 1px solid black;
            padding: 5px;
        }
        #search-button {
            margin-left: 10px;
            padding-left: 2px;
            padding-right: 2px;
            border: 1px solid black;
            border-radius: 5px;
        }
        #search-button:hover {
            background-color: #848487;
        }
    </style>
</head>
<body>

@auth
<span>
    Hi there, {{Auth::user()->ab_name}}
</span>
@endauth

<h1>Artikelübersicht</h1>
<div id="cart-wrapper">
    <button id="cart">🛒 Warenkorb</button>
    <ul id="cart-items"></ul>
</div>
<br>
<!-- Tabelle der Artikel -->
<div id="article-table">

    <input type="search" id="search-bar" v-model="searchByName" placeholder="search article...">
    <button id="search-button" @click="searchArticlesByName">search</button><br>

    <label>select category:</label>
    <div id="categories-select">
        <div v-for="cat in categories" :key="cat.id">
            <label>
                <input type="checkbox" :value="cat.id" v-model="selectedCategories">
                @{{ cat.ab_name }}
            </label>
        </div>
    </div>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Creator ID</th>
            <th>Create date</th>
            <th>Bild</th>
            <th>Add to cart</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="article in filteredArticles" :key="article.id">
            <td>@{{ article.id }}</td>
            <td>@{{ article.ab_name }}</td>
            <td>@{{ (article.ab_price / 100).toFixed(2) }} €</td>
            <td>@{{ article.ab_description }}</td>
            <td>@{{ article.ab_creator_id }}</td>
            <td>@{{ article.ab_createdate }}</td>
            <td>
                <img :src="'./images/articelimages/' +  article.id  + '.jpg'" alt="Bild" width="100" @@error="handleImageError($event)">
            </td>
            <td><button id="add-to-cart" @click="addToCart(article.id)">+</button></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>
