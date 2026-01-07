<article class="post-preview">
    <div class="post-preview__image">
        <img src="{$post.image}" alt="{$post.title}">
    </div>

    <h3 class="post-preview__title title-3">
        {$post.title}
    </h3>

    <div class="post-preview__description">
        <p>{$post.description}</p>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: end">
        <div>
            <time class="post-preview__date">
                {$post.created_at}
            </time>

            <div class="post-preview__views">
                Views: {$post.views}
            </div>
        </div>

        <a href="/posts/{$post.id}" class="post-preview__link">Read</a>
    </div>
</article>
