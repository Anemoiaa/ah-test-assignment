<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{block name="title"}Blog{/block}</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
<header class="header">
    <div class="header__container container">
        <h1 class="header__title">
            <a href="/" class="header__title-link">Blog</a>
        </h1>

        <nav class="header__nav">
            <ul class="header__menu">
                <li class="header__menu-item">
                    <a href="/" class="header__menu-link primary-btn">Home</a>
                </li>
            </ul>
        </nav>
    </div>
</header>

<main class="main">
    {block name="content"}{/block}
</main>

<footer class="footer">
    <div class="container">
        Footer
    </div>
</footer>
</body>
</html>
