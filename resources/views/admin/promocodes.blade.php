@extends('admin.layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" ng-app="promocodeApp" ng-controller="promocodeController">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Promocode Section</li>
        </ol>
        </section>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="col-sm-6" id="search_div">
                    <button type="button" class="btn btn-success" id="search_button"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp; Search</button><input type="text" id="search" placeholder="&nbsp; Seach By Any.." ng-model="search">
                </div>
                <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">
                <a style="margin-top: 5px; padding: 10px 17px; float: right;b margin-right: 17px;"><button type="button" class="btn btn-primary" id="flip" href="" ng-click="addOpen()">Add More PromoCode</button></a>
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
                        <th>Promo Code</th>
                        <th>Image</th>
                        <th>Descount Amount</th>
                        <th>Descount In</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody ng-repeat ="promocode in promocodeData | filter:search">
                    <tr>
                        <td>@{{$index+1}}</td>
                        <td>@{{promocode.promocode}}</td>
                        <td> <img ng-src="@{{baseUrl}}@{{promocode.image}}" style="width:83px; height:56px;"/> </td>
                        <td>@{{promocode.discount_amount}}</td>
                        <td >
							<span ng-show="promocode.discount_in == '1'">Rs</span>
							<span ng-show="promocode.discount_in == '2'">%</span>
						</td>
                        <td>@{{promocode.created_at|limitTo:10}}</td>
                        <td>
                            <button type="button" class="btn btn-success"><a href="" ng-click="update(promocode)"><i class="fa fa-pencil" style="font-size:16px;color:white" aria-hidden="true"></i></a></button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-danger"><a href=""  ng-click="delete(promocode)"><i class="fa fa-trash" style="font-size:16px;color:white" aria-hidden="true"></i></a></button> 
                        </td>
                    </tr>
                </tbody> 
            </table>
        </section>    
        <!-- /.content -->
        <!-- add modal -->
        <div class="modal fade" id="AddPromocode" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want to Add Promo Code</h4>
                    </div>
                    <div class="modal-body">
                        <!-- row start -->
                        <div class="row">
                            <!-- column start -->
                            <div class="col-sm-6">
                                <!-- Promocode -->
                                <div class="form-group">
                                    <label for="">Promo Code</label>
                                    <input type="text" class="form-control" ng-model="Promocode" placeholder="Enter Promo Code">
                                </div>
                                <!-- Description -->
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea class="form-control" class="form-control" ng-model="Desciption" rows="3" id="description"></textarea>
                                </div>
                                 <!-- discount in -->
                                <div class="form-group">
                                    <label for="">Discount Type</label>
                                    <select class="form-control" ng-model="DiscountIn">
                                        <option value="" label="Please Select Unit"></option>
                                        <option value="1">Rs</option>
                                        <option value="2">%</option>
                                    </select>
                                </div>
                            </div>
                            <!-- column end -->
                            <!-- column start -->
                            <div class="col-sm-6">
                                <!-- discount amount -->
                                <div class="form-group">
                                    <label for="">Discount Amount</label>
                                    <input type="text" class="form-control" ng-model="DiscountAmount" placeholder="Enter Promo Code">
                                </div>
                                <!-- image -->
                                <div class="form-group">
                                    <label for="">Promocode Image</label>
                                    <input type="file" class="form-control" id="promocode_image" accept="image/*" 
                                    onchange="angular.element(this).scope().uploadedFile(this)" placeholder="Select  Image"><br>
                                </div>
                                <img ng-src="@{{baseUrl}}@{{promocodeImage}}" style="width:164px; height:146px;"/>
                            </div>
                            <!-- column end -->
                        </div>
                        <!-- row end -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" ng-click="addpromocode()">Submit</button>
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!--/ add modal close -->
        <!-- Update Promocode -->
        <div class="modal fade" id="updatePromocode" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want to Update</h4>
                    </div>
                    <div class="modal-body">
                        <!-- row start -->
                        <div class="row">
                            <!-- column start -->
                            <div class="col-sm-6">
                                <!-- Promocode -->
                                <div class="form-group">
                                    <label for="">Promo Code</label>
                                    <input type="text" class="form-control" ng-model="Promocode" placeholder="Enter Promo Code">
                                </div>
                                <!-- Description -->
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea class="form-control" class="form-control" ng-model="Desciption" rows="3" id="description"></textarea>
                                </div>
                                 <!-- discount in -->
                                <div class="form-group">
                                    <label for="">Discount Type</label>
                                    <select class="form-control" ng-model="DiscountIn">
                                        <option value="" label="Please Select Unit"></option>
                                        <option value="1">Rs</option>
                                        <option value="2">%</option>
                                    </select>
                                </div>
                            </div>
                            <!-- column end -->
                            <!-- column start -->
                            <div class="col-sm-6">
                                <!-- discount amount -->
                                <div class="form-group">
                                    <label for="">Discount Amount</label>
                                    <input type="text" class="form-control" ng-model="DiscountAmount" placeholder="Enter Promo Code">
                                </div>
                                <!-- image -->
                                <div class="form-group">
                                    <label for="">Promocode Image</label>
                                    <input type="file" class="form-control" id="promocode_image" accept="image/*" 
                                    onchange="angular.element(this).scope().uploadedFile(this)" placeholder="Select  Image"><br>
                                </div>
                                <img ng-src="@{{baseUrl}}@{{promocodeImage}}" style="width:164px; height:146px;"/>
                            </div>
                            <!-- column end -->
                        </div>
                        <!-- row end -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" ng-click="updatecategory()">Success</button>
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!--/Update Promocode close  -->
		
        <!-- Delete Promocode -->
		<div class="modal fade" id="detete_promocode" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Do you want to Delete</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" ng-click="deletePromocode()">Delete</button>
                        {{ Form::button('Cancel',['class'=>'btn btn-default','data-dismiss'=>'modal']) }}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!--/Delete Promocode -->
    </div>
   
@endsection
@section('script')
 

<script>
    var promocodeApp = angular.module("promocodeApp",[]);//'datatables'
    promocodeApp.controller("promocodeController",function($scope, $http) {//,DTOptionsBuilder
        // promocode listing   
       // $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('order', [0, 'asc']);
		
        $scope.promocodeData = [];
        $scope.getRequest = function() {
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/get-promo-codes").then(response =>{
				$scope.promocodeData = [];
                $scope.promocodeData = response.data.data.promocodes;
                $scope.baseUrl = response.data.data.baseUrl;
            }).catch(error => {
                console.log(error);
            });
        };
        $scope.getRequest();
        // add promocode
        $scope.addOpen = function() {
            $scope.Promocode="";
            $scope.Desciption = "";
            $scope.promocodeImage ="";
            $scope.DiscountAmount ="";
            $scope.DiscountIn ="";
            $('#AddPromocode').modal('show');
        }
        $scope.addpromocode = function() {
            var reqData={
                promocode:$scope.Promocode, 
                desciption:$scope.Desciption,  
                image:$scope.promocodeImage,
                discount_amount:$scope.DiscountAmount,  
                discount_in:$scope.DiscountIn,
            }
            console.log(reqData);
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/add-update-promocode",reqData).then(response =>{
                $scope.getRequest();
                $('#AddPromocode').modal('hide');
            }).catch(error => {
                console.log(error);
            });
        };	

		// update promocode
        $scope.update = function(data){
            console.log(data.image);
            $scope.updateData = data;
            $scope.Promocode = data.promocode;
            $scope.Desciption = data.desciption;
            $scope.promocodeImage = data.image;
            $scope.DiscountAmount = data.discount_amount;
            $scope.DiscountIn = data.discount_in;
            $('#updatePromocode').modal('show');
        }
        $scope.updatecategory = function() {
            var reqData={
                id:$scope.updateData.id,
                promocode:$scope.Promocode, 
                desciption:$scope.Desciption,  
                image:$scope.promocodeImage,
                discount_amount:$scope.DiscountAmount,  
                discount_in:$scope.DiscountIn,
            }
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/add-update-promocode",reqData).then(response =>{
            $('#updatePromocode').modal('hide');
				$scope.getRequest();
            }).catch(error => {
                console.log(error);
            });
        };
        // delete category
		$scope.delete = function(data){
            $scope.updateData = data;
            $('#detete_promocode').modal('show');
		}
        $scope.deletePromocode = function() {
            var reqData={
                id:$scope.updateData.id.toString(),
            }
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/delete-promocode",reqData).then(response =>{
                $scope.getRequest();
                $('#detete_promocode').modal('hide');

            }).catch(error => {
                console.log(error);
            });
        };
        // promo code image upload
        // $scope.uploadFile = function (files) {
        //     //debugger;
        //     var file = files;
        //     var uploadUrl = "http://www.projects.estateahead.com/stock_inventory_mgt/api/promocode-image-upload";
        //     var fd = new FormData();
        //     fd.append('promocode_image', file);
        //     $http.post(uploadUrl, fd, {
        //         transformRequest: angular.identity,
        //         headers: { 'Content-Type': undefined }
        //     })
        //     .then(res => {
        //         $scope.Image = res.data.image_url;
        //     })
        //     .catch(err => {
        //         console.log(err)
        //     });
        // };

        // $scope.uploadedFile = function(element) {
		//     $scope.currentFile = element.files[0];
		//     var reader = new FileReader();

		//     reader.onload = function(event) {
        //         $scope.Image = event.target.result
        //         $scope.$apply(function($scope) {
        //             $scope.files = element.files;
        //             $scope.uploadFile(element.files[0]);
        //         });
		//     }
        //     reader.readAsDataURL(element.files[0]);
        // }



        ///kjhkjkkjh
        $scope.uploadFile = function (files) {
            //debugger;
            var file = files;
            //console.log(files);
            
            var uploadUrl = "http://www.projects.estateahead.com/stock_inventory_mgt/api/promocode-image-upload";
            //var fd = new FormData();
            // fd.append('product_image', file);
            $http.post(uploadUrl, {promocode_image: file})
            .then(res => {
                $scope.promocodeImage = res.data.image_url;
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
                $scope.promocodeImage = event.target.result
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
 
