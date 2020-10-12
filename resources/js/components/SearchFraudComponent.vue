<template>
    <div class="container">

        <h1>Сейчас в базе {{frauds_count}} записи(ей) о мошенниках</h1>

        <div class="alert alert-danger" role="alert" v-for="error in errors">
            {{error}}
        </div>


        <div class="row">
            <div class="col-lg-3">

                <div class="fraud-search">
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
                </div>
            </div>
        </div>

        <p>
            <a class="btn btn-success" :href="this.routes['fraud.create']">Добавить мошенника</a>
        </p>

        <div v-if="showResult">
            <p v-if="firstComment.id === undefined">По вашему запросу ничего не найдено</p>

            <div v-if="firstComment.id > 0">
                <h1>
                    Результат поиска. <span
                    class="text-secondary">Телефон - {{firstComment.phone.number}} </span>
                    <span class="float-right"
                          v-bind:class="{ 'text-danger': this.fraudPercent > 50 ,'text-success': this.fraudPercent < 50 }">
                    Мошенник {{this.fraudPercent}}%
                    </span>
                </h1>

                <div class="">
                    <div class="row rounded border-top border-left border-right border-dark text-center">
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
                    <div class="row rounded border-bottom border-left border-right border-dark">
                        <div class="col-md-1">
                            {{firstComment.date}}
                        </div>
                        <div class="col-md-8">
                            {{firstComment.description}}
                        </div>
                        <div class="col-md-2">
                        <span v-for="card in firstComment.cards">
                                    {{card.card_num}}
                                </span>
                        </div>
                        <div class="col-md-1 text-center">
                            <span v-if="firstComment.status === 'approved'"><i class="fa fa-plus"></i></span>
                            <span v-if="firstComment.status === 'declined'"><i
                                class="fa fa-minus"></i></span>
                        </div>
                    </div>
                </div>
                <br>

                <div class="row border rounded mt-2" v-for="comment in comments">
                    <div class="col-md-1 text-right border small">
                        {{comment.date}}
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
                <button class="btn btn-secondary mt-2" v-if="currentPage < maxPage" @click="loadPage">Показать еще
                </button>
                <h3 class="mt-4">Добавить комментарий</h3>
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
                firstComment: [],
                fraudPercent: 0,
                comments: [],

                commentText: '',
                commentStatus: true,
                fraudCards: [],
                fraudCardsCount: 1,

                currentPage: 1,
                maxPage: 1,
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
                this.comments = [];
                this.firstComment = [];
                this.currentPage = 1;
                window.axios.get(this.routes['fraud.search'], {params: {phone: this.searchPhone}}).then(({data}) => {
                    this.showResult = true;
                    if (data.first_comment.id !== undefined) {
                        this.firstComment = data.first_comment;
                        this.comments = data.comments.data;
                        this.maxPage = data.comments.last_page;
                        this.fraudPercent = data.fraud_percent;
                        this.calculateSearchResults();
                    }
                }).catch(error => {
                    console.log(error);
                    if (422 === error.response.status) {
                        this.showErrors(error.response.data.errors);
                    }
                });
            },
            loadPage() {
                if (this.currentPage < this.maxPage) {
                    this.currentPage++;
                    window.axios.get(this.routes['fraud.search'], {
                        params: {
                            phone: this.searchPhone,
                            page: this.currentPage
                        }
                    }).then(({data}) => {
                        for (var i in data.comments.data) {
                            this.comments.push(data.comments.data[i]);
                        }
                        this.calculateSearchResults();
                    });
                }
            },
            calculateSearchResults() {
                var date = new Date(this.firstComment.created_at);
                this.firstComment.date = ("0" + date.getDate()).slice(-2) + '.' + ("0" + (date.getMonth() + 1)).slice(-2) + '.' + date.getFullYear();

                this.comments = this.comments.sort((b, a) => (a.created_at > b.created_at) ? 1 : ((b.created_at > a.created_at) ? -1 : 0));
                for (var j in this.comments) {
                    var mydate = new Date(this.comments[j].created_at);
                    this.comments[j].date = ("0" + mydate.getDate()).slice(-2) + '.' + ("0" + (mydate.getMonth() + 1)).slice(-2) + '.' + mydate.getFullYear();
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
                this.comments = [];
                this.firstComment = [];
                this.currentPage = 1;
            }
        }
    }
</script>

<style scoped>

</style>
