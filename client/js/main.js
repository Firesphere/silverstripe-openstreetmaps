import mapboxgl from 'mapbox-gl';
window.locations = window.locations || [[[0, 0]]];
const ACCESS_TOKEN = window.mapboxtoken
mapboxgl.accessToken = ACCESS_TOKEN;
let markers = [];
let boundsLng = [];
let boundsLat = [];
const templ = document.createElement("DIV");
templ.innerHTML = window.popupTemplate;
console.log(window.popupTemplate);
const map = new mapboxgl.Map(window.mapConfig);
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
        rendered.getElementsByClassName('url')[0].setAttribute('href', locations[i][4]);
        rendered.getElementsByClassName('description')[0].innerHTML= locations[i][3] ?? 'This is a location';
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
    if (boundsLat.length > 1) {
        const maxLng = (getMax(boundsLng));
        const minLng = (getMin(boundsLng));
        const maxLat = (getMax(boundsLat));
        const minLat = (getMin(boundsLat));
        // @todo make the padding configurable
        map.fitBounds([[maxLng, maxLat], [minLng, minLat]], {'padding': 50});
    }
}
