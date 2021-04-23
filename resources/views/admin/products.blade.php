@extends('admin.layouts.app')

@section('content')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" ng-app="productApp" ng-controller="productController">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Products</li>
        </ol>
    </section>
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="col-sm-6" id="search_div">
                <button type="button" class="btn btn-success" id="search_button"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp; Search</button><input type="text" id="search" placeholder="&nbsp; Seach By Any.." ng-model="search">
            </div>
            <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">
           
               @if((Auth::User()->role == 1))
                <a style="margin-top: 5px; padding: 10px 17px; float: right;b margin-right: 17px;" href="#"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-file-excel-o" aria-hidden="true"></i> &nbsp; Emport xls file</button></a>
                @endif

                <a style="margin-top: 5px; padding: 10px 17px; float: right;margin-right: 17px;"><button type="button" class="btn btn-primary" id="flip" href="" ng-click="addOpen()">Add More Products</button></a>
            </div>
        </div>
    </div>
    <div class="row">
    </div>
    <!-- view list of agents -->
    <!-- Main content -->
    <section class="content">
        <table id="categories" datatable="ng" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th width="2%">#</th>
                    <th width="10%">Products</th>
                    <th width="5%">MRP</th>
                    <th width="14%">Big Basket Price/Rs</th>
                    <th width="12%">Rujooal Price/Rs</th>
                    <th width="7%">weight</th>
                    <th width="5%">Unit</th>
                    <th width="10%">Product Image</th>
                    <th width="5%">stock</th>
                    <th width="10%">Action</th>
                </tr>
            </thead>
            <tbody ng-repeat="product in ProductData |filter:search">
                    <tr>
                        <td>@{{$index+1}}</td>
                        <td>@{{product.products}}</td>
                        <td>@{{product.mrp}}</td>
                        <td>@{{product.big_basket_mrp}}</td>
                        <td>@{{product.rujooal_price}}</td>
                        <td>@{{product.weight}}</td>
                        <td>@{{product.unit}}</td>
                        <td><img ng-src = "@{{baseUrl}}@{{product.product_image}}" style="width:60px; border:1px solid black;"> </td>
                <!-- @{{base_url+'/'+trendingProduct[0].trending_products.product_image}} -->
                <td>@{{product.stock}}</td>

                <!-- <td>@{{trendingProduct.created_at|limitTo:10}}</td> -->
                <td>
                    <button type=" button" class="btn btn-success"><a href="" ng-click="updateModal(product)"><i
                        class="fa fa-pencil" style="font-size:16px;color:white"
                        aria-hidden="true"></i></a></button>&nbsp;&nbsp;
                <button type="button" class="btn btn-danger"><a href="" ng-click="deleteModal(product)"><i
                            class="fa fa-trash" style="font-size:16px;color:white" aria-hidden="true"></i></a></button>
                </td>
                </tr>
            </tbody>
        </table>
    </section>
    <!-- /.content -->
    <!-- add product modal -->
    <div class="modal fade" id="AddProduct" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" id="product_content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Do you want add product</h4>
                </div>
                <div class="modal-body">
                    <!-- row strat -->
                    <div class="row">
                        <!-- column 6 -->
                        <div class="col-sm-6">
                            <!-- category id -->
                            <div class="form-group">
                                <label for="category">Select Category</label>
                                <select ng-model="catId" class="form-control">
                                    <option value="" label="Please Select Category"></option>
                                    <option ng-repeat="category in categoryData" value="@{{category.id}}">
                                        @{{category.categories}}
                                    </option>
                                </select>
                            </div>
                            <!-- Product name  -->
                            <div class="form-group">
                                <label for="">Product Name</label>
                                <input type="text" class="form-control" ng-model="product"
                                    placeholder="Enter Product Name">
                            </div>
                            <!-- Big basket Price -->
                            <div class="form-group">
                                <label for="">Big basket Price</label>
                                <input type="number" class="form-control" ng-model="bigBasketMrp"
                                    placeholder="Enter Big Basket Price">
                            </div>
                            <!-- Weight -->
                            <div class="form-group">
                                <label for="">Weight</label>
                                <input type="number" class="form-control" ng-model="weight"
                                    placeholder="Enter Product weight">
                            </div>
                            <!-- Product Image -->
                            <div class="form-group">
                                <label for="">Product Image</label>
                                <input type="file" class="form-control" id="product_image" accept="image/*" 
                                    onchange="angular.element(this).scope().uploadedFile(this)"
                                    placeholder="Select Product Image" /><br>
                            </div>
                            <img ng-src="@{{baseUrl}}@{{productImage}}" style="width:164px; height:146px;" />

                        </div>
                        <!--/column 6  -->
                        <!--column 6  -->
                        <div class="col-sm-6">
                            <!-- brand id -->
                            <div class="form-group">
                                <label for="brand">Select Brand</label>
                                <select ng-model="brandId" class="form-control">
                                    <option value="" label="Please Select Brand"></option>
                                    <option ng-repeat="brand in brandData" value="@{{brand.id}}">
                                        @{{brand.brand_name}}
                                    </option>
                                </select>
                            </div>
                            <!-- Product MRP -->
                            <div class="form-group">
                                <label for="">MRP</label>
                                <input type="number" class="form-control" ng-model="mrp"
                                    placeholder="Enter Product MRP">
                            </div>
                            <!-- Rujoal Price -->
                            <div class="form-group">
                                <label for="">Rujoal Price</label>
                                <input type="number" class="form-control" ng-model="rujoalPrice"
                                    placeholder="Enter Rujoal Price">
                            </div>
                            <!-- Unit -->
                            <div class="form-group">
                                <label for="">Unit</label>
                                <select class="form-control" ng-model="unit">
                                    <option value="" label="Please Select Unit"></option>
                                    <option value="kg">Kg</option>
                                    <option value="gm">Gm</option>
                                    <option value="ltr">Ltr</option>
                                    <option value="pcs">Pcs</option>
                                </select>
                            </div>
                            <!-- Stock -->
                            <div class="form-group">
                                <label for="">Stock</label>
                                <input type="text" class="form-control" ng-model="stock" placeholder="Enter Stock">
                            </div>
                        </div>
                        <!--/column 6  -->
                        <!-- Description -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea class="form-control" class="form-control" ng-model="description" rows="3"
                                    id="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <!--/ row end -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" ng-click="addproduct()">Submit</button>
                    {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- update product modal -->
    <div class="modal fade" id="UpdateProduct" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content" id="product_content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Do you want update product</h4>
                </div>
                <div class="modal-body">
                    <!-- row strat -->
                    <div class="row">
                        <!-- column 6 -->
                        <div class="col-sm-6">
                            <!-- category id -->
                            <div class="form-group">
                                <label for="category">Select Category</label>
                                <select ng-model="catId" class="form-control">
                                    <option value="" label="Please Select Category"></option>
                                    <option ng-repeat="category in categoryData" value="@{{category.id}}">
                                        @{{category.categories}}
                                    </option>
                                </select>
                            </div>
                            <!-- Product name  -->
                            <div class="form-group">
                                <label for="">Product Name</label>
                                <input type="text" class="form-control" ng-model="product"
                                    placeholder="Enter Product Name">
                            </div>
                            <!-- Big basket Price -->
                            <div class="form-group">
                                <label for="">Big basket Price</label>
                                <input type="text" class="form-control" ng-model="bigBasketMrp"
                                    placeholder="Enter Big Basket Price">
                            </div>
                            <!-- Weight -->
                            <div class="form-group">
                                <label for="">Weight</label>
                                <input type="text" class="form-control" ng-model="weight"
                                    placeholder="Enter Product weight">
                            </div>
                            <!-- Product Image -->
                            <div class="form-group">
                                <label for="">Product Image</label>
                                <input type="file" class="form-control" id="product_image" accept="image/*" 
                                    onchange="angular.element(this).scope().uploadedFile(this)"
                                    placeholder="Select Product Image" /><br>
                            </div>
                            <img ng-src="@{{baseUrl}}@{{productImage}}" style="width:164px; height:146px;" />
                        </div>
                        <!--/column 6  -->
                        <!--column 6  -->
                        <div class="col-sm-6">
                            <!-- brand id -->
                            <div class="form-group">
                                <label for="brand">Select Brand</label>
                                <select ng-model="brandId" class="form-control">
                                    <option value="" label="Please Select Brand"></option>
                                    <option ng-repeat="brand in brandData" value="@{{brand.id}}">
                                        @{{brand.brand_name}}
                                    </option>
                                </select>
                            </div>
                            <!-- Product MRP -->
                            <div class="form-group">
                                <label for="">MRP</label>
                                <input type="text" class="form-control" ng-model="mrp" placeholder="Enter Product MRP">
                            </div>
                            <!-- Rujoal Price -->
                            <div class="form-group">
                                <label for="">Rujoal Price</label>
                                <input type="text" class="form-control" ng-model="rujoalPrice"
                                    placeholder="Enter Rujoal Price">
                            </div>
                            <!-- Unit -->
                            <div class="form-group">
                                <label for="">Unit</label>
                                <select class="form-control" ng-model="unit">
                                    <option value="" label="Please Select Unit"></option>
                                    <option value="kg">Kg</option>
                                    <option value="gm">Gm</option>
                                    <option value="ltr">Ltr</option>
                                    <option value="pcs">Pcs</option>
                                </select>
                            </div>
                            <!-- Stock -->
                            <div class="form-group">
                                <label for="">Stock</label>
                                <input type="text" class="form-control" ng-model="stock" placeholder="Enter Stock">
                            </div>
                        </div>
                        <!--/column 6  -->
                        <!-- Description -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="description">Description:</label>
                                <textarea class="form-control" class="form-control" ng-model="description" rows="3"
                                    id="description" placeholder="Add Some Description....."></textarea>
                            </div>
                        </div>
                    </div>
                    <!--/ row end -->

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" ng-click="updateproduct()">update</button>
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
    <!-- modal open for import file -->
   
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Import Bulk Data</h4>
                </div>
                <div class="modal-body">
                {!! Form::open(['url' => 'import-file','enctype'=>'multipart/form-data']) !!}
                    {{ Form::file('file',['class'=>'custom-file-input']) }}   
                </div>
                <div class="modal-footer">
                    {{ Form::submit('Submit',['class'=>'btn btn-success']) }}
                    {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- modal close -->
</div>
@endsection
@section('script')

<script>
    var productApp = angular.module("productApp", []);//'datatables'
    productApp.controller("productController", function ($scope, $http) {//, DTOptionsBuilder
        //products Listing
        //$scope.dtOptions = DTOptionsBuilder.newOptions().withOption('order', [0, 'asc']);

        // .directive('stringToNumber', function() {
        //     return {
        //         require: 'ngModel',
        //         link: function($scope, $element, $attrs, $ngModel) {
        //         $ngModel.$parsers.push(function(value) {
        //             return '' + value;
        //         });
        //         $ngModel.$formatters.push(function(value) {
        //             return parseFloat(value);
        //         });
        //         }
        //     };
        // });

        // all categories for dropdown
        $scope.categoryData = [];
        $scope.getCategory = function () {
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/get-categories").then(response => {
                $scope.categoryData = response.data.data.categories;
                //console.log($scope.categoryData);
            }).catch(error => {
                console.log(error);
            });
        };
        $scope.getCategory();

        // get brands for dropdown
        $scope.brandData = [];
        $scope.getRequest = function () {
            $http.get("http://www.projects.estateahead.com/stock_inventory_mgt/api/get-brands").then(response => {
                $scope.brandData = response.data.data.brands;
            }).catch(error => {
                console.log(error);
            });
        };
        $scope.getRequest();

        //all products
        $scope.ProductData = [];
        $scope.getProducts = function () {
            $http.get("http://www.projects.estateahead.com/stock_inventory_mgt/api/get-products").then(response => {
                $scope.ProductData = response.data.data.products;
                $scope.baseUrl = response.data.data.baseUrl;
                //console.log($scope.ProductData);
            }).catch(error => {
                console.log(error);
            });
        };
        $scope.getProducts();
        // open add brand modal
        $scope.addOpen = function () {
            $scope.catId = "";
            $scope.brandId = "";
            $scope.product = "";
            $scope.mrp = "";
            $scope.bigBasketMrp = "";
            $scope.rujoalPrice = "";
            $scope.weight = "";
            $scope.unit = "";
            $scope.stock = "";
            $scope.productImage = "";
            $scope.description = "";
            $('#AddProduct').modal('show');
        }
        // add product
        $scope.addproduct = function () {
            var reqData = {
                cat_id: $scope.catId,
                brand_id: $scope.brandId,
                products: $scope.product,
                mrp: $scope.mrp,
                big_basket_mrp: $scope.bigBasketMrp,
                rujooal_price: $scope.rujoalPrice,
                weight: $scope.weight,
                unit: $scope.unit,
                stock: $scope.stock,
                product_image: $scope.productImage,
                description: $scope.description,
            }
            console.log(reqData);
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/add-update-product", reqData).then(response => {
                $scope.getProducts();
                $('#AddProduct').modal('hide');

            }).catch(error => {
                console.log(error);
            });
        };
        // Open update modal
        $scope.updateModal = function (data) {
            $scope.updateData = data;
            console.log($scope.updateData);
            $scope.catId = $scope.updateData.cat_id;
            $scope.brandId = $scope.updateData.brand_id;
            $scope.product = $scope.updateData.products;
            $scope.mrp = $scope.updateData.mrp;
            $scope.bigBasketMrp = $scope.updateData.big_basket_mrp;
            $scope.rujoalPrice = $scope.updateData.rujooal_price;
            $scope.weight = $scope.updateData.weight;
            $scope.unit = $scope.updateData.unit;
            $scope.stock = $scope.updateData.stock;
            $scope.productImage = $scope.updateData.product_image;
            $scope.description = $scope.updateData.description;
            $('#UpdateProduct').modal('show');
        }
        // //update data
        $scope.updateproduct = function () {
            var reqData = {
                id: $scope.updateData.id,
                cat_id: $scope.catId,
                brand_id: $scope.brandId,
                products: $scope.product,
                mrp: $scope.mrp,
                big_basket_mrp: $scope.bigBasketMrp,
                rujooal_price: $scope.rujoalPrice,
                weight: $scope.weight,
                unit: $scope.unit,
                stock: $scope.stock,
                product_image: $scope.productImage,
                description: $scope.description
            }
            console.log(reqData);
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/add-update-product", reqData).then(response => {
                $scope.getProducts();
                $('#UpdateProduct').modal('hide');
            }).catch(error => {
                console.log(error);
            });
        };
        // delete modal
        $scope.deleteModal = function (data) {
            $scope.DeleteData = data;
            $('#deteteProduct').modal('show');
        }
        // delete data
        $scope.deleteProduct = function () {
            var reqData = {
                id: $scope.DeleteData.id.toString(),
            }
            console.log(reqData);
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/delete-product", reqData).then(response => {
                $scope.getProducts();
                $('#deteteProduct').modal('hide');
            }).catch(error => {
                console.log(error);
            });
        };

        $scope.uploadFile = function (files) {
            //debugger;
            var file = files;
            //console.log(files);
            
            var uploadUrl = "http://www.projects.estateahead.com/stock_inventory_mgt/api/image-upload";
            //var fd = new FormData();
            // fd.append('product_image', file);
            $http.post(uploadUrl, {product_image: file})
            .then(res => {
                $scope.productImage = res.data.image_url;
                $scope.baseUrl = res.data.base_url;
            })
            .catch(err => {
                console.log(err)
            });
        };

        $scope.uploadedFile = function(element) {
		    $scope.currentFile = element.files[0];
		    var reader = new FileReader();

		    reader.onload = function(event) {
                $scope.productImage = event.target.result
                $scope.$apply(function($scope) {
                    $scope.files = element.files;
                    $scope.uploadFile(event.target.result);
                });
		    }
            reader.readAsDataURL(element.files[0]);
        }
    });        
</script>
@endsection