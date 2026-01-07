{extends file="layouts/main.tpl"}

{block name="content"}
    {foreach $categories as $category}
        <section class="category-preview container">
            <div class="category-preview__header">
                <h2 class="category-preview__title title-2">
                    {$category['name']}
                </h2>
                <a href="/categories/{$category['id']}" class="category-preview__link">
                    View All
                </a>
            </div>

                <div class="category-preview__list grid-cols-3">
                {foreach $category['posts'] as $post}
                    {include file="post/partials/post-preview.tpl" post=$post}
                {/foreach}
            </div>
        </section>
    {/foreach}
{/block}
