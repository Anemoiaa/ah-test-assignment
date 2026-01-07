{extends file="layouts/main.tpl"}

{block name="title"}Not found{/block}

{block name="content"}
    <div class="error-page container">
        <h1 class="title-1">Error {$code}</h1>
        <p>{$message}</p>

        <a href="/" class="inverted-btn">Back to home</a>
    </div>
{/block}
