<template>
    <div class="container">

        <h1>Сейчас в базе {{frauds_count}} записи(ей) о мошенниках</h1>

        <div class="alert alert-danger" role="alert" v-for="error in errors">
            {{error}}
        </div>

        <div class="alert alert-primary" role="alert" v-for="message in messages">
            {{message}}
        </div>

        <div class="row">
            <div class="col-lg-3">

                <div class="fraud-search">
                    <div class="form-group field-fraudsearch-phone">

                        <div class="input-group mb-3">
                            <input type="text" v-model="searchPhone" class="form-control"
                                   maxlength="10" minlength="10" placeholder="0930000000">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" @click="search()">Поиск</button>
                            </div>
                        </div>
                        <small class="form-text text-muted">Для поиска введите полный номер
                            телефона (10 цифр начиная с "0")</small>

                        <div class="help-block"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <button type="reset" class="btn btn-secondary" @click="resetSearch()">Сброс</button>
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
                          v-bind:class="{ 'text-danger': this.fraudPercent > 40 ,'text-success': this.fraudPercent <= 40 }">
                    Мошенник {{this.fraudPercent}}%
                    </span>
                </h1>

                <div class="row">
                    <div class="col-md-12">
                        <div class="blog-comment">
                            <ul class="comments">

                                <li class="clearfix">
                                    <div class="post-comments border-dark border">
                                        <p class="meta">{{firstComment.date}} <a
                                            href="#">{{firstComment.author.name}}</a>
                                        </p>
                                        <p class="text-secondary">
                                            {{firstComment.description}}
                                        </p>
                                        <p class="meta"></p>
                                        <div v-if="firstComment.cards.length">Добавлены карты мошенника:</div>
                                        <div v-for="card in firstComment.cards">
                                            <b>{{card.card_num}} </b>
                                        </div>
                                    </div>
                                </li>

                                <li class="clearfix" v-for="comment in comments">
                                    <div class="post-comments">
                                        <p class="meta">{{comment.date}} <a href="#">{{comment.author.name}}</a>

                                            <span class="float-right" v-if="comment.status_int > 0">Считает, что {{firstComment.phone.number}} - <b>Мошенник</b></span>
                                            <span class="float-right" v-if="comment.status_int < 0">Считает, что {{firstComment.phone.number}} - <b>НЕ Мошенник</b></span>
                                        </p>

                                        <p>
                                            {{comment.description}}
                                        </p>
                                        <p v-if="comment.cards.length" class="meta"></p>
                                        <div v-if="comment.cards.length">Добавлены карты мошенника:</div>
                                        <div v-for="card in comment.cards">
                                            <b>{{card.card_num}} </b>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <button class="btn btn-secondary" v-if="currentPage < maxPage" @click="loadPage">Показать еще
                </button>
                <h3 class="mt-4">Добавить комментарий</h3>

                <div v-if="!auth_check" class="mb-4">
                    <a :href="routes['login']">Войдите в систему</a>, чтобы добавить комментарий
                </div>

                <div v-if="auth_check">
                    <div class="input-group">

                            <textarea class="form-control"
                                      v-model="commentText"
                                      rows="6" placeholder="Опишите ситуацию..." required
                                      aria-label="With textarea"></textarea>
                    </div>

                    <div v-if="commentStatus">
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
                        <span class="text-secondary pointer" @click="addCard()" v-if="fraudCardsCount < 3">
                            Добавить еще карту <i class="fa fa-plus"></i>
                        </span>
                        </div>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" v-model="commentStatus" class="form-check-input" checked>
                        <label class="form-check-label">Подтверждаю мошенничество</label>
                    </div>

                    <div class="form-group mt-1">
                        <button type="button" class="btn btn-success" @click="createComment()">Добавить комментарий
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SearchFraudComponent",
        props: ["frauds_count", "routes", "auth_check"],
        data() {
            return {
                errors: [],
                messages: [],
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
                    this.firstComment = data.first_comment;
                    this.comments = data.comments.data;
                    this.maxPage = data.comments.last_page;
                    this.fraudPercent = data.fraud_percent;
                    this.commentStatus = 'declined' !== data.last_comment_status;
                    this.calculateSearchResults();
                }).catch(error => {
                    console.log(error);
                    if (404 === error.response.status) {
                        this.showResult = true;
                    }
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
                //first comment logic
                var date = new Date(this.firstComment.created_at);
                this.firstComment.date = ("0" + date.getDate()).slice(-2) + '.' + ("0" + (date.getMonth() + 1)).slice(-2) + '.' + date.getFullYear();
                for (let k in this.firstComment.cards) {
                    this.firstComment.cards[k].card_num = this.formatCreditCard(this.firstComment.cards[k].card_num);
                }

                //ALL comments logic
                this.comments = this.comments.sort((b, a) => (a.created_at > b.created_at) ? 1 : ((b.created_at > a.created_at) ? -1 : 0));
                for (let j in this.comments) {
                    var mydate = new Date(this.comments[j].created_at);
                    this.comments[j].date = ("0" + mydate.getDate()).slice(-2) + '.' + ("0" + (mydate.getMonth() + 1)).slice(-2) + '.' + mydate.getFullYear();

                    for (let k in this.comments[j].cards) {
                        this.comments[j].cards[k].card_num = this.formatCreditCard(this.comments[j].cards[k].card_num);
                    }
                }
            },
            formatCreditCard(value) {
                let v = value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                let matches = v.match(/\d{4,16}/g);
                let match = matches && matches[0] || '';
                let parts = [];

                for (let i = 0, len = match.length; i < len; i += 4) {
                    parts.push(match.substring(i, i + 4));
                }

                if (parts.length) {
                    return parts.join(' ');
                } else {
                    return value;
                }
            },
            showErrors(errors) {
                this.errors = errors;
                setTimeout(() => {
                    this.errors = [];
                }, 3000);
            },
            showMessages(messages) {
                this.messages = messages;
                setTimeout(() => {
                    this.messages = [];
                }, 3000);
            },
            resetSearch() {
                this.searchPhone = '';
                this.showResult = false;
                this.comments = [];
                this.firstComment = [];
                this.currentPage = 1;
            },
            createComment() {
                let status = 'declined';
                if (this.commentStatus) {
                    status = 'approved';
                }

                const params = {
                    phone_id: this.firstComment.phone.id,
                    comment: this.commentText,
                    cards: this.fraudCards,
                    status: status,
                };

                window.axios.post(this.routes['fraud.comment'], params).then(({data}) => {
                    this.showMessages(data);
                    this.commentText = '';
                    this.fraudCards = [];
                    this.search();
                    window.scrollTo(0, 0);
                }).catch(error => {
                    this.showErrors(error.response.data.errors);
                });
            }
        }
    }
</script>

<style scoped>

</style>
