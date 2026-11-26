const sizeButtons = document.querySelectorAll('.bike-show__size');

sizeButtons.forEach(button => {
    button.addEventListener('click', () => {
        sizeButtons.forEach(btn => btn.classList.remove('bike-show__size--selected'));
        button.classList.add('bike-show__size--selected');
    });
});

const colourButtons = document.querySelectorAll('.bike-show__colour');

colourButtons.forEach(button => {
    button.addEventListener('click', () => {
        colourButtons.forEach(btn => btn.classList.remove('bike-show__colour--selected'));
        button.classList.add('bike-show__colour--selected');
    });
});