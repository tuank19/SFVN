// ajax-helper.js

function submitFormById(formId, url, successCallback, errorCallback) {
    const formData = new FormData(document.getElementById(formId));
    $.ajax({
        type: 'POST',
        url: url,
        data: formData,
        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')},
        contentType: false,
        processData: false,
        success: function(response) {
            if (typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}

function showToast(status) {
    const toastLiveExample = document.getElementById("liveToast")
    const toastHeader = document.getElementById("toastHeader")
    if(status === 200) {
        toastLiveExample.classList.add('bg-success');
        toastLiveExample.classList.remove('bg-danger');
        toastHeader.classList.add('bg-success');
        toastHeader.classList.remove('bg-danger');
    }
    else {
        toastLiveExample.classList.add('bg-danger');
        toastHeader.classList.add('bg-danger');
        toastLiveExample.classList.remove('bg-success');
        toastHeader.classList.remove('bg-success');
    }
    const toast = new bootstrap.Toast(toastLiveExample)
    toast.show()
}

function printErrorMsg (errors) {
    clearErrors();
    $.each( errors, function( key, value ) {
        $( '#'+key ).addClass( "is-invalid" );
        $('.'+key+'Error').text(value);
        $('.'+key+'Error').addClass( "is-invalid" );
        $('label[for=' + key + ']').addClass('is-invalid');
    });
}

function clearErrors() {
    document.querySelectorAll('.validate-require').forEach(input => {
        input.classList.remove('is-invalid');
    });
    document.querySelectorAll('.validate-text').forEach(element => {
        element.innerText = ''
    });
}

function updateSlug(roleName,slugName) {
    let name, slug;
    name = document.getElementById(roleName).value;
    slug = name.toLowerCase();
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    slug = slug.replace(/ /gi, "-");
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    document.getElementById(slugName).value = slug;
}

function closeModal(modal) {
    $('#'+modal).modal('hide');
}

function clearFormById(formId) {
    const form = document.getElementById(formId); // Get the form element by ID
    if (form) {
        form.reset(); // Reset the form
    } else {
        console.error('Form with ID ' + formId + ' not found.');
    }
}

function deleteItem(url) {
    $.ajax({
        url: url,
        method:'delete',
        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')},
        contentType: false,
        processData: false,
        success: function(response) {
            location.reload();
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("Error occurred while deleting record.");
        }
    });
}

function getCity() {
    $.ajax({
        url:'/utils/city',
        method:'GET',
        processData:false,
        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')},
        contentType:false,
        success:function(response){
            $('#city').append('<option value="" disabled selected>Chọn tỉnh thành</option>');
            response.cities.forEach(function(city) {
                $('#city').append('<option value="' + city.id + '">' + city.name + '</option>');
            });
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
            } else {
                console.error(xhr.responseText);
            }
        }
    });
}

function selectedCity() {
    const selectedCity = $('#city').val();
    var districtSelect = document.getElementById('district');
    districtSelect.innerHTML = '';
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'Chọn quận/huyện';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    districtSelect.appendChild(defaultOption);
    fetch(`/utils/get-district/${selectedCity}`)
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(function(data) {
            data.districts.forEach(function(district) {
                var option = document.createElement('option');
                option.value = district.id;
                option.textContent = district.name;
                districtSelect.appendChild(option);
            });
        })
        .catch(function(error) {
            console.error('There was a problem with the fetch operation:', error);
        });
}

function selectDistrict() {
    const selectedDistrict = $('#district').val();
    let wardSelect = document.getElementById('ward');
    wardSelect.innerHTML = '';
    const defaultOption = document.createElement('option');
    defaultOption.value = '';
    defaultOption.textContent = 'Chọn phường/xã';
    defaultOption.disabled = true;
    defaultOption.selected = true;
    wardSelect.appendChild(defaultOption);
    fetch(`/utils/get-ward/${selectedDistrict}`)
        .then(function(response) {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(function(data) {
            data.wardList.forEach(function(ward) {
                const option = document.createElement('option');
                option.value = ward.id;
                option.textContent = ward.name;
                wardSelect.appendChild(option);
            });
        })
        .catch(function(error) {
            console.error('There was a problem with the fetch operation:', error);
        });
}


function getData(url, successCallback, errorCallback) {
    $.ajax({
        type: 'GET',
        url: url,
        headers: {'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')},
        contentType: false,
        processData: false,
        success: function(response) {
            if (typeof successCallback === 'function') {
                successCallback(response);
            }
        },
        error: function(xhr, status, error) {
            if (typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}
