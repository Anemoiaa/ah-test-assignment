{*
    Variables:
    - totalPages
    - currentPage
    - currentSort
*}

{if $totalPages > 1}
    <nav class="pagination">
        {math equation="max(1, page-2)" page=$currentPage assign="start"}
        {math equation="min(total, start+5)" total=$totalPages start=$start assign="end"}

        {if $start > 1}
            <a href="?page=1&sort={$currentSort}">1</a>
            {if $start > 2}<span>...</span>{/if}
        {/if}

        {for $i=$start to $end}
            <a href="?page={$i}&sort={$currentSort}" class="{if $i==$currentPage}active{/if}">{$i}</a>
        {/for}

        {if $end < $totalPages}
            {if $end < $totalPages-1}<span>...</span>{/if}
            <a href="?page={$totalPages}&sort={$currentSort}">{$totalPages}</a>
        {/if}
    </nav>
{/if}
