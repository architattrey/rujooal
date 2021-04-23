@extends('admin.layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" ng-app="brandApp" ng-controller="brandController">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Brands Section</li>
        </ol>
        </section>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="col-sm-6" id="search_div">
                    <button type="button" class="btn btn-success" id="search_button"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp; Search</button><input type="text" id="search" placeholder="&nbsp; Seach By Any.." ng-model="search">
                </div>
                <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">
                <a style="margin-top: 5px; padding: 10px 17px; float: right;b margin-right: 17px;"><button type="button" class="btn btn-primary" id="flip" href="" ng-click="addOpen()">Add More Brands</button></a>
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
                        <th>Brands</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody ng-repeat ="brand in brandData | filter:search">
                    <tr>
                        <td>@{{$index+1}}</td>
                        <td>@{{brand.brand_name}}</td>
                        <td>@{{brand.created_at|limitTo:10}}</td>
                        <td>
                            <button type="button" class="btn btn-success"><a href="" ng-click="update(brand)"><i class="fa fa-pencil" style="font-size:16px;color:white" aria-hidden="true"></i></a></button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-danger"><a href=""  ng-click="deleteModel(brand)"><i class="fa fa-trash" style="font-size:16px;color:white" aria-hidden="true"></i></a></button> 
                        </td>
                    </tr>
                </tbody> 
            </table>
        </section>    
        <!-- /.content -->
        <!-- add brand modal -->

        <div class="modal fade" id="Addbrands" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want to Add Brand</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Select Category</label>
                            <select ng-model = "CategoryId" class="form-control">
                                <option value = "" label = "Please Select Category"></option>
                                <option ng-repeat ="category in categoryData" value="@{{category.id}}">
                                    @{{category.categories}}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Add Brand</label>    
                            <input type="text" ng-model="Brand" class="form-control"><br>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" ng-click="addBrand()">Submit</button>
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!--/add brand modal -->
        <!-- update Modal -->
        <div class="modal fade" id="updateModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want to Update</h4>
                    </div>
                    <div class="modal-body">
                        <select ng-model = "CategoryId" >
                            <option value="" label = "Please Select Category"></option>
                            <option ng-repeat ="category in categoryData" value="@{{category.id}}" ng-selected="category.id == updateData.cat_id">
                                @{{category.categories}}
                            </option>
                        </select>
                    <input type="text" ng-model="updateData.brand_name"><br>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" ng-click="updateBrand()">Update</button>
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!--/ update Modal  -->
        <!--delete Modal  -->
        <div class="modal fade" id="deteteBrand" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Do you want to Delete</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" ng-click="deleteBrand()">Delete</button>
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
    var brandApp = angular.module("brandApp",[]);
    brandApp.controller("brandController",function($scope, $http){
        // Brand Listing
        //$scope.dtOptions = DTOptionsBuilder.newOptions().withOption('order', [0, 'asc']);
        $scope.brandData = [];
        $scope.getRequest = function() {
            $http.get("http://www.projects.estateahead.com/stock_inventory_mgt/api/get-brands").then(response =>{
                $scope.brandData = response.data.data.brands;
            }).catch(error => {
                console.log(error);
            });
        };
        $scope.getRequest();

        // all categories for dropdown
        $scope.categoryData = [];
        $scope.getCategory = function() {
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/get-categories").then(response =>{
                $scope.categoryData = response.data.data.categories;
                //console.log($scope.categoryData);
            }).catch(error => {
                console.log(error);
            });
        };
        $scope.getCategory();
        // open add brand modal
        $scope.addOpen = function() {
            $scope.Brand="";
            $scope.CategoryId ="";
            $('#Addbrands').modal('show');
        } 
        // add brand
        $scope.addBrand = function() {
            var reqData={
                brand_name:$scope.Brand,
                cat_id:$scope.CategoryId
            }
            //console.log(reqData);
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/add-update-brand",reqData).then(response =>{
                $scope.getRequest();
                $('#Addbrands').modal('hide');

            }).catch(error => {
                console.log(error);
            });
        };
        // Open update modal
        $scope.update = function(data){
            $scope.updateData = data;
            $scope.CategoryId = $scope.updateData.cat_id
            $('#updateModal').modal('show');
        }
        //update data
        $scope.updateBrand = function() {
            var reqData={
                id:$scope.updateData.id,
                cat_id:$scope.CategoryId,
                brand_name:$scope.updateData.brand_name
            }
            //console.log(reqData);
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/add-update-brand",reqData).then(response =>{
            $('#updateModal').modal('hide');
            }).catch(error => {
                console.log(error);
            });
        };
        // delete modal
        $scope.deleteModel = function(data){
			$scope.DeleteData = data;
			$('#deteteBrand').modal('show');
		}
        // delete data
        $scope.deleteBrand = function() {
            var reqData={
                id:$scope.DeleteData.id.toString(),
            }
            //console.log(reqData);
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/delete-brand",reqData).then(response =>{
                $scope.getRequest();
                $('#deteteBrand').modal('hide');
            }).catch(error => {
                console.log(error);
            });
        };
    });
</script>
@endsection