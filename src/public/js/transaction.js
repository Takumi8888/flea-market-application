// 画像のボタン
const imageButton = document.getElementById("image-button");
const file = document.getElementById("file");

imageButton.addEventListener("click", (e) => {
    if (file) {
        file.click();
    }
}, false,);

file.addEventListener("input", (e) => {
    if (file.value) {
        imageButton.style.backgroundColor = '#FF5555';
        imageButton.style.color = '#FFFFFF';
    }
}, false,);

// レビュー画面表示（モーダル：購入者）
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}

// 画像拡大（モーダル）
var modal = document.getElementById("modal-img");
var modalImg = document.getElementById("js-modal-img");
var captionText = document.getElementById("caption");

var images = document.querySelectorAll(".message-img img");
images.forEach(function(img) {
    img.onclick = function() {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    }
});

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}