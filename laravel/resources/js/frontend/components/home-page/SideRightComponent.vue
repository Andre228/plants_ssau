<template>
    <div>
        <div>
            <h4 class="pb-4 mb-4 border-bottom">
                {{ title }}
            </h4>

            <article v-for="item in newsInfo" class="blog-post mt-2">
                <div style="word-break: break-word;">
                    <h5 class="blog-post-title" style="font-weight: bold">{{ item.title }}</h5>
                </div>
                <p class="blog-post-meta">Последнее изменение: {{ item.updated_at }}, написал(а): <span style="text-decoration: underline">{{ item.user.name }}</span>
                    <span v-if="isFavoriteNews(item) && userInfo" @click="deleteFromReadingList($event, item.id)" title="Убрать из списка для чтения" class="interactive"><i class="fas fa-bookmark"></i></span>
                    <span v-if="!isFavoriteNews(item) && userInfo" @click="toReadingList($event, item.id)" title="Добавить в список для чтения" class="interactive"><i class="far fa-bookmark"></i></span>
                </p>
                <hr>
               <p>{{ item.content_raw }}</p>
                <div class="d-flex justify-content-end"><a :href="'/news/' + item.id">Подробнее</a></div>
            </article>

            <nav v-if="hasNext" class="blog-pagination" aria-label="Pagination">
                <button @click="getMore($event)" class="btn btn-outline-light w-100 btn-fetch-more">Загрузить ещё</button>
            </nav>

        </div>
    </div>
</template>

