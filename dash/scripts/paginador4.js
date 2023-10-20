const divsOcultos = document.querySelectorAll('.div-oculto');

for (let i = 0; i < divsOcultos.length; i++) {
  divsOcultos[i].style.display = 'none';
}

let htmlDivs = [];

for (let i = 0; i < divsOcultos.length; i++) {
  htmlDivs.push(divsOcultos[i].innerHTML);
}

// console.log(htmlDivs);

const divMostrado = document.querySelector('.div-mostrado');

let currentPage = 1;
const itemsPerPage = 6;

function showCards(start, end) {
  divMostrado.innerHTML = htmlDivs.slice(start, end).join('');
}

showCards(0, itemsPerPage);

const numPages = Math.ceil(htmlDivs.length / itemsPerPage);

function updateActivePage(pageNum) {
  const activeBtn = document.querySelector('.page-btn.active-paginador');
  activeBtn.classList.remove('active-paginador');
  pageButtons[pageNum - 1].classList.add('active-paginador');
  currentPage = pageNum;
  updateColorsPaginator();
}

const pageButtons = [];

for (let i = 1; i <= numPages; i++) {
  const link = document.createElement('a');
  link.innerHTML = i;
  link.classList.add('page-btn');
  if (i == currentPage) {
    link.classList.add('active-paginador');
  }
  pageButtons.push(link);
}

const paginador = document.querySelector('.paginador');
paginador.innerHTML = '';
const prevBtn = document.createElement('a');

prevBtn.innerHTML = '<<';
prevBtn.classList.add('page-btn');
prevBtn.addEventListener('click', function () {
  updateActivePage(1);
  showCards(0, itemsPerPage);
});

paginador.appendChild(prevBtn);
paginador.append(...pageButtons);

const nextBtn = document.createElement('a');

nextBtn.innerHTML = '>>';
nextBtn.classList.add('page-btn');

nextBtn.addEventListener('click', function () {
  updateActivePage(numPages);
  const startIndex = (numPages - 1) * itemsPerPage;
  const endIndex = startIndex + itemsPerPage;
  showCards(startIndex, endIndex);
});

paginador.appendChild(nextBtn);

const txtBuscar2 = document.getElementById("txtBuscar2");

pageButtons.forEach(function (a) {
  a.addEventListener('click', function () {
    const pageNumber = Number(a.textContent);
    updateActivePage(pageNumber);
    const startIndex = (pageNumber - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    showCards(startIndex, endIndex);
    if (txtBuscar2) txtBuscar2.value = "";
    document.querySelector('#noResults').style.display = 'none';
  });
});

if (txtBuscar2) {
  txtBuscar2.addEventListener('click', function () {
    updateActivePage(1);
    pageButtons[0].click();
  });
}