const apiUrl = `https://ibnux.github.io/data-indonesia/provinsi.json`;

const selectProvinsi = document.getElementById('provinsi');
const selectKota = document.getElementById('kabupaten_kota');

fetch(apiUrl).then(response => response.json()).then(response => {
    // console.log(response.data);
    var provinces = response;
    var options = '<option>Pilih Provinsi</option>';

    var oldProvinsi = document.getElementById('provinsi_hidden').value;

    provinces.forEach(province => {
        if (province.nama == oldProvinsi) {
            options += `<option data-prov="${province.id}" value="${province.nama}" selected>${province.nama}</option>`;
        } else {
            options += `<option data-prov="${province.id}" value="${province.nama}">${province.nama}</option>`;
        }
    });
    selectProvinsi.innerHTML = options;

    const provId = selectProvinsi.options[selectProvinsi.selectedIndex].dataset.prov;
    if (provId == undefined) {
        return;
    }
    fetch(`https://ibnux.github.io/data-indonesia/kabupaten/${provId}.json`)
    .then(response => response.json())
    .then(response => {
        var cities = response;
        // console.log(response);
        var options = '<option>Pilih Kabupaten/Kota</option>';
    
        const oldKota = document.getElementById('kabupaten_kota_hidden').value;
    
        cities.forEach(city => {
            if (city.nama == oldKota) {
                options += `<option value="${city.nama}" selected>${city.nama}</option>`;
            } else {
                options += `<option value="${city.nama}">${city.nama}</option>`;
            }
        });
        selectKota.innerHTML = options;
    
    }).catch(error => {
        // Handle errors here
        console.error('Error:', error);
    });

}).catch(error => {
    // Handle errors here
    console.error('Error:', error);
});

selectProvinsi.addEventListener('change', (e) => {
    // console.log(e.target.value);
    const provId = e.target.options[e.target.selectedIndex].dataset.prov;
    // console.log(provId);
    fetch(`https://ibnux.github.io/data-indonesia/kabupaten/${provId}.json`)
    .then(response => response.json())
    .then(response => {
        // console.log(response.data);
        var cities = response;
        var options = '<option>Pilih Kabupaten/Kota</option>';
    
        const oldKota = document.getElementById('kabupaten_kota_hidden').value;
    
        cities.forEach(city => {
            if (city.nama == oldKota) {
                options += `<option value="${city.nama}" selected>${city.nama}</option>`;
            } else {
                options += `<option value="${city.nama}">${city.nama}</option>`;
            }
        });
        selectKota.innerHTML = options;
    
    }).catch(error => {
        // Handle errors here
        console.error('Error:', error);
    });
});


//tambahan: disable auto submit form ketika menekan enter
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form');
    form.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
        event.preventDefault();
        return false;
        }
    });
});



// const apiKey = '37cd264d-438c-5003-2225-3a198744';
// const apiUrl = `https://api.goapi.io/regional/provinsi?api_key=${apiKey}`;

// const selectProvinsi = document.getElementById('provinsi');
// const selectKota = document.getElementById('kabupaten_kota');

// fetch(apiUrl).then(response => response.json()).then(response => {
//     // console.log(response.data);
//     var provinces = response.data;
//     var options = '<option>Pilih Provinsi</option>';

//     var oldProvinsi = document.getElementById('provinsi_hidden').value;

//     provinces.forEach(province => {
//         if (province.name == oldProvinsi) {
//             options += `<option data-prov="${province.id}" value="${province.name}" selected>${province.name}</option>`;
//         } else {
//             options += `<option data-prov="${province.id}" value="${province.name}">${province.name}</option>`;
//         }
//     });
//     selectProvinsi.innerHTML = options;

//     const provId = selectProvinsi.options[selectProvinsi.selectedIndex].dataset.prov;
//     if (provId == undefined) {
//         return;
//     }
//     fetch(`https://api.goapi.io/regional/kota?provinsi_id=${provId}&api_key=${apiKey}`)
//     .then(response => response.json())
//     .then(response => {
//         var cities = response.data;
//         console.log(response.data);
//         var options = '<option>Pilih Kabupaten/Kota</option>';
    
//         const oldKota = document.getElementById('kabupaten_kota_hidden').value;
    
//         cities.forEach(city => {
//             if (city.name == oldKota) {
//                 options += `<option value="${city.name}" selected>${city.name}</option>`;
//             } else {
//                 options += `<option value="${city.name}">${city.name}</option>`;
//             }
//         });
//         selectKota.innerHTML = options;
    
//     }).catch(error => {
//         // Handle errors here
//         console.error('Error:', error);
//     });

// }).catch(error => {
//     // Handle errors here
//     console.error('Error:', error);
// });

// selectProvinsi.addEventListener('change', (e) => {
//     // console.log(e.target.value);
//     const provId = e.target.options[e.target.selectedIndex].dataset.prov;
//     // console.log(provId);
//     fetch(`https://api.goapi.io/regional/kota?provinsi_id=${provId}&api_key=${apiKey}`)
//     .then(response => response.json())
//     .then(response => {
//         // console.log(response.data);
//         var cities = response.data;
//         var options = '<option>Pilih Kabupaten/Kota</option>';
    
//         const oldKota = document.getElementById('kabupaten_kota_hidden').value;
    
//         cities.forEach(city => {
//             if (city.name == oldKota) {
//                 options += `<option value="${city.name}" selected>${city.name}</option>`;
//             } else {
//                 options += `<option value="${city.name}">${city.name}</option>`;
//             }
//         });
//         selectKota.innerHTML = options;
    
//     }).catch(error => {
//         // Handle errors here
//         console.error('Error:', error);
//     });
// });


// //tambahan: disable auto submit form ketika menekan enter
// document.addEventListener('DOMContentLoaded', function() {
//     const form = document.getElementById('form');
//     form.addEventListener('keypress', function(event) {
//         if (event.key === 'Enter') {
//         event.preventDefault();
//         return false;
//         }
//     });
// });