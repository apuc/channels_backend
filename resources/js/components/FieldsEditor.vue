<template>
    <div class="card card-default">
        <div class="card-header">
            <label>{{title}}</label>
        </div>

        <div class="card-body field-editor">

            <div class="d-flex justify-content-between json-hints">
                <p><b>Label</b> - заголовок поля <span>*</span></p>
                <p><b>Type</b> - тип поля(select,input,checkbox) <span>*</span></p>
                <p><b>Name</b> - name инпута <span>*</span></p>
                <p><b>Input Type</b> - тип инпута</p>
                <p><b>Select Options</b> - элементы списка для селекта(ключ - текст,значение - value селекта)</p>
            </div>

            <div class="row">
                <div class="col-8">
                    <v-json-editor
                        :data="root"
                        :editable="true"
                        @change="$forceUpdate()">

                    </v-json-editor>

                    <button type="button" @click="add" class="mt-3 mb-3 btn btn-primary">Добавить поле</button>
                </div>

                <div class="col-4">
                    <p><b>Итоговый json:</b></p>cal
                    <pre>{{root.fields}}</pre>
                </div>
            </div>

            <input type="hidden" :name="inputName" :value="JSON.stringify(root.fields)">
        </div>
    </div>
</template>

<script>
    import JsonEditor from 'vue-json-editor-block-view'
    import Vue from 'vue';

    Vue.use(JsonEditor);

    const fieldItem =  {
        "label": "",
        "type": "input",
        "name": "",
        "input_type": "text",
        "select_options":"",
    }

    export default {
        name:'FieldsEditor',

        components: { JsonEditor },

        props:{
          title:String,

          fields:{
              type:String,
              default:null,
          },

          inputName:{
              type:String,
              required:true
          }
        },

        created(){
            if(this.fields){
                this.root.fields = JSON.parse(this.fields)
            }
        },

        mounted() {
            this.$nextTick(()=>{
                $('.card-body').each(function(i,elem) {
                    $(elem).find('.input_ctl').first().hide();
                    $(elem).find('.semicolon').first().hide();
                });
            })
        },

        data(){
          return {
              root: {
                  fields:[],
              }
          }
        },

        methods: {
            add(){
                let item = Object.assign({},fieldItem);
                item.select_options = [];

                this.root.fields.push(item)
            }
        },
    }
</script>

<style>
    body .input_ctl input{
        width: 150px !important;
        height: 25px !important;
        padding: 15px !important;
    }

    body .input{
        margin-bottom: 15px !important;
    }

    body .content_style div{
        border:none !important;
    }

    .json-hints span{
       color:red;
        font-weight:bold;
    }
</style>
