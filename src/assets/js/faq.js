$(function menuClick(){
    $('.parent-list>li').on('click', function (){
        $('.parent-list>li').not(this).find('a').removeClass('show');
    });
    
    $('.child-list li a').on('click', function (){
        $('.child-list li a').not(this).removeClass('show');
        $(this).addClass('show');
    });
});