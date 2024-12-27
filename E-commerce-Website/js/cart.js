
  // Product list (mock database)
  const products = [
  { id: 2, name: "womens kurta", price: 1000, image: "images/product-2.jpeg" },
    { id: 3, name: "mens DNX pant", price: 800, image: "images/product-3.jpeg" },
    { id: 4, name: "mens ETA shirt", price: 900, image: "images/product-4.jpeg" },
    { id: 5, name: "womens HRX shirt", price: 900, image: "images/product-5.jpeg" },
    { id: 6, name: "mens shirt", price: 700, image: "images/product-6.jpeg" },
    { id: 7, name: "mens shirt", price: 1500, image: "images/product-7.jpeg" },
    { id: 8, name: "mens shirt", price: 2500, image: "images/product-8.jpeg" },
    { id: 9, name: "womens cloths", price: 1800, image: "images/product-9.jpeg" },
    { id: 10, name: "mens shirt", price: 1500, image: "images/product-10.jpeg" },
    { id: 11, name: "mens shirt", price: 900, image: "images/product-11.jpeg" },
    { id: 12, name: "womens cloths", price: 850, image: "images/product-12.jpeg" },
    { id: 13, name: "mens shirt", price: 2000, image: "images/product-13.jpeg" },
    { id: 14, name: "mens shirt", price: 600, image: "images/product-14.jpeg" },
    { id: 15, name: "womens cloths", price: 700,  image: "images/product-15.jpeg" },
    { id: 1, name: "mens shirt", price: 500, image: "images/product-1.jpeg" },
  ];

  // Cart data
  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  // Function to render cart items
  function renderCartItems() {
    const cartItemsContainer = document.getElementById("cart-items");
    const subtotalEl = document.getElementById("subtotal");
    const taxEl = document.getElementById("tax");
    const totalEl = document.getElementById("total");

    cartItemsContainer.innerHTML = ""; // Clear existing items
    let subtotal = 0;

    cart.forEach((item, index) => {
      subtotal += item.price * item.quantity;

      const cartRow = document.createElement("tr");
      cartRow.innerHTML = `
        <td>
          <div class="cart-info">
            <img src="${item.image}" alt="${item.name}">
            <div>
              <p>${item.name}</p>
              <span class="price">₹${item.price}</span><br>
              <a href="#" class="remove-from-cart" data-index="${index}">Remove</a>
            </div>
          </div>
        </td>
        <td><input type="number" class="quantity" value="${item.quantity}" min="1" data-index="${index}" /></td>
        <td class="item-subtotal">₹${item.price * item.quantity}</td>
      `;
      cartItemsContainer.appendChild(cartRow);
    });

    const tax = subtotal * 0.1;
    const total = subtotal + tax;

    subtotalEl.textContent = `₹${subtotal.toFixed(2)}`;
    taxEl.textContent = `₹${tax.toFixed(2)}`;
    totalEl.textContent = `₹${total.toFixed(2)}`;

    attachEventListeners();
  }

  // Add to cart
  function addToCart(productId) {
    const product = products.find((p) => p.id === productId);
    if (!product) return;

    const cartItem = cart.find((item) => item.id === productId);
    if (cartItem) {
      cartItem.quantity++;
    } else {
      cart.push({ ...product, quantity: 1 });
    }

    localStorage.setItem("cart", JSON.stringify(cart));
    renderCartItems();
  }

  // Attach event listeners
  function attachEventListeners() {
    // Remove item
    document.querySelectorAll(".remove-from-cart").forEach((button) => {
      button.addEventListener("click", (e) => {
        e.preventDefault();
        const index = e.target.dataset.index;
        cart.splice(index, 1);
        localStorage.setItem("cart", JSON.stringify(cart));
        renderCartItems();
      });
    });

    // Update quantity
    document.querySelectorAll(".quantity").forEach((input) => {
      input.addEventListener("change", (e) => {
        const index = e.target.dataset.index;
        const newQuantity = parseInt(e.target.value);
        if (newQuantity > 0) {
          cart[index].quantity = newQuantity;
          localStorage.setItem("cart", JSON.stringify(cart));
          renderCartItems();
        }
      });
    });
  }

  // Event listener for "Add to Cart" buttons
  document.querySelectorAll(".add-to-cart").forEach((button) => {
    button.addEventListener("click", () => {
      const productId = parseInt(button.dataset.id);
      addToCart(productId);
    });
  });

  // Initial render
  renderCartItems();
