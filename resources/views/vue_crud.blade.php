@extends('layout.template')

@section('content')



    <div class="container-fluid display-page" id="display-post-category" >

        <!-- @create Modal--->
        <modal  v-if="modal.get('create')" @close="modal.set('create', false)" >
        <template slot="header" ><h4>Create Item</h4></template>
        <template slot="body" >
            <form method="POST" action="" @submit.prevent="storeItem()">
                <div class="modal-body">

                    <!-- form Group -->
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input class="form-control border-input" placeholder="Title" v-model="forms.title"  type="text"  >
                        <span class="error-msg" v-if="errors.has('title')" v-text="errors.get('title')"></span>


                    </div>

                    <!-- form Group -->
                    <div class="form-group">
                        <label for="sub_title">Sub Title</label>
                        <input class="form-control border-input" placeholder="Sub Title" v-model="forms.sub_title"  type="text"  >
                        <span class="error-msg" v-if="errors.has('sub_title')" v-text="errors.get('sub_title')"></span>
                    </div>


                    <!-- form Group -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control border-input" placeholder="Type here the description" rows="10" name="short_text" cols="50" v-model="forms.description"></textarea>
                        <span class="error-msg" v-if="errors.has('description')" v-text="errors.get('description')"></span>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="modal.set('create', false)" >Close</button>
                    <button type="submit" class="btn btn-success">Create</button>
                </div>

            </form>
        </template>
        </modal>


        <!-- @update --->
        <modal  v-if="modal.get('edit')" @close="modal.set('edit', false)"  >
        <template slot="header" ><h4>Edit Item</h4></template>
        <template slot="body" >

            <form method="POST" action="" @submit.prevent="updateItem()">
                <div class="modal-body">

                    <!-- form Group -->
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input class="form-control border-input" placeholder="Title" v-model="forms.title"  type="text"  >
                        <span class="error-msg" v-if="errors.has('title')" v-text="errors.get('title')"></span>
                    </div>

                    <!-- form Group -->
                    <div class="form-group">
                        <label for="sub_title">Sub Title</label>
                        <input class="form-control border-input" placeholder="Sub Title" v-model="forms.sub_title"  type="text"  >
                        <span class="error-msg" v-if="errors.has('sub_title')" v-text="errors.get('title')"></span>
                    </div>


                    <!-- form Group -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control border-input" placeholder="Type here the description" rows="10" name="short_text" cols="50" v-model="forms.description"></textarea>
                        <span class="error-msg" v-if="errors.has('description')" v-text="errors.get('description')"></span>

                    </div>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="modal.set('edit', false)" >Close</button>
                    <button type="submit" class="btn btn-success">Edit</button>
                </div>
            </form>
        </template>
        </modal>


        <!-- @delete --->
        <modal  v-if="modal.get('delete')" @close="modal.set('delete', false)"  >
        <template slot="header" ><h4>Delete Item</h4></template>
        <template slot="body" >

            <form method="POST" action="" @submit.prevent="destroyItem( submitSelectedItems )">
                <div class="modal-body">
                    <p>Are you Sure that you want to delete this  ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="modal.set('delete', false)" >Close</button>
                    <button type="submit" class="btn btn-success">Delete</button>
                </div>
            </form>
        </template>
        </modal>





        <div class="row" >

            <div class="col-md-7">




            </div>

            <div class="col-md-5">


                <ul class="list_right_menu_top">
                    <li><a href="#" type="button" class="delete-item-all-btn btn btn-primary btn pull-right "  @click="deleteManyItems()" >Delete</a></li>
                    <li> <a href="#" class="btn-primary btn pull-right "  @click="createItem()" >Create Item</a></li>
                </ul>

            </div>



            <div class="col-md-12">
                <div class="card">



                    <div class="header">
                        <h4 class="title">Vue Crud</h4>
                        <p class="total_row_values"><span>Total of</span> <span class="total_row_number" id="total_row_number"> </span> <span>Items</span> </p>
                    </div>



                            <!-- content -->
                    <div class="content table-responsive table-full-width" id="display"   >
                        <table class="table  table-striped">
                            <thead>
                            <th>ID</th>
                            <th>
                                <label class="checkbox checkbox-blue" >
                                    <input name="chkSelectAll" type="checkbox" id="chkSelectAll" v-model="toggleAll" @click="selectAll" >
                                </label>
                            </th>
                            <th>Title</th>
                            <th>Sub Title</th>
                            <th class="td-actions text-right" data-field="actions" >
                                <div class="th-inner ">Ação</div>

                            </th>

                            </thead>


                            <tbody class="posts">


                            <tr class="display_item post"  v-for="(item , index )  in displayItems"   >

                                <td></td>
                                <td> <label class="checkbox checkbox-blue" for="check_option">

                                        <input type="checkbox" :value="index" v-model="selectedItems">

                                    </label>
                                </td>

                                <td class="row_title" v-text="item.title" ></td>

                                <td  v-text="item.sub_title"></td>

                                <td class="td-actions text-right " >



                                    <ul class="list_table_action">


                                        <!-- edit  Button -->
                                        <li class="edit">
                                            <a class="hint--top" aria-label="Editar"  href="#"  @click.prevent="editItem(item)" >
                                                <i class="fa"></i>
                                            </a>
                                        </li>

                                        <!-- edit  Button -->
                                        <li class="delete">
                                            <a class="hint--top" aria-label="Deletar"  href="#"  @click.prevent="deleteItem(item)" >
                                                <i class="fa"></i>
                                            </a>
                                        </li>




                                    </ul>



                                </td>
                            </tr>



                            </tbody>

                        </table>


                        <!-- pagination -->
                        <div class="fixed-table-pagination">
                            <div class="text-center">

                                <ul class="pagination">
                                    <li class="first_pg">
                                        <a v-if="pagination.get('current_page') > 1" href="#" aria-label="Previous" @click.prevent="pagination.prevPage()">
                                            <span aria-hidden="true">«</span>
                                        </a>
                                    </li>
                                    <li v-for="page in pagesNumber"  v-bind:class="[ page == pagination.isActived ? 'active' : '']" >
                                        <a href="#" @click.prevent="pagination.changePage(page)">
                                            @{{ page }}
                                        </a>
                                    </li>
                                    <li class="last_pg">
                                        <a  v-if="pagination.get('current_page') < pagination.get('last_page')" href="#" aria-label="Next" @click.prevent="pagination.nextPage()">
                                            <span aria-hidden="true">»</span>
                                        </a>
                                    </li>
                                </ul>



                            </div>
                        </div>
                        <!-- end pagination -->

                    </div>
                    <!-- content -->



                    <!-- end row -->
                </div>
                <!-- container-fluid-->
            </div>





        </div>
    </div>



