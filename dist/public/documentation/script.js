(function(){

    'use strict';

    new SmoothScroll('a[href*="#"]', 
        {
            speed: 400,
            speedAsDuration: true
        }
    );

    var menus = document.querySelectorAll('.sidebar ul li a');

    menus.forEach(function(menu){

        menu.addEventListener('click', function(){

            menus.forEach(function(menu){
                menu.classList.remove('active');
            });

            menu.classList.add('active');
        });

    });

})();