import {MapboxSearchBox} from "@mapbox/search-js-web";

document.onreadystatechange = () => {
    if (document.readyState === "interactive") {

        const addrField = document.getElementById('Address');
        const countryField = document.getElementById('Country');
        const cityField = document.getElementById('City');
        const latField = document.getElementById('Latitude');
        const lonField = document.getElementById('Longitude');

        const search = document.querySelectorAll('mapbox-address-autofill')[0];
        if (document.OSMConfig) {
            search.options = document.OSMConfig;
        }

        search.options.

        search.addEventListener('retrieve', (event) => {
            let properties = event.detail.features[0].properties;
            let geometry = event.detail.features[0].geometry;
            console.log(geometry);
            addrField.value = properties.full_address
            countryField.value = properties.country;
            cityField.value = properties.place_name;
            latField.value = geometry.coordinates[1];
            lonField.value = geometry.coordinates[0];
        });
    }
}

