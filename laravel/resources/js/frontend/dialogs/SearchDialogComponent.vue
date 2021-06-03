<template>

    <div style="width: 90%">

        <form class="row mt-5" v-bind:style="styleSearchForm">

            <div class="input-group mb-3 mt-3">
                <label class="col-sm-3 col-form-label" style="font-size: 1.2rem">1) Штрихкод</label>
                <select @change="changeParam('barcode')" v-model="barcode.displayMatch" class="form-control form-select" title="Сравнение" style="flex: 0.3 1 auto;">
                    <option value="any" selected> Любое </option>
                    <option value="="> = </option>
                    <option value="!="> Не равно </option>
                    <option value="null"> Пусто </option>
                    <option value="like"> Частичное совпадение </option>
                </select>
                <input :disabled="barcode.displayMatch === 'any'" @change="changeParam('barcode')" v-model="barcode.displayText" type="text" class="form-control">
            </div>

            <div class="input-group mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 1.2rem">2) Определение</label>
                <select @change="changeParam('determination')" v-model="determination.displayMatch" class="form-control form-select" title="Определение" style="flex: 0.3 1 auto;">
                    <option value="any" selected> Любое </option>
                    <option value="="> = </option>
                    <option value="!="> Не равно </option>
                    <option value="null"> Пусто </option>
                    <option value="like"> Частичное совпадение </option>
                </select>
                <input :disabled="determination.displayMatch === 'any'" @change="changeParam('determination')" v-model="determination.displayText" type="text" class="form-control">
            </div>

            <div class="input-group mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 1.2rem">3) Русское название</label>
                <select @change="changeParam('russian_name')" v-model="russian_name.displayMatch" class="form-control form-select" title="Русское название" style="flex: 0.3 1 auto;">
                    <option value="any" selected> Любое </option>
                    <option value="="> = </option>
                    <option value="!="> Не равно </option>
                    <option value="null"> Пусто </option>
                    <option value="like"> Частичное совпадение </option>
                </select>
                <input :disabled="russian_name.displayMatch === 'any'" @change="changeParam('russian_name')" v-model="russian_name.displayText" type="text" class="form-control">
            </div>

            <div class="input-group mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 1.2rem">4) Дата сбора
                    <!--<span :title="collection_date.tooltipText" style="cursor: pointer"><i class="fas fa-question-circle"></i></span>-->
                </label>
                <select @change="changeParam('collection_date')" v-model="collection_date.displayMatch" class="form-control form-select" title="Дата сбора" style="flex: 0.3 1 auto;">
                    <option value="any" selected> Любое </option>
                    <option value="="> = </option>
                    <option value=">"> Позже </option>
                    <option value="<"> Раньше </option>
                </select>
                <input @change="changeParam('collection_date')" :disabled="collection_date.displayMatch === 'any'" v-model="collection_date.displayText" type="datetime-local" class="form-control">
            </div>

            <div class="input-group mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 1.2rem">5) Текст на этикетке</label>
                <select @change="changeParam('label_text')" v-model="label_text.displayMatch" class="form-control form-select" title="Текст на этикетке" style="flex: 0.3 1 auto;">
                    <option value="any" selected> Любое </option>
                    <option value="="> = </option>
                    <option value="!="> Не равно </option>
                    <option value="null"> Пусто </option>
                    <option value="like"> Частичное совпадение </option>
                </select>
                <input :disabled="label_text.displayMatch === 'any'" @change="changeParam('label_text')" v-model="label_text.displayText" type="text" class="form-control">
            </div>

            <div class="input-group mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 1.2rem">6) Принятое название</label>
                <select @change="changeParam('adopted_name')" v-model="adopted_name.displayMatch" class="form-control form-select" title="Принятое название" style="flex: 0.3 1 auto;">
                    <option value="any" selected> Любое </option>
                    <option value="="> = </option>
                    <option value="!="> Не равно </option>
                    <option value="null"> Пусто </option>
                    <option value="like"> Частичное совпадение </option>
                </select>
                <input :disabled="adopted_name.displayMatch === 'any'" @change="changeParam('adopted_name')" v-model="adopted_name.displayText" type="text" class="form-control">
            </div>

            <div class="input-group mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 1.2rem">7) Точность </label>
                <select @change="changeParam('accuracy')" v-model="accuracy.displayMatch" class="form-control form-select" title="Точность" style="flex: 0.3 1 auto;">
                    <option value="any" selected> Любое </option>
                    <option value="="> = </option>
                    <option value="!="> Не равно </option>
                    <option value="null"> Пусто </option>
                    <option value="like"> Частичное совпадение </option>
                </select>
                <input :disabled="accuracy.displayMatch === 'any'" @change="changeParam('accuracy')" v-model="accuracy.displayText" type="number" class="form-control">
            </div>

            <div class="input-group mb-3">
                <label class="col-sm-3 col-form-label" style="font-size: 1.2rem">8) Природоохранный статус в Красной книге Самарской области </label>
                <select @change="changeParam('environmental_status')" v-model="environmental_status.displayMatch" class="form-control form-select" title="Природоохранный статус в Красной книге Самарской области" style="flex: 0.3 1 auto;">
                    <option value="any" selected> Любое </option>
                    <option value="="> = </option>
                    <option value="!="> Не равно </option>
                    <option value="null"> Пусто </option>
                    <option value="like"> Частичное совпадение </option>
                </select>
                <input :disabled="environmental_status.displayMatch === 'any'" @change="changeParam('environmental_status')" v-model="environmental_status.displayText" type="number" class="form-control">
            </div>

        </form>

    </div>

