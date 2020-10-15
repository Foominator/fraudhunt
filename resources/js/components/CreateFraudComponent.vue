<template>
    <div>
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h1>Добавить мошенника
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <form action="#" method="post" @submit="createFraud">
                    <div class="fraud-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group mb-2 mt-2">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text bg-dark text-white">Телефон</span>
                                    </div>
                                    <input class="form-control" v-model="fraudPhone"
                                           type="tel" v-mask="'+38(0##)-###-####'"
                                           placeholder="+38(093)-00-0000">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-2 mt-2">
                                    <div class="text-secondary pointer pt-2" @click="addAdditionalPhone()"
                                         v-if="additionalPhonesCount < 2">
                                        Добавить еще телефон <i class="fa fa-plus"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6" v-for="i in additionalPhonesCount">
                                <div class="input-group mb-2 mt-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-dark text-white">Тел.</span>
                                    </div>
                                    <input type="text" v-model="additionalPhones[i-1]" class="form-control"
                                           v-mask="'+38(0##)-###-####'"
                                           placeholder="+38(093)-00-0000">
                                    <div class="input-group-append pointer" @click="deleteAdditionalPhone(i-1)">
                                        <span class="input-group-text"><i class="fa fa-times"></i></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="card mt-1 mb-2">
                            <div class="card-header bg-dark text-white">
                                Подробнее
                            </div>
                            <div class="card-body padding-0">
                                <div class="input-group">

                            <textarea class="form-control"
                                      v-model="fraudComment"
                                      rows="6" placeholder="Опишите ситуацию..." required
                                      aria-label="With textarea"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="help-block"></div>
                    </div>

                    <small class="form-text text-muted">&nbsp;&nbsp;*необязательно</small>
                    <div class="row" v-for="i in fraudCardsCount">
                        <div class="col-md-8">
                            <div class="input-group mb-3">
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
                    </div>

                    <div class="form-group">
                        <span class="text-secondary pointer" @click="addCard()" v-if="fraudCardsCount < 3">
                            Добавить еще карту <i class="fa fa-plus"></i>
                        </span>
                    </div>

                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Создать</button>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="text-danger pt-2" v-for="error in errors">{{error}}</div>
                            <div class="text-success pt-2" v-for="message in messages">{{message}}</div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "CreateFraudComponent",
        props: ["routes"],
        data() {
            return {
                messages: [],
                errors: [],
                fraudComment: '',
                fraudPhone: '',
                fraudCards: [],
                fraudCardsCount: 1,

                additionalPhones: [],
                additionalPhonesCount: 0
            };
        },
        methods: {
            addCard() {
                this.fraudCardsCount++;
            },
            addAdditionalPhone() {
                this.additionalPhonesCount++;
            },
            deleteAdditionalPhone(phoneI) {
                if (0 < this.additionalPhonesCount) {
                    for (var key in this.additionalPhones) {
                        if (key == this.additionalPhonesCount - 1) {
                            this.additionalPhones.splice(phoneI, 1);
                        }
                    }
                    this.additionalPhonesCount--;
                }
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
            createFraud(e) {
                // Remove Input Masks
                let phones = [];
                let cards = [];
                for (let i in this.additionalPhones) {
                    phones.push(this.additionalPhones[i].replace('+38', '').replace(/\D/g, ''));
                }
                phones.push(this.fraudPhone.replace('+38', '').replace(/\D/g, ''));

                for (let i in this.fraudCards) {
                    cards.push(this.fraudCards[i].replace(/\D/g, ''));
                }

                const params = {
                    comment: this.fraudComment,
                    phones: phones,
                    cards: cards,
                };
                window.axios.post('/' + this.routes['fraud.store'], params).then(({data}) => {
                    this.showMessages(data);
                    this.fraudComment = '';
                    this.fraudPhone = '';
                    this.fraudCards = [];
                    this.additionalPhones = [];
                }).catch(error => {
                    if (422 === error.response.status) {
                        let errors = Object.values(error.response.data.errors);
                        this.showErrors([errors.pop().pop()]);
                    }
                });

                e.preventDefault();
            },
            showMessages(messages) {
                this.messages = messages;
                setTimeout(() => {
                    this.messages = [];
                }, 3000);
            },
            showErrors(errors) {
                this.errors = errors;
                setTimeout(() => {
                    this.errors = [];
                }, 3000);
            }
        },
    }
</script>
