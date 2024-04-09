const addBtns = document.querySelectorAll('.add-to-cart')
const alert = document.querySelector('.alert')
const productImgs = document.querySelectorAll('.product-img')
const modalBody = document.querySelector('.modal-body')

const showAlert = (e) => {
  alert.style.display = "block"; 
};

const showProductImg = (e) => {
  const img = `<img src=${e.target.src} style="width: 100%"/>`
  modalBody.innerHTML = img;
};

addBtns.forEach((addBtn) => {
  addBtn.addEventListener('click', showAlert);
});

productImgs.forEach((productImg) => { 
  productImg.addEventListener('click', (e) => {
    showProductImg(e);
  });
});