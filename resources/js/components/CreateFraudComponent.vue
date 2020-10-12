<template>
    <div>
        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <h1>Добавить мошенника
                </h1>
            </div>
        </div>

        <div class="alert alert-danger" role="alert" v-for="error in errors">
            {{error}}
        </div>

        <div class="alert alert-primary" role="alert" v-for="message in messages">
            {{message}}
        </div>

        <div class="row">
            <div class="col-lg-6 offset-lg-3">
                <form action="#" method="post" @submit="createFraud">
                    <div class="fraud-form">
                        <div class="input-group mb-3 mt-4">
                            <div class="input-group-prepend ">
                                <span class="input-group-text bg-dark text-white">Телефон</span>
                            </div>
                            <input type="text" class="form-control" v-model="fraudPhone"
                                   maxlength="10" placeholder="0930000000" required>
                        </div>

                        <div class="card">
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

                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Создать</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        name: "CreateFraudComponent",
        data() {
            return {
                messages: [],
                errors: [],
                fraudComment: '',
                fraudPhone: '',
                fraudCards: [],
                fraudCardsCount: 1,
            };
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
            createFraud(e) {
                const params = {
                    comment: this.fraudComment,
                    phone: this.fraudPhone,
                    cards: this.fraudCards,
                };
                window.axios.post('/frauds/store', params).then(({data}) => {
                    this.showMessages(data);
                    this.fraudComment = '';
                    this.fraudPhone = '';
                    this.fraudCards = [];
                }).catch(error => {
                    if (422 === error.response.status) {
                        this.showErrors(error.response.data.errors);
                    }
                });

                console.log('success');
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
