const imgs = document.querySelectorAll('.picture-select a');
const imgBtns = [...imgs];
let imgId = 1;

imgBtns.forEach((imgItem) => {
    imgItem.addEventListener('mouseover', (event) => {
        event.preventDefault();
        imgId = imgItem.dataset.id;
        slideImage();
    });
});
// Function performed on resizing
function slideImage(){
    if("matchMedia" in window) { // Detection
        if(window.matchMedia("(max-width:1023px)").matches) {
            //select the picture concerned
            const displayWidth = document.querySelector('.picture-showcase img:first-child').clientWidth;
            //move the pictures in the X position, by choosing the width of the images as a reference
            document.querySelector('.picture-showcase').style.transform = `translateX(${- (imgId - 1) * displayWidth}px)`;
        } else {
            const displayHeight = document.querySelector('.picture-showcase img:first-child').clientHeight;
            //move the pictures in the Y position, by choosing the height of the images as a reference
            document.querySelector('.picture-showcase').style.transform = `translateY(${- (imgId -1) * displayHeight}px)`;
        }
    }
}
// We bind the resize event to the function
window.addEventListener('resize', slideImage);

//---------------------------------------------------------------------------------------------
// Function to add or delete a cycling shirt to favorite
document.querySelectorAll('.like').forEach(item => {item.addEventListener('click', addToLikes)});

function addToLikes(event)
{
    event.preventDefault();
    let likeLink = event.currentTarget;
    let link = likeLink.href;
    fetch(link);
    document.location.reload();
}
