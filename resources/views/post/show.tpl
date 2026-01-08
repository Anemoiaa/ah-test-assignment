{extends file="layouts/main.tpl"}

{block name="title"}
    {$post.title}
{/block}

{block name="content"}
    <div class="container">
        <article class="post">
            <h1 class="post__title title-1">
                {$post.title}
            </h1>

            <div class="post__meta">
                <time class="post__date">
                    {$post.created_at}
                </time>

                <span class="post__views">
                {$post.views} views
            </span>
            </div>

            <div class="post__image">
                <img src="{$post.image}" alt="{$post.title}">
            </div>

            <div class="post__content">
                <p>
                    {$post.text}
                </p>
            </div>
        </article>

        <div>
            <h2 class="title-2">Similar Posts</h2>
            <div class="grid-cols-3">
                {foreach $similarPosts as $post}
                    {include file="post/partials/post-preview.tpl" post=$post}
                {/foreach}
            </div>
        </div>
    </div>
{/block}
