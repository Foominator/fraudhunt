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
            <p v-if="searchResults.length === 0">По вашему запросу ничего не найдено</p>
            <div v-for="fraud in searchResults">

                <h1>
                    Результат поиска. <span class="text-secondary">Телефон - {{fraud.number}} </span>
                    <span class="float-right"
                          v-bind:class="{ 'text-danger': fraud.fraudPercent > 50 ,'text-success': fraud.fraudPercent < 50 }">
                    Мошенник {{fraud.fraudPercent}}%
                    </span>
                </h1>


                <div class="row text-center">
                    <div class="col-md-1">
                        Дата
                    </div>
                    <div class="col-md-8">
                        Комментарий
                    </div>
                    <div class="col-md-2">
                        Карты
                    </div>
                    <div class="col-md-1">
                        Мошенник
                    </div>

                </div>

                <div class="row border rounded mt-2" v-for="comment in fraud.comments">
                    <div class="col-md-1 text-right">
                        {{comment.created_at}}
                    </div>
                    <div class="col-md-8 text-left">
                        {{comment.description}}
                    </div>
                    <div class="col-md-2 text-center">
                            <span v-for="card in comment.cards">
                                    {{card.card_num}}
                                </span>
                    </div>
                    <div class="col-md-1 text-center align-middle">
                        <span v-if="comment.status === 'approved'"><i class="fa fa-plus"></i></span>
                        <span v-if="comment.status === 'declined'"><i class="fa fa-minus"></i></span>
                    </div>
                </div>
                <br>
                <h3>Добавить комментарий</h3>
                <div class="input-group">

                            <textarea class="form-control"
                                      v-model="commentText"
                                      rows="6" placeholder="Опишите ситуацию..." required
                                      aria-label="With textarea"></textarea>

                </div>

                <div class="input-group mb-3 mt-4" v-for="i in fraudCardsCount">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-dark text-white">Карта № {{i}}</span>
                    </div>
                    <input type="text" v-model="fraudCards[i-1]" class="form-control" maxlength="16"
                           minlength="16"
                           placeholder="0000000000000000">
                    <div class="input-group-append pointer" @click="deleteCard(i-1)">
                        <span class="input-group-text"><i class="fa fa-times"></i></span>
                    </div>
                </div>

                <div class="form-group">
                    <button type="button" class="btn btn-primary" @click="addCard()" v-if="fraudCardsCount < 3">
                        Добавить карту <i class="fa fa-plus"></i>
                    </button>
                </div>


                <div class="form-check">
                    <input type="checkbox" v-model="commentStatus" class="form-check-input" checked>
                    <label class="form-check-label">Подтверждаю мошенничество</label>
                </div>

                <div class="form-group mt-1">
                    <button type="button" class="btn btn-success">Добавить комментарий</button>
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
                searchResults: [],

                commentText: '',
                commentStatus: true,
                fraudCards: [],
                fraudCardsCount: 1,
            }
        },
        mounted() {
        },
        methods: {
            addCard() {
                this.fraudCardsCount++;
            },
            deleteCard(cardI) {
                if (0 < this.fraudCardsCount) {
                    for (var key in this.fraudCards) {
                        if (key == this.fraudCardsCount - 1) {
                            this.fraudCards.splice(cardI, 1);
                        }
                    }
                    this.fraudCardsCount--;
                }
            },
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
                    this.searchResults[i].comments = fraud.comments.sort((b, a) => (a.created_at > b.created_at) ? 1 : ((b.created_at > a.created_at) ? -1 : 0));
                    for (var j in fraud.comments) {
                        if ('approved' === fraud.comments[j].status) {
                            approvedCount++;
                        }
                        commentsCount++;
                        var mydate = new Date(fraud.comments[j].created_at);
                        fraud.comments[j].created_at = mydate.getDate() + '.' + mydate.getMonth() + '.' + mydate.getFullYear();
                    }
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
