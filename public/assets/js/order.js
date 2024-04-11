function selectCustomer() {
    $("#customer").val();
    const value = $("#customer").val();
    if (value === "add-new") {
        $("#addCustomerModal").modal("show");
    } else {
        $.ajax({
            url: `/customer/get-customer-${value}`,
            type: "GET",
            success: function (response) {
                renderCustomer(
                    response.customer.name,
                    response.city.name,
                    response.district.name,
                    response.ward.name,
                    response.customer.phone
                );
            },
            error: function (xhr, status, error) {
                console.error("Lỗi khi gửi yêu cầu AJAX:", error);
            },
        });
    }
}

$("#createCustomerForm").submit(function (e) {
    e.preventDefault();
    const url = $(this).attr("action");
    submitFormById(
        "createCustomerForm",
        url,
        function (response) {
            $("#addCustomerModal").modal("hide");
            addOptionToSelect(
                "customer",
                response.customer.uuid,
                response.customer.name
            );
            renderCustomer(
                response.customer.name,
                response.city.name,
                response.district.name,
                response.ward.name,
                response.customer.phone
            );
        },
        function (xhr, status, error) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                printErrorMsg(errors);
            } else {
                console.error(xhr.responseText);
            }
        }
    );
});

function renderCustomer(name, city, district, ward, phone) {
    $("#billingAddress").show();
    $("#customerName").text(name);
    $("#cityBilling").text(city);
    $("#districtBilling").text(district);
    $("#wardBilling").text(ward);
    $("#phoneBilling").text(phone);
}

function addOptionToSelect(selectId, value, text) {
    var selectElement = document.getElementById(selectId);
    var option = document.createElement("option");
    option.value = value;
    option.text = text;
    option.selected = true;
    selectElement.appendChild(option);
}
let productsByCat = [];
let productData = {};
let subTotal = 0;
const discount = 0;
let sum =0;
function selectCategory(e) {
    const catUUID = e.value;
    const url = `/product/get-product-${catUUID}`;
    getData(
        url,
        function (response) {
            productsByCat = productsByCat.concat(response.products);
            const productDom = document.getElementById('product');
            productDom.innerHTML = '';
            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = '-- Choose product --';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            productDom.appendChild(defaultOption);

            response.products.forEach(function(product) {
                const option = document.createElement('option');
                option.value = product.uuid;
                option.textContent = product.name;
                productDom.appendChild(option);
            });
        },
        function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    );
}

function addProduct() {
    const productUUID = document.getElementById('product').value;
    const quantity = parseInt(document.getElementById('quantity').value);
    const foundItem = productsByCat.find(element => element.uuid === productUUID);

    if (productUUID in productData) {
        productData[productUUID] += quantity;
        foundItem.quantity += quantity;
    } else {
        productData[productUUID] = quantity;
        foundItem.quantity = quantity;
    }
    displayProduct(foundItem);
    console.log(productData)
    document.getElementById('product').value = '';
}

function displayProduct(foundItem) {

    var existingRow = document.getElementById('product_' + foundItem.uuid);
    if (existingRow) {
        existingRow.cells[5].textContent = productData[foundItem.uuid];
        existingRow.cells[6].textContent = productData[foundItem.uuid] * foundItem.price;

    } else {
        var table = document.getElementById('tableProductItem');
        var newRow = table.insertRow(-1);
        newRow.id = 'product_' + foundItem.uuid;

        var numberCell = newRow.insertCell(0); // Ô cho số thứ tự
        numberCell.textContent = table.rows.length - 1;

        var categoryCell = newRow.insertCell(1); // Ô cho loại sản phẩm
        categoryCell.textContent = foundItem.category.name;
        categoryCell.classList.add("text-center");

        var nameCell = newRow.insertCell(2); // Ô cho tên sản phẩm
        nameCell.textContent = foundItem.name;

        var unitCell = newRow.insertCell(3); // Ô cho đơn vị
        unitCell.textContent = foundItem.unit.attr_value;
        unitCell.classList.add("text-center");

        var priceCell = newRow.insertCell(4); // Ô cho giá
        priceCell.textContent = foundItem.price;
        priceCell.classList.add("text-center");

        var quantityCell = newRow.insertCell(5); // Ô cho số lượng
        quantityCell.textContent = productData[foundItem.uuid];
        quantityCell.classList.add("text-center");

        var totalCell = newRow.insertCell(6); // Ô cho thành tiền
        totalCell.textContent = productData[foundItem.uuid] * foundItem.price;
        totalCell.classList.add("text-center");

        var actionCell = newRow.insertCell(7); // Ô cho thao tác
        actionCell.classList.add("text-right", "d-flex", "justify-content-between");
        var increaseBtn = document.createElement("button");
        increaseBtn.textContent = "+";
        increaseBtn.classList.add("btn", "btn-light", "btn-sm", "waves-effect", "waves-light");
        increaseBtn.onclick = function() {
            productData[foundItem.uuid]++;
            quantityCell.textContent = productData[foundItem.uuid];
            totalCell.textContent = productData[foundItem.uuid] * foundItem.price;
            updateProductCounter()
        };
        actionCell.appendChild(increaseBtn);
        var decreaseBtn = document.createElement("button");
        decreaseBtn.textContent = "-";
        decreaseBtn.classList.add("btn", "btn-light", "btn-sm", "waves-effect", "waves-light");
        decreaseBtn.onclick = function() {
            if (productData[foundItem.uuid] > 1) {
                productData[foundItem.uuid]--;
                quantityCell.textContent = productData[foundItem.uuid];
                totalCell.textContent = productData[foundItem.uuid] * foundItem.price;
                updateProductCounter()
            }
        };
        actionCell.appendChild(decreaseBtn);
        var deleteBtn = document.createElement("button");
        deleteBtn.textContent = "Delete";
        deleteBtn.classList.add("btn", "btn-success", "btn-sm", "waves-effect", "waves-light");
        deleteBtn.onclick = function() {
            newRow.remove();
            delete productData[foundItem.uuid];
            updateProductCounter();
        };
        actionCell.appendChild(deleteBtn);
    }
    updateProductCounter()
}

function updateProductCounter() {
    var table = document.getElementById('tableProductItem');
    var rows = table.getElementsByTagName('tr');
    subTotal = 0;
    for (var i = 1; i < rows.length; i++) {
        var productId = rows[i].id.replace('product_', '');
        var quantityCell = rows[i].cells[5];
        quantityCell.textContent = productData[productId];
        var totalCell = rows[i].cells[6];
        var foundItem = productsByCat.find(element => element.uuid === productId);
        if(foundItem) {
            totalCell.textContent = productData[productId] * foundItem.price;
            subTotal += productData[productId] * foundItem.price;
        }
    }
    document.getElementById('subtotal').textContent = subTotal.toFixed(2);
    sum = subTotal - discount;
    document.getElementById('sum').textContent = sum.toFixed(2);
}








