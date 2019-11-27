<template>
    <div class="card card-default">
        <div class="card-header">
            <label>{{title}}</label>
        </div>

        <div class="card-body">

            <p>Label - заголовок поля *</p>
            <p>Type - тип поля(select,input,checkbox) *</p>
            <p>Name - name инпута *</p>
            <p>Input Type - тип инпута</p>
            <p>Select Options - элементы списка для селекта(ключ - текст,значение - value селекта)</p>

            <v-json-editor
                :data="root"
                :editable="true"
                @change="$forceUpdate()"></v-json-editor>

            <button type="button" @click="add" class="mt-3 mb-3 btn btn-primary">Добавить</button>

            <pre>{{root.fields}}</pre>

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
        "select_options": [],
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

        data(){
          return {
              root: {
                  fields:[],
              }
          }
        },

        methods: {
            add(){
                this.root.fields.push(Object.assign({},fieldItem))
            }
        },
    }
</script>
