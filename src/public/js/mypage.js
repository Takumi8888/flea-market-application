// ボタン
const button = document.getElementById("button");
const image = document.getElementById("image");

button.addEventListener("click", (e) => {
    if (image) {
        image.click();
    }
}, false,);