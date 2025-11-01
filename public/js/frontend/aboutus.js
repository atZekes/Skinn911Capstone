// About page JS: sticky header behaviour
window.addEventListener('DOMContentLoaded', function() {
    var header = document.querySelector('.header-area');
    var mainHeader = document.querySelector('.main-header-area');
    function handleScroll() {
        if (window.scrollY > 50) {
            header.style.display = '';
            mainHeader.classList.add('sticky');
        } else {
            header.style.display = 'none';
            mainHeader.classList.remove('sticky');
        }
    }
    handleScroll();
    window.addEventListener('scroll', handleScroll);
});
