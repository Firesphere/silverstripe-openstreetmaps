import mapboxgl from 'mapbox-gl';
window.locations = window.locations || [[[0, 0]]];
const ACCESS_TOKEN = window.mapboxtoken
mapboxgl.accessToken = ACCESS_TOKEN;
let markers = [];
let boundsLng = [];
let boundsLat = [];
const templ = document.createElement("DIV");
// @todo make user-editable
// <div class="card"><div class="card-body">
// <div class="card-text"><h5 style="padding-right: 25px">${properties.name}</h5></div>
templ.innerHTML = "<div class='card'>" +
    "<div class='card-body'>" +
    "<div class='card-text'>" +
    "<h4 class='heading' style='padding-right: 25px'>" +
    "<a href='' target='_blank' class='url'></a>" +
    "</h4>" +
    "<div class='description'></div>" +
    "<div class='text'>" +
    "<b>Address:</b> " +
    "<span class='address'></span>" +
    "</div>" +
    "</div>" +
    "</div>" +
    "</div>";


const map = new mapboxgl.Map({
    container: 'map', // container ID
    style: 'mapbox://styles/mapbox/outdoors-v12', // style URL @todo use config
    center: window.locations[0][0], // starting position [lng, lat]
    maxZoom: 25,
    zoom: 12
});


const getMax = (a) => {
    return Math.max(...a.map(e => Array.isArray(e) ? getMax(e) : e));
}

const getMin = (a) => {
    return Math.min(...a.map(e => Array.isArray(e) ? getMin(e) : e));
}

if (window.locations && window.locations.length) {
    for (let i = 0; i < window.locations.length; i++) {
        let rendered = templ.cloneNode(true);
        rendered.getElementsByClassName('url')[0].innerHTML = locations[i][1];
        rendered.getElementsByClassName('description')[0].innerHTML= locations[i][3] ?? 'This is a location';
        rendered.getElementsByClassName('url')[0].setAttribute('href', locations[i][4]);
        rendered.getElementsByClassName('address')[0].innerHTML = locations[i][2];
        let popup = new mapboxgl.Popup({})
            .setHTML(rendered.innerHTML);
        markers.push(
            new mapboxgl.Marker()
                .setLngLat(locations[i][0])
                .addTo(map)
                .setPopup(popup)
        );
        boundsLng.push(locations[i][0][0]);
        boundsLat.push(locations[i][0][1]);
    }
    const maxLng = (getMax(boundsLng));
    const minLng = (getMin(boundsLng));
    const maxLat = (getMax(boundsLat));
    const minLat = (getMin(boundsLat));
    // @todo make the padding configurable
    map.fitBounds([[maxLng, maxLat], [minLng, minLat]], {'padding': 50});
}
