// Toggle the order sidebar visibility
function toggleOrderSidebar() {
    const sidebar = document.getElementById("order-sidebar");
    const menuContainer = document.querySelector(".menu-container");

    // Toggle sidebar visibility
    if (sidebar.style.display === "none" || sidebar.style.display === "") {
        sidebar.style.display = "block";
        menuContainer.classList.add("shifted");
    } else {
        sidebar.style.display = "none";
        menuContainer.classList.remove("shifted");
    }
}

// Add product row dynamically
// Add product row dynamically
function addRow() {
    const wrapper = document.getElementById("products-wrapper");

    // Buat row baru manual
    const newRow = document.createElement("div");
    newRow.classList.add("product-row", "product-list-wrapper");

    // CLONE select
    const originalSelect = document.querySelector(".product-row select");
    const clonedSelect = originalSelect.cloneNode(true);
    clonedSelect.selectedIndex = 0; // Reset pilihan ke opsi pertama (atau kosong)
    clonedSelect.name = "products[]";
    clonedSelect.classList.add("item-list");
    clonedSelect.required = true;

    // Isi HTML-nya
    newRow.innerHTML = `
        <div class="product-list"></div>
        <div class="quantity">
            <input type="number" name="quantities[]" class="product-quantity" min="1" value="1" required>
        </div>
        <div class="remove-btn-head">
            <button type="button" class="btn btn-danger" onclick="removeRow(this)">🗑️</button>
        </div>
    `;

    // Append cloned select ke div product-list
    newRow.querySelector(".product-list").appendChild(clonedSelect);

    wrapper.appendChild(newRow);

    // Pasang event baru
    const select = newRow.querySelector("select");
    const qtyInput = newRow.querySelector('input[type="number"]');

    select.addEventListener("change", calculateTotal);
    qtyInput.addEventListener("input", calculateTotal);

    // Hitung total setelah menambahkan row
    calculateTotal(); // langsung hitung total setelah menambah row
}


// Handle order submission
function submitOrder() {
    const paidAmount = document.getElementById("paid_amount_sidebar").value;
    const totalAmount = parseInt(
        document.getElementById("total_amount_sidebar").value.replace(/\D/g, "")
    );

    if (!paidAmount || paidAmount <= 0) {
        alert("Isi jumlah bayar dengan benar.");
        return;
    }

    if (parseInt(paidAmount) < totalAmount) {
        alert("Jumlah bayar kurang dari total harga!");
        return;
    }

    // Proceed with form submission
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "{{ route('transactions.store') }}";

    // CSRF Token
    const csrf = document.createElement("input");
    csrf.type = "hidden";
    csrf.name = "_token";
    csrf.value = "{{ csrf_token() }}";
    form.appendChild(csrf);

    // Products and quantities
    document.querySelectorAll(".product-row").forEach((row) => {
        const productInput = row.querySelector("select").value;
        const qtyInput = row.querySelector('input[type="number"]').value;

        const productField = document.createElement("input");
        productField.type = "hidden";
        productField.name = "products[]";
        productField.value = productInput;
        form.appendChild(productField);

        const qtyField = document.createElement("input");
        qtyField.type = "hidden";
        qtyField.name = "quantities[]";
        qtyField.value = qtyInput;
        form.appendChild(qtyField);
    });

    // Paid Amount
    const paidInput = document.createElement("input");
    paidInput.type = "hidden";
    paidInput.name = "paid_amount";
    paidInput.value = paidAmount;
    form.appendChild(paidInput);

    document.body.appendChild(form);
    form.submit();
}

// Calculate total price
function calculateTotal() {
    let total = 0;

    document.querySelectorAll("#products-wrapper .product-row").forEach((row) => {
        const select = row.querySelector("select");
        const quantityInput = row.querySelector('input[type="number"]');

        // Pastikan select valid dan punya opsi
        if (select && select.selectedOptions.length > 0) {
            const price =
                parseFloat(select.selectedOptions[0].getAttribute("data-price")) || 0;
            const quantity = parseInt(quantityInput.value) || 0;

            total += price * quantity;
        }
    });

    // Update total pada sidebar
    const totalAmountElement = document.getElementById("total_amount_sidebar");
    if (totalAmountElement) {
        totalAmountElement.value = total.toLocaleString("id-ID");
    }
}

// Attach event listeners on page load
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".product-row").forEach((row) => {
        const select = row.querySelector("select");
        const qtyInput = row.querySelector('input[type="number"]');

        select.addEventListener("change", calculateTotal);
        qtyInput.addEventListener("input", calculateTotal);
    });
    

    document.getElementById('products-wrapper').addEventListener('input', function(event) {
        if (event.target.matches('select, input[type="number"]')) {
            calculateTotal();
        }
    });
    calculateTotal(); // Hitung total awal
});
