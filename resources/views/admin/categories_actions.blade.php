@extends('admin.layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" ng-app="categoryApp" ng-controller="categoryController">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Categories Section</li>
        </ol>
        </section>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="col-sm-6" id="search_div">
                    <button type="button" class="btn btn-success" id="search_button"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp; Search</button><input type="text" id="search" placeholder="&nbsp; Seach By Any.." ng-model="search">
                </div>
                <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">
                <a style="margin-top: 5px; padding: 10px 17px; float: right;b margin-right: 17px;"><button type="button" class="btn btn-primary" id="flip" href="" ng-click="addOpen()">Add More Categories</button></a>
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
                        <th>Categories</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody ng-repeat ="category in categoryData | filter:search">
                    <tr>
                        <td>@{{$index+1}}</td>
                        <td>@{{category.categories}}</td>
                        <td>@{{category.created_at|limitTo:10}}</td>
                        <td>
                            <button type="button" class="btn btn-success"><a href="" ng-click="update(category)"><i class="fa fa-pencil" style="font-size:16px;color:white" aria-hidden="true"></i></a></button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-danger"><a href=""  ng-click="deleteModel(category)"><i class="fa fa-trash" style="font-size:16px;color:white" aria-hidden="true"></i></a></button> 
                        </td>
                    </tr>
                </tbody> 
            </table>
        </section>    
        <!-- /.content -->
		 <!-- modal open for import file -->
   
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Do you want to Update</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Update Category</label>
                        <input type="text"  class="form-control" ng-model="updateData.categories"><br> 
                    </div>    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" ng-click="updatecategory()">Success</button>
                    {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="AddCategory" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Do you want to Add Category</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Add Category</label>
                        <input type="text" class="form-control" ng-model="Category"><br>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" ng-click="addcategory()">Success</button>
                    {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <!-- modal close -->
		<div class="modal fade" id="deteteCate" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want to Delete</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" ng-click="deleteCategory()">Delete</button>
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
   
@endsection
@section('script')

<script>
    var categoryApp = angular.module("categoryApp",[]);
    categoryApp.controller("categoryController",function($scope, $http) {
        // categories listing   
       //  $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('order', [0, 'asc']);
		
        $scope.categoryData = [];
        $scope.getRequest = function() {
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/get-categories").then(response =>{
                $scope.categoryData = response.data.data.categories;
            }).catch(error => {
                console.log(error);
            });
        };
        $scope.getRequest();

		// update category
        $scope.update = function(data){
            $scope.updateData = data;
            $('#myModal').modal('show');
        }
        $scope.updatecategory = function() {
            var reqData={
                id:$scope.updateData.id,
                categories:$scope.updateData.categories
            }
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/add-update",reqData).then(response =>{
            $('#myModal').modal('hide');
            }).catch(error => {
                console.log(error);
            });
        };
		
        // delete category
		$scope.deleteModel = function(data){
            $scope.updateData = data;
            $('#deteteCate').modal('show');
		}
        $scope.deleteCategory = function() {
            var reqData={
                id:$scope.updateData.id.toString(),
            }
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/delete-category",reqData).then(response =>{
                $scope.getRequest();
                $('#deteteCate').modal('hide');

            }).catch(error => {
                console.log(error);
            });
        };
        // add category
        $scope.addOpen = function() {
            $scope.Category="";
            $('#AddCategory').modal('show');
        }
        $scope.addcategory = function() {
            var reqData={
                categories:$scope.Category
            }
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/add-update",reqData).then(response =>{
                $scope.getRequest();
                $('#AddCategory').modal('hide');

            }).catch(error => {
                console.log(error);
            });
        };
		
    });
</script>
@endsection	
 
