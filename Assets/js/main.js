var tbody = document.querySelector("tbody");
var pageUl = document.querySelector(".pagination");
var itemShow = document.querySelector("#itemperpage");
var tr = tbody.querySelectorAll("tr");
var emptyBox = [];
var index = 1;
var itemPerPage = 10;
for (let i = 0; i < tr.length; i++) {
  emptyBox.push(tr[i]);
}

itemShow.onchange = giveTrPerPage;
function giveTrPerPage() {
  itemPerPage = Number(this.value);
  console.log(itemPerPage);
  displayPage(itemPerPage);
  pageGenerator(itemPerPage);
  getpagElement(itemPerPage);
}

function displayPage(limit) {
  tbody.innerHTML = '';
  for (let i = 0; i < limit; i++) {
    tbody.appendChild(emptyBox[i]);
  }
  const pageNum = pageUl.querySelectorAll('.list');
  pageNum.forEach(n => n.remove());
}
displayPage(itemPerPage);

function pageGenerator(getem) {
  const num_of_tr = emptyBox.length;
  if (num_of_tr <= getem) {
    pageUl.style.display = 'none';
  } else {
    pageUl.style.display = 'flex';
    const num_Of_Page = Math.ceil(num_of_tr / getem);
    updatePagination(1, num_Of_Page);
  }
}
pageGenerator(itemPerPage);

function updatePagination(currentPage, num_Of_Page) {
  pageUl.innerHTML = ''; // Clear existing pagination

  const prevLi = document.createElement('li');
  prevLi.className = 'list';
  const prevA = document.createElement('a');
  prevA.href = '#';
  prevA.innerText = 'Previous';
  prevA.setAttribute('data-page', 'prev');
  prevLi.appendChild(prevA);
  pageUl.appendChild(prevLi);

  let startPage = Math.max(currentPage - 2, 1);
  let endPage = Math.min(currentPage + 2, num_Of_Page);

  if (num_Of_Page > 5) {
    if (currentPage > 3) {
      startPage = Math.max(currentPage - 2, 1);
      endPage = Math.min(currentPage + 2, num_Of_Page);
    } else {
      startPage = 1;
      endPage = 5;
    }

    if (currentPage > num_Of_Page - 3) {
      startPage = Math.max(num_Of_Page - 4, 1);
      endPage = num_Of_Page;
    }
  }

  if (currentPage > 4) {
    const firstLi = document.createElement('li');
    firstLi.className = 'list';
    const firstA = document.createElement('a');
    firstA.href = '#';
    firstA.innerText = 1;
    firstA.setAttribute('data-page', 1);
    firstLi.appendChild(firstA);
    pageUl.appendChild(firstLi);

    const dotsLi = document.createElement('li');
    dotsLi.className = 'list';
    const dotsSpan = document.createElement('span');
    dotsSpan.innerText = '...';
    dotsLi.appendChild(dotsSpan);
    pageUl.appendChild(dotsLi);
  }

  for (let i = startPage; i <= endPage; i++) {
    const li = document.createElement('li');
    li.className = 'list';
    if (i === currentPage) {
      li.classList.add('active');
    }
    const a = document.createElement('a');
    a.href = '#';
    a.innerText = i;
    a.setAttribute('data-page', i);
    li.appendChild(a);
    pageUl.appendChild(li);
  }

  if (endPage < num_Of_Page) {
    const dotsLi = document.createElement('li');
    dotsLi.className = 'list';
    const dotsSpan = document.createElement('span');
    dotsSpan.innerText = '...';
    dotsLi.appendChild(dotsSpan);
    pageUl.appendChild(dotsLi);

    const lastLi = document.createElement('li');
    lastLi.className = 'list';
    const lastA = document.createElement('a');
    lastA.href = '#';
    lastA.innerText = num_Of_Page;
    lastA.setAttribute('data-page', num_Of_Page);
    lastLi.appendChild(lastA);
    pageUl.appendChild(lastLi);
  }

  const nextLi = document.createElement('li');
  nextLi.className = 'list';
  const nextA = document.createElement('a');
  nextA.href = '#';
  nextA.innerText = 'Next';
  nextA.setAttribute('data-page', 'next');
  nextLi.appendChild(nextA);
  pageUl.appendChild(nextLi);

  pageRunner(pageUl.querySelectorAll("a"), itemPerPage, num_Of_Page, pageUl.querySelectorAll('.list'));
}

function pageRunner(page, items, num_Of_Page, active) {
  for (let button of page) {
    button.onclick = e => {
      const page_num = e.target.getAttribute('data-page');
      if (page_num === 'prev') {
        index--;
        if (index < 1) {
          index = 1;
        }
      } else if (page_num === 'next') {
        index++;
        if (index > num_Of_Page) {
          index = num_Of_Page;
        }
      } else {
        index = Number(page_num);
      }
      updatePagination(index, num_Of_Page);
      pageMaker(index, items);
    }
  }
}

function getpagElement(val) {
  let num_Of_Page = Math.ceil(emptyBox.length / val);
  updatePagination(1, num_Of_Page);
}

function pageMaker(index, item_per_page) {
  const start = (index - 1) * item_per_page;
  const end = start + item_per_page;
  const current_page = emptyBox.slice(start, end);
  tbody.innerHTML = "";
  for (let j = 0; j < current_page.length; j++) {
    let item = current_page[j];
    tbody.appendChild(item);
  }
}
