// 画像のボタン
const imageButton = document.getElementById("btn--img");
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


// 画像アップロード時に画像を動的に表示・切り替える
$('#file').on('change', function (e) {
    const reader = new FileReader();
    reader.onload = function (e) {
        $('#img').attr('src', e.target.result);
    }
    reader.readAsDataURL(this.files[0]);
})


// カテゴリのボタン
const categoryButton = document.getElementsByClassName("btn--category");
const checkbox = document.getElementsByClassName("checkbox");

for (let i = 0; i < categoryButton.length; i++) {
    categoryButton[i].addEventListener("click", (e) => {
        if (checkbox[i]) {
            checkbox[i].click();
            if (checkbox[i].checked) {
                categoryButton[i].style.backgroundColor = '#FF5555';
                categoryButton[i].style.color = '#FFFFFF';
            } else {
                categoryButton[i].style.backgroundColor = '#FFFFFF';
                categoryButton[i].style.color = '#FF5555';
            }
        }
    }, false,);
}


// 金額の桁区切り用カンマ表示
function updateTextView(_obj) {
    const num = getNumber(_obj.val());
    if (num == 0) {
        _obj.val('');
    } else {
        _obj.val(num.toLocaleString());
    }
}

function getNumber(_str) {
    const arr = _str.split('');
    const out = new Array();

    for (let cnt = 0; cnt < arr.length; cnt++) {
        if (isNaN(arr[cnt]) == false) {
            out.push(arr[cnt]);
        }
    }
    return Number(out.join(''));
}

$(function () {
    $('input[name=price]').on('keyup', function () {
        updateTextView($(this));
    });
});