<script>
    import {LoaderService} from "../../services/loader-service";
    import {RequestService} from "../../request-services/request-service";
    import {NotifyService} from "../../services/notify-service";

    export default {
        name: "SideRightComponent",
        props: ['news', 'usernews'],
        data() {
            return {
                title: 'Виртуальный гербарий Самарского университета',
                newsInfo: this.news.news,
                userInfo: this.usernews,
                page: 1,
                hasNext: false,
                rest: new RequestService(),
                loader: new LoaderService(),
                notify: new NotifyService(),
                response: {}
            }
        },

        mounted() {
            this.hasNext = this.news.hasNext;

            // GO HERE => https://github.com/mrdoob/three.js/blob/master/examples/canvas_particles_waves.html

            const SEPARATION = 100, AMOUNTX = 50, AMOUNTY = 50;
            let container, stats;
            let camera, scene, renderer;
            let particles, particle, count = 0;
            let mouseX = 0, mouseY = 0;
            let windowHalfX = window.innerWidth / 2;
            let windowHalfY = window.innerHeight / 2;

            function init() {
                container = document.createElement( 'div' );
                document.body.appendChild(container);
                camera = new THREE.PerspectiveCamera(50, window.innerWidth / window.innerHeight, 1, 10000 );
                camera.position.z = 1000; // Good var to change
                scene = new THREE.Scene();
                particles = new Array();
                var PI2 = Math.PI * 2;
                var geometry = new THREE.Geometry();
                var material = new THREE.SpriteCanvasMaterial({
                    color: 0xffffff,
                    program: function ( context ) {
                        context.beginPath();
                        context.arc( 0, 0, 0.4, 0, PI2, true );
                        context.fill();
                    }
                });


                var i = 0;
                for ( var ix = 0; ix < AMOUNTX; ix ++ ) {
                    for ( var iy = 0; iy < AMOUNTY; iy ++ ) {
                        particle = particles[ i ++ ] = new THREE.Sprite( material );
                        particle.position.x = ix * SEPARATION - ( ( AMOUNTX * SEPARATION ) / 2 );
                        particle.position.z = iy * SEPARATION - ( ( AMOUNTY * SEPARATION ) / 2 );
                        scene.add(particle);

                        if (i > 0) {
                            geometry.vertices.push( particle.position );
                        }
                    }
                }

                // var line = new THREE.Line(geometry, new THREE.LineBasicMaterial({
                //   color: 0xffffff,
                //   opacity: 0.5,
                //   linewidth: 4
                // }));
                // scene.add( line );

                renderer = new THREE.CanvasRenderer();
                renderer.setPixelRatio(window.devicePixelRatio);
                renderer.setSize(window.innerWidth, window.innerHeight);
                container.appendChild(renderer.domElement);
                stats = new Stats();
                container.appendChild( stats.dom );
                document.addEventListener( 'mousemove', onDocumentMouseMove, false );
                document.addEventListener( 'touchstart', onDocumentTouchStart, false );
                document.addEventListener( 'touchmove', onDocumentTouchMove, false );
                //
                window.addEventListener( 'resize', onWindowResize, false );
            }

            function onWindowResize() {
                windowHalfX = window.innerWidth / 2;
                windowHalfY = window.innerHeight / 2;
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize( window.innerWidth, window.innerHeight );
            }

            function onDocumentMouseMove(event) {
                mouseX = event.clientX - windowHalfX;
                mouseY = event.clientY - windowHalfY;
            }

            function onDocumentTouchStart(event) {
                if (event.touches.length === 1) {
                    event.preventDefault();
                    mouseX = event.touches[ 0 ].pageX - windowHalfX;
                    mouseY = event.touches[ 0 ].pageY - windowHalfY;
                }
            }

            function onDocumentTouchMove( event ) {
                if (event.touches.length === 1) {
                    event.preventDefault();
                    mouseX = event.touches[ 0 ].pageX - windowHalfX;
                    mouseY = event.touches[ 0 ].pageY - windowHalfY;
                }
            }

            function animate() {
                requestAnimationFrame( animate );
                render();
                stats.update();
            }

            function render() {
                renderer.setClearColor( 0x07074e, 1);
                camera.position.x += ( mouseX - camera.position.x ) * .05;
                camera.position.y += ( - mouseY - camera.position.y ) * .05;
                camera.lookAt( scene.position );
                var i = 0;
                for (var ix = 0; ix < AMOUNTX; ix++) {
                    for (var iy = 0; iy < AMOUNTY; iy++) {
                        particle = particles[i++];
                        particle.position.y = (Math.sin((ix + count) * 0.3) * 50) + (Math.sin((iy + count) * 0.5) * 50);
                        particle.scale.x = particle.scale.y = (Math.sin((ix + count) * 0.3) + 1) * 4 + (Math.sin((iy + count) * 0.5) + 1) * 4;
                    }
                }
                renderer.render(scene, camera);
                count += 0.1;
            }

            init();
            animate();
        },

        computed: {

        },

        methods: {
            getMore(event) {
                if (this.hasNext) {
                    this.loader.runLoader();
                    this.page++;
                    const url = `api/news/batch/?page=${this.page}`;
                    this.rest.get(url).then(response => {
                        if (response && response.data.status === 'OK') {
                            const details = JSON.parse(response.data.details);
                            if (response.data.details && details.news) {
                                this.newsInfo = this.newsInfo.concat(details.news);
                            } else {
                                if (response.data.message)
                                this.notify.info(response.data.message);
                            }
                            this.hasNext = details.hasNext;
                        }
                        this.loader.removeLoader();
                    });
                }
            },

            isFavoriteNews(news) {
                if (this.userInfo && this.userInfo.user_reading) {
                    return this.userInfo.user_reading.some(item => item.news_id === news.id);
                } else {
                    return false;
                }
            },

            async toReadingList(event, id) {
                this.loader.runLoader();
                if (this.userInfo) {
                    const url = `/user/favorite/news/${id}`;
                    await this.rest.post(url, null, null).then(response => {
                        if (response.data.status == 'OK') {
                            this.response = {
                                type: 'success',
                                text: response.data.message
                            };
                            if (response.data.details) {
                                this.userInfo = response.data.details;
                            }
                        }
                        if (response.data.status == 'ERROR') {
                            this.response = {
                                type: 'error',
                                text: response.data.message
                            };
                        }
                    })
                        .catch((error) => {
                            this.response = {
                                type: 'error',
                                text: error
                            };
                        });

                    this.afterRequest();
                }
            },

            async deleteFromReadingList(event, id) {
                this.loader.runLoader();
                if (id >= 0) {
                    const url = `/user/favorite/news/delete/${id}`;
                    await this.rest.destroy(url).then(response => {
                        if (response.data.status == 'OK') {
                            this.response = {
                                type: 'success',
                                text: response.data.message
                            };
                            const index = this.userInfo.user_reading.indexOf(this.userInfo.user_reading.find(item => item.news_id === id));
                            this.userInfo.user_reading.splice(index, 1);
                        }
                        if (response.data.status == 'ERROR') {
                            this.response = {
                                type: 'error',
                                text: response.data.message
                            };
                        }
                    })
                        .catch((error) => {
                            this.response = {
                                type: 'error',
                                text: error
                            };
                        });

                    this.afterRequest();
                }
            },

            afterRequest() {
                this.loader.removeLoader();
                this.notify[this.response.type](this.response.text);
                this.response = {};
            }
        }
    }
</script>

<style scoped>

    .btn-fetch-more {
        color: #686868 !important;
    }

    .btn-fetch-more:hover {
        color: black;
    }

    .interactive {
        margin-left: 17%;
        cursor: pointer;
        font-size: 22px;
        color: #c8cbcf;
    }

    i {
        transition: .3s all;
    }

    i:hover {
        color: #0d6efd;
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