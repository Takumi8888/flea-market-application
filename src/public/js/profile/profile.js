// 画像アップロード時に画像を動的に表示・切り替える
$('#file').on('change', function (e) {
    const reader = new FileReader();
    reader.onload = function (e) {
        $('#image').attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
})

// ファイル選択ボタン
const button = document.getElementById("button");
const file = document.getElementById("file");

button.addEventListener("click", (e) => {
    if (file) {
        file.click();
    }
}, false,);

file.addEventListener("input", (e) => {
    if (file.value) {
        button.style.backgroundColor = '#FF5555';
        button.style.color = '#FFFFFF';
    }
}, false,);