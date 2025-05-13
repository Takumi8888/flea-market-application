// 支払方法の表示
const selector = document.querySelector('#select');
const display = document.querySelector('#display');
display.textContent = '選択してください';

selector.addEventListener('change', (event) => {
    display.textContent = event.target.value;

    if (display.textContent == 'konbini') {
        display.textContent = 'コンビニ払い';
    } else if (display.textContent == 'card') {
        display.textContent = 'カード支払い';
    }
});