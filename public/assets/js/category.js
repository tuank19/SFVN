let uuid =''
$('#editCatModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget)
    const recipient = button.data('whatever')
    const name = button.data('name')
    uuid = button.data('uuid')
    const parent = button.data('parent')
    const modal = $(this)
    modal.find('.modal-title').text(recipient)
    $('#uuid').val(uuid);
    $('#nameEdit').val(name);
    updateSlug('nameEdit','slugEdit');
    var isParentEditCheckbox = document.getElementById("isParentEdit");
    var selectElement = document.getElementById("parentIDEdit");
    const parentCategorySelect = document.getElementById('parentCategorySelectEdit');
    if(!parent) {
        isParentEditCheckbox.checked = true;
        parentCategorySelect.style.display = 'none';
    } else {
        isParentEditCheckbox.checked = false;
        parentCategorySelect.style.display = 'block';
        for (var i = 0; i < selectElement.options.length; i++) {
            var option = selectElement.options[i];
            if (option.value == parent) {
                option.selected = true;
                break;
            }
        }
    }
})

$('#createCatModal').on('hidden.bs.modal', function (event) {
    clearErrors()
})

$('#createCatForm').submit(function(e) {
    e.preventDefault();
    const url =$(this).attr('action')
    submitFormById('createCatForm', url, function(response) {
        // addNewRowCat(response.category)
        // closeModal('createCatModal');
        clearFormById('createCatForm');
        location.reload();
    }, function(xhr, status, error) {
        if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            printErrorMsg(errors)
        } else {
            console.error(xhr.responseText);
        }
    });
});

$('#editCatForm').submit(function(e) {
    e.preventDefault();
    const url =`/category/edit-${uuid}`
    submitFormById('editCatForm', url, function(response) {
        clearFormById('editCatForm');
        location.reload();
    }, function(xhr, status, error) {
        if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            printErrorMsg(errors)
        } else {
            console.error(xhr.responseText);
        }
    });
});

function showParent(e, parent) {
    const parentCategorySelect = document.getElementById(parent);
    if(e.checked) {
        parentCategorySelect.style.display = 'none';
        $('#parentIDEdit').val('')
    }else {
        parentCategorySelect.style.display = 'block';
    }
}

function deleteCat(uuid) {
    const url = '/category/delete-' + uuid
    deleteItem(url);
}