@stop


@section('scripts.footer')
    <script>
        /* ------------------------------------------------------------------------------------- ERRORS
         ---------------------------------------------------------------------------------------------------- */
        class Errors{
            constructor(){
                this.errors = {};

            }

            get(field){

                if(this.errors[field]){
                    return  this.errors[field][0];
                }
            }

            record(errors){

                this.errors = errors.response.data;
            }

            any(){
                return Object.keys(this.errors).length > 0;
            }

            has(field){
                return this.errors.hasOwnProperty(field);
            }

            clear(field){
                if(field) delete this.errors[field];

                this.errors = {};
            }

            clearAll(){
                this.errors = "";
            }

        }


        /* ------------------------------------------------------------------------------------- LOAD PAGE
         ---------------------------------------------------------------------------------------------------- */
        class LoadPage {

            constructor(urlToLoad) {
                // start upload
                this.startLoading(urlToLoad);
            }

            startLoading(urlToLoad){


                axios.get(urlToLoad)
                        .then(function (res) {
                            window.eventBus.$emit('dataLoaded', res.data);
                        })
                        .catch(function (res) {
                            alert('erro');
                        });

            }
        }


        /* ------------------------------------------------------------------------------------- FLASH MESSAGE
         ---------------------------------------------------------------------------------------------------- */
        class FlashMessage {

            constructor(typeMesage , contentMessage , redirect = null ) {
                // start upload
                this.createMessage(typeMesage , contentMessage , redirect);

            }

            createMessage(typeMesage , contentMessage , redirect){




                setTimeout(() => {
                    // set new data
                    swal({
                            title: 'Congratulations',
                            text: contentMessage,
                            type: typeMesage,
                            confirmButtonText: 'OK'
                    }).then(function () {
                    // redirect if is not null
                    if(redirect != null){
                        window.location = redirect
                    }

                })

            }, 0.800);




            }
        }



        /* ------------------------------------------------------------------------------------- CRUD FORM
         ---------------------------------------------------------------------------------------------------- */
        class CrudForm {
            constructor(data) {

                this.originalData = data;

                for(let field in data){

                    this[field] = data[field];
                }

            }

            reset(){
                for(let field in this.originalData){
                    this[field] = '';
                }
            }

            /*  Set a value to the temp , verify if has this item and update  */
            setFillItem(item , index){
                for(let field in this.originalData){

                    if(field in item){
                        this[field] = item[field];
                    }else{
                        // if is index
                        if(field == 'index'){ this[field] = index; }

                    }


                }

            }
            data(){

                let data = Object.assign({} , this);

                delete data.originalData;
                delete data.errors;


                return data;
            }


        }

        /* ------------------------------------------------------------------------------------- CRUD MODAL
         ---------------------------------------------------------------------------------------------------- */
        class CrudModal{

            constructor(data){

                this.modal = data;

            }
            get(value){
                if(this.modal[value]){

                    return this.modal[value];
                }

            }
            set(data , value){
                this.modal[data] = value;
            }

        }



        /* ------------------------------------------------------------------------------------- DESTROY ITEM
         ---------------------------------------------------------------------------------------------------- */
        class DestroyItem{
            constructor(url , item){

                // start upload
                this.startDelete(url , item);

            }

            // start the upload here
            startDelete(url , item) {


                var output = document.getElementById('output');
                var data = new FormData();

                /* data.append('value[]', JSON.stringify({id: item['id'], index: item['index']})); */

                for (var prop in item) {
                    /*alert(item[prop]['id']); */
                    data.append('value[]', JSON.stringify({id: item[prop]['id'], index: item[prop]['index']}));

                }



                axios.post(url, data)

                        .then(function (res) {
                            window.eventBus.$emit('deleteItem', res.data);
                        })
                        .catch(function (err) {
                            alert('erro');
                        });



            }


        }


        /* ------------------------------------------------------------------------------------- PAGINATION
         ---------------------------------------------------------------------------------------------------- */
        class Pagination{

            constructor(data){
                this.pagination = data;

            }
            get(field){
                if(this.pagination[field]){

                    return this.pagination[field];
                }

            }
            set(field , value){
                this.pagination[field] = value;
            }

            changePage(page) {
                this.set('current_page' , page);
                window.eventBus.$emit('updatePage', page);

            }

            prevPage(){
                this.changePage(this.get('current_page') - 1)
            }

            nextPage(){

                this.changePage(this.get('current_page') + 1);
            }

            isActived() {
                return this.get('current_page');
            }



            loadData(data){
                for(let field in this.pagination){
                    if(field in data){

                        /* this.pagination[field] = data[field]; */

                        this.set(field , data[field] );

                    }

                }


            }


            changePageStatus(action , number){

                let value_page = action == 'add' ? this.get('total') + number : this.get('total') - number;
                this.set('total' , value_page);
                this.changePage(1);
            }


        }

        /* ------------------------------------------------------------------------------------- STORE ITEM
         ---------------------------------------------------------------------------------------------------- */
        class StoreItem{
            constructor(url , fillItem){

                // start upload
                this.startUpload(url , fillItem);

            }

            // start the upload here
            startUpload(url , fillItem) {

                var output = document.getElementById('output');
                var data = new FormData();


                for(let field in fillItem){
                    data.append(field, JSON.stringify(fillItem[field]));

                }



                axios.post(url, data)
                        .then(response => {
                    window.eventBus.$emit('createItem', response.data);
            })
            .catch(error => window.eventBus.$emit('formError', error));



            }


        }


        /* ------------------------------------------------------------------------------------- UPDATE ITEM
          ---------------------------------------------------------------------------------------------------- */
        class UpdateItem{
            constructor(url , fillItem ){

                // start upload
                this.startUpload(url , fillItem );

            }

            // start the upload here
            startUpload(url , fillItem) {


                var output = document.getElementById('output');
                var data = new FormData();


                for(let field in fillItem){

                    data.append(field, JSON.stringify(fillItem[field]));

                }



                axios.post(url, data)

                        .then(response =>  window.eventBus.$emit('updateItem', response.data))
                        .catch(error => window.eventBus.$emit('formError', error.response.data));


            }


        }


        // -----------------------------------------------------------------------------------------------  COMPONENT MODAL
        const Modal = {

            template: `   <transition name="modal">
                                <div class="modal-mask">
                                  <div class="modal-wrapper">

                                    <div :class="modalStyle">
                                    <a class="close-modal" @click="$emit('close')" ></a>

                                      <div class="modal-header">
                                           <p class="modal-card-title"><slot name="header" class="modal-card-title "></slot></p>
                                      </div>
                                        <slot name="body">
                                          default body
                                        </slot>
                                    </div>
                                  </div>
                                </div>
                              </transition>` ,
            props: {
                modalsize: {type: String},
            } ,
            computed: {

                modalStyle() {
                    return this.modalsize == null ? 'modal-container' : this.modalsize + ' modal-container';
                }
            }
        };





        window.axios = axios;


        window.eventBus = new Vue();


        Vue.component('modal', Modal);

            // -----------------------------------------------------------------------------------------------  CRUD
            /*  add components */
            Vue.component('modal', Modal);

            new Vue({
                el: '.display-page',
                data: {
                    pageInfo: {pageUrl: 'vue-crud'} ,
                    forms:new CrudForm({index:'',  id:'' , title:'' , sub_title:'' , description:''  }) ,
                    modal:new CrudModal({create:false , edit:false , delete:false }),
                    pagination: new Pagination({total: 0, per_page: 2, from: 1,to: 0, current_page: 1 , last_page: 1, offset: 4}),
                    formErrors:{},
                    displayItems:[] ,
                    selectedItems:[] ,
                    submitSelectedItems:[] ,
                    errors: new Errors() ,
                    filter: ''
                },
                mounted: function () {

                        this.pagination.set('per_page' , 5);
                        this.loadPage(this.pagination.pagination.current_page);



             } ,
        filters: {
            uppercase: function(value, onlyFirstCharacter) {
                if (!value) {
                    return '';
                }

                value = value.toString();

                if (onlyFirstCharacter) {
                    return value.charAt(0).toUpperCase() + value.slice(1);
                } else {
                    return value.toUpperCase();
                }
            }
        } ,
        methods: {
            editLink(id){
                return this.pageInfo.pageUrl + '/' + id + '/edit';
            } ,
            loadPage: function (page) {
                new LoadPage(this.pageInfo.pageUrl + '/load-display?page=' + page);
            } ,
            link_to(page , value_page ){
                return  this.pageInfo.pageUrl +  '/' + page + '/' + value_page;
            } ,
            createItem() {
                this.forms.reset();
                this.errors.clearAll();
                this.modal.set('create', true);
            } ,
            storeItem() {
                let data =  this.forms.data();
                return  new StoreItem(this.pageInfo.pageUrl + '/store' , data );
            } ,
            editItem(item ,index = this.displayItems.indexOf(item)){
                this.forms.setFillItem(item , index );
                this.errors.clearAll();
                this.modal.set('edit', true);
            } ,
            updateItem() {
                let data  =  this.forms.data();
                return  new UpdateItem(this.pageInfo.pageUrl + '/update' , data);
            } ,
            deleteItem(item , index = this.displayItems.indexOf(item)){
                /*this.setFillItem(item , index); */
                this.submitSelectedItems = [{index: index, id:item.id}];
                this.modal.set('delete', true);
            } ,
            deleteManyItems(){

                let deleteItemsInfo = [];
                for (var prop in this.selectedItems) {
                    let  selectedIndex = this.selectedItems[prop];

                    deleteItemsInfo.unshift({ index: selectedIndex, id:this.displayItems[selectedIndex]['id']});
                }

                this.submitSelectedItems = deleteItemsInfo;
                this.modal.set('delete', true);

            } ,
            destroyItem(item){
                return  new DestroyItem(this.pageInfo.pageUrl + '/delete' , item );

            } ,
            setNewValuesDisplay(value){

                for (let prop in value)
                {

                    this.displayItems.unshift(value[prop]);
                }


            } ,

            setNewItemDisplay(fillItem){


                for (var prop in fillItem) {

                    this.displayItems[fillItem.index][prop]        =     fillItem[prop];

                }

            } ,

            selectAll(){
                var selectall = this.toggleAll;

                if (!selectall) {

                    this.selectedItems = [];
                    for (var prop in this.displayItems) {

                        this.selectedItems.push(prop);
                    }
                }else{

                    this.selectedItems = [];
                }



            } ,

            countAggregate(value){

                if(typeof value != "undefined" && value != null && value.length > 0){
                    return value[0]['aggregate'];
                }

                return 0;

            } ,
            makeThumbExtension(image){
                let thumbImage = (image).split('.');
                return  thumbImage[0] + '_thumb.' + thumbImage[1];

            }
        } ,  computed: {
            pagesNumber(){

                if (!this.pagination.get('to')) {
                    return [];
                }


                var from = this.pagination.get('current_page') - this.pagination.get('offset');
                if (from < 1) {
                    from = 1;
                }
                var to = from + (this.pagination.get('offset') * 2);
                if (to >= this.pagination.get('last_page')) {
                    to = this.pagination.get('last_page');
                }
                var pagesArray = [];
                while (from <= to) {
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;
            } ,
            toggleAll() {
                return this.selectedItems.length == this.displayItems.length
            }

        } ,
        created(){

            eventBus.$on('formDataLoaded' , (item) => {

                        this.formOptions.setFillItem(item);
                });

                    window.eventBus.$on('dataLoaded',  (item) => {
                    this.displayItems = item.data.data;
                    this.pagination.loadData(item.pagination);


                });

                    window.eventBus.$on('createItem' ,  (item) => {

                        // hide modal
                        this.modal.set('create', false);

                    // get all fields dinamic from request
                    this.setNewValuesDisplay(item);

                    /* this.pagination.changePageStatus('add' , 1); */

                    new FlashMessage('success' , 'Item Created');

                });


                    window.eventBus.$on('statusModal' , (item) => {
                        this[item.modal] = item.status;
                });



                    window.eventBus.$on('updatePage' , (page) => {
                        this.loadPage(page);
                });


                    window.eventBus.$on('updateItem' , (data) => {

                        // set new value item
                        /* this.setNewItemDisplay(data); */

                        for (var prop in data) {
                        this.displayItems[data.index][prop]        =     data[prop];
                    }
                    // hide modal
                    this.modal.set('edit', false);

                });


                    window.eventBus.$on('deleteItem' , (data) => {


                        let count = 0;
                    for (var prop in data.index)
                    {
                        this.displayItems.splice(data.index[prop], 1);
                        count ++;
                    }
                    // set pagination
                    this.pagination.changePageStatus('remove' , count);

                    this.selectedItems = [];
                    this.submitSelectedItems = [];
                    // hide modal
                    this.modal.set('delete', false);

                });


                    window.eventBus.$on('formError' , (data) => {

                        this.errors.record(data);

                        console.log(this.errors);

                        console.log(this.errors.get('title'));

                });




        }



            });



        </script>

@stop




