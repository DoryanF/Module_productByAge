<div class="container_menu_age_leftColumn">
    <section style="text-align: center;">
        <p class="h6 text-uppercase facet-label">By Age</p>
        <ul class="menu_age_leftColumn">
        {assign var=currentAge value=1}
        {foreach from=$imgPath item=image}
            <a href="{$link->getModuleLink('productbyage','productage',['age' => $currentAge])}">
                <li class="item_menu_age_leftColumn"><img src="{$image}" style="width: 15%;">{$currentAge} an(s)</li>
            </a>
            {assign var=currentAge value=$currentAge+1}
        {/foreach}
        </ul>
    
    </section>
</div>

{* <div class="container_menu_age_leftColumn">
    <section style="text-align: center;">
        <p class="h6 text-uppercase facet-label">By Age</p>
        <ul class="menu_age_leftColumn">
            {assign var=startAge value=1}
            {assign var=endAge value=4}
            {while $startAge <= 12}
                {assign var=currentAge value="$startAge-$endAge"}
                <li class="item_menu_age_leftColumn {$currentAge|replace:'-':'to'}">
                    <a href="#" class="age-link" data-age="{$currentAge}">{$startAge} à {$endAge} an(s)</a>
                </li>
                {assign var=startAge value=$endAge+1}
                {assign var=endAge value=$endAge+4}
            {/while}
        </ul>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var ageLinks = document.querySelectorAll('.age-link');
    ageLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            var clickedAge = this.getAttribute('data-age');
            var allImageContainers = document.querySelectorAll('.image-container');

            allImageContainers.forEach(function(container) {
                container.classList.remove('active');
            });

            var activeImageContainers = document.querySelectorAll('.image-container.' + 'age-' + clickedAge);
            activeImageContainers.forEach(function(container) {
                container.classList.add('active');
            });
        });
    });
});
</script> *}
