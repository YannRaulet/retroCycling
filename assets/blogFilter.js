// Display all the articles

function articlesFunction() {
    const articles = document.getElementById('blogArticles');
    const cyclingShirt = document.getElementById('blogCyclingShirt');
    const cyclist = document.getElementById('blogCyclist');
    const tour = document.getElementById('blogTour');

    if (articles.style.display === 'none') {

        cyclingShirt.style.display = 'none';
        cyclist.style.display = 'none';
        tour.style.display = 'none';
        articles.style.display = 'block';
    }
}
document.getElementById('allArticles').addEventListener('click', articlesFunction, false);

//--------------------------------------------------------
// Display the articles of the "Maillots d'antan" category

function cyclingShirtFunction() {
    const cyclingShirt = document.getElementById('blogCyclingShirt');
    const cyclist = document.getElementById('blogCyclist');
    const tour = document.getElementById('blogTour');
    const articles = document.getElementById('blogArticles');

    if (cyclingShirt.style.display === 'none') {

        articles.style.display = 'none';
        cyclist.style.display = 'none';
        tour.style.display = 'none';
        cyclingShirt.style.display = 'block';
    }
}
document.getElementById('switchCyclingShirt').addEventListener('click', cyclingShirtFunction, false);

//--------------------------------------------------------
// Display the articles of the "Coureurs d'antan" category

function cyclistFunction() {
    const cyclist = document.getElementById('blogCyclist');
    const cyclingShirt = document.getElementById('blogCyclingShirt');
    const tour = document.getElementById('blogTour');
    const articles = document.getElementById('blogArticles');

    if (cyclist.style.display === 'none') {
        articles.style.display = 'none';
        tour.style.display = 'none';
        cyclingShirt.style.display = 'none';
        cyclist.style.display = 'block';
    }
}
document.getElementById('switchCyclist').addEventListener('click', cyclistFunction, false);

//-----------------------------------------------------
// Display the articles of the "Tours d'antan" category

function tourFunction() {
    const tour = document.getElementById('blogTour');
    const cyclist = document.getElementById('blogCyclist');
    const cyclingShirt = document.getElementById('blogCyclingShirt');
    const articles = document.getElementById('blogArticles');

    if (tour.style.display === 'none') {
        articles.style.display = 'none';
        cyclist.style.display = 'none';
        cyclingShirt.style.display = 'none';
        tour.style.display = 'block';
    }
}
document.getElementById('switchTours').addEventListener('click', tourFunction, false);
