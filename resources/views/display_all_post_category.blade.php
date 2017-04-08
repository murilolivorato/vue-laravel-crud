@extends('layout.admin')

@section('content')



    <div class="container-fluid display-page" id="display-post-category" >

        <!-- @create Modal--->
        <modal  v-if="modal.get('create')" @close="modal.set('create', false)" >
        <template slot="header" ><h4>Criar Categoria de Notícia</h4></template>
        <template slot="body" >
            <form method="POST" action="" @submit.prevent="storeItem()">
                <div class="modal-body">
                    <h5>Texto do Topo </h5>
                    <div class="form-group">
                        {!! Form::label('title', 'Título da Categoria') !!}
                        {!!  Form::text('title', '', array('class' => 'form-control border-input' , 'placeholder' => 'Título da Categoria' , 'v-model' => 'forms.title'  )) !!}

                        <span class="help is-danger" v-text="errors.get('title')"></span>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="modal.set('create', false)" >Fechar</button>
                    <button type="submit" class="btn btn-success">Criar</button>
                </div>
            </form>
        </template>
        </modal>


        <!-- @update --->
        <modal  v-if="modal.get('edit')" @close="modal.set('edit', false)"  >
        <template slot="header" ><h4>Editar Categoria de Notícia</h4></template>
        <template slot="body" >

            <form method="POST" action="" @submit.prevent="updateItem()">
                <div class="modal-body">
                    <h5>Texto do Topo </h5>
                    <div class="form-group">
                        {!! Form::label('title', 'Título da Categoria') !!}
                        {!!  Form::text('title', '', array('class' => 'form-control border-input' , 'placeholder' => 'Título da Categoria' ,  'v-model' => 'forms.title'  )) !!}

                        <span class="help is-danger" v-text="errors.get('title')"></span>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="modal.set('edit', false)" >Fechar</button>
                    <button type="submit" class="btn btn-success">Editar</button>
                </div>
            </form>
        </template>
        </modal>


        <!-- @delete --->
        <modal  v-if="modal.get('delete')" @close="modal.set('delete', false)"  >
        <template slot="header" ><h4>Deletar Categoria de Notícia</h4></template>
        <template slot="body" >

            <form method="POST" action="" @submit.prevent="destroyItem( submitSelectedItems )">
                <div class="modal-body">
                    <p>Tem Certeza que deseja deletar esta Categoria ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" @click="modal.set('delete', false)" >Fechar</button>
                    <button type="submit" class="btn btn-success">Deletar</button>
                </div>
            </form>
        </template>
        </modal>





        <div class="row" >

            <div class="col-md-7">


                @include('admin/posts/sub_nav')


            </div>

            <div class="col-md-5">


                <ul class="list_right_menu_top">
                    <li><a href="#" type="button" class="delete-item-all-btn btn btn-primary btn pull-right "  @click="deleteManyItems()" >Deletar</a></li>
                    <li> <a href="#" class="btn-primary btn pull-right "  @click="createItem()" >Criar Categoria de Notícias</a></li>
                </ul>

            </div>



            <div class="col-md-12">
                <div class="card">



                    <div class="header">
                        <h4 class="title">Categoria de Notícias</h4>
                        <p class="total_row_values"><span>Total de</span> <span class="total_row_number" id="total_row_number"> </span> <span>Categorias</span> </p>
                    </div>

                    @{{  message }}

                            <!-- content -->
                    <div class="content table-responsive table-full-width" id="display"   >
                        <table class="table  table-striped">
                            <thead>
                            <th>ID</th>
                            <th>
                                <label class="checkbox checkbox-blue" >
                                    {!!   Form::checkbox('chkSelectAll', ''  , false , ['v-model' => 'toggleAll' , '@click' => 'selectAll' ])  !!}

                                </label>
                            </th>
                            <th>Catgeroria de Notiícia</th>
                            <th>Notícias nesta Categoria</th>
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

                                <td>
                                    @{{  countAggregate(item.count_products)  }}
                                </td>

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




