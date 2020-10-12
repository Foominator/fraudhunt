<template>
    <div class="container">

        <h1>Сейчас в базе {{frauds_count}} записи(ей) о мошенниках</h1>

        <div class="alert alert-danger" role="alert" v-for="error in errors">
            {{error}}
        </div>


        <div class="row">
            <div class="col-lg-3">

                <div class="fraud-search">
                    <form id="w0" action="/frauds" method="get">

                        <div class="form-group field-fraudsearch-phone">
                            <label class="control-label">Для поиска введите полный номер
                                телефона (10 цифр начиная с "0")</label>
                            <input type="text" v-model="searchPhone" class="form-control"
                                   maxlength="10" minlength="10" placeholder="0930000000">

                            <div class="help-block"></div>
                        </div>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" @click="search()">Поиск</button>
                            <button type="reset" class="btn btn-secondary" @click="resetSearch()">Сброс</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <p>
            <a class="btn btn-success" :href="this.routes['fraud.create']">Добавить мошенника</a>
        </p>

        <div v-if="showResult">
            <h1>Результат поиска</h1>
            <p v-if="searchResults.length === 0">По вашему запросу ничего не найдено</p>

            <div class="card" v-for="fraud in searchResults">
                <div class="card-header">
                    {{fraud.name}} - {{fraud.number}} <span class="float-right">Мошенник {{fraud.fraudPercent}}%</span>
                </div>
                <div class="card-body padding-0 text-center">
                    <table class="table table-bordered">
                        <tr>
                            <td>Комментарий</td>
                            <td>Карты</td>
                            <td>Мошенник</td>
                        </tr>
                        <tr v-for="comment in fraud.comments">
                            <td>{{comment.description}}</td>
                            <td>
                                <span v-for="card in comment.cards">
                                    {{card.card_num}}
                                </span>
                            </td>
                            <td v-if="comment.status === 'approved'"><i class="fa fa-plus"></i></td>
                            <td v-if="comment.status === 'declined'"><i class="fa fa-minus"></i></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SearchFraudComponent",
        props: ["frauds_count", "routes"],
        data() {
            return {
                errors: [],
                showResult: false,
                searchPhone: '',
                searchResults: []
            }
        },
        mounted() {
        },
        methods: {
            search() {
                window.axios.get('/frauds/search', {params: {phone: this.searchPhone}}).then(({data}) => {
                    this.showResult = true;
                    this.searchResults = data;
                    this.calculateFraudStats();
                }).catch(error => {
                    console.log(error);
                    if (422 === error.response.status) {
                        this.showErrors(error.response.data.errors);
                    }
                });
            },
            calculateFraudStats() {
                for (var i in this.searchResults) {
                    var approvedCount = 0;
                    var commentsCount = 0;
                    var fraud = this.searchResults[i];
                    for (var j in fraud.comments) {
                        if ('approved' === fraud.comments[j].status) {
                            approvedCount++;
                        }
                        commentsCount++;
                    }
                    console.log(approvedCount);
                    console.log(commentsCount);
                    this.searchResults[i].fraudPercent = approvedCount / commentsCount * 100;
                    this.searchResults[i].fraudPercent = Math.round(this.searchResults[i].fraudPercent * 10) / 10;
                }
            },
            showErrors(errors) {
                this.errors = errors;
                setTimeout(() => {
                    this.errors = [];
                }, 3000);
            },
            resetSearch() {
                this.showResult = false;
                this.searchResults = [];
            }
        }
    }
</script>

<style scoped>

</style>
