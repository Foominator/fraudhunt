<template>
    <div class="container">

        <h1>{{translations['info_count.part1']}} {{frauds_count}} {{translations['info_count.part2']}}</h1>

        <div class="row">
            <div class="col-lg-3">

                <div class="fraud-search">
                    <div class="form-group field-fraudsearch-phone">

                        <div class="input-group mb-3">
                            <input class="form-control" @input="typePhone"
                                   type="tel" v-mask="'+38(0##)-###-####'" :value="searchPhone"
                                   placeholder="+38(093)-00-0000">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" @click="search()">
                                    {{translations['search_button']}}
                                </button>
                            </div>
                        </div>
                        <small class="form-text text-muted">{{translations['search_description']}}</small>

                        <div class="help-block"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <button type="reset" class="btn btn-secondary" @click="resetSearch()">{{translations['reset_button']}}
                </button>
            </div>
        </div>

        <p>
            <a class="btn btn-success" :href="this.generateRoute('fraud.create')">{{translations['add_fraud_button']}}</a>
        </p>

        <div v-if="showResult">
            <p v-if="firstComment.id === undefined">{{translations['empty_result']}}</p>

            <div v-if="firstComment.id > 0">
                <h1>
                    {{translations['search_result_label']}}. <span
                    class="text-secondary">Телефон - {{firstComment.phone.number}} </span>
                    <span class="float-right"
                          v-bind:class="{ 'text-danger': this.fraudPercent > 40 ,'text-success': this.fraudPercent <= 40 }">
                    {{translations['fraud_label']}} {{this.fraudPercent}}%
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
                                        <div v-if="firstComment.cards.length">{{translations['cards_added']}}:</div>
                                        <div v-for="card in firstComment.cards">
                                            <b><i class="fa fa-credit-card"></i> {{card.card_num}} </b>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <h3 class="mt-2">{{translations['add_comment_label']}}</h3>

                <div v-if="!auth_check" class="mb-4">
                    <a :href="routes['login']">Войдите</a> или <a :href="routes['register']">Зарегистрируйтесь</a>,
                    чтобы добавить комментарий
                </div>

                <div v-if="auth_check">
                    <div class="input-group">
                            <textarea class="form-control"
                                      v-model="commentText"
                                      rows="4" :placeholder="translations['input_description_placeholder']" required
                                      aria-label="With textarea"></textarea>
                    </div>

                    <div v-if="commentStatus" class="mb-2 mt-2">
                        <small class="form-text text-muted">&nbsp;&nbsp;*{{translations['not_required']}}</small>
                        <div class="row">
                            <div class="col-md-4" v-for="i in fraudCardsCount">
                                <div class="input-group ">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark text-white">Карта № {{i}}</span>
                                    </div>
                                    <input type="text" v-model="fraudCards[i-1]" class="form-control"
                                           v-mask="'#### #### #### ####'"
                                           placeholder="0000 0000 0000 0000">
                                    <div class="input-group-append pointer" @click="deleteCard(i-1)">
                                        <span class="input-group-text"><i class="fa fa-times"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4" v-if="fraudCardsCount < 3">
                                <div class="text-secondary pointer pt-2" @click="addCard()">
                                    {{translations['add_one_more_card_text']}} <i class="fa fa-plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" v-model="commentStatus" class="form-check-input" checked>
                        <label class="form-check-label">{{translations['approve_fraud_text']}}</label>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <button type="button" class="btn btn-success" @click="createComment()">
                                    {{translations['add_comment_button']}}
                                </button>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="text-danger pt-2" v-for="error in errors">{{error}}</div>
                            <div class="text-success pt-2" v-for="message in messages">{{message}}</div>
                        </div>
                    </div>

                </div>

                <h3 class="mt-4" v-if="comments.length">{{translations['last_comments_label']}}</h3>

                <div class="row">
                    <div class="col-md-12">
                        <div class="blog-comment">
                            <ul class="comments">
                                <li class="clearfix" v-for="comment in comments">
                                    <div class="post-comments">
                                        <p class="meta">{{comment.date}} <a href="#">{{comment.author.name}}</a>

                                            <span class="float-right" v-if="comment.status_int > 0">{{translations['opinion_text']}} {{firstComment.phone.number}} - <b>{{translations['fraud_label']}}</b></span>
                                            <span class="float-right" v-if="comment.status_int < 0">{{translations['opinion_text']}} {{firstComment.phone.number}} - <b>НЕ {{translations['fraud_label']}}</b></span>
                                        </p>

                                        <p>
                                            {{comment.description}}
                                        </p>
                                        <p v-if="comment.cards.length" class="meta"></p>
                                        <div v-if="comment.cards.length">{{translations['cards_added']}}:</div>
                                        <div v-for="card in comment.cards">
                                            <b><i class="fa fa-credit-card"></i> {{card.card_num}} </b>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <button class="btn btn-secondary mb-2" v-if="currentPage < maxPage" @click="loadPage">
                    {{translations['show_more']}}
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "SearchFraudComponent",
        props: ["frauds_count", "routes", "locale", "auth_check", "translations"],
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
            let url = new URL(window.location.href);
            let phone = url.searchParams.get("phone");
            if (phone) {
                this.searchPhone = phone;
                this.search();
            }
        },
        methods: {
            generateRoute(name) { // with locale
                return "/" + this.routes[this.locale + '.' + name];
            },
            typePhone(event) {
                let maskedPhone = event.target.value;
                this.searchPhone = maskedPhone.replace('+38', '').replace(/\D/g, '');

                window.history.pushState('page', 'Title', '?phone=' + this.searchPhone);
            },
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
                window.axios.get(this.generateRoute('fraud.search'), {params: {phone: this.searchPhone}}).then(({data}) => {
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
                    window.axios.get(this.generateRoute('fraud.search'), {
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
                window.history.pushState('page', 'Title', '?phone=');
                this.searchPhone = '';
                this.showResult = false;
                this.comments = [];
                this.firstComment = [];
                this.currentPage = 1;
            },
            createComment() {
                let cards = [];
                for (let i in this.fraudCards) {
                    cards.push(this.fraudCards[i].replace(/\D/g, ''));
                }

                let status = 'declined';
                if (this.commentStatus) {
                    status = 'approved';
                }

                const params = {
                    phone_id: this.firstComment.phone.id,
                    comment: this.commentText,
                    cards: cards,
                    status: status,
                };

                window.axios.post(this.generateRoute('fraud.comment'), params).then(({data}) => {
                    this.showMessages(data);
                    this.commentText = '';
                    this.fraudCards = [];
                    this.search();
                    window.scrollTo(0, 0);
                }).catch(error => {
                    if (422 === error.response.status) {
                        let errors = Object.values(error.response.data.errors);
                        this.showErrors([errors.pop().pop()]);
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
