import L from 'leaflet';
import { LMap, LTileLayer, LMarker } from 'vue2-leaflet';

export class MapService {

    constructor() {
        this.map = {};
        this.mapLayer = null;
        this.marker = null;
        this.store = null;
    }

    buildMap(containerName, store) {
        let lat;
        let lng;
        if (store) {
          this.store = store;
          lat = this.store.getters.getPostObject.coordinates.lat;
          lng = this.store.getters.getPostObject.coordinates.lng;
        }
        if (!lat || !lng) {
            lat = 51.959;
            lng = -8.623;
        }
        this.map = L.map(containerName).setView([lat, lng], 12);
        this.mapLayer = L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
            attribution:
                '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        });
        this.map.addLayer(this.mapLayer);

        let theMarker = L.marker([lat, lng], { draggable: true});
        this.marker = theMarker;
        this.map.addLayer(this.marker);

        this.map.addEventListener('click', (e) => {
            let lat = e.latlng.lat;
            let lon = e.latlng.lng;

            if (this.marker != undefined) {
                this.map.removeLayer(this.marker);
            }

            this.marker = L.marker([lat,lon],{
                draggable: true
            });
            this.map.addLayer(this.marker);

            this.bindEvents(this.marker);
            this.setCoordinates(this.marker);

        });
        this.bindEvents(this.marker);
        return this.map
    }


    bindEvents(marker) {
        this.bindPopupListener(marker);
        marker.addEventListener('mouseover', (e) => {
            this.bindPopupListener(marker);
        });

        marker.addEventListener('mouseout', (e) => {
            this.unbindPopupListener(marker);
        });

        marker.addEventListener('dragend', (e) => {
            this.setCoordinates(marker);
        });
    }

    bindPopupListener(marker) {
        let title = this.store.getters.getPostObject.coordinates.title;
        marker.bindPopup(title).openPopup();
    }

    unbindPopupListener(marker) {
        if (marker.isPopupOpen()) marker.closePopup();
    }

    setCoordinates(marker) {
        this.store.state.post.postObject.coordinates = {
            lat: marker.getLatLng().lat,
            lng: marker.getLatLng().lng,
            title: marker.getPopup().getContent()
        };
    }

    getMarker() {
        return this.marker;
    }

}