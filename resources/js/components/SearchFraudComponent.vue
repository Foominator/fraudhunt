<template>
    <div class="container">

        <h1>Сейчас в базе 586 записи(ей) о мошенниках</h1>

        <div class="row">
            <div class="col-lg-3">

                <div class="fraud-search">
                    <form id="w0" action="/frauds" method="get">

                        <div class="form-group field-fraudsearch-phone">
                            <label class="control-label" for="fraudsearch-phone">Для поиска введите полный номер
                                телефона (10 цифр начиная с "0")</label>
                            <input type="text" id="fraudsearch-phone" class="form-control" name="FraudSearch[phone]"
                                   maxlength="10" placeholder="0930000000">

                            <div class="help-block"></div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Поиск</button>
                            <button type="reset" class="btn btn-secondary">Сброс</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <p>
            <a class="btn btn-success" href="/frauds/create">Добавить мошенника</a>
        </p>

    </div>
</template>

<script>
    export default {
        name: "SearchFraudComponent",
        data() {
            return {
            }
        },
        mounted() {
        }
    }
</script>

<style scoped>

</style>
