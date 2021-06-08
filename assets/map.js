//Icon of the jerseys on the map
var iconPicture = L.icon ({
    iconUrl: '/assets/images/cycling.png',
    iconSize: [25, 25],
    popupAnchor:  [0, -10]
});

 //Card initialization function
 function initMap() {
    var map = L.map('mapId').setView([48.833, 2.333], 10); 

    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        minZoom: 2,
        maxZoom: 13,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoieWFubnJhdWxldCIsImEiOiJja3BjYzV0bTQwMTBqMzBvOGR1ZTBweDcxIn0.5jvTEj-WaEiKxIpSFpEu1Q'
    }).addTo(map);

    //Checkbox for filters by years
    var command = L.control();
    command.onAdd = function (map) {
        var div = L.DomUtil.create('div', 'command');
        div.innerHTML += '<h5>Filtres <br> par collection</h5>';
        div.innerHTML += '<form><input id="checkboxAll" + type="checkbox"/> Tous les maillots</form>';
        div.innerHTML += '<form><input id="checkbox50_60" + type="checkbox"/> Années 50 - 60</form>';
        div.innerHTML += '<form><input id="checkbox70" + type="checkbox"/> Années 70</form>';
        div.innerHTML += '<form><input id="checkbox80" +  type="checkbox"/> Années 80</form>';
        div.innerHTML += '<form><input id="checkbox90" + type="checkbox"/> Années 90</form>';
        return div;
    };
    //Add leaflet legend control
    command.addTo(map);

    //Variable for checkbox filters
    var cyclingShirts = document.getElementById('checkboxAll');
    var cyclingShirts50_60 = document.getElementById('checkbox50_60');
    var cyclingShirts70 = document.getElementById('checkbox70');
    var cyclingShirts80 = document.getElementById('checkbox80');
    var cyclingShirts90 = document.getElementById('checkbox90');

    //Creating layers and clusters with leaflet class
    var layerGroup = L.layerGroup().addTo(map);

    var markersGroup = L.markerClusterGroup({
        //Added options from the github documentation
        disableClusteringAtZoom: 13,
        spiderfyOnMaxZoom: false,
        removeOutsideVisibleBounds: true,
        showCoverageOnHover: false,
        iconCreateFunction: function(cluster) {
            var count = cluster.getChildCount();
            return L.divIcon({
                html: count,
                className: 'cluster',
                iconSize: null
            })
        }
    });

    var markersGroup50_60 = L.markerClusterGroup({
        //Added options from the github documentation
        disableClusteringAtZoom: 13,
        spiderfyOnMaxZoom: false,
        removeOutsideVisibleBounds: true,
        showCoverageOnHover: false,
        iconCreateFunction: function(cluster) {
            var count = cluster.getChildCount();
            return L.divIcon({
                html: count,
                className: 'cluster',
                iconSize: null
            })
        }
    });

    var markersGroup70 = L.markerClusterGroup({
        //Added options from the github documentation
        disableClusteringAtZoom: 13,
        spiderfyOnMaxZoom: false,
        removeOutsideVisibleBounds: true,
        showCoverageOnHover: false,
        iconCreateFunction: function(cluster) {
            var count = cluster.getChildCount();
            return L.divIcon({
                html: count,
                className: 'cluster',
                iconSize: null
            })
        }
    });

    var markersGroup80 = L.markerClusterGroup({
        //Added options from the github documentation
        disableClusteringAtZoom: 13,
        spiderfyOnMaxZoom: false,
        removeOutsideVisibleBounds: true,
        showCoverageOnHover: false,
        iconCreateFunction: function(cluster) {
            var count = cluster.getChildCount();
            return L.divIcon({
                html: count,
                className: 'cluster',
                iconSize: null
            })
        }
    });

    var markersGroup90 = L.markerClusterGroup({
        //Added options from the github documentation
        disableClusteringAtZoom: 13,
        spiderfyOnMaxZoom: false,
        removeOutsideVisibleBounds: true,
        showCoverageOnHover: false,
        iconCreateFunction: function(cluster) {
            var count = cluster.getChildCount();
            return L.divIcon({
                html: count,
                className: 'cluster',
                iconSize: null
            })
        }
    });

    // 'checkboxAll' checked at the begining
    document.getElementById('checkboxAll').checked = true;
    if (cyclingShirts.checked === true) {
        // get the method map form the apiController
        fetch("/api/map")
        .then(response => {
            return response.json()
        })
        .then(result => {
            result.forEach( element => {
                //Get the coordinates from the Promise to add them to the LayerGroup
                layerGroup = new L.marker([element.latitude, element.longitude], {icon: iconPicture})
                    .bindPopup(function (layer) {
                        if (element.years == 'Années 50-60') {
                            return "<span>" + element.name + "</span>" + "<br>" +  "<div class='img-hover-zoom'>" + "<a href=" + "/collection50_60/" + element.id + ">" + "<img class='picturePopup' src=/assets/images/uploads/" + element.pictureFront + ">" + "</a>" + "</div>" +
                            "<br>" + element.city +"<br>" + "<a href=" + "/collection50_60" + ">" + element.years + "</a>"
                        }
                        else if (element.years == 'Années 70') {
                            return "<span>" + element.name + "</span>" + "<br>" +  "<div class='img-hover-zoom'>" + "<a href=" + "/collection70/" + element.id + ">" + "<img class='picturePopup' src=/assets/images/uploads/" + element.pictureFront + ">" + "</a>" + "</div>" +
                            "<br>" + element.city +"<br>" + "<a href=" + "/collection70" + ">" + element.years + "</a>"
                        }
                        else if (element.years == 'Années 80') {
                            return "<span>" + element.name + "</span>" + "<br>" +  "<div class='img-hover-zoom'>" + "<a href=" + "/collection80/" + element.id + ">" + "<img class='picturePopup' src=/assets/images/uploads/" + element.pictureFront + ">" + "</a>" + "</div>" +
                            "<br>" + element.city +"<br>" + "<a href=" + "/collection80" + ">" + element.years + "</a>"
                        }
                        else if (element.years == 'Années 90') {
                            return "<span>" + element.name + "</span>" + "<br>" +  "<div class='img-hover-zoom'>" + "<a href=" + "/collection90/" + element.id + ">" + "<img class='picturePopup' src=/assets/images/uploads/" + element.pictureFront + ">" + "</a>" + "</div>" +
                            "<br>" + element.city +"<br>" + "<a href=" + "/collection90" + ">" + element.years + "</a>"
                        }
                }, {className: 'pop-up-leaflet', direction: 'top'},
                )
                markersGroup.addLayer(layerGroup);
            });
            //Adds all markers to the clusterGroup
            map.addLayer(markersGroup);
        })
        .catch(() => console.error('error'));
    }

    //-----------------------------------------------------------------------------------------------------------

    //Function for add or remove the markers on the map
    function filterAll() {
        //If the checkbox is checked then we add the markers on the map
        if (cyclingShirts.checked === true) {
            document.getElementById('checkbox50_60').checked = false;
            document.getElementById('checkbox70').checked = false;
            document.getElementById('checkbox80').checked = false;
            document.getElementById('checkbox90').checked = false;
            //Asynchronously retrieves data with the server and returns an object of type Promise
            fetch("/api/map")
            .then(response => {
                return response.json()
            })
            .then(result => {
                result.forEach( element => {
                    //Get the coordinates from the Promise to add them to the LayerGroup
                    layerGroup = new L.marker([element.latitude, element.longitude], {icon: iconPicture})
                        .bindPopup(function (layer) {
                            if (element.years == 'Années 50-60') {
                                return "<span>" + element.name + "</span>" + "<br>" +  "<div class='img-hover-zoom'>" + "<a href=" + "/collection50_60/" + element.id + ">" + "<img class='picturePopup' src=/assets/images/uploads/" + element.pictureFront + ">" + "</a>" + "</div>" +
                                "<br>" + element.city +"<br>" + "<a href=" + "/collection50_60" + ">" + element.years + "</a>"
                            }
                            else if (element.years == 'Années 70') {
                                return "<span>" + element.name + "</span>" + "<br>" +  "<div class='img-hover-zoom'>" + "<a href=" + "/collection70/" + element.id + ">" + "<img class='picturePopup' src=/assets/images/uploads/" + element.pictureFront + ">" + "</a>" + "</div>" +
                                "<br>" + element.city +"<br>" + "<a href=" + "/collection70" + ">" + element.years + "</a>"
                            }
                            else if (element.years == 'Années 80') {
                                return "<span>" + element.name + "</span>" + "<br>" +  "<div class='img-hover-zoom'>" + "<a href=" + "/collection80/" + element.id + ">" + "<img class='picturePopup' src=/assets/images/uploads/" + element.pictureFront + ">" + "</a>" + "</div>" +
                                "<br>" + element.city +"<br>" + "<a href=" + "/collection80" + ">" + element.years + "</a>"
                            }
                            else if (element.years == 'Années 90') {
                                return "<span>" + element.name + "</span>" + "<br>" +  "<div class='img-hover-zoom'>" + "<a href=" + "/collection90/" + element.id + ">" + "<img class='picturePopup' src=/assets/images/uploads/" + element.pictureFront + ">" + "</a>" + "</div>" +
                                "<br>" + element.city +"<br>" + "<a href=" + "/collection90" + ">" + element.years + "</a>"
                            }
                    }, {className: 'pop-up-leaflet', direction: 'top'},
                    )
                    markersGroup.addLayer(layerGroup);
                });
                //Adds all markers to the clusterGroup
                map.addLayer(markersGroup);
                //Delete the others clusterGroup
                markersGroup50_60.clearLayers();
                markersGroup70.clearLayers();
                markersGroup80.clearLayers();
                markersGroup90.clearLayers();
            })
            .catch(() => console.error('error'));
        //If the box is not checked, we delete the markers on the map
        } else if (cyclingShirts.checked === false) {
            fetch("/api/map")
            .then(response => { 
                return response.json()
            })
                .then(result => {
                    markersGroup.clearLayers();
                })
                .catch(() => console.error('error'));
        }
    }
    document.getElementById('checkboxAll').addEventListener('click', filterAll, false);

    //-----------------------------------------------------------------------------------------------------------

    function filter50_60() {
        if (cyclingShirts50_60.checked === true) {
             document.getElementById('checkboxAll').checked = false;
            fetch("/api/map")
            .then(response => {
                return response.json()
            })
            .then(result => {
                markersGroup.clearLayers();
            })
            .catch(() => console.error('error'));

            fetch("/api/filter50_60")
            .then(response => { 
                return response.json()
            })
            .then(result => {
                result.forEach( element => {
                    layerGroup = new L.marker([element.latitude, element.longitude], {icon: iconPicture})
                        .bindPopup(function (layer) {
                            return "<span>" + element.name + "</span>" + "<br>" +  "<div class='img-hover-zoom'>" + "<a href=" + "/collection50_60/" + element.id + ">" + "<img class='picturePopup' src=/assets/images/uploads/" + element.pictureFront + ">" + "</a>" + "</div>" +
                            "<br>" + element.city +"<br>" + "<a href=" + "/collection50_60" + ">" + element.years + "</a>"
                    }, {className: 'pop-up-leaflet', direction: 'top'},
                    )
                    markersGroup50_60.addLayer(layerGroup);
                });
                map.addLayer(markersGroup50_60);
            })
            .catch(() => console.error('error'));
        }  else if (cyclingShirts.checked === false) {
            fetch("/api/filter50_60")
            .then(response => { 
                return response.json()
            })
            .then(result => {
                markersGroup50_60.clearLayers();
            })
            .catch(() => console.error('error'));
        }
    }
    document.getElementById('checkbox50_60').addEventListener('click', filter50_60, false);

    //-----------------------------------------------------------------------------------------------------------

    function filter70() {
        if (cyclingShirts70.checked === true) {
            document.getElementById('checkboxAll').checked = false;
            fetch("/api/map")
            .then(response => {
                return response.json()
            })
            .then(result => {
                markersGroup.clearLayers();
            })
            .catch(() => console.error('error'));

            fetch("/api/filter70")
            .then(response => { 
                return response.json()
            })
            .then(result => {
                result.forEach( element => {
                    layerGroup = new L.marker([element.latitude, element.longitude], {icon: iconPicture})
                        .bindPopup(function (layer) {
                            return "<span>" + element.name + "</span>" + "<br>" +  "<div class='img-hover-zoom'>" + "<a href=" + "/collection70/" + element.id + ">" + "<img class='picturePopup' src=/assets/images/uploads/" + element.pictureFront + ">" + "</a>" + "</div>" +
                            "<br>" + element.city +"<br>" + "<a href=" + "/collection70" + ">" + element.years + "</a>"
                    }, {className: 'pop-up-leaflet', direction: 'top'},
                    )
                    markersGroup70.addLayer(layerGroup);
                });
                map.addLayer(markersGroup70);
            })
            .catch(() => console.error('error'));  
        }  else if (cyclingShirts.checked === false) {
            fetch("/api/filter70")
            .then(response => { 
                return response.json()
            })
            .then(result => {
                markersGroup70.clearLayers();
            })
            .catch(() => console.error('error'));
        }
    }
    document.getElementById('checkbox70').addEventListener('click', filter70, false);

    //-----------------------------------------------------------------------------------------------------------

    function filter80() {
        if (cyclingShirts80.checked === true) {
           document.getElementById('checkboxAll').checked = false;
            fetch("/api/map")
            .then(response => {
                return response.json()
            })
            .then(result => {
                markersGroup.clearLayers();
            })
            .catch(() => console.error('error'));

            fetch("/api/filter80")
            .then(response => { 
                return response.json()
            })
            .then(result => {
                result.forEach( element => {
                    layerGroup = new L.marker([element.latitude, element.longitude], {icon: iconPicture})
                        .bindPopup(function (layer) {
                            return "<span>" + element.name + "</span>" + "<br>" +  "<div class='img-hover-zoom'>" + "<a href=" + "/collection80/" + element.id + ">" + "<img class='picturePopup' src=/assets/images/uploads/" + element.pictureFront + ">" + "</a>" + "</div>" +
                            "<br>" + element.city +"<br>" + "<a href=" + "/collection80" + ">" + element.years + "</a>"
                    }, {className: 'pop-up-leaflet', direction: 'top'},
                    )
                    markersGroup80.addLayer(layerGroup);
                });
                map.addLayer(markersGroup80);
            })
            .catch(() => console.error('error'));  
        }  else if (cyclingShirts.checked === false) {
            fetch("/api/filter80")
            .then(response => { 
                return response.json()
            })
            .then(result => {
                markersGroup80.clearLayers();
            })
            .catch(() => console.error('error'));
        }
    }
    document.getElementById('checkbox80').addEventListener('click', filter80, false);

    //-----------------------------------------------------------------------------------------------------------

    function filter90() {
        if (cyclingShirts90.checked === true) {

           document.getElementById('checkboxAll').checked = false;
            fetch("/api/map")
            .then(response => {
                return response.json()
            })
            .then(result => {
                markersGroup.clearLayers();
            })
            .catch(() => console.error('error'));

            fetch("/api/filter90")
            .then(response => { 
                return response.json()
            })
            .then(result => {
                result.forEach( element => {
                    layerGroup = new L.marker([element.latitude, element.longitude], {icon: iconPicture})
                        .bindPopup(function (layer) {
                            return "<span>" + element.name + "</span>" + "<br>" +  "<div class='img-hover-zoom'>" + "<a href=" + "/collection90/" + element.id + ">" + "<img class='picturePopup' src=/assets/images/uploads/" + element.pictureFront + ">" + "</a>" + "</div>" +
                            "<br>" + element.city +"<br>" + "<a href=" + "/collection90" + ">" + element.years + "</a>"
                    }, {className: 'pop-up-leaflet', direction: 'top'},
                    )
                    markersGroup90.addLayer(layerGroup);
                });
                map.addLayer(markersGroup90);
            })
            .catch(() => console.error('error'));  
        }  else if (cyclingShirts.checked === false) {
            fetch("/api/filter90")
            .then(response => { 
                return response.json()
            })
            .then(result => {
                markersGroup90.clearLayers();
            })
            .catch(() => console.error('error'));
        }
    }
    document.getElementById('checkbox90').addEventListener('click', filter90, false);
}

window.onload = function(){
    // Initialization function that runs when the DOM is loaded
    initMap();
};
