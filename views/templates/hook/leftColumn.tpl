<div class="container_menu_age_leftColumn">
    <section style="text-align: center;">
        <p class="h6 text-uppercase facet-label">By Age</p>
        <button class="scroll-btn-leftColumn left-btn-leftColumn" onclick="scrollMenu('prev')">&uarr; Précédent</button>
        <ul class="menu_age_leftColumn">
        {assign var=currentAge value=1}
        {foreach from=$imgPath item=image}
            <a href="{$link->getModuleLink('productbyage','productage',['age' => $currentAge])}">
                <li class="item_menu_age_leftColumn"><img src="{$image}" style="width: 15%;">{$currentAge} an(s)</li>
            </a>
            {assign var=currentAge value=$currentAge+1}
        {/foreach}
        </ul>
        <button class="scroll-btn-leftColumn right-btn-leftColumn" onclick="scrollMenu('next')">Suivant &darr;</button>
    </section>
</div>


<script>
    let currentOffset = 0; // Variable pour suivre la position actuelle
    const itemsPerPage = 6; // Nombre d'éléments à afficher à la fois

    function scrollMenu(direction) {
        const items = document.querySelectorAll('.menu_age_leftColumn a');
        const totalItems = items.length;

        if (direction === 'next') {
            if (currentOffset + itemsPerPage < totalItems) {

                currentOffset += 1;
            } else {
                currentOffset = 0 - 1 ; // Revenir au début si on dépasse le nombre total d'éléments
            }
        } else if (direction === 'prev') {
            if (currentOffset - 1 >= 0) {
                currentOffset -= 1;
            } else {
                const totalPages = Math.ceil(totalItems / itemsPerPage);
                currentOffset = (totalPages - 1) * itemsPerPage + itemsPerPage - 1;
            }
        }

        updateVisibility(items, currentOffset);
    }

    function updateVisibility(items, offset) {
        items.forEach((item, index) => {
            const adjustedIndex = index + 1;
            if (adjustedIndex > offset && adjustedIndex <= offset + itemsPerPage) {
                item.style.display = 'inline-block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    const prevBtn = document.querySelector('.scroll-btn-leftColumn.left-btn-leftColumn');
    const nextBtn = document.querySelector('.scroll-btn-leftColumn.right-btn-leftColumn');

    prevBtn.addEventListener('click', () => scrollMenu('prev'));
    nextBtn.addEventListener('click', () => scrollMenu('next'));

    const initialItems = document.querySelectorAll('.menu_age_leftColumn a');
    updateVisibility(initialItems, currentOffset);
</script>