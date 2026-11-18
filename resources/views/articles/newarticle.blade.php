<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="auth-token" content="{{ session('auth_token') }}">
    <title>Neuer Artikel</title>
    @vite(['resources/js/app.js', 'resources/css/app.scss'])
</head>
<body>
    <div class="article-form" id="article-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <label class="article-form__label">Name</label>
        <input class="article-form__input" type="text" v-model="ab_name">

        <label class="article-form__label">Price</label>
        <input class="article-form__input" type="number" v-model="ab_price">

        <label class="article-form__label">Description</label>
        <textarea class="article-form__textarea" v-model="ab_description"></textarea>

        <button class="article-form__button" @click="articleValidate">
            save article
        </button>

        <div id="message"></div>
    </div>
</body>
</html>
