function searchProduct() {
  //get the value of input text
  let input = document.getElementById("searchbar").value;

  input = input.toLowerCase();

  // getting the classname of the div containing stay products
  let x = document.getElementsByClassName("Products");

  // console.log(x);

  const productsArray = [...x];

  console.log(productsArray);

  // looping through products to to check if shown products matches input
  // if does not match, hide them, otherwise (if matches) show them

  for (i = 0; i < x.length; i++) {
    if (!x[i].innerHTML.toLowerCase().includes(input)) {
      x[i].style.display = "none";
    } else {
      x[i].style.display = "flex";
    }
  }
}

// function filterPrice() {
//   let y = document.getElementsByClassName("price");
//   console.log(y);
//   let x = document.getElementsByClassName("Products");

//   for (let i = 0; i < y.length; i++) {
//     if (y[i].innerHTML === "€50") {
//       x[i].style.display = "flex";
//     } else {
//       x[i].style.display = "none";
//     }
//   }
// }
