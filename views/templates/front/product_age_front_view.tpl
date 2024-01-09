{extends file="page.tpl"}

{block content}
    <h3>{$age}</h3>

    {foreach from=$products item="product"}
        {include file="catalog/_partials/miniatures/product.tpl" product=$product}
    {/foreach}
{/block}