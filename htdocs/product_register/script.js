'use strict'

let photo = document.getElementById('imgPhoto');
let file = document.getElementById('flImage')


photo.addEventListener('click', () => {
    file.click()
});


file.addEventListener('change', (event) => {

    let reader = new FileReader();


    reader.onload = () => {
        photo.src = reader.result;
    }

    reader.readAsDataURL(file.files[0]);
});