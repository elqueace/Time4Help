"use strict";

var autocomplete, places;

function init() {
    autocomplete = new google.maps.places.Autocomplete(document.getElementsByClassName('main-search-adress')[0]);
}


// function onPlaceChanged() {
//     var place = autocomplete.getPlace();
//     if (place.geometry) {
//         map.panTo(place.geometry.location);
//         map.setZoom(15);
//         search();
//     } else {
//         document.getElementById('autocomplete').placeholder = 'Enter a city';
//     }
// }
init();
