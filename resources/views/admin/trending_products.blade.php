@extends('admin.layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" ng-app="trendingApp" ng-controller="trendingController">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Trending Products Section</li>
        </ol>
        </section>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="col-sm-6" id="search_div">
                    <button type="button" class="btn btn-success" id="search_button"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp; Search</button><input type="text" id="search" placeholder="&nbsp; Seach By Any.." ng-model="search">
                </div>
                <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">
                <a style="margin-top: 5px; padding: 10px 17px; float: right;b margin-right: 17px; @{{css}}" ><button type="button" class="btn btn-primary" id="flip" href="" ng-click="addOpen()" >Add More Trending Products</button></a>
                </div>
            </div>
        </div>
        <div class="row">
        </div>
        <!-- view list of agents -->
        <!-- Main content -->
        <section class="content" >
            <table id="categories"  datatable="ng" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Products</th>
                        <th>MRP</th>
                        <th>Big Basket Price/Rs</th>
                        <th>Rujooal Price/Rs</th>
                        <th>weight</th>
                        <th>Unit</th>
                        <th>Product Image</th>
                        <th>Priority</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody ng-repeat ="trendingProduct in trendingData | orderBy:'priority' | filter:search">
                    <tr>
                        <td>@{{$index+1}}</td>
                        <td>@{{trendingProduct[0].trending_products.products}}</td>
                        <td>@{{trendingProduct[0].trending_products.mrp}}</td>
                        <td>@{{trendingProduct[0].trending_products.big_basket_mrp}}</td>
                        <td>@{{trendingProduct[0].trending_products.rujooal_price}}</td>
                        <td>@{{trendingProduct[0].trending_products.weight}}</td>
                        <td>@{{trendingProduct[0].trending_products.unit}}</td>
                        <td><img ng-src = "@{{baseUrl}}@{{trendingProduct[0].trending_products.product_image}}" style="width:60px; border:1px solid black;"> </td>
                        <!-- @{{base_url+'/'+trendingProduct[0].trending_products.product_image}} -->
                        <td>@{{trendingProduct[0].priority}}</td>
						
                        <!-- <td>@{{trendingProduct.created_at|limitTo:10}}</td> -->
                        <td>
                            <button type="button" class="btn btn-success"><a href="" ng-click="updateModal(trendingProduct)"><i class="fa fa-pencil" style="font-size:16px;color:white" aria-hidden="true"></i></a></button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-danger"><a href=""  ng-click="deleteModal(trendingProduct)"><i class="fa fa-trash" style="font-size:16px;color:white" aria-hidden="true"></i></a></button> 
                        </td>
                    </tr>
                </tbody> 
            </table>
        </section>    
        <!-- /.content -->
        <!-- add brand modal -->
        <div class="modal fade" id="AddTrendingProduct" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want to set Priority</h4>
                    </div>
                    <div class="modal-body">
                        <select ng-model = "ProductId" >
                            <option value = "" label = "Please Select Products"></option>
                            <option ng-repeat ="product in ProductData" value="@{{product.id}}">
                                @{{product.products}}
                            </option>
                        </select>
                        <select ng-model = "priority" >
                            <option value = "" label = "Please Select Priority"></option>
                            <option  value="1">1</option>
                            <option  value="2">2</option>
                            <option  value="3">3</option>
                            <option  value="4">4</option>
                            <option  value="5">5</option>
                        </select>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" ng-click="addproduct()">Submit</button>
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="updateModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want to Update</h4>
                    </div>
                    <div class="modal-body">
                        <select ng-model = "ProductId" >
                            <option value = "" label = "Please Select Products"></option>
                            <option ng-repeat ="product in ProductData" ng-selected="product.id == updateData[0].product_id" value="@{{product.id}}">
                                @{{product.products}}
                            </option>
                        </select>
                        <select ng-model = "priority" >
                            <option  value = "" label = "Please Select Priority"></option>
                            <option  value="1" ng-selected="1 == updateData[0].priority">1</option>
                            <option  value="2" ng-selected="2 == updateData[0].priority">2</option>
                            <option  value="3" ng-selected="3 == updateData[0].priority">3</option>
                            <option  value="4" ng-selected="4 == updateData[0].priority">4</option>
                            <option  value="5" ng-selected="5 == updateData[0].priority">5</option>
                        </select>
                        <br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" ng-click="updateProduct()">Update</button>
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!--/ update Modal  -->
        <!--delete Modal  -->
        <div class="modal fade" id="deteteProduct" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Do you want to Delete</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" ng-click="deleteProduct()">Delete</button>
                    {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
        <!--/delete Modal -->
    </div>
@endsection 
@section('script') 

<script>
    var trendingApp = angular.module("trendingApp",[]);//'datatables'
    trendingApp.controller("trendingController",function($scope, $http){ //,DTOptionsBuilder
        // Brand Listing
        $scope.baseUrl  = "http://www.projects.estateahead.com/stock_inventory_mgt/storage/app/public/"
        //$scope.dtOptions = DTOptionsBuilder.newOptions().withOption('order', [0, 'asc']);
        $scope.trendingData = [];
        $scope.getRequest = function() {
            $http.get("http://www.projects.estateahead.com/stock_inventory_mgt/api/get-trendings-product").then(response =>{
                $scope.trendingData = response.data.data;
                $scope.base_url = response.data.base_url;
               
                if($scope.trendingData.length == 5){
                    $scope.css = 'display: none;'
                }else{
                    $scope.css = 'display: block;'
                }
                // console.log($scope.base_url);
            }).catch(error => {
                console.log(error);
            });
        };
        $scope.getRequest();
        //all products for dropdown
        $scope.ProductData = [];
        $scope.getProducts = function() {
            $http.get("http://www.projects.estateahead.com/stock_inventory_mgt/api/get-products").then(response =>{
                $scope.ProductData = response.data.data.products;
                //console.log($scope.ProductData);
            }).catch(error => {
                console.log(error);
            });
        };
        $scope.getProducts();
        // open add brand modal
        $scope.addOpen = function() {
            $scope.priority="";
            $scope.ProductId ="";
            $('#AddTrendingProduct').modal('show');
        }
        // add tranding product
        $scope.addproduct = function() {
            var reqData={
                priority:$scope.priority,
                product_id:$scope.ProductId
            }
            //console.log(reqData);
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/add-update-trending-product",reqData).then(response =>{
                $scope.getRequest();
                $('#AddTrendingProduct').modal('hide');

            }).catch(error => {
                console.log(error);
            });
        };
        // Open update modal
        $scope.updateModal = function(data){
            $scope.updateData = data;
            $scope.product_id = $scope.updateData[0].product_id;
            //console.log($scope.updateData[0]);
            $('#updateModal').modal('show');
        }
        //update data
        $scope.updateProduct = function() {
            var reqData={
                id:$scope.updateData[0].id,
                product_id:$scope.ProductId,
                priority:$scope.priority
            }
            console.log(reqData);
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/add-update-trending-product",reqData).then(response =>{
            $('#updateModal').modal('hide');
            }).catch(error => {
                console.log(error);
            });
        };
        // delete modal
        $scope.deleteModal = function(data){
			$scope.DeleteData = data;
			$('#deteteProduct').modal('show');
		}
        // delete data
        $scope.deleteProduct = function() {
            var reqData={
                id:$scope.DeleteData[0].id.toString(),
            }
            console.log(reqData);
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/delete-trending-product",reqData).then(response =>{
                $scope.getRequest();
                $('#deteteProduct').modal('hide');
            }).catch(error => {
                console.log(error);
            });
        };
         
    });
</script>
@endsection  