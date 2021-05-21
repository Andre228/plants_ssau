<template>
    <div class="row position-relative">
        <div class="col-md-12 mb-md-0 p-md-4">
            <h5>
                Федеральное государственное автономное образовательное учреждение высшего образования
                «Самарский национальный исследовательский университет имени академика С.П. Королева»
                (Самарский университет)
            </h5>

            <div class="row mt-5">
                <div class="col-md-7">
                    <span class="font-weight-bold">Адрес: ул. Московское шоссе, д. 34, г. Самара, 443086</span>
                    <ul>
                        <li>Телефон (приемная ректора): (846) 335-18-26</li>
                        <li>Факс: (846) 335-18-36</li>
                    </ul>

                    <ul class="mt-3">
                        <li>Телефон (приемная комиссия): 8 (800) 550-34-35, 8 (846) 267-48-67</li>
                        <li>Сайт: <a href="https://ssau.ru/priem" target="_blank">www.ssau.ru/priem</a></li>
                        <li>E-mail: <a href="mailto:priem@ssau.ru" target="_blank">priem@ssau.ru</a></li>
                    </ul>

                    <ul class="mt-3">
                        <li>Телефон (канцелярия): (846) 267-43-70</li>
                        <li>Факс: (846) 267-43-70</li>
                        <li>E-mail: <a href="mailto:ssau@ssau.ru" target="_blank">ssau@ssau.ru</a></li>
                    </ul>
                </div>
                <div class="col-md-5">
                    <div id="mapContainer"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {MapService} from "../../admin/posts/services/map-service";

    export default {
        name: "ContactComponent",
        data() {
            return {
                mapService: new MapService(),
                lat: 53.211926279573206,
                lng: 50.177388640603006,
            }
        },

        mounted() {
            this.map = this.mapService.buildMap('mapContainer', null, true, this.lat, this.lng, 16);
        }
    }
</script>

<style scoped>

    @import "~leaflet/dist/leaflet.css";
    #mapContainer {
        width: 100%;
        height: 50vh;
    }

    a {
        text-decoration: none;
        color: #0d6efd !important;
        cursor: pointer;
    }

    a:hover {
        text-decoration: underline !important;
        color: #0056b3 !important;
    }

</style>