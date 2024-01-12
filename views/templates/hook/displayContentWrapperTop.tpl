<div class="container_menu_age">
    <h3>By Age</h3>
    <button class="scroll-btn left-btn" onclick="scrollMenu('prev')">&#9664; Précédent</button>
    <ul class="menu_age">
      {assign var=currentAge value=1}
      {foreach from=$imgPath item=image}
          <a href="{$link->getModuleLink('productbyage','productage',['age' => $currentAge])}">
              <li class="item_menu_age"><img src="{$image}">{$currentAge}</li>
          </a>
          {assign var=currentAge value=$currentAge+1}
      {/foreach}
    </ul>
    <button class="scroll-btn right-btn" onclick="scrollMenu('next')">Suivant &#9654;</button>
</div>


<script>
    const menu = document.querySelector('.menu_age');
    const scrollBtns = document.querySelectorAll('.scroll-btn');
    const btnRight = document.querySelector('.right-btn');
    const btnLeft = document.querySelector('.left-btn');
    let scrollPosition = 0;
    var scrollStep = 5;

    var items = document.querySelectorAll('.menu_age a');
    var currentMarginLeft = parseFloat(items[0].style.marginLeft) || 0;
    
    if(currentMarginLeft == 0)
    {
        btnLeft.disabled = true;
    }

    if(window.screen.width < 767)
    {
        scrollStep = 12;
    }

    function scrollMenu(direction) {
        var items = document.querySelectorAll('.menu_age a');
        var lastIndex = items.length - 1;

        if (direction === 'next') {

            var currentMarginLeft = parseFloat(items[0].style.marginLeft) || 0;
            items[0].style.marginLeft = (currentMarginLeft - scrollStep) + '%';
            
            items[lastIndex].style.marginRight = '10px';

            if (window.screen.width < 767)
            {
                // const scrollStep = 50;

                if (currentMarginLeft <= -345) 
                {                    
                    btnRight.disabled = true;
                } 

                if(currentMarginLeft = -12)
                {
                    btnLeft.disabled = false;
                }
            }

            if (currentMarginLeft <= -70) 
            {                
                btnRight.disabled = true;
            } 

            if(currentMarginLeft =5)
            {
                btnLeft.disabled = false;
            }

        } else if (direction === 'prev') {
            
            var currentMarginLeft = parseFloat(items[0].style.marginLeft) || 0;
            items[0].style.marginLeft = (currentMarginLeft + scrollStep) + '%';

            items[lastIndex].style.marginRight = '10px';

            if(currentMarginLeft > -80)
            {
                btnRight.disabled = false;
            }

            if(currentMarginLeft == -5)
            {
                btnLeft.disabled = true;
            }

            if(window.screen.width < 767)
            {
                if(currentMarginLeft > -350)
                {
                    btnRight.disabled = false;

                }

                if(currentMarginLeft == -12)
                {
                    btnLeft.disabled = true;
                }
            }
        }
    }

    scrollBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const direction = btn.getAttribute('onclick').includes('prev') ? 'prev' : 'next';
            scrollMenu(direction);
        });
    });
</script>