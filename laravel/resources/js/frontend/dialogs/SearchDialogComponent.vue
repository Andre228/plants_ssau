<template>

    <div style="width: 90%">

        <form class="row mt-5">

            <div class="input-group mb-3">
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
                <input @change="changeParam('collection_date')" :disabled="collection_date.displayMatch === 'any'" v-model="collection_date.displayText" type="datetime-local" class="form-control" id="element">
            </div>

        </form>

    </div>

</template>

<script>
    import {LoaderService} from "../services/loader-service";
    import {NotifyService} from "../services/notify-service";
    import {DateTimeParser} from "../parsers/datetime-parser";
    import {RequestService} from "../request-services/request-service";

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
                    // tooltipText: 'Обратите внимание, что параметры, которые равны пустому полю'
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
            });
            this.paramsArray = [this.barcode, this.determination, this.russian_name, this.collection_date];
        },

        methods: {
            search() {
                this.convertToSqlParams(this.paramsArray);

                const params = {
                    barcode: this.paramsArray[0],
                    determination: this.paramsArray[1],
                    russian_name: this.paramsArray[2],
                    collection_date: this.paramsArray[3]
                };

                const url = `/search`;

                this.rest.post(url, params).then(res => {
                    console.log(res);
                });
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
                            const date = array[i].displayText ? new Date(array[i].displayText) : new Date();
                            array[i].value = this.dateTimeParser.getCurrentDateTime(date);
                        }

                    }
                }

                return array;
            },

            isDisabledSubmit() {
                return this.paramsArray.every(item => item.displayMatch === 'any') || false;
            }
        }

    }
</script>

<style scoped>

</style>