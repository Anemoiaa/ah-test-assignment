{extends file="layouts/main.tpl"}

{block name="title"}{$category.name}{/block}

{block name="content"}
    <div class="container">
        <div class="category">
            <h1 class="category__title title-1">{$category.name}</h1>
            <p class="category__description">{$category.description}</p>

            <form method="get" class="category__sort-form">
                <label>Sort by:
                    <select name="sort">
                        {foreach $sortOptions as $key => $option}
                            <option value="{$key}" {if $currentSort == $key}selected{/if}>{$option.label}</option>
                        {/foreach}
                    </select>
                </label>
                <button type="submit" class="inverted-btn">Apply</button>
            </form>

            <div class="category__posts grid-cols-3">
                {foreach $posts as $post}
                    {include file="post/partials/post-preview.tpl" post=$post}
                {/foreach}
            </div>
        </div>

        {if $totalPages > 1}
            {include file="partials/pagination.tpl"
                totalPages=$totalPages
                currentPage=$page
                currentSort=$currentSort
            }
        {/if}

    </div>
{/block}

