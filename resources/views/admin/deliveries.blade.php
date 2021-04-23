@extends('admin.layouts.app')

@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" ng-app="deliveriesApp" ng-controller="deliveriesController">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Deliveries Section</li>
        </ol>
        </section>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="col-sm-6" id="search_div">
                    <button type="button" class="btn btn-success" id="search_button"><i class="fa fa-search-plus" aria-hidden="true"></i>&nbsp; Search</button><input type="text" id="search" placeholder="&nbsp; Seach By Any.." ng-model="search">
                </div>
                <div class="back-bg" style="background-color:#fff; height: 64px; margin-top: 20px;">
                
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
                        <th>Order Id</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Promo Code</th>
                        <th>Delivery Address</th>
                        <th>Delivery Status</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody ng-repeat ="delivery in alltransactions | filter:search">
                    <tr>
                        <td>@{{$index+1}}</td>
                        <td>@{{delivery.order_id}}</td>
                        <td>@{{delivery.amount}}</td>
                        <td>@{{delivery.status}}</td>
                        <td>@{{delivery.promo_code}}</td>
                        <td><textarea class="form-control" rows="3" id="comment" disabled>@{{delivery.dlvry_address}}</textarea></td>
                        <td>
						    <span ng-show="delivery.dlvry_status =='2'">Delivered</span>
							<select ng-model="delivery.dlvry_status" ng-change="changeStatus(delivery)" ng-show="delivery.dlvry_status !='2'" ng-disabled="delivery.status =='Fail'">
                                <option ng-repeat="sel in options" ng-selected="delivery.dlvry_status == sel.id" value="@{{sel.id}}">@{{sel.name}}</option>
                            </select>
                        </td>
                        <td>@{{delivery.created_at|limitTo:10}}</td>
                        <td>
                            <button ng-disabled="delivery.dlvry_status =='2'" type="button" class="btn btn-info" ng-click="invoice(delivery)"><a href="" ><i class="fa fa-print" style="font-size:16px;color:white" aria-hidden="true"></i></a></button>&nbsp;&nbsp; 
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
                <div class="modal-content" id="m-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Generate Invoice</h4>
                    </div>
                    
                    <div class="modal-body">
                        <!-- invoice section  -->
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#home">Order and Account</a></li>
                            <li><a data-toggle="tab" href="#menu1">Address</a></li>
                            <li><a data-toggle="tab" href="#menu2">Payment and Shipping</a></li>
                            <li><a data-toggle="tab" href="#menu3">Products Ordered</a></li>
                            <li><a data-toggle="tab" href="#menu4">Show Invoice</a></li>
                        </ul>
                        <br>
                        <div class="tab-content">
                            <!-- Order and Account -->
                            <div id="home" class="tab-pane fade in active">
                               <!--order account-->
                                <!-- Order Information -->
                                <div class="secton-title" style="border-bottom:1px solid #ddd;">
                                    <span class="pay_title" style="color:#96a1ab;"><h4>Order Information</h4></span>
                                </div>
								<div class="section-content">
                                    <div class="row">
                                        <span class="title" >Order Date : &nbsp;</span>
                                        <span class="value">@{{transactionData.created_at|limitTo:10}}</span>               
                                    </div>
                                    <div class="row" style="padding-top:14px;">
                                        <span class="title">Order Status : &nbsp;</span>
                                        <span class="value" ng-show="transactionData.dlvry_status == '0'">Order Received</span>
                                        <span class="value" ng-show="transactionData.dlvry_status == '1'">Out For Delivery</span>
                                    </div>
                                    <div class="row" style="padding-top:14px;">
                                        <span class="title" >Channel : &nbsp;</span>
                                        <span class="value">Default</span>
                                    </div>
                                </div>
                                <!-- Account Information  -->
                                <div class="secton-title" style="border-bottom:1px solid #ddd; padding:top:20px;">
                                    <span class="pay_title" style="color:#96a1ab;"><h4>Account Information</h4></span>
                                </div>
                                <div class="section-content">
                                    <div class="row">
                                        <span class="title">Customer Name : &nbsp;</span>
                                        <span class="value">@{{userData.name}}</span>
                                    </div>

                                    <div class="row" style="padding-top:14px;">
                                        <span class="title">Email : &nbsp;</span>
                                        <span class="value">@{{userData.email_id}}</span>
                                    </div>
									 <div class="row" style="padding-top:14px;">
                                        <span class="title">Phone number : &nbsp;</span>
                                        <span class="value">@{{userData.phone_number}}</span>
                                    </div>
                                </div>
                                <!--order account-->
                            </div>
                            <!--/ Order and Account -->
                            <!-- Address -->
                            <div id="menu1" class="tab-pane fade">
                                <div class="secton-title" style="border-bottom:1px solid #ddd;">
                                    <span class="pay_title" style="color:#96a1ab;"><h4>Billing Address</h4></span>
                                    <textarea class="form-control" rows="3" id="comment" disabled>@{{transactionData.dlvry_address}}</textarea>
								</div>
								<div class="secton-title" style="border-bottom:1px solid #ddd;">
                                    <span class="pay_title" style="color:#96a1ab;"><h4>Shipping Address</h4></span>
                                    <textarea class="form-control" rows="3" id="comment" disabled>@{{transactionData.dlvry_address}}</textarea>
								</div>
                            </div>
                            <!--/ Address -->
                            <!-- Payment and Shipping -->
                            <div id="menu2" class="tab-pane fade">
                                <div class="sale-section">
                                    <div class="secton-title" style="border-bottom:1px solid #ddd;">
										<span class="pay_title" style="color:#96a1ab;"><h4>Payment Information</h4></span>
                                    </div>
                                    <div class="section-content">
                                        <div class="row">
                                            <span class="title" >Payment Method : &nbsp;</span>
                                            <span class="value" ng-show="transactionData.status ==' '">Cash on delivery</span> 
                                            <span class="value" ng-show="transactionData.status =='Success'">Online</span>  
                                        </div>

                                        <div class="row" style="padding-top:14px;">
                                            <span class="title">Currency : &nbsp;</span>
                                            <span class="value">INR</span>
                                        </div>
                                    </div>
                                </div> 
								<div class="sale-section" style="padding-top: 46px; padding-bottom: 36px;">
                                    <div class="secton-title" style="border-bottom:1px solid #ddd;">
										<span class="pay_title" style="color:#96a1ab;"><h4>Shipping Information</h4></span>
                                    </div>
                                    <div class="section-content">
                                        <div class="row">
                                            <span class="title">Shipping Method : &nbsp;</span>
                                            <span class="value">Flat Rate - Flat Rate</span>
                                        </div>

                                        <div class="row" style="padding-top:14px;">
                                            <span class="title">Shipping Price : &nbsp;</span>
                                            <span class="value">00.00 Rs</span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <!--/ Payment and Shipping -->
                            <!-- Products Ordered -->
                            <div id="menu3" class="tab-pane fade">		 
                                <table  class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Product Name</th>
                                            <th>Price</th>
                                            <th>Qty</th>
                                            <th>Weight</th>
                                            <th>Unit</th>
                                            <th>rujooal price</th>
                                            <th>Tax Amount</th>
                                            <th>Total Ammount</th>
                                        </tr>
                                    </thead>
                                    <tbody  ng-repeat ="product in productData">
                                        <tr>
                                            <td>@{{product.products}}</td>
                                            <td>@{{product.mrp}} Rs</td>
                                            <td>1</td>
                                            <td>@{{product.weight}}<br></td>
                                            <td>@{{product.unit}}<br></td>
                                            <td>@{{product.rujooal_price}} Rs</td>
                                            <td>0.00 Rs</td>
                                            <td>@{{product.rujooal_price}} Rs</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="products_total_estimate">
                                    <h4>Subtotal <span style="margin-left:155px;">- @{{transactionData.amount}} </span></h4>
                                    <h4>Shipping & Handling <span style="margin-left:63px;">- 00.00</span></h4>
                                    <h4>Tax <span style="margin-left:192px;">- 00.00</span></h4>
                                    <h4 style="font-weight:bold;">Grand Total <span style="margin-left:127px; font-weight:bold;">- @{{transactionData.amount}}</span></h4>
                                </div>
							</div>
                            <!--/ Products Ordered  -->
                            <!-- Show Invoice -->
                            <div id="menu4" class="tab-pane fade">
                                <button class="btn btn-success" id="cmd2" style="float:right;" ng-disabled="transactionData.status =='Fail'"> <a href="#"  class="waves-effect waves-light btn-large" style="color:white;">Download PDF </a></button>
                                <div class="db-2-com db-2-main" id="content2">
                                   
                                    <!-- content which do want printout -->
                                    <div class="row">
                                        <div class="col-sm-11" style="margin-left: 27px;">
                                            <div class="cont">
                                                <h5>Invoice Id -  <span class="hife">@{{transactionData.invoice_id}}</span></h5>
                                                <h5>Order Id - <span class="hife">@{{transactionData.order_id}}</span></h5>
                                                <h5>Order Date - <span class="hife">@{{transactionData.created_at|limitTo:10}}</span></h5>
												 <h5>Phone Number - <span class="hife">@{{userData.phone_number}}</span></h5>
											 
                                            </div>
                                            <table id="customers">
                                                <tr>
                                                    <th>Bill to</th>
                                                    <th>Ship to</th>    
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <span>@{{transactionData.dlvry_address}}</span><br>
                                                    </td>
                                                    <td>
                                                        <span>@{{transactionData.dlvry_address}}</span><br>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="tab2">
                                                <table id="customers">
                                                    <tr>
                                                        <th>Payment Method</th>
                                                        <th>Shipping Method</th>    
                                                    </tr>
                                                    <tr>
                                                        <td><span ng-show="transactionData.status ==' '">Cash on delivery</span><br></td>
                                                        <td><span>Flat Rate - Flat Rate</span><br></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="tab3">
                                                <table id="customers">
                                                    <thead>
                                                        <tr> 
                                                            <th>Product name</th>
                                                            <th>MRP</th>
                                                            <th>Qty</th>
                                                            <th>Weight</th>
                                                            <th>Unit</th>
                                                            <th>Rujooal Price</th>  
                                                        </tr>
                                                    </thead>
                                                    <tbody ng-repeat ="product in productData">
                                                        <tr>
                                                            <td><span>@{{product.products}}</span><br> </td>
                                                            <td><span>@{{product.mrp}} Rs</span><br></td>
                                                            <td><span>1</span><br></td>
                                                            <td><span>@{{product.weight}}</span><br></td>
                                                            <td><span>@{{product.unit}}</span><br></td> 
                                                            <td><span>@{{product.rujooal_price}} Rs</span><br></td> 
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="bill">
                                                <h4>Subtotal <span style="margin-left:155px;">- @{{transactionData.amount}} </span></h4>
                                                <h4>Shipping & Handling <span style="margin-left:63px;">- 00.00</span></h4>
                                                <h4>Tax <span style="margin-left:192px;">- 00.00</span></h4>
                                                <h4 style="font-weight:bold;">Grand Total <span style="margin-left:127px; font-weight:bold;">- @{{transactionData.amount}}</span></h4>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <!--/ Show Invoice -->
                        </div>
                    <!--/invoice section  -->
                    </div>
                    <div class="modal-footer">
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
    var deliveriesApp = angular.module("deliveriesApp",[]);//'datatables'
    deliveriesApp.controller("deliveriesController",function($scope, $http) {//,DTOptionsBuilder
        // deliveries listing   
       // $scope.dtOptions = DTOptionsBuilder.newOptions().withOption('order', [0, 'asc']);
		$scope.options = [{ name: "Order Recieved", id: '0' }, { name: "Out for delivery", id: '1' },{ name: "Delivered", id: '2' }];
        $scope.deliveriesData = [];
        $scope.getRequest = function() {
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/get-deliveries").then(response =>{
                $scope.alltransactions = response.data.data.alltransactions;
                console.log($scope.alltransactions);
            }).catch(error => {
                console.log(error);
            });
        };
        $scope.getRequest();
        //change status
        $scope.changeStatus =function(data){
			//debugger;
            var reqData = {
                id:data.id,
                dlvry_status:data.dlvry_status
            }
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/change-delivery-status",reqData).then(response =>{
                 
            }).catch(error => {
                console.log(error);
            });
        };
        //invoice partition
        $scope.invoice = function(data){
            $scope.transactionData = data;
            var reqData = {
                id:data.id,
                user_id:data.user_id,
                product_id:data.product_id
            }
            $http.post("http://www.projects.estateahead.com/stock_inventory_mgt/api/get-invoice-data",reqData).then(response =>{
                $scope.productData =  response.data.data.productData;
                $scope.userData = response.data.data.userData;
				//console.log($scope.userData);
                $('#myModal').modal('show'); 
            }).catch(error => {
                console.log(error);
            }); 
        }
        //generate pdf
        $('#cmd2').click(function() {
            html2canvas(document.getElementById('content2'), {
                onrendered: function (canvas) {
                    var data = canvas.toDataURL();
                    var docDefinition = {
                        content: [{
                            image: data,
                            width: 500,
                        }]
                    };
                    pdfMake.createPdf(docDefinition).download("Score_Details.pdf");
                }
            });
        });    
    });
</script>
@endsection	
 
