import L from 'leaflet';
import { LMap, LTileLayer, LMarker } from 'vue2-leaflet';

export class MapService {

    markerLat;
    markerLng;

    constructor() {
        this.map = {};
        this.mapLayer = null;
        this.marker = null;
        this.store = null;
        this.readonly = false;
    }

    buildMap(containerName, store, readonly = false, latInit = null, lngInit = null) {
        this.readonly = readonly;
        this.markerLat = latInit ? latInit : null;
        this.markerLng = lngInit ? lngInit : null;
        if (store) {
          this.store = store;
            this.markerLat = this.store.getters.getPostObject.coordinates.lat;
            this.markerLng = this.store.getters.getPostObject.coordinates.lng;
        }
        if (!this.markerLat || !this.markerLng) {
            this.markerLat = 51.959;
            this.markerLng = -8.623;
        }
        this.map = L.map(containerName).setView([this.markerLat, this.markerLng], 12);
        this.mapLayer = L.tileLayer("http://{s}.tile.osm.org/{z}/{x}/{y}.png", {
            attribution:
                '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        });
        this.map.addLayer(this.mapLayer);

        let theMarker = L.marker([this.markerLat, this.markerLng], { draggable: true});
        this.marker = theMarker;
        this.map.addLayer(this.marker);

        if (!this.readonly)
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

        if (!this.readonly) {
            marker.addEventListener('dragend', (e) => {
                this.setCoordinates(marker);
            });
        } else {
            marker.dragging.disable();
        }

    }

    bindPopupListener(marker) {
        let title = this.store.getters.getPostObject.coordinates.title;
        if (title)
        marker.bindPopup(title).openPopup();
    }

    unbindPopupListener(marker) {
        if (marker.isPopupOpen()) marker.closePopup();
    }

    setCoordinates(marker) {
        this.markerLat = marker.getLatLng().lat;
        this.markerLng = marker.getLatLng().lng;
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