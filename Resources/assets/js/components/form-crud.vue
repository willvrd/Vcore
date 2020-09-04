<template>
    <div>

        <section class="forms">

            <form @submit.prevent="onSubmit(item)">
                <div class="card">

                    <div class="card-header text-uppercase font-weight-bold">{{ mainTitle }}</div>
                    <div class="card-body">

                        <div v-for="(attr, index) in item" :key="index">

                            <div v-if="attr.type=='text'" class="form-group">
                                <label :for="'input_'+attr.name">{{attr.title}}</label>
                                <input type="text" class="form-control mb-2"
                                        :placeholder="attr.title" v-model="attr.value">
                            </div>

                            <div v-if="attr.type=='email'" class="form-group">
                                <label :for="'input_'+attr.name">{{attr.title}}</label>
                                <input type="email" class="form-control mb-2"
                                        :placeholder="attr.title" v-model="attr.value">
                            </div>

                            <div v-if="attr.type=='select'" class="form-group">
                                <label :for="'input_'+attr.name">{{attr.title}}</label>
                                <select :name="'select_'+attr.name" v-model="attr.value"  class="form-control">
                                    <option value="">{{trans.form.selectOption}}</option>
                                    <option  v-for="(opt,index) in attr.options" :key="index" :value="opt.value">
                                        {{opt.title}}
                                    </option>
                                </select>
                            </div>

                        </div>

                        <button class="btn btn-primary" type="submit">{{btnTitle}}</button>

                        <button v-if="modeUpdate" class="btn btn-danger" type="submit"
                            @click="cancelUpdate">{{trans.btn.cancel}}</button>
                    </div>

                </div>
            </form>

            <!-- Errors Form -->
            <section v-if="Object.keys(errors).length>0" class="errorsForm">
                <div v-for="(error, index) in errors" :key="index">
                    <alert :alert="{status:true,type:'alert-danger',text: error.name,dismissible:true}"></alert>
                </div>
            </section>

        </section>

    </div>
</template>

<script>
export default {
    props: {
        path:{type:String,required:true},
        idSelected:{type:Number},
        modeUpdate:{type: Boolean,required: true},
        trans:{type: Object,required: true},
        item:{type: Array,required: true},
        loading:{type: Boolean,required: true},
        hasChanged:{type: Boolean,required: true}
    },
    data() {
        return {
            errors: []
        }
    },
    computed:{
        mainTitle(){
            return this.modeUpdate ? this.trans.form.edit.title : this.trans.form.add.title
        },
        btnTitle(){
            return this.modeUpdate ? this.trans.btn.update : this.trans.btn.add
        }
    },
    methods:{

        addItem(){

            this.errors = []

            if(this.validateForm()){

                this.emitLoading(true)
                let attr = this.fixAttributesToSend()

                axios.post(this.path, {attributes:attr})
                .then((response) =>{
                    alert(this.trans.messages.itemAdded)
                    this.cleanValues()
                    this.emitHasChanged(true)
                }).catch(error => {
                    this.catchErrors(error)
                    console.log(error)
                })
                .finally(() =>  this.emitLoading(false))

            }

        },
        updateItem(itemUp){

            this.errors = []

            if(this.validateForm()){

                let attr = this.fixAttributesToSend()

                this.emitLoading(true)
                axios.put(this.path+`/${this.idSelected}`,{attributes:attr})
                .then(response=>{
                    this.emitMode(false)
                    this.emitHasChanged(true)
                    this.cleanValues();
                    alert(this.trans.messages.itemUpdated)
                }).catch(error=>{
                    this.catchErrors(error)
                    console.log(error)
                })
                .finally(() => this.emitLoading(false))

            }


        },
        cancelUpdate(){

            this.emitMode(false)
            this.cleanValues()
            this.errors = []
        },
        cleanValues(){

            let newItem = this.item
            newItem.forEach(attr => {
                attr.value = ""
            });
            this.emitItem(newItem)

        },
        addError(name){
            this.errors.push({
                "name":name
            });
        },
        catchErrors(error){

            let objErrors = {}

            if (error.response){
                objErrors = JSON.parse(error.response.data.errors);
            }

            Object.entries(objErrors).forEach(([key, value]) => {
                value.forEach(element => {
                    this.addError(element)
                });
            })

        },
        validateForm() {

            this.errors = []
            let error = ""

            this.item.forEach(item => {
                if(item.required && !item.value){
                    error = item.title+" "+this.trans.validations.required
                    this.addError(error)
                }
                if(item.type=="email" && !this.validEmail(item.value)){
                    error = item.title+" "+this.trans.validations.email
                    this.addError(error)
                }
            });

            if(Object.keys(this.errors).length==0)
               return true

            return false

        },
        emitMode(value){
            this.$emit('modeUpdate',value);
        },
        emitItem(value){
            this.$emit('item',value);
        },
        emitLoading(value){
            this.$emit('loading',value);
        },
        emitHasChanged(value){
            this.$emit('hasChanged',value);
        },
        transformToSnakeCase(string) {
            return string.replace(/[\w]([A-Z0-9])/g, function (m) {
                return m[0] + '_' + m[1]
            }).toLowerCase()
        },
        fixAttributesToSend(){
            let attr = {}
            this.item.forEach(item => {
               let attName = this.transformToSnakeCase(item.name)
               attr[attName] = item.value
            });
            return attr
        },
        onSubmit(item){

            if(this.modeUpdate)
                this.updateItem(item)
            else
                this.addItem()

        },
        validEmail(email) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(email);
        }
    }
}
</script>
