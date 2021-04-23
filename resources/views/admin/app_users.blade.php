@extends('admin.layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" ng-app="userApp" ng-controller="userController">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">App. Users Section</li>
        </ol>
        </section>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="col-sm-6" id="search_div">
                    <button type="button" class="btn btn-success" id="search_button"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp; Search</button><input type="text" id="search" placeholder="&nbsp; Seach By Any.." ng-model="search">
                </div>
                <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;"></div>
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
                        <th>Name</th>
                        <th>Email Id</th>
                        <th>Phone Number</th>
                        <th>Image</th>
                        <th>Gender</th>
                        <th>City</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody ng-repeat ="user in userData | filter:search">
                    <tr>
                        <td>@{{$index+1}}</td>
                        <td>@{{user.name}}</td>
                        <td>@{{user.email_id}}</td>
                        <td>@{{user.phone_number}}</td>
                        <td><img ng-src = "@{{imageBaseUrl}}@{{user.image}}" style="width:60px; border:1px solid black;"></td>
                        <td>@{{user.gender}}</td>
                        <td>@{{user.city}}</td>
                        <td>@{{user.created_at|limitTo:10}}</td>
                        <td>
                            <button type="button" class="btn btn-danger" data-toggle="tooltip" title="Disable this User"  ng-click="delete(user)" data-placement="top"><a href="" ><i class="fa fa-trash" style="font-size:16px;color:white" aria-hidden="true"></i></a></button>

                            <button type="button" class="btn btn-primary" ng-click="deliveryAddress(user)"><a href=""  ><i class="fa fa-motorcycle" style="font-size:16px;color:white" aria-hidden="true"></i></a></button> 

                            <button type="button" class="btn btn-info" ng-click="userFeedbacks(user)"><a href=""  ><i class="fa fa-commenting-o" style="font-size:16px;color:white" aria-hidden="true"></i></a></button>

                            <button type="button" class="btn btn-success"  ng-click="userTransaction(user)"><a href="" ><i class="fa fa-book" style="font-size:16px;color:white" aria-hidden="true"></i></a></button> 
                        </td>
                    </tr>
                </tbody> 
            </table>
        </section>    
        <!-- /.content -->
        <!-- Delete user -->
		<div class="modal fade" id="detete_user" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want to Disable this user</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" ng-click="deleteUser()">Delete</button>
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!--/Delete User -->
        <!-- user Delivery address -->
		<div class="modal fade" id="delivery_address" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">All delivery address of this user</h4>
                    </div>
                    <!-- add delivery address here will show -->
                    <div class="row">
                        <div class="col-sm-11">
                            <div class="address">
                                <div class="form-group" ng-repeat="address in userAddress">
                                    <label for="comment">Address : @{{$index+1}}</label>
                                    <textarea class="form-control" rows="4" id="comment" disabled>@{{address.dlvry_address}}</textarea>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!--/ User delivery address -->
        <!-- transactions -->
		<div class="modal fade" id="transections" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content" id="transections_content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" style="text-align:center;">All transactions of this user</h4>
                    </div>
                    <!-- search bar -->
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="col-sm-6" id="search_div">
                                <button type="button" class="btn btn-success" id="search_button"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp; Search</button><input type="text" id="search" placeholder="&nbsp; Seach By Any.." ng-model="search_transaction">
                            </div>
                        </div>
                    </div>
                    <!--/ search bar -->
                    <!-- all transaction show -->
                    <div class="row">
                        <div class="col-sm-11" id="transaction_column">
                            <!-- get all transections -->
                            <div class="tractions">
                                <!-- Main content -->
                                <section class="content" >
                                    <table id="categories"  datatable="ng" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Order Id</th>
                                                <th>Amount</th>
                                                <th>Status</th>
                                                <th>Promo Code</th>
                                                <th>Delivery Address</th>
                                                <th>Delivery Status</th>
                                                <th>Transaction At</th>
                                            </tr>
                                        </thead>
                                        <tbody ng-repeat ="transaction in userTransactions | filter:search_transaction">
                                            <tr>
                                                <td>@{{$index+1}}</td>
                                                <td>@{{transaction.order_id}}</td>
                                                <td>@{{transaction.amount}}</td>
                                                <td>@{{transaction.status}}</td>
                                                <td>@{{transaction.promo_code}}</td>
                                                <td>@{{transaction.dlvry_address}}</td>
                                                <td></td>
                                                <td>@{{transaction.created_at|limitTo:10}}</td>
                                            </tr>
                                        </tbody> 
                                    </table>
                                </section>    
                                <!-- /.content -->
                            </div>
                        </div>    
                    </div>
                    <div class="modal-footer">
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!--/ transactions -->
        <!-- user Feedbacks -->
		<div class="modal fade" id="feedbacks" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">All feedbacks of this user</h4>
                    </div>
                    <!-- feedbacks here will show -->
                    <div class="row">
                        <div class="col-sm-11">
                            <div class="address">
                                <div class="form-group" ng-repeat="feedback in feedbacks">
                                    <label for="comment">Feedback : @{{$index+1}}</label>
                                    <textarea class="form-control" rows="4" id="comment" disabled>@{{feedback.feedbacks}}</textarea>
                                </div>
                            </div>    
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- feedbackss -->
    </div>
@endsection
@section('script')
 

<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
    var usersApp = angular.module("userApp",[]);
    usersApp.controller("userController",function($scope, $http) {
        // users listing   
       // $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('order', [0, 'asc']);
		
        $scope.userData = [];
        $scope.getRequest = function() {
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/get-user-data").then(response =>{
                $scope.userData = response.data.data.userdata;
                $scope.imageBaseUrl = response.data.data.image_base_url;
            }).catch(error => {
                console.log(error);
            });
        };
        $scope.getRequest();
         
        // delete category
		$scope.delete = function(data){
            $scope.updateData = data;
            $('#detete_user').modal('show');
		}
        $scope.deleteUser = function() {
            var reqData={
                id:$scope.updateData.id.toString(),
            }
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/delete-user",reqData).then(response =>{
                $scope.getRequest();
                $('#detete_user').modal('hide');
            }).catch(error => {
                console.log(error);
            });
        };
        // get user delivery address
        $scope.deliveryAddress = function(data){
            $scope.getData = data;
            var reqData={
                user_id:$scope.getData.id.toString(),
            }
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/get-user-delivery-address",reqData).then(response =>{
                //$scope.getRequest();
                $scope.userAddress = response.data.data.userdeliveryaddress; 
                $("#delivery_address").modal('show');
            }).catch(error => {
                console.log(error);
            });
        }
        // get user transactions
        $scope.userTransaction = function(data){
            $scope.getData = data;
            var reqData={
                user_id:$scope.getData.id.toString(),
            }
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/user-transactions",reqData).then(response =>{
                //$scope.getRequest();
                $scope.userTransactions = response.data.data.usertransactions; 
                $("#transections").modal('show');
            }).catch(error => {
                console.log(error);
            });
        }
        // get user feedback
        $scope.userFeedbacks = function(data){
            $scope.getData = data;
            var reqData={
                user_id:$scope.getData.id.toString(),
            }
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/user-feedbacks",reqData).then(response =>{
                //$scope.getRequest();
                $scope.feedbacks = response.data.data.userfeedbacks;
                $("#feedbacks").modal('show');
            }).catch(error => {
                console.log(error);
            });
        }
    });
</script>
  
@endsection	
 
