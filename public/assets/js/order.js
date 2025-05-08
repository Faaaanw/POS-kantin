document.addEventListener("DOMContentLoaded", function () {
    const container = document.getElementById("product-selection-container");
    const wrapper = document.getElementById("products-wrapper");

    container.addEventListener("click", function (e) {
        const item = e.target.closest(".product-item");
        if (!item) return;

        const productId = item.getAttribute("data-id");
        const productName = item.getAttribute("data-name");
        const productPrice = item.getAttribute("data-price");

        const newRow = document.createElement("div");
        newRow.classList.add("product-row", "d-flex", "align-items-center", "mb-2");

        newRow.innerHTML = `
            <input type="hidden" name="products[]" value="${productId}">
            <div class="product-info-box d-flex justify-content-between align-items-center px-3 py-2 rounded me-2">
                <div class="product-name-price">
                    <div class="product-name">${productName}</div>
                    <div class="product-price">Rp ${parseInt(productPrice).toLocaleString("id-ID")}</div>
                </div>
            </div>

            <input type="number" name="quantities[]" class="form-control form-control-sm text-center qty-input me-2" style="width: 50px;" min="1" value="1" required>

            <button type="button" class="btn btn-sm btn-danger rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                <i class="fas fa-trash-alt text-white"></i>
            </button>
        `;

        // Tambahkan ke wrapper
        wrapper.appendChild(newRow);

        // Event listener jumlah
        const qtyInput = newRow.querySelector('input[type="number"]');
        qtyInput.addEventListener("input", calculateTotal);

        // Event listener hapus
        const removeBtn = newRow.querySelector("button");
        removeBtn.addEventListener("click", function () {
            newRow.remove();
            calculateTotal();
        });

        // Hitung total
        calculateTotal();

        // Tutup modal
        const modal = bootstrap.Modal.getInstance(document.getElementById("productSelectionModal"));
        modal.hide();
    });
});

function removeRow(button) {
    button.closest(".product-row").remove();
    calculateTotal(); // Ini akan urus total dan empty-message sekaligus
}


function calculateTotal() {
    const wrapper = document.getElementById("products-wrapper");
    const emptyMessage = document.getElementById("empty-message");
    const rows = wrapper.querySelectorAll(".product-row");

    let total = 0;

    rows.forEach((row) => {
        const quantityInput = row.querySelector('input[type="number"]');
        const priceText = row.querySelector(".product-price")?.innerText;
        let price = 0;

        if (priceText) {
            const match = priceText.match(/Rp\s?([\d.]+)/);
            if (match) {
                price = parseInt(match[1].replace(/\./g, "")) || 0;
            }
        }

        const quantity = parseInt(quantityInput.value) || 0;
        total += price * quantity;
    });

    // Update total
    const totalAmountElement = document.getElementById("total_amount_sidebar");
    if (totalAmountElement) {
        totalAmountElement.value = total.toLocaleString("id-ID");
    }

    // Tampilkan/ sembunyikan pesan kosong
    if (rows.length === 0) {
        emptyMessage.style.display = "block";
    } else {
        emptyMessage.style.display = "none";
    }
}

function toggleOrderSidebar() {
    const sidebar = document.getElementById("order-sidebar");
    const menuContainer = document.querySelector(".menu-container");
    const orderButton = document.getElementById("orderButton");
    const categoryButton = document.getElementById("category-list");

    const isHidden =
        sidebar.style.display === "none" || sidebar.style.display === "";

    if (isHidden) {
        sidebar.style.display = "block";
        menuContainer.classList.add("shifted");
        orderButton.style.display = "none";
    } else {
        sidebar.style.display = "none";
        menuContainer.classList.remove("shifted");
        orderButton.style.display = "inline-block";
    }
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

    // Validasi stok
    let stockValid = true;
    let outOfStockMessage = "";

    document.querySelectorAll(".product-row").forEach((row) => {
        const select = row.querySelector("select");
        const quantityInput = row.querySelector('input[type="number"]');

        const selectedOption = select.selectedOptions[0];
        const stock = parseInt(selectedOption.getAttribute("data-stock")) || 0;
        const qty = parseInt(quantityInput.value) || 0;

        if (qty > stock) {
            stockValid = false;
            outOfStockMessage += `- ${selectedOption.text} hanya tersedia ${stock}\n`;
        }
    });

    if (!stockValid) {
        alert("Produk habis atau stok tidak cukup:\n" + outOfStockMessage);
        return;
    }

    // Lanjut submit form jika valid
    const form = document.createElement("form");
    form.method = "POST";
    form.action = "{{ route('transactions.store') }}";

    const csrf = document.createElement("input");
    csrf.type = "hidden";
    csrf.name = "_token";
    csrf.value = "{{ csrf_token() }}";
    form.appendChild(csrf);

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

    const paidInput = document.createElement("input");
    paidInput.type = "hidden";
    paidInput.name = "paid_amount";
    paidInput.value = paidAmount;
    form.appendChild(paidInput);

    document.body.appendChild(form);
    form.submit();
}

// Calculate total price

// Attach event listeners on page load
document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("backButton")
        .addEventListener("click", function () {
            toggleOrderSidebar();
        });

    document.querySelectorAll(".product-row").forEach((row) => {
        const select = row.querySelector("select");
        const qtyInput = row.querySelector('input[type="number"]');

        select.addEventListener("change", calculateTotal);
        qtyInput.addEventListener("input", calculateTotal);
    });

    document
        .getElementById("products-wrapper")
        .addEventListener("input", function (event) {
            if (event.target.matches('select, input[type="number"]')) {
                calculateTotal();
            }
        });
    calculateTotal(); // Hitung total awal
});
function konfirmasiHapus(button) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Produk ini akan dihapus secara permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit form terdekat
            button.closest("form").submit();
        }
    });
}
