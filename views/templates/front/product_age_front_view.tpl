{extends file="page.tpl"}

{block content}

    {if isset($noProductsMessage)}
        <p>{$noProductsMessage}</p>
        <a href="{$base_url}" class="btn btn-primary">Retour à la page d'accueil</a>
    {else}
        <div class="products products_front_controller">
            {foreach from=$products item="product"}
                {include file="catalog/_partials/miniatures/product.tpl" product=$product}
            {/foreach}
        </div>
    {/if}
    
{/block}