</template>

<script>
    import {LoaderService} from "../services/loader-service";
    import {NotifyService} from "../services/notify-service";
    import {DateTimeParser} from "../parsers/datetime-parser";
    import {RequestService} from "../request-services/request-service";
    import {DeviceHelper} from "../helpers/device-helper";

    export default {
        name: "SearchDialogComponent",

        data() {
            return {
                barcode: {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'number'
                },
                determination: {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'string'
                },
                russian_name: {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'string'
                },
                collection_date: {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'date'
                },
                label_text: {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'string'
                },
                accuracy: {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'number'
                },
                adopted_name: {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'string'
                },
                environmental_status: {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'number'
                },

                styleSearchForm: {
                    height: 75 + 'vh',
                    overflowY: 'scroll'
                },

                paramsArray: [],
                rest: new RequestService(),
                loaderService: new LoaderService(),
                notifyService: new NotifyService(),
                dateTimeParser: new DateTimeParser(),
                response: {}
            }
        },

        mounted() {
            this.$root.$on('SearchDialogComponent', (data) => {
                if (data.method === 'search') {
                    this.search();
                }
                if (data.method === 'clearSearchParams') {
                    this.clearSearchParams();
                }
            });

            this.paramsArray = [
                this.barcode, this.determination, this.russian_name, this.collection_date,
                this.label_text, this.accuracy, this.adopted_name, this.environmental_status,
            ];

            if (DeviceHelper.isPhone()) {
                this.styleSearchForm.height = 60 + 'vh';
            }
        },

        methods: {
            search() {
                this.convertToSqlParams(this.paramsArray);

                let url = `/posts/search/${encodeURI(JSON.stringify(this.paramsArray[0]))}/
                ${encodeURI(JSON.stringify(this.paramsArray[1]))}/
                ${encodeURI(JSON.stringify(this.paramsArray[2]))}/
                ${encodeURI(JSON.stringify(this.paramsArray[3]))}/
                ${encodeURI(JSON.stringify(this.paramsArray[4]))}/
                ${encodeURI(JSON.stringify(this.paramsArray[5]))}/
                ${encodeURI(JSON.stringify(this.paramsArray[6]))}/
                ${encodeURI(JSON.stringify(this.paramsArray[7]))}`;

                window.location.href = encodeURI(url);

            },

            changeParam(param) {
                this.$modal.next(this.isDisabledSubmit());
                if (this[param].displayMatch === 'null') {
                    this[param].displayText = null;
                }
            },

            convertToSqlParams(array) {
                if (array.length > 0) {

                    for(let i = 0; i < array.length; i++) {

                        if (array[i].displayMatch === '=') {
                            array[i].match = '=';
                            if (!array[i].displayText) {
                                array[i].value = null;
                            } else {
                                array[i].value = array[i].displayText.trim();
                            }
                        }

                        if (array[i].displayMatch === '!=' || array[i].displayMatch === 'any') {
                            array[i].match = '!=';
                            array[i].value = array[i].displayText.trim();
                            if (!array[i].displayText.trim() || array[i].displayMatch === 'any') {
                                array[i].value = null;
                            }
                        }

                        if (array[i].displayMatch === 'null') {
                            array[i].match = '=';
                            array[i].value = null;
                            array[i].displayText = null;
                        }

                        if (array[i].displayMatch === 'like' && array[i].displayText) {
                            array[i].match = 'like';
                            array[i].value = `%${array[i].displayText.trim()}%`;
                        }

                        if (array[i].displayMatch === 'any') {
                            array[i].match = 'any';
                            array[i].value = null;
                        }

                        if (array[i].type === 'date') {
                            array[i].match = array[i].displayMatch;
                            let date = null;
                            if (array[i].displayText) {
                                date = new Date(array[i].displayText);
                                array[i].value = this.dateTimeParser.getCurrentDateTime(date);
                            }
                            if (!array[i].displayText && array[i].displayMatch !== 'any') {
                                date = new Date();
                                array[i].value = this.dateTimeParser.getCurrentDateTime(date);
                            }

                        }

                    }
                }

                return array;
            },

            clearSearchParams() {

                this.barcode = {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'number'
                };

                this.determination = {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'string'
                };

                this.russian_name = {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'string'
                };

                this.collection_date = {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'date'
                };

                this.label_text = {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'string'
                };

                this.accuracy = {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'number'
                };

                this.adopted_name = {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'string'
                };

                this.environmental_status = {
                    match: 'any',
                    value: null,
                    displayText: '',
                    displayMatch: 'any',
                    type: 'number'
                };

                this.paramsArray = [
                    this.barcode, this.determination, this.russian_name, this.collection_date,
                    this.label_text, this.accuracy, this.adopted_name, this.environmental_status,
                ];

                this.$modal.next(this.isDisabledSubmit());

            },

            isDisabledSubmit() {
                return this.paramsArray.every(item => item.displayMatch === 'any') || false;
            }
        }

    }
</script>

<style scoped>

</style>