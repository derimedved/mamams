$(document).ready(function() {
const blackout = document.querySelector('.blackout'),
      popUpClose = document.querySelectorAll('.pop-up__close'),
      openThankYou = document.querySelector('.open-thank-you'),
      popupThankYou = document.querySelector('.pop-up-thank-you');

popUpClose.forEach((element, i) => {
    element.addEventListener('click', () =>{
        blackout.classList.remove('blackout_active');
        popupThankYou.classList.remove('pop-up_active');
    })
});
console.log('openThankYou', openThankYou);
if(openThankYou) {
    openThankYou.addEventListener('click', () => {
        popupThankYou.classList.add('pop-up_active');
        blackout.classList.add('blackout_active');
    });
}




    $(document).mouseup(function (e){ // событие клика по веб-документу
        var div = $(".pop-up"); // тут указываем ID элемента
        if (!div.is(e.target) // если клик был не по нашему блоку
            && div.has(e.target).length === 0) { // и не по его дочерним элементам
            popupThankYou.classList.remove('pop-up_active');
            blackout.classList.remove('blackout_active');
        }
    });